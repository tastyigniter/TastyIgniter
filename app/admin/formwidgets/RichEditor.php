<?php namespace Admin\FormWidgets;

use Admin\Classes\BaseFormWidget;

/**
 * Rich Editor
 * Renders a rich content editor field.
 *
 * Adapted from october\backend\classes\RichEditor
 *
 * @package Admin
 */
class RichEditor extends BaseFormWidget
{
    //
    // Configurable properties
    //

    /**
     * @var boolean Determines whether content has HEAD and HTML tags.
     */
    public $fullPage = FALSE;

    public $stretch;

    public $size;

    public $toolbarButtons = null;

    //
    // Object properties
    //

    protected $defaultAlias = 'richeditor';

    public function initialize()
    {
        $this->fillFromConfig([
            'fullPage',
            'stretch',
            'size',
            'toolbarButtons',
        ]);
    }

    public function render()
    {
        $this->prepareVars();

        return $this->makePartial('richeditor/richeditor');
    }

    public function loadAssets()
    {
        $this->addCss('vendor/summernote/summernote-bs4.css', 'summernote-css');
        $this->addJs('vendor/summernote/summernote-bs4.min.js', 'summernote-js');
        $this->addCss('css/richeditor.css', 'richeditor-css');
        $this->addJs('js/richeditor.js', 'richeditor-js');
    }

    /**
     * Prepares the list data
     */
    public function prepareVars()
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
     * @return string
     */
    protected function evalToolbarButtons()
    {
        $buttons = $this->toolbarButtons;

        if (is_string($buttons)) {
            $buttons = array_map(function ($button) {
                return strlen($button) ? $button : '|';
            }, explode('|', $buttons));
        }

        return $buttons;
    }
}
