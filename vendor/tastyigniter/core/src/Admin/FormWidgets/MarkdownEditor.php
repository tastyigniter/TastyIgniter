<?php

declare(strict_types=1);

namespace Igniter\Admin\FormWidgets;

use Igniter\Admin\Classes\BaseFormWidget;
use Igniter\Flame\Mail\Markdown;
use Override;

/**
 * Markdown Editor
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
    public string $mode = 'tab';

    //
    // Object properties
    //

    protected string $defaultAlias = 'markdown';

    #[Override]
    public function initialize(): void
    {
        $this->fillFromConfig([
            'mode',
        ]);

        if ($this->formField->disabled || $this->formField->readOnly) {
            $this->previewMode = true;
        }
    }

    #[Override]
    public function render(): string
    {
        $this->prepareVars();

        return $this->makePartial('markdowneditor/markdowneditor');
    }

    /**
     * Prepares the widget data
     */
    public function prepareVars(): void
    {
        $this->vars['mode'] = $this->mode;
        $this->vars['stretch'] = $this->formField->stretch;
        $this->vars['size'] = $this->formField->size;
        $this->vars['name'] = $this->formField->getName();
        $this->vars['value'] = $this->getLoadValue();
    }

    #[Override]
    public function loadAssets(): void
    {
        $this->addJs('js/vendor.editor.js', 'vendor-editor-js');
        $this->addCss('markdowneditor.css', 'markdowneditor-css');
        $this->addJs('markdowneditor.js', 'markdowneditor-js');
    }

    public function onRefresh(): array
    {
        $value = post($this->formField->getName());
        $previewHtml = Markdown::parse($value)->toHtml();

        return [
            'preview' => $previewHtml,
        ];
    }
}
