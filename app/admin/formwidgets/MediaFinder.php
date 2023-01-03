<?php

namespace Admin\FormWidgets;

use Admin\Classes\BaseFormWidget;
use Admin\Classes\FormField;
use Admin\Traits\ValidatesForm;
use Admin\Widgets\Form;
use Igniter\Flame\Database\Attach\HasMedia;
use Igniter\Flame\Database\Attach\Media;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Flame\Exception\SystemException;
use Illuminate\Support\Collection;
use Main\classes\MediaItem;
use Main\Classes\MediaLibrary;
use System\Models\Settings_model;

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
 */
class MediaFinder extends BaseFormWidget
{
    use ValidatesForm;

    //
    // Configurable properties
    //

    /**
     * @var string Prompt to display if no record is selected.
     */
    public $prompt = 'lang:admin::lang.text_empty';

    /**
     * @var string Display mode. Values: grid, inline.
     */
    public $mode = 'grid';

    public $isMulti = false;

    /**
     * @var array Options used for generating thumbnails.
     */
    public $thumbOptions = [
        'fit' => 'contain',
        'width' => 122,
        'height' => 122,
    ];

    /**
     * @var bool Automatically attaches the chosen file if the parent record exists. Defaults to false.
     */
    public $useAttachment = false;

    //
    // Object properties
    //

    protected $defaultAlias = 'media';

