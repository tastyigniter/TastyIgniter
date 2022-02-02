<?php

namespace Main\Requests;

use System\Classes\FormRequest;

class MediaSettings extends FormRequest
{
    public function attributes()
    {
        return [
            'image_manager.max_size' => lang('system::lang.settings.label_media_max_size'),
            'image_manager.uploads' => lang('system::lang.settings.label_media_uploads'),
            'image_manager.new_folder' => lang('system::lang.settings.label_media_new_folder'),
            'image_manager.copy' => lang('system::lang.settings.label_media_copy'),
            'image_manager.move' => lang('system::lang.settings.label_media_move'),
            'image_manager.rename' => lang('system::lang.settings.label_media_rename'),
            'image_manager.delete' => lang('system::lang.settings.label_media_delete'),
        ];
    }

    public function rules()
    {
        return [
            'image_manager.max_size' => ['required', 'numeric'],
            'image_manager.uploads' => ['integer'],
            'image_manager.new_folder' => ['integer'],
            'image_manager.copy' => ['integer'],
            'image_manager.move' => ['integer'],
            'image_manager.rename' => ['integer'],
            'image_manager.delete' => ['integer'],
        ];
    }
}
