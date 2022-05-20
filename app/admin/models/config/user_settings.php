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
            'allow_registration' => [
                'label' => 'lang:system::lang.settings.label_allow_registration',
                'type' => 'switch',
                'default' => true,
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
    ],
];
