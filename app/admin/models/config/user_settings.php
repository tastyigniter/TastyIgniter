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
                    'data-request-submit' => 'true',
                    'data-request' => 'onSave',
                ],
                'saveClose' => [
                    'label' => 'lang:admin::lang.button_save_close',
                    'class' => 'btn btn-default',
                    'data-request' => 'onSave',
                    'data-request-submit' => 'true',
                    'data-request-data' => 'close:1',
                ],
            ],
        ],
        'fields' => [
            'allow_registration' => [
                'label' => 'lang:system::lang.settings.label_allow_registration',
                'type' => 'switch',
                'default' => TRUE,
                'comment' => 'lang:system::lang.settings.help_allow_registration',
            ],
            'registration_email' => [
                'label' => 'lang:system::lang.settings.label_registration_email',
                'type' => 'checkboxtoggle',
                'options' => [
                    'customer' => 'lang:system::lang.settings.text_to_customer',
                    'admin' => 'lang:system::lang.settings.text_to_admin',
                ],
                'comment' => 'lang:system::lang.settings.help_registration_email',
            ],
        ],
        'rules' => [
            ['allow_registration', 'lang:system::lang.settings.label_allow_registration', 'required|integer'],
            ['registration_email.*', 'lang:system::lang.settings.label_registration_email', 'required|alpha'],
        ],
    ],
];