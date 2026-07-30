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
            'api_key' => [
                'label' => 'MailChimp API key',
                'span' => 'left',
                'type' => 'text',
                'comment' => 'Get an API Key from http://admin.mailchimp.com/account/api/',
            ],
            'list_id' => [
                'label' => 'MailChimp List/Audience ID',
                'span' => 'right',
                'type' => 'text',
                'comment' => 'List/Audience ID from MailChimp. Email will be added to this list',
            ],
        ],
        'rules' => [
            ['api_key', 'MailChimp API key', 'required|string'],
            ['list_id', 'MailChimp List Id', 'required|string'],
        ],
    ],
];
