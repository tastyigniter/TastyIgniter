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

    /**
     * @var string Prompt text for adding new items.
     */
    public $prompt = 'lang:admin::lang.text_please_select';

    /**
     * @var bool Items can be sorted.
     */
    public $sortable = FALSE;

    /**
     * @var bool Items can be edited.
     */
    public $editable = TRUE;

    public $popupSize;

    public function initialize()
    {
        $this->fillFromConfig([
            'formName',
            'form',
            'prompt',
            'editable',
            'sortable',
            'nameFrom',
            'descriptionFrom',
            'partial',
            'popupSize',
        ]);

        $fieldName = $this->formField->getName(FALSE);
        $this->sortableInputName = self::SORT_PREFIX.$fieldName;
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
        return (array)$this->processSaveValue($value);
    }

    /**
     * Prepares the view data
     */
    public function prepareVars()
    {
        $this->vars['formField'] = $this->formField;
        $this->vars['fieldItems'] = $this->processLoadValue() ?? [];

        $this->vars['prompt'] = $this->prompt;
        $this->vars['editable'] = $this->editable;
        $this->vars['sortable'] = $this->sortable;
        $this->vars['nameFrom'] = $this->nameFrom;
        $this->vars['partial'] = $this->partial;
        $this->vars['descriptionFrom'] = $this->descriptionFrom;
        $this->vars['sortableInputName'] = $this->sortableInputName;
    }

    public function onLoadRecord()
    {
        $recordId = post('recordId');
        $model = $this->getRelationModel()->find($recordId);

        if (!$model)
            throw new ApplicationException(lang('admin::lang.form.record_not_found'));

        return $this->makePartial('recordeditor/form', [
            'formRecordId' => $recordId,
            'formTitle' => 'Edit '.lang($this->formName),
            'formWidget' => $this->makeItemFormWidget($model, 'edit'),
        ]);
    }

    public function onSaveRecord()
    {
        $model = strlen($recordId = post('recordId'))
            ? $this->getRelationModel()->find($recordId)
            : $this->getRelationObject();

        $form = $this->makeItemFormWidget($model, 'edit');

        $this->validateFormWidget($form, $saveData = $form->getSaveData());

        $modelsToSave = $this->prepareModelsToSave($model, $saveData);

        DB::transaction(function () use ($modelsToSave) {
            foreach ($modelsToSave as $modelToSave) {
                $modelToSave->saveOrFail();
            }
        });

        flash()->success(sprintf(lang('admin::lang.alert_success'), 'Item updated'))->now();

        $this->formField->value = null;
        $this->model->reloadRelations();

        $this->prepareVars();

        return [
            '#notification' => $this->makePartial('flash'),
            '#'.$this->getId('items') => $this->makePartial('connector/connector_items'),
        ];
    }

    public function onDeleteRecord()
    {
        if (!strlen($recordId = post('recordId')))
            return FALSE;

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

        $value = $value instanceof Collection
            ? $value->sortBy($this->sortColumnName)
            : sort_array($value, $this->sortColumnName);

        return $value;
    }

    protected function processSaveValue($value)
    {
        if (!$this->sortable)
            return FormField::NO_SAVE_DATA;

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

    protected function makeItemFormWidget($model, $context)
    {
        $widgetConfig = is_string($this->form) ? $this->loadConfig($this->form, ['form'], 'form') : $this->form;
        $widgetConfig['model'] = $model;
        $widgetConfig['alias'] = $this->alias.'Form'.'connector';
        $widgetConfig['arrayName'] = $this->formField->arrayName.'[connectorData]';
        $widgetConfig['context'] = $context;
        $widget = $this->makeWidget(Form::class, $widgetConfig);

        $widget->bindToController();
        $widget->previewMode = $this->previewMode;

        return $widget;
    }
}
