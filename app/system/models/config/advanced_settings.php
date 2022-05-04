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
            ],
        ],
        'fields' => [
            'system_log' => [
                'label' => 'lang:system::lang.settings.text_tab_title_system_log',
                'type' => 'section',
            ],
            'enable_request_log' => [
                'label' => 'lang:system::lang.settings.label_enable_request_log',
                'type' => 'switch',
                'default' => true,
                'comment' => 'lang:system::lang.settings.help_enable_request_log',
            ],
            'maintenance' => [
                'label' => 'lang:system::lang.settings.text_tab_title_maintenance',
                'type' => 'section',
            ],
            'maintenance_mode' => [
                'label' => 'lang:system::lang.settings.label_maintenance_mode',
                'type' => 'switch',
                'comment' => 'lang:system::lang.settings.help_maintenance',
            ],
            'maintenance_message' => [
                'label' => 'lang:system::lang.settings.label_maintenance_message',
                'type' => 'textarea',
                'default' => 'Site is under maintenance. Please check back later.',
                'trigger' => [
                    'action' => 'show',
                    'field' => 'maintenance_mode',
                    'condition' => 'checked',
                ],
            ],
            'activity_log' => [
                'label' => 'lang:system::lang.settings.text_tab_title_activity_log',
                'type' => 'section',
            ],
            'activity_log_timeout' => [
                'label' => 'lang:system::lang.settings.label_activity_log_timeout',
                'type' => 'number',
                'default' => '60',
                'comment' => 'lang:system::lang.settings.help_activity_log_timeout',
            ],
        ],
    ],
];
