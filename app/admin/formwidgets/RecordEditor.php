<?php namespace Admin\FormWidgets;

use Admin\Classes\BaseFormWidget;
use Admin\Traits\FormModelWidget;
use Admin\Widgets\Form;
use ApplicationException;
use DB;
use Html;

/**
 * Record Editor
 *
 * @package Admin
 */
class RecordEditor extends BaseFormWidget
{
    use FormModelWidget;

    public $form;

    public $modelClass;

    public $addonLeft;

    public $addonRight;

    public $popupSize;

    public $formName = 'Record';

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
            'addLabel',
            'editLabel',
            'deleteLabel',
            'popupSize',
        ]);
    }

    public function render()
    {
        $this->prepareVars();

        return $this->makePartial('recordeditor/recordeditor');
    }

    public function loadAssets()
    {
        $this->addJs('../../repeater/assets/js/jquery-sortable.js', 'jquery-sortable-js');
        $this->addJs('../../repeater/assets/js/repeater.js', 'repeater-js');

        $this->addJs('js/recordeditor.modal.js', 'recordeditor-modal-js');
        $this->addJs('js/recordeditor.js', 'recordeditor-js');
    }

    public function prepareVars()
    {
        $this->vars['field'] = $this->formField;
        $this->vars['fieldOptions'] = $this->getRecordEditorOptions();
        $this->vars['addonLeft'] = $this->makeFieldAddon('left');
        $this->vars['addonRight'] = $this->makeFieldAddon('right');

        $this->vars['addLabel'] = $this->addLabel;
        $this->vars['editLabel'] = $this->editLabel;
        $this->vars['deleteLabel'] = $this->deleteLabel;
    }

    public function onLoadRecord()
    {
        $model = strlen($recordId = post('recordId'))
            ? $this->findFormModel($recordId)
            : $this->createFormModel();

        return $this->makePartial('recordeditor/form', [
            'formRecordId' => $recordId,
            'formTitle'    => ($model->exists ? $this->editLabel : $this->addLabel).' '.lang($this->formName),
            'formWidget'   => $this->makeRecordFormWidget($model),
        ]);
    }

    public function onSaveRecord()
    {
        $model = strlen($recordId = post('recordId'))
            ? $this->findFormModel($recordId)
            : $this->createFormModel();

        $form = $this->makeRecordFormWidget($model);

        $modelsToSave = $this->prepareModelsToSave($model, $form->getSaveData());

        DB::transaction(function () use ($modelsToSave) {
            foreach ($modelsToSave as $modelToSave) {
                $modelToSave->saveOrFail();
            }
        });

        flash()->success(sprintf(lang('admin::lang.alert_success'),
            lang($this->formName).' '.($form->context == 'create' ? 'created' : 'updated')))->now();

        return [
            '#notification'               => $this->makePartial('flash'),
            '#'.$this->formField->getId() => $form->renderField($this->formField, [
                'useContainer' => FALSE,
            ]),
        ];
    }

    public function onDeleteRecord()
    {
        $model = $this->findFormModel($recordId = post('recordId'));

        $form = $this->makeRecordFormWidget($model);

        $model->delete();

        flash()->success(sprintf(lang('admin::lang.alert_success'), lang($this->formName).' deleted'))->now();

        return [
            '#notification'               => $this->makePartial('flash'),
            '#'.$this->formField->getId() => $form->renderField($this->formField, [
                'useContainer' => FALSE,
            ]),
        ];
    }

    protected function makeRecordFormWidget($model, $context = null)
    {
        if (is_null($context))
            $context = $model->exists ? 'edit' : 'create';

        $widgetConfig = is_string($this->form) ? $this->loadConfig($this->form, ['form'], 'form') : $this->form;
        $widgetConfig['model'] = $model;
        $widgetConfig['alias'] = $this->alias.'record-editor';
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
            'tag'        => 'span',
            'label'      => 'Label',
            'attributes' => [],
        ], $config);

        return '<'.$config->tag.Html::attributes($config->attributes).'>'.lang($config->label).'</'.$config->tag.'>';
    }

    protected function getRecordEditorOptions()
    {
        $model = $this->createFormModel();
        $methodName = 'get'.studly_case($this->fieldName).'RecordEditorOptions';

        if (!$model->methodExists($methodName) AND !$model->methodExists('getRecordEditorOptions')) {
            throw new ApplicationException(sprintf('Missing method [%s] in %s', 'getRecordEditorOptions', get_class($model)));
        }

        if ($model->methodExists($methodName)) {
            $result = $model->$methodName();
        }
        else {
            $result = $model->getRecordEditorOptions($this->fieldName);
        }

        return $result;
    }
}
