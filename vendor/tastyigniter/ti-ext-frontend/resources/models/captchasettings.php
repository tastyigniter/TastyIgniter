<?php

return [
    'form' => [
        'toolbar' => [
            'buttons' => [
                'save' => ['label' => 'lang:admin::lang.button_save', 'class' => 'btn btn-primary', 'data-request' => 'onSave'],
                'saveClose' => [
                    'label' => 'lang:admin::lang.button_save_close',
                    'class' => 'btn btn-default',
                    'data-request' => 'onSave',
                    'data-request-data' => 'close:1',
                ],
            ],
        ],
        'fields' => [
            'setup' => [
                'type' => 'partial',
                'path' => 'igniter.frontend::captcha.setup',
            ],
            'api_site_key' => [
                'label' => 'lang:igniter.frontend::default.captcha.label_api_site_key',
                'span' => 'left',
                'type' => 'text',
            ],
            'api_secret_key' => [
                'label' => 'lang:igniter.frontend::default.captcha.label_api_secret_key',
                'span' => 'right',
                'type' => 'text',
            ],
            'lang' => [
                'label' => 'lang:igniter.frontend::default.captcha.label_lang',
                'span' => 'right',
                'type' => 'text',
                'comment' => 'lang:igniter.frontend::default.captcha.help_lang',
            ],
        ],
        'rules' => [
            ['api_site_key', 'lang:igniter.frontend::default.captcha.label_api_site_key', 'required|string'],
            ['api_secret_key', 'lang:igniter.frontend::default.captcha.label_api_secret_key', 'required|string'],
            ['lang', 'lang:igniter.frontend::default.captcha.label_lang', 'required|string'],
        ],
    ],
];
