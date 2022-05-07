<?php

return [
    'form' => [
        'toolbar' => [
            'buttons' => [
                'back' => [
                    'label' => 'lang:admin::lang.button_icon_back',
                    'class' => 'btn btn-outline-secondary',
                    'href' => 'settings',
                ],
                'save' => [
                    'label' => 'lang:admin::lang.button_save',
                    'class' => 'btn btn-primary',
                    'data-request' => 'onSave',
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
                'default' => true,
                'span' => 'left',
                'comment' => 'lang:system::lang.settings.help_media_upload',
            ],
            'image_manager[new_folder]' => [
                'label' => 'lang:system::lang.settings.label_media_new_folder',
                'type' => 'switch',
                'default' => true,
                'span' => 'right',
                'comment' => 'lang:system::lang.settings.help_media_new_folder',
            ],
            'image_manager[copy]' => [
                'label' => 'lang:system::lang.settings.label_media_copy',
                'type' => 'switch',
                'default' => true,
                'span' => 'left',
                'comment' => 'lang:system::lang.settings.help_media_copy',
            ],
            'image_manager[move]' => [
                'label' => 'lang:system::lang.settings.label_media_move',
                'type' => 'switch',
                'default' => true,
                'span' => 'right',
                'comment' => 'lang:system::lang.settings.help_media_move',
            ],
            'image_manager[rename]' => [
                'label' => 'lang:system::lang.settings.label_media_rename',
                'type' => 'switch',
                'default' => true,
                'span' => 'left',
                'comment' => 'lang:system::lang.settings.help_media_rename',
            ],
            'image_manager[delete]' => [
                'label' => 'lang:system::lang.settings.label_media_delete',
                'type' => 'switch',
                'default' => true,
                'span' => 'right',
                'comment' => 'lang:system::lang.settings.help_media_delete',
            ],
        ],
    ],
];
