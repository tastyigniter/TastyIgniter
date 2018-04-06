<?php namespace Admin\FormWidgets;

use Admin\Classes\BaseFormWidget;

/**
 * Code Editor
 * Renders a code editor field.
 *
 * @package Admin
 */
class CodeEditor extends BaseFormWidget
{
    const CHANGED_PREFIX = '___changed_';

    //
    // Configurable properties
    //

    public $mode = 'css';

    public $theme = 'material';

    /**
     * @var boolean Determines whether content has HEAD and HTML tags.
     */
    public $fullPage = FALSE;

    public $lineSeparator;

    public $readOnly = FALSE;

    //
    // Object properties
    //

    protected $defaultAlias = 'codeeditor';

    public function initialize()
    {
        $this->fillFromConfig([
            'fullPage',
            'lineSeparator',
            'mode',
            'theme',
            'readOnly',
        ]);
    }

    public function render()
    {
        $this->prepareVars();

        return $this->makePartial('codeeditor/codeeditor');
    }

    public function loadAssets()
    {
        $this->addCss('css/codeeditor.css', 'codeeditor-css');
        $this->addJs('js/codeeditor.js', 'codeeditor-js');

        $this->addCss('vendor/codemirror/material.css', 'material-css');
        $this->addCss('vendor/codemirror/codemirror.css', 'codemirror-css');
        $this->addJs('vendor/codemirror/codemirror.js', 'codemirror-js');
        $this->addJs('vendor/codemirror/xml/xml.js', 'codemirror-xml-js');
        $this->addJs('vendor/codemirror/css/css.js', 'codemirror-css-js');
        $this->addJs('vendor/codemirror/javascript/javascript.js', 'codemirror-javascript-js');
        $this->addJs('vendor/codemirror/php/php.js', 'codemirror-php-js');
        $this->addJs('vendor/codemirror/htmlmixed/htmlmixed.js', 'codemirror-htmlmixed-js');
        $this->addJs('vendor/codemirror/clike/clike.js', 'codemirror-clike-js');
    }

    /**
     * Prepares the list data
     */
    public function prepareVars()
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
        $this->vars['changedName'] = self::CHANGED_PREFIX.strtolower($this->alias);
    }

    public function getSaveValue($value)
    {
        $name = self::CHANGED_PREFIX.strtolower($this->alias);
        if (post($name) < 1)
            return -1;

        return $value;
    }
}
