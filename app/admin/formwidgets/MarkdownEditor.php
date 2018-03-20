<?php

namespace Admin\FormWidgets;

use Admin\Classes\BaseFormWidget;
use October\Rain\Parse\Markdown;

/**
 * Code Editor
 * Renders a code editor field.
 *
 * @package Admin
 */
class MarkdownEditor extends BaseFormWidget
{
    //
    // Configurable properties
    //

    /**
     * @var string Display mode: split, tab.
     */
    public $mode = 'tab';

    //
    // Object properties
    //

    protected $defaultAlias = 'markdown';

    public function initialize()
    {
        $this->fillFromConfig([
            'mode',
        ]);
    }

    public function render()
    {
        $this->prepareVars();

        return $this->makePartial('markdowneditor/markdowneditor');
    }

    /**
     * Prepares the widget data
     */
    public function prepareVars()
    {
        $this->vars['mode'] = $this->mode;
        $this->vars['stretch'] = $this->formField->stretch;
        $this->vars['size'] = $this->formField->size;
        $this->vars['name'] = $this->formField->getName();
        $this->vars['value'] = $this->getLoadValue();
    }

    public function loadAssets()
    {
        $this->addCss('vendor/editormd/css/editormd.css', 'editormd-css');
        $this->addCss('css/markdowneditor.css', 'markdowneditor-css');
        $this->addJs('vendor/editormd/editormd.min.js', 'editormd-js');
        $this->addJs('js/markdowneditor.js', 'markdowneditor-js');
    }

    public function onRefresh()
    {
        $value = post($this->formField->getName());
        $previewHtml = (new Markdown)->parse($value);

        return [
            'preview' => $previewHtml,
        ];
    }
}
