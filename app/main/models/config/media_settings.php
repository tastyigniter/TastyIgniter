<?php

return [
    'form' => [
        'toolbar' => [
            'buttons' => [
                'back' => [
                    'label' => 'lang:admin::lang.button_icon_back',
                    'class' => 'btn btn-default',
                    'href' => 'settings',
                ],
                'save' => [
                    'label' => 'lang:admin::lang.button_save',
                    'class' => 'btn btn-primary',
                    'data-request' => 'onSave',
                    'data-progress-indicator' => 'admin::lang.text_saving',
                ],
                'saveClose' => [
                    'label' => 'lang:admin::lang.button_save_close',
                    'class' => 'btn btn-default',
                    'data-request' => 'onSave',
                    'data-request-data' => 'close:1',
                    'data-progress-indicator' => 'admin::lang.text_saving',
                ],
            ],
        ],
        'fields' => [
            'image_manager[max_size]' => [
                'label' => 'lang:system::lang.settings.label_media_max_size',
                'type' => 'number',
                'default' => 300,
                'comment' => 'lang:system::lang.settings.help_media_max_size',
            ],
            'image_manager[uploads]' => [
                'label' => 'lang:system::lang.settings.label_media_uploads',
                'type' => 'switch',
                'default' => TRUE,
                'span' => 'left',
                'comment' => 'lang:system::lang.settings.help_media_upload',
            ],
            'image_manager[new_folder]' => [
                'label' => 'lang:system::lang.settings.label_media_new_folder',
                'type' => 'switch',
                'default' => TRUE,
                'span' => 'right',
                'comment' => 'lang:system::lang.settings.help_media_new_folder',
            ],
            'image_manager[copy]' => [
                'label' => 'lang:system::lang.settings.label_media_copy',
                'type' => 'switch',
                'default' => TRUE,
                'span' => 'left',
                'comment' => 'lang:system::lang.settings.help_media_copy',
            ],
            'image_manager[move]' => [
                'label' => 'lang:system::lang.settings.label_media_move',
                'type' => 'switch',
                'default' => TRUE,
                'span' => 'right',
                'comment' => 'lang:system::lang.settings.help_media_move',
            ],
            'image_manager[rename]' => [
                'label' => 'lang:system::lang.settings.label_media_rename',
                'type' => 'switch',
                'default' => TRUE,
                'span' => 'left',
                'comment' => 'lang:system::lang.settings.help_media_rename',
            ],
            'image_manager[delete]' => [
                'label' => 'lang:system::lang.settings.label_media_delete',
                'type' => 'switch',
                'default' => TRUE,
                'span' => 'right',
                'comment' => 'lang:system::lang.settings.help_media_delete',
            ],
        ],
        'rules' => [
            ['image_manager.max_size', 'lang:system::lang.settings.label_media_max_size', 'required|numeric'],
            ['image_manager.uploads', 'lang:system::lang.settings.label_media_uploads', 'integer'],
            ['image_manager.new_folder', 'lang:system::lang.settings.label_media_new_folder', 'integer'],
            ['image_manager.copy', 'lang:system::lang.settings.label_media_copy', 'integer'],
            ['image_manager.move', 'lang:system::lang.settings.label_media_move', 'integer'],
            ['image_manager.rename', 'lang:system::lang.settings.label_media_rename', 'integer'],
            ['image_manager.delete', 'lang:system::lang.settings.label_media_delete', 'integer'],
        ],
    ],
];