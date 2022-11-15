<?php

namespace Admin\FormWidgets;

use Admin\Classes\BaseFormWidget;
use Igniter\Flame\Mail\Markdown;

/**
 * Code Editor
 * Renders a code editor field.
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

        if ($this->formField->disabled || $this->formField->readOnly) {
            $this->previewMode = true;
        }
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
        $this->addCss('vendor/easymde/easymde.min.css', 'easymde-css');
        $this->addCss('css/markdowneditor.css', 'markdowneditor-css');
        $this->addJs('vendor/easymde/easymde.min.js', 'easymde-js');
        $this->addJs('js/markdowneditor.js', 'markdowneditor-js');
    }

    public function onRefresh()
    {
        $value = post($this->formField->getName());
        $previewHtml = Markdown::parse($value)->toHtml();

        return [
            'preview' => $previewHtml,
        ];
    }
}
