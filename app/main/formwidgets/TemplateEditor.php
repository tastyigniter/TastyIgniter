<?php

namespace Main\FormWidgets;

use Admin\Classes\BaseFormWidget;
use Admin\Traits\FormModelWidget;
use Admin\Widgets\Form;
use ApplicationException;
use Main\Classes\Theme;

/**
 * Template Editor
 */
class TemplateEditor extends BaseFormWidget
{
    use FormModelWidget;

    public $form;

    public $placeholder = 'system::lang.themes.text_select_file';

    public $formName = 'system::lang.themes.label_template';

    public $addLabel = 'system::lang.themes.button_new_source';

    public $editLabel = 'system::lang.themes.button_rename_source';

    public $deleteLabel = 'system::lang.themes.button_delete_source';

    //
    // Object properties
    //

    protected $defaultAlias = 'templateeditor';

    public function initialize()
    {
        $this->fillFromConfig([
            'form',
            'formName',
            'addLabel',
            'editLabel',
            'deleteLabel',
            'placeholder',
        ]);
    }

    public function render()
    {
        $this->prepareVars();

        return $this->makePartial('templateeditor/templateeditor');
    }

    public function prepareVars()
    {
        $this->vars['field'] = $this->formField;
        $this->vars['fieldOptions'] = $this->getTemplateEditorOptions();
        $this->vars['templateTypes'] = $this->getTemplateTypes();
    }

    protected function makeTemplateFormWidget($model, $context = null)
    {
        if (is_null($context))
            $context = $model->exists ? 'edit' : 'create';

        $widgetConfig = is_string($this->form) ? $this->loadConfig($this->form, ['form'], 'form') : $this->form;
        $widgetConfig['model'] = $model;
        $widgetConfig['alias'] = $this->alias.'template-editor';
        $widgetConfig['arrayName'] = $this->formField->arrayName.'[templateData]';
        $widgetConfig['context'] = $context;
        $widget = $this->makeWidget(Form::class, $widgetConfig);

        $widget->bindToController();

        return $widget;
    }

    protected function getTemplateEditorOptions()
    {
        if (!$themeObject = $this->model->getTheme() OR !$themeObject instanceof Theme)
            throw new ApplicationException('Missing theme object on '.get_class($this->model));

        $type = array_get((array)$this->getLoadValue(), 'type') ?? '_pages';
        /** @var \Main\Template\Model $templateClass */
        $templateClass = $themeObject->getTemplateClass($type);
        $result = $templateClass::getDropdownOptions($themeObject, TRUE);

        return $result;
    }

    protected function getTemplateTypes()
    {
        return [
            '_pages' => 'system::lang.themes.label_type_page',
            '_partials' => 'system::lang.themes.label_type_partial',
            '_layouts' => 'system::lang.themes.label_type_layout',
            '_content' => 'system::lang.themes.label_type_content',
        ];
    }
}
