<?php

namespace Admin\FormWidgets;

use Admin\Classes\BaseFormWidget;
use Admin\Traits\FormModelWidget;
use Admin\Traits\ValidatesForm;
use Admin\Widgets\Form;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Flame\Html\HtmlFacade as Html;
use Illuminate\Support\Facades\DB;

/**
 * Record Editor
 */
class RecordEditor extends BaseFormWidget
{
    use FormModelWidget;
    use ValidatesForm;

    public $form;

    public $modelClass;

    public $addonLeft;

    public $addonRight;

    public $popupSize;

    public $formName = 'Record';

    public $hideEditButton = false;

    public $hideDeleteButton = false;

    public $hideCreateButton = false;

    public $addLabel = 'New';

    public $editLabel = 'Edit';

    public $deleteLabel = 'Delete';

    //
    // Object properties
    //

    protected $defaultAlias = 'recordeditor';

    public function initialize()
    {
        $this->fillFromConfig([
            'form',
            'formName',
            'modelClass',
            'addonLeft',
            'addonRight',
            'hideCreateButton',
            'hideEditButton',
            'hideDeleteButton',
            'addLabel',
            'editLabel',
            'deleteLabel',
            'popupSize',
        ]);

        $this->makeRecordFormWidgetFromRequest();
    }

    public function render()
    {
        $this->prepareVars();

        return $this->makePartial('recordeditor/recordeditor');
    }

    public function loadAssets()
    {
        $this->addJs('../../repeater/assets/vendor/sortablejs/Sortable.min.js', 'sortable-js');
        $this->addJs('../../repeater/assets/vendor/sortablejs/jquery-sortable.js', 'jquery-sortable-js');
        $this->addJs('../../repeater/assets/js/repeater.js', 'repeater-js');

        $this->addJs('js/recordeditor.modal.js', 'recordeditor-modal-js');
        $this->addJs('js/recordeditor.js', 'recordeditor-js');
    }

    public function prepareVars()
    {
        $this->vars['field'] = $this->makeFormField();
        $this->vars['addonLeft'] = $this->makeFieldAddon('left');
        $this->vars['addonRight'] = $this->makeFieldAddon('right');

        $this->vars['addLabel'] = $this->addLabel;
        $this->vars['editLabel'] = $this->editLabel;
        $this->vars['deleteLabel'] = $this->deleteLabel;
        $this->vars['showEditButton'] = !$this->hideEditButton;
        $this->vars['showDeleteButton'] = !$this->hideDeleteButton;
        $this->vars['showCreateButton'] = !$this->hideCreateButton;
    }

    public function onLoadRecord()
    {
        $model = strlen($recordId = post('recordId'))
            ? $this->findFormModel($recordId)
            : $this->createFormModel();

        return $this->makePartial('recordeditor/form', [
            'formRecordId' => $recordId,
            'formTitle' => ($model->exists ? $this->editLabel : $this->addLabel).' '.lang($this->formName),
            'formWidget' => $this->makeRecordFormWidget($model),
        ]);
    }

    public function onSaveRecord()
    {
        $model = strlen($recordId = post('recordId'))
            ? $this->findFormModel($recordId)
            : $this->createFormModel();

        $form = $this->makeRecordFormWidget($model);

        $this->validateFormWidget($form, $saveData = $form->getSaveData());

        $modelsToSave = $this->prepareModelsToSave($model, $saveData);

        DB::transaction(function () use ($modelsToSave) {
            foreach ($modelsToSave as $modelToSave) {
                $modelToSave->saveOrFail();
            }
        });

        flash()->success(sprintf(lang('admin::lang.alert_success'),
            lang($this->formName).' '.($form->context == 'create' ? 'created' : 'updated')))->now();

        return [
            '#notification' => $this->makePartial('flash'),
            '#'.$this->formField->getId('group') => $form->renderField($this->formField, [
                'useContainer' => false,
            ]),
        ];
    }

    public function onDeleteRecord()
    {
        $model = $this->findFormModel(post('recordId'));

        $form = $this->makeRecordFormWidget($model);

        $model->delete();

        flash()->success(sprintf(lang('admin::lang.alert_success'), lang($this->formName).' deleted'))->now();

        return [
            '#notification' => $this->makePartial('flash'),
            '#'.$this->formField->getId() => $form->renderField($this->formField, [
                'useContainer' => false,
            ]),
        ];
    }

    protected function makeRecordFormWidget($model)
    {
        $context = $model->exists ? 'edit' : 'create';

        $widgetConfig = is_string($this->form) ? $this->loadConfig($this->form, ['form'], 'form') : $this->form;
        $widgetConfig['model'] = $model;
        $widgetConfig['alias'] = $this->alias.'RecordEditor';
        $widgetConfig['arrayName'] = $this->formField->arrayName.'[recordData]';
        $widgetConfig['context'] = $context;
        $widget = $this->makeWidget(Form::class, $widgetConfig);

        $widget->bindToController();

        return $widget;
    }

    protected function makeFieldAddon($string)
    {
        $name = camel_case('addon_'.$string);
        $config = $this->{$name};

        if (!$config)
            return null;

        if (!is_array($config))
            $config = [$config];

        $config = (object)array_merge([
            'tag' => 'div',
            'label' => 'Label',
            'attributes' => [],
        ], $config);

        return '<'.$config->tag.Html::attributes($config->attributes).'>'.lang($config->label).'</'.$config->tag.'>';
    }

    protected function getRecordEditorOptions()
    {
        $model = $this->createFormModel();
        $methodName = 'get'.studly_case($this->fieldName).'RecordEditorOptions';

        if (!$model->methodExists($methodName) && !$model->methodExists('getRecordEditorOptions')) {
            throw new ApplicationException(sprintf(lang('admin::lang.alert_missing_method'), 'getRecordEditorOptions', get_class($model)));
        }

        if ($model->methodExists($methodName)) {
            $result = $model->$methodName();
        }
        else {
            $result = $model->getRecordEditorOptions($this->fieldName);
        }

        return $result;
    }

    protected function makeRecordFormWidgetFromRequest()
    {
        if (post('recordId'))
            return;

        if (!strlen($requestData = request()->header('X-IGNITER-RECORD-EDITOR-REQUEST-DATA')))
            return;

        if (!strlen($recordId = array_get(json_decode($requestData, true), $this->alias.'.recordId')))
            return;

        $model = $this->findFormModel($recordId);

        $this->makeRecordFormWidget($model);
    }

    protected function makeFormField()
    {
        $field = clone $this->formField;

        $field->options(function () {
            return $this->getRecordEditorOptions();
        });

        return $this->clonedFormField = $field;
    }
}
