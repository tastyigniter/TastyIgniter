<?php

declare(strict_types=1);

namespace Igniter\Admin\FormWidgets;

use Igniter\Admin\Classes\BaseFormWidget;
use Override;

/**
 * Rich Editor
 * Renders a rich content editor field.
 *
 * Adapted from october\backend\classes\RichEditor
 */
class RichEditor extends BaseFormWidget
{
    //
    // Configurable properties
    //

    /** Determines whether content has HEAD and HTML tags. */
    public bool $fullPage = false;

    public ?string $stretch = null;

    public ?string $size = null;

    public ?string $toolbarButtons = null;

    //
    // Object properties
    //

    protected string $defaultAlias = 'richeditor';

    #[Override]
    public function initialize(): void
    {
        $this->fillFromConfig([
            'fullPage',
            'stretch',
            'size',
            'toolbarButtons',
        ]);
    }

    #[Override]
    public function render(): string
    {
        $this->prepareVars();

        return $this->makePartial('richeditor/richeditor');
    }

    #[Override]
    public function loadAssets(): void
    {
        $this->addJs('js/vendor.editor.js', 'vendor-editor-js');
        $this->addCss('richeditor.css', 'richeditor-css');
        $this->addJs('richeditor.js', 'richeditor-js');
    }

    /**
     * Prepares the list data
     */
    public function prepareVars(): void
    {
        $this->vars['field'] = $this->formField;
        $this->vars['fullPage'] = $this->fullPage;
        $this->vars['stretch'] = $this->stretch;
        $this->vars['size'] = $this->size;
        $this->vars['name'] = $this->formField->getName();
        $this->vars['value'] = $this->getLoadValue();
        $this->vars['toolbarButtons'] = $this->evalToolbarButtons();
    }

    /**
     * Determine the toolbar buttons to use based on config.
     */
    protected function evalToolbarButtons(): ?array
    {
        $buttons = $this->toolbarButtons;

        if (is_string($buttons)) {
            $buttons = array_map(fn($button): string => $button ?: '|', explode('|', $buttons));
        }

        return $buttons;
    }
}
