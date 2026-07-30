<?php

declare(strict_types=1);

namespace Igniter\Admin\FormWidgets;

use Igniter\Admin\Classes\BaseFormWidget;
use Override;

/**
 * Code Editor
 * Renders a code editor field.
 */
class CodeEditor extends BaseFormWidget
{
    //
    // Configurable properties
    //

    public string $mode = 'css';

    public string $theme = 'material';

    /**
     * @var bool Determines whether content has HEAD and HTML tags.
     */
    public bool $fullPage = false;

    public ?string $lineSeparator = null;

    public bool $readOnly = false;

    //
    // Object properties
    //

    protected string $defaultAlias = 'codeeditor';

    #[Override]
    public function initialize(): void
    {
        $this->fillFromConfig([
            'fullPage',
            'lineSeparator',
            'mode',
            'theme',
            'readOnly',
        ]);
    }

    #[Override]
    public function render(): string
    {
        $this->prepareVars();

        return $this->makePartial('codeeditor/codeeditor');
    }

    #[Override]
    public function loadAssets(): void
    {
        $this->addJs('js/vendor.editor.js', 'vendor-editor-js');
        $this->addCss('codeeditor.css', 'codeeditor-css');
        $this->addJs('codeeditor.js', 'codeeditor-js');
    }

    public function prepareVars(): void
    {
        $this->vars['field'] = $this->formField;
        $this->vars['fullPage'] = $this->fullPage;
        $this->vars['stretch'] = $this->formField->stretch;
        $this->vars['size'] = $this->formField->size;
        $this->vars['lineSeparator'] = $this->lineSeparator;
        $this->vars['readOnly'] = $this->readOnly;
        $this->vars['mode'] = $this->mode;
        $this->vars['theme'] = $this->theme;
        $this->vars['name'] = $this->formField->getName();
        $this->vars['value'] = $this->getLoadValue();
    }
}
