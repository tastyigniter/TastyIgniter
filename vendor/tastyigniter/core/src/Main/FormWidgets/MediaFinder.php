<?php

declare(strict_types=1);

namespace Igniter\Main\FormWidgets;

use Igniter\Admin\Classes\BaseFormWidget;
use Igniter\Admin\Classes\FormField;
use Igniter\Admin\Traits\ValidatesForm;
use Igniter\Admin\Widgets\Form;
use Igniter\Flame\Database\Attach\HasMedia;
use Igniter\Flame\Database\Attach\Media;
use Igniter\Flame\Exception\FlashException;
use Igniter\Main\Classes\MediaItem;
use Igniter\Main\Classes\MediaLibrary;
use Igniter\System\Models\Settings;
use Illuminate\Support\Collection;
use Override;

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

    /** Prompt to display if no record is selected. */
    public string $prompt = 'lang:igniter::admin.text_empty';

    /** Display mode. Values: grid, inline. */
    public string $mode = 'grid';

    public bool $isMulti = false;

    /** Options used for generating thumbnails. */
    public array $thumbOptions = [
        'fit' => 'contain',
        'width' => 122,
        'height' => 122,
    ];

    /** Automatically attaches the chosen file if the parent record exists. Defaults to false. */
    public bool $useAttachment = false;

    //
    // Object properties
    //

    protected string $defaultAlias = 'media';

    #[Override]
    public function initialize(): void
    {
        $this->fillFromConfig([
            'mode',
            'isMulti',
            'prompt',
            'thumbOptions',
            'useAttachment',
        ]);
    }

    #[Override]
    public function render(): string
    {
        $this->prepareVars();

        return $this->makePartial('mediafinder/mediafinder');
    }

    /**
     * Prepares the list data
     */
    public function prepareVars(): void
    {
        $this->vars['value'] = $this->getLoadValue();
        $this->vars['fieldName'] = $this->isMulti ? $this->formField->getName().'[]' : $this->formField->getName();
        $this->vars['field'] = $this->formField;
        $this->vars['prompt'] = str_replace('%s', '<i class="icon-folder"></i>', !empty($this->prompt) ? lang($this->prompt) : '');
        $this->vars['mode'] = $this->mode;
        $this->vars['isMulti'] = $this->isMulti;
        $this->vars['useAttachment'] = $this->useAttachment;
        $this->vars['chooseButtonText'] = lang($this->useAttachment ? 'igniter::main.media_manager.text_attach' : 'igniter::main.media_manager.text_choose');
    }

    #[Override]
    public function loadAssets(): void
    {
        if ($this->getConfig('useAttachment')) {
            $this->addJs('formwidgets/repeater.js', 'repeater-js');
        }

        $this->addJs('mediafinder.js', 'mediafinder-js');
        $this->addCss('mediafinder.css', 'mediafinder-css');
    }

    public function getMediaIdentifier(null|string|Media $media): mixed
    {
        if ($media instanceof Media) {
            return $media->getKey();
        }

        return null;
    }

    public function getMediaName(null|string|Media $media): string
    {
        if ($media instanceof Media) {
            return $media->getFilename();
        }

        return trim((string)$media, '/');
    }

    public function getMediaPath(null|string|Media $media): string
    {
        if ($media instanceof Media) {
            return $media->getDiskPath();
        }

        return resolve(MediaLibrary::class)->getMediaRelativePath(trim((string)$media, '/'));
    }

    public function getMediaThumb(null|string|Media $media): string
    {
        if ($media instanceof Media) {
            return $media->getThumb($this->thumbOptions);
        }

        if (empty($path = trim((string)$media, '/'))) {
            return $path;
        }

        return resolve(MediaLibrary::class)->getMediaThumb($path, $this->thumbOptions);
    }

    public function getMediaFileType(null|string|Media $media): string
    {
        $path = is_string($media) ? trim($media, '/') : null;
        if ($media instanceof Media) {
            $path = $media->getFilename();
        }

        $extension = pathinfo((string)$path, PATHINFO_EXTENSION);
        if (empty($extension)) {
            return MediaItem::FILE_TYPE_DOCUMENT;
        }

        if (in_array($extension, Settings::imageExtensions())) {
            return MediaItem::FILE_TYPE_IMAGE;
        }

        if (in_array($extension, Settings::audioExtensions())) {
            return MediaItem::FILE_TYPE_AUDIO;
        }

        if (in_array($extension, Settings::videoExtensions())) {
            return MediaItem::FILE_TYPE_VIDEO;
        }

        return MediaItem::FILE_TYPE_DOCUMENT;
    }

    public function onLoadAttachmentConfig(): array
    {
        if (!$this->useAttachment || !$mediaId = post('media_id')) {
            return [];
        }

        if (!in_array(HasMedia::class, class_uses_recursive($this->model::class))) {
            return [];
        }

        $media = $this->model->findMedia($mediaId);

        return [
            '#'.$this->getId('config-modal-content') => $this->makePartial('mediafinder/config_form', [
                'formMediaId' => $mediaId,
                'formWidget' => $this->makeAttachmentConfigFormWidget($media),
            ]),
        ];
    }

    public function onSaveAttachmentConfig(): array
    {
        if (!$this->useAttachment || !$mediaId = post('media_id')) {
            return [];
        }

        if (!in_array(HasMedia::class, class_uses_recursive($this->model::class))) {
            return [];
        }

        $media = $this->model->findMedia($mediaId);

        $form = $this->makeAttachmentConfigFormWidget($media);

        $this->validateFormWidget($form, $configData = $form->getSaveData());

        $media->setCustomProperty('title', array_get($configData, 'custom_properties.title'));
        $media->setCustomProperty('description', array_get($configData, 'custom_properties.description'));
        $media->setCustomProperty('extras', array_get($configData, 'custom_properties.extras', []));

        $media->save();

        flash()->success(sprintf(lang('igniter::admin.alert_success'), 'Media attachment updated'))->now();

        return ['#notification' => $this->makePartial('flash')];
    }

    public function onRemoveAttachment(): void
    {
        if (!$this->useAttachment || !$mediaId = post('media_id')) {
            return;
        }

        if (!in_array(HasMedia::class, class_uses_recursive($this->model::class))) {
            return;
        }

        $this->model->deleteMedia($mediaId);
    }

    public function onAddAttachment(): array
    {
        if (!$this->useAttachment) {
            return [];
        }

        if (!in_array(HasMedia::class, class_uses_recursive($this->model::class))) {
            return [];
        }

        if (!array_key_exists($this->fieldName, $this->model->mediable())) {
            throw new FlashException(sprintf(lang('igniter::main.media_manager.alert_missing_mediable'),
                $this->fieldName, $this->model::class,
            ));
        }

        $data = $this->validate(request()->input(), [
            'items' => ['required', 'array'],
            'items.*.name' => ['required', 'string'],
            'items.*.path' => ['required', 'string'],
            'items.*.publicUrl' => ['required', 'string'],
            'items.*.fileType' => ['required', 'string'],
        ]);

        $model = $this->model;
        if (!$model->exists) {
            throw new FlashException(lang('igniter::main.media_manager.alert_only_attach_to_saved'));
        }

        $manager = resolve(MediaLibrary::class);
        foreach ($data['items'] as &$item) {
            $item['path'] = strip_tags((string)$item['path']);

            $media = $model->newMediaInstance();
            $media->addFromRaw(
                $manager->get(array_get($item, 'path'), true),
                array_get($item, 'name'),
                $this->fieldName,
            );
            $media->save();

            $item['identifier'] = $media->getKey();
        }

        return [
            'result' => $data['items'],
        ];
    }

    #[Override]
    public function getLoadValue(): mixed
    {
        $value = parent::getLoadValue();
        if (!is_array($value) && !$value instanceof Collection) {
            $value = [$value];
        }

        if (is_array($value)) {
            $value = array_filter($value);
        }

        if ($this->isMulti) {
            $value[] = null;
        }

        return $value;
    }

    #[Override]
    public function getSaveValue(mixed $value): mixed
    {
        if ($this->useAttachment || $this->formField->disabled || $this->formField->hidden) {
            return FormField::NO_SAVE_DATA;
        }

        return $value;
    }

    protected function makeAttachmentConfigFormWidget($model): Form
    {
        $widgetConfig = $this->getAttachmentFieldsConfig();
        $widgetConfig['model'] = $model;
        $widgetConfig['alias'] = $this->alias.'AttachmentConfig';
        $widgetConfig['arrayName'] = 'media';

        /** @var Form $widget */
        $widget = $this->makeWidget(Form::class, $widgetConfig);

        $widget->bindToController();

        return $widget;
    }

    protected function getAttachmentFieldsConfig(): array
    {
        return [
            'fields' => [
                'custom_properties[title]' => [
                    'label' => 'lang:igniter::main.media_manager.label_attachment_title',
                    'type' => 'text',
                ],
                'custom_properties[description]' => [
                    'label' => 'lang:igniter::main.media_manager.label_attachment_description',
                    'type' => 'textarea',
                ],
                'custom_properties[extras]' => [
                    'label' => 'lang:igniter::main.media_manager.label_attachment_properties',
                    'type' => 'repeater',
                    'sortable' => false,
                    'form' => [
                        'fields' => [
                            'key' => [
                                'label' => 'lang:igniter::main.media_manager.label_attachment_property_key',
                                'type' => 'text',
                            ],
                            'value' => [
                                'label' => 'lang:igniter::main.media_manager.label_attachment_property_value',
                                'type' => 'text',
                            ],
                        ],
                    ],
                ],
            ],
            'rules' => [
                ['custom_properties.title', 'lang:igniter::main.media_manager.label_attachment_title', 'string|max:255'],
                ['custom_properties.description', 'lang:igniter::main.media_manager.label_attachment_description', 'string|max:255'],
                ['custom_properties.extras', 'lang:igniter::main.media_manager.label_attachment_properties', 'array'],
                ['custom_properties.extras.*.key', 'lang:igniter::main.media_manager.label_attachment_property_key', 'string|max:255'],
                ['custom_properties.extras.*.value', 'lang:igniter::main.media_manager.label_attachment_property_value', 'string|max:255'],
            ],
        ];
    }
}
