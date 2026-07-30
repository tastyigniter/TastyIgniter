<?php

return [
    'form' => [
        'toolbar' => [
            'buttons' => [
                'save' => [
                    'label' => 'lang:igniter::admin.button_save',
                    'class' => 'btn btn-primary',
                    'data-request' => 'onSave',
                    'data-progress-indicator' => 'igniter::admin.text_saving',
                ],
            ],
        ],
        'fields' => [
            'allow_registration' => [
                'label' => 'lang:igniter.user::default.label_allow_registration',
                'type' => 'switch',
                'default' => true,
                'comment' => 'lang:igniter.user::default.help_allow_registration',
            ],
            'registration_email' => [
                'label' => 'lang:igniter.user::default.label_registration_email',
                'type' => 'checkboxtoggle',
                'options' => [
                    'customer' => 'lang:igniter::system.settings.text_to_customer',
                    'admin' => 'lang:igniter::system.settings.text_to_admin',
                ],
                'comment' => 'lang:igniter.user::default.help_registration_email',
            ],
        ],
    ],
];
