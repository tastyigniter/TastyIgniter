<?php

namespace Admin\FormWidgets;

use Admin\Classes\BaseFormWidget;
use Admin\Classes\FormField;
use Admin\Traits\FormModelWidget;
use Admin\Traits\ValidatesForm;
use Admin\Widgets\Form;
use Igniter\Flame\Exception\ApplicationException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Form Relationship
 */
class Connector extends BaseFormWidget
{
    use FormModelWidget;
    use ValidatesForm;

    const INDEX_SEARCH = '___index__';

    const SORT_PREFIX = '___dragged_';

    //
    // Object properties
    //

    protected $defaultAlias = 'connector';

    protected $sortableInputName;

    //
    // Configurable properties
    //

    public $sortColumnName = 'priority';

    public $nameFrom = 'name';

    public $descriptionFrom = 'description';

    public $partial;

    public $formName = 'Record';

    /**
     * @var array Form field configuration
     */
    public $form;

    public $newRecordTitle = 'New %s';

    public $editRecordTitle = 'Edit %s';

    public $emptyMessage = 'admin::lang.list.text_empty';

    public $confirmMessage = 'admin::lang.alert_warning_confirm';

    /**
     * @var bool Items can be sorted.
     */
    public $sortable = false;

    /**
     * @var bool Items can be edited.
     */
    public $editable = true;

    public $popupSize;

    public $hideNewButton = true;

    public function initialize()
    {
        $this->fillFromConfig([
            'formName',
            'form',
            'newRecordTitle',
            'editRecordTitle',
            'emptyMessage',
            'confirmMessage',
            'editable',
            'sortable',
            'nameFrom',
            'descriptionFrom',
            'partial',
            'popupSize',
            'hideNewButton',
        ]);

        $fieldName = $this->formField->getName(false);
        $this->sortableInputName = self::SORT_PREFIX.$fieldName;

        if ($this->formField->disabled || $this->formField->readOnly) {
            $this->previewMode = true;
        }
    }

    public function render()
    {
        $this->prepareVars();

        return $this->makePartial('connector/connector');
    }

    public function loadAssets()
    {
        $this->addJs('../../repeater/assets/vendor/sortablejs/Sortable.min.js', 'sortable-js');
        $this->addJs('../../repeater/assets/vendor/sortablejs/jquery-sortable.js', 'jquery-sortable-js');
        $this->addJs('../../repeater/assets/js/repeater.js', 'repeater-js');

        $this->addJs('../../recordeditor/assets/js/recordeditor.modal.js', 'recordeditor-modal-js');
        $this->addJs('../../recordeditor/assets/js/recordeditor.js', 'recordeditor-js');

        $this->addJs('js/connector.js', 'connector-js');
    }

    public function getSaveValue($value)
    {
        if (!$this->sortable)
            return FormField::NO_SAVE_DATA;

        return (array)$this->processSaveValue($value);
    }

    /**
     * Prepares the view data
     */
    public function prepareVars()
    {
        $this->vars['formField'] = $this->formField;
        $this->vars['fieldItems'] = $this->processLoadValue() ?? [];

        $this->vars['editable'] = $this->editable;
        $this->vars['sortable'] = $this->sortable;
        $this->vars['nameFrom'] = $this->nameFrom;
        $this->vars['partial'] = $this->partial;
        $this->vars['descriptionFrom'] = $this->descriptionFrom;
        $this->vars['sortableInputName'] = $this->sortableInputName;
        $this->vars['newRecordTitle'] = sprintf($this->newRecordTitle, lang($this->formName));

        $this->vars['emptyMessage'] = $this->emptyMessage;
        $this->vars['confirmMessage'] = $this->confirmMessage;
    }

    public function reload()
    {
        $this->formField->value = null;
        $this->model->reloadRelations();

        $this->prepareVars();

        return [
            '#notification' => $this->makePartial('flash'),
            '#'.$this->getId('items') => $this->makePartial('connector/connector_items'),
        ];
    }

    public function onLoadRecord()
    {
        $model = $this->getRelationModel();

        $formTitle = lang($this->newRecordTitle);
        if (strlen($recordId = post('recordId'))) {
            $model = $model->find($recordId);
            $formTitle = lang($this->editRecordTitle);
        }

        return $this->makePartial('recordeditor/form', [
            'formRecordId' => $recordId,
            'formTitle' => sprintf($formTitle, lang($this->formName)),
            'formWidget' => $this->makeItemFormWidget($model),
        ]);
    }

    public function onSaveRecord()
    {
        $model = $this->getRelationModel();

        if (strlen($recordId = post('recordId')))
            $model = $model->find($recordId);

        $form = $this->makeItemFormWidget($model);

        $this->validateFormWidget($form, $saveData = $form->getSaveData());

        if (!$model->exists)
            $saveData[$this->model->getKeyName()] = $this->model->getKey();

        $modelsToSave = $this->prepareModelsToSave($model, $saveData);

        DB::transaction(function () use ($modelsToSave) {
            foreach ($modelsToSave as $modelToSave) {
                $modelToSave->saveOrFail();
            }
        });

        flash()->success(sprintf(lang('admin::lang.alert_success'), 'Item updated'))->now();

        return $this->reload();
    }

    public function onDeleteRecord()
    {
        if (!strlen($recordId = post('recordId')))
            return false;

        $model = $this->getRelationModel()->find($recordId);
        if (!$model)
            throw new ApplicationException(sprintf(lang('admin::lang.form.not_found'), $recordId));

        $model->delete();

        flash()->success(sprintf(lang('admin::lang.alert_success'), lang($this->formName).' deleted'))->now();

        $this->prepareVars();

        return [
            '#notification' => $this->makePartial('flash'),
        ];
    }

    protected function processLoadValue()
    {
        $value = $this->getLoadValue();
        if (!$this->sortable) {
            return $value;
        }

        return $value instanceof Collection
            ? $value->sortBy($this->sortColumnName)
            : sort_array($value, $this->sortColumnName);
    }

    protected function processSaveValue($value)
    {
        $items = $this->formField->value;
        if (!$items instanceof Collection)
            return $items;

        $sortedIndexes = (array)post($this->sortableInputName);
        $sortedIndexes = array_flip($sortedIndexes);

        $results = [];
        foreach ($items as $index => $item) {
            $results[$index] = [
                $item->getKeyName() => $item->getKey(),
                $this->sortColumnName => $sortedIndexes[$item->getKey()],
            ];
        }

        return $results;
    }

    protected function makeItemFormWidget($model)
    {
        $widgetConfig = is_string($this->form) ? $this->loadConfig($this->form, ['form'], 'form') : $this->form;
        $widgetConfig['model'] = $model;
        $widgetConfig['alias'] = $this->alias.'FormConnector';
        $widgetConfig['arrayName'] = $this->formField->arrayName.'[connectorData]';
        $widgetConfig['context'] = $model->exists ? 'edit' : 'create';
        $widget = $this->makeWidget(Form::class, $widgetConfig);

        $widget->bindToController();
        $widget->previewMode = $this->previewMode;

        return $widget;
    }
}