    public function initialize()
    {
        $this->fillFromConfig([
            'mode',
            'isMulti',
            'prompt',
            'thumbOptions',
            'useAttachment',
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
        $this->vars['value'] = $this->getLoadValue();
        $this->vars['fieldName'] = $this->isMulti ? $this->formField->getName().'[]' : $this->formField->getName();
        $this->vars['field'] = $this->formField;
        $this->vars['prompt'] = str_replace('%s', '<i class="icon-folder"></i>', $this->prompt ? lang($this->prompt) : '');
        $this->vars['mode'] = $this->mode;
        $this->vars['isMulti'] = $this->isMulti;
        $this->vars['useAttachment'] = $this->useAttachment;
        $this->vars['chooseButtonText'] = lang($this->useAttachment ? 'main::lang.media_manager.text_attach' : 'main::lang.media_manager.text_choose');
    }

    public function loadAssets()
    {
        if ($this->getConfig('useAttachment')) {
            $this->addJs('../../repeater/assets/js/repeater.js', 'repeater-js');
        }

        $this->addJs('js/mediafinder.js', 'mediafinder-js');
        $this->addCss('css/mediafinder.css', 'mediafinder-css');
    }

    public function getMediaIdentifier($media)
    {
        if ($media instanceof Media)
            return $media->getKey();
    }

    public function getMediaName($media)
    {
        if ($media instanceof Media)
            return $media->getFilename();

        return trim($media, '/');
    }

    public function getMediaPath($media)
    {
        if ($media instanceof Media)
            return $media->getDiskPath();

        try {
            return MediaLibrary::instance()->getMediaRelativePath(trim($media, '/'));
        }
        catch (SystemException $ex) {
            return $media;
        }
    }

    public function getMediaThumb($media)
    {
        if ($media instanceof Media)
            return $media->getThumb($this->thumbOptions);

        if (!strlen($path = trim($media, '/')))
            return $path;

        return MediaLibrary::instance()->getMediaThumb($path, $this->thumbOptions);
    }

    public function getMediaFileType($media)
    {
        $path = trim($media, '/');
        if ($media instanceof Media)
            $path = $media->getFilename();

        $extension = pathinfo($path, PATHINFO_EXTENSION);
        if (!strlen($extension))
            return MediaItem::FILE_TYPE_DOCUMENT;

        if (in_array($extension, Settings_model::imageExtensions()))
            return MediaItem::FILE_TYPE_IMAGE;

        if (in_array($extension, Settings_model::audioExtensions()))
            return MediaItem::FILE_TYPE_AUDIO;

        if (in_array($extension, Settings_model::videoExtensions()))
            return MediaItem::FILE_TYPE_VIDEO;

        return MediaItem::FILE_TYPE_DOCUMENT;
    }

    public function onLoadAttachmentConfig()
    {
        if (!$this->useAttachment || !$mediaId = post('media_id'))
            return;

        if (!in_array(HasMedia::class, class_uses_recursive(get_class($this->model))))
            return;

        $media = $this->model->findMedia($mediaId);

        return [
            '#'.$this->getId('config-modal-content') => $this->makePartial('mediafinder/config_form', [
                'formMediaId' => $mediaId,
                'formWidget' => $this->makeAttachmentConfigFormWidget($media),
            ]),
        ];
    }

    public function onSaveAttachmentConfig()
    {
        if (!$this->useAttachment || !$mediaId = post('media_id'))
            return;

        if (!in_array(HasMedia::class, class_uses_recursive(get_class($this->model))))
            return;

        $media = $this->model->findMedia($mediaId);

        $form = $this->makeAttachmentConfigFormWidget($media);

        $this->validateFormWidget($form, $configData = $form->getSaveData());

        $media->setCustomProperty('title', array_get($configData, 'custom_properties.title'));
        $media->setCustomProperty('description', array_get($configData, 'custom_properties.description'));
        $media->setCustomProperty('extras', array_get($configData, 'custom_properties.extras', []));

        $media->save();

        flash()->success(sprintf(lang('admin::lang.alert_success'), 'Media attachment updated'))->now();

        return ['#notification' => $this->makePartial('flash')];
    }

    public function onRemoveAttachment()
    {
        if (!$this->useAttachment || !$mediaId = post('media_id'))
            return;

        if (!in_array(HasMedia::class, class_uses_recursive(get_class($this->model))))
            return;

        $this->model->deleteMedia($mediaId);
    }

    public function onAddAttachment()
    {
        if (!$this->useAttachment)
            return;

        if (!in_array(HasMedia::class, class_uses_recursive(get_class($this->model))))
            return;

        if (!array_key_exists($this->fieldName, $this->model->mediable())) {
            throw new ApplicationException(sprintf(lang('main::lang.media_manager.alert_missing_mediable'),
                $this->fieldName, get_class($this->model)
            ));
        }

        $items = post('items');
        if (!is_array($items))
            throw new ApplicationException(lang('main::lang.media_manager.alert_select_item_to_attach'));

        $model = $this->model;
        if (!$model->exists)
            throw new ApplicationException(lang('main::lang.media_manager.alert_only_attach_to_saved'));

        $manager = MediaLibrary::instance();
        foreach ($items as &$item) {
            $media = $model->newMediaInstance();
            $media->addFromRaw(
                $manager->get(array_get($item, 'path'), true),
                array_get($item, 'name'),
                $this->fieldName
            );
            $media->save();

            $item['identifier'] = $media->getKey();
        }

        return $items;
    }

    public function getLoadValue()
    {
        $value = parent::getLoadValue();
        if (!is_array($value) && !$value instanceof Collection)
            $value = [$value];

        if (is_array($value))
            $value = array_filter($value);

        if ($this->isMulti) {
            $value[] = null;
        }

        return $value ?? [];
    }

    public function getSaveValue($value)
    {
        if ($this->useAttachment || $this->formField->disabled || $this->formField->hidden) {
            return FormField::NO_SAVE_DATA;
        }

        return $value;
    }

    protected function makeAttachmentConfigFormWidget($model)
    {
        $widgetConfig = $this->getAttachmentFieldsConfig();
        $widgetConfig['model'] = $model;
        $widgetConfig['alias'] = $this->alias.'AttachmentConfig';
        $widgetConfig['arrayName'] = 'media';
        $widget = $this->makeWidget(Form::class, $widgetConfig);

        $widget->bindToController();

        return $widget;
    }

    protected function getAttachmentFieldsConfig()
    {
        return [
            'fields' => [
                'custom_properties[title]' => [
                    'label' => 'lang:main::lang.media_manager.label_attachment_title',
                    'type' => 'text',
                ],
                'custom_properties[description]' => [
                    'label' => 'lang:main::lang.media_manager.label_attachment_description',
                    'type' => 'textarea',
                ],
                'custom_properties[extras]' => [
                    'label' => 'lang:main::lang.media_manager.label_attachment_properties',
                    'type' => 'repeater',
                    'sortable' => false,
                    'form' => [
                        'fields' => [
                            'key' => [
                                'label' => 'lang:main::lang.media_manager.label_attachment_property_key',
                                'type' => 'text',
                            ],
                            'value' => [
                                'label' => 'lang:main::lang.media_manager.label_attachment_property_value',
                                'type' => 'text',
                            ],
                        ],
                    ],
                ],
            ],
            'rules' => [
                ['custom_properties.title', 'lang:main::lang.media_manager.label_attachment_title', 'string|max:128'],
                ['custom_properties.description', 'lang:main::lang.media_manager.label_attachment_description', 'string|max:255'],
                ['custom_properties.extras', 'lang:main::lang.media_manager.label_attachment_properties', 'array'],
                ['custom_properties.extras.*.key', 'lang:main::lang.media_manager.label_attachment_property_key', 'string|max:128'],
                ['custom_properties.extras.*.value', 'lang:main::lang.media_manager.label_attachment_property_value', 'string|max:128'],
            ],
        ];
    }
}
