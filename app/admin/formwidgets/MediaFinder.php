<?php namespace Admin\FormWidgets;

use Admin\Classes\BaseFormWidget;
use Main\Libraries\MediaManager as MediaLibrary;
use SystemException;

/**
 * Media Finder
 * Renders a record finder field.
 *
 * Adapted from october\backend\formwidgets\MediaFinder
 *
 * image:
 *        label: Some image
 *        type: mediafinder
 *        mode: inline
 *        prompt: Click the %s button to find a user
 *
 * @package Admin
 */
class MediaFinder extends BaseFormWidget
{
    //
    // Configurable properties
    //

    /**
     * @var string Prompt to display if no record is selected.
     */
    public $prompt = 'lang:admin::default.text_empty';

    /**
     * @var string Display mode for the selection. Values: picker, inline.
     */
    public $mode = 'grid';

    public $isMulti = FALSE;

    public $blankImage = 'no_photo.png';

    //
    // Object properties
    //

    protected $defaultAlias = 'media';

    public function initialize()
    {
        $this->fillFromConfig([
            'mode',
            'blankImage',
            'isMulti',
            'prompt',
        ]);
    }

    public function render()
    {
        $this->prepareVars();

        return $this->makePartial('mediafinder/mediafinder');
    }

    /**
     * Prepares the list data
     */
    public function prepareVars()
    {
        $this->vars['value'] = $this->getFormValue();
        $this->vars['fieldName'] = $this->isMulti ? $this->formField->getName().'[]' : $this->formField->getName();
        $this->vars['field'] = $this->formField;
        $this->vars['prompt'] = str_replace('%s', '<i class="icon-folder"></i>', $this->prompt ? lang($this->prompt) : '');
        $this->vars['mode'] = $this->mode;
        $this->vars['isMulti'] = $this->isMulti;
        $this->vars['blankImage'] = $this->blankImage;
    }

    public function loadAssets()
    {
        $this->addJs('js/mediafinder.js', 'mediafinder-js');
        $this->addCss('css/mediafinder.css', 'mediafinder-css');
    }

    public function getMediaUrl($imagePath)
    {
        $imagePath = trim($imagePath, '/');

        return MediaLibrary::instance()->getMediaUrl($imagePath);
    }

    protected function getFormValue()
    {
        $value = $this->formField->value;
        try {
            if (is_array($value))
                array_map(function ($val) {
                    return MediaLibrary::instance()->getMediaRelativePath($val);
                }, $value);

            return MediaLibrary::instance()->getMediaRelativePath($value);
        } catch (SystemException $e) {
            return $value;
        }
    }
}