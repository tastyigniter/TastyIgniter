<?php

use Illuminate\Support\Str;

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
            'provider' => [
                'label' => 'lang:igniter.broadcast::default.label_provider',
                'type' => 'radiotoggle',
                'default' => 'pusher',
                'options' => [
                    'pusher' => 'lang:igniter.broadcast::default.text_pusher',
                    'reverb' => 'lang:igniter.broadcast::default.text_reverb',
                    'ably' => 'lang:igniter.broadcast::default.text_ably',
                    'none' => 'lang:igniter.broadcast::default.text_disabled',
                ],
            ],
            'reverb_host' => [
                'label' => 'lang:igniter.broadcast::default.label_reverb_host',
                'span' => 'left',
                'type' => 'text',
                'default' => 'localhost',
                'comment' => 'lang:igniter.broadcast::default.help_reverb_setup',
                'trigger' => [
                    'action' => 'show',
                    'field' => 'provider',
                    'condition' => 'value[reverb]',
                ],
            ],
            'reverb_port' => [
                'label' => 'lang:igniter.broadcast::default.label_reverb_port',
                'span' => 'left',
                'type' => 'number',
                'default' => 443,
                'trigger' => [
                    'action' => 'show',
                    'field' => 'provider',
                    'condition' => 'value[reverb]',
                ],
            ],
            'reverb_scheme' => [
                'label' => 'lang:igniter.broadcast::default.label_reverb_scheme',
                'span' => 'left',
                'type' => 'text',
                'default' => 'https',
                'trigger' => [
                    'action' => 'show',
                    'field' => 'provider',
                    'condition' => 'value[reverb]',
                ],
            ],
            'reverb_app_id' => [
                'label' => 'lang:igniter.broadcast::default.label_app_id',
                'span' => 'left',
                'type' => 'text',
                'default' => random_int(100_000, 999_999),
                'trigger' => [
                    'action' => 'show',
                    'field' => 'provider',
                    'condition' => 'value[reverb]',
                ],
            ],
            'reverb_key' => [
                'label' => 'lang:igniter.broadcast::default.label_key',
                'span' => 'right',
                'type' => 'text',
                'default' => Str::lower(Str::random(20)),
                'trigger' => [
                    'action' => 'show',
                    'field' => 'provider',
                    'condition' => 'value[reverb]',
                ],
            ],
            'reverb_secret' => [
                'label' => 'lang:igniter.broadcast::default.label_secret',
                'span' => 'left',
                'type' => 'text',
                'default' => Str::lower(Str::random(20)),
                'trigger' => [
                    'action' => 'show',
                    'field' => 'provider',
                    'condition' => 'value[reverb]',
                ],
            ],
            'app_id' => [
                'label' => 'lang:igniter.broadcast::default.label_app_id',
                'span' => 'left',
                'type' => 'text',
                'trigger' => [
                    'action' => 'show',
                    'field' => 'provider',
                    'condition' => 'value[pusher]',
                ],
            ],
            'key' => [
                'label' => 'lang:igniter.broadcast::default.label_key',
                'span' => 'right',
                'type' => 'text',
                'trigger' => [
                    'action' => 'show',
                    'field' => 'provider',
                    'condition' => 'value[pusher]',
                ],
            ],
            'secret' => [
                'label' => 'lang:igniter.broadcast::default.label_secret',
                'span' => 'left',
                'type' => 'text',
                'trigger' => [
                    'action' => 'show',
                    'field' => 'provider',
                    'condition' => 'value[pusher]',
                ],
            ],
            'cluster' => [
                'label' => 'lang:igniter.broadcast::default.label_cluster',
                'span' => 'right',
                'default' => 'mt1',
                'type' => 'text',
                'trigger' => [
                    'action' => 'show',
                    'field' => 'provider',
                    'condition' => 'value[pusher]',
                ],
            ],
            'encrypted' => [
                'label' => 'lang:igniter.broadcast::default.label_encrypted',
                'span' => 'left',
                'type' => 'switch',
                'default' => true,
                'trigger' => [
                    'action' => 'show',
                    'field' => 'provider',
                    'condition' => 'value[pusher]',
                ],
            ],
            'ably_key' => [
                'label' => 'lang:igniter.broadcast::default.label_key',
                'span' => 'right',
                'type' => 'text',
                'trigger' => [
                    'action' => 'show',
                    'field' => 'provider',
                    'condition' => 'value[ably]',
                ],
            ],
        ],
        'rules' => [
            ['provider', 'lang:igniter.broadcast::default.label_provider', 'required|string|in:pusher,reverb,ably,none'],
            ['reverb_host', 'lang:igniter.broadcast::default.label_reverb_host', 'nullable|required_if:provider,reverb|string'],
            ['reverb_port', 'lang:igniter.broadcast::default.label_reverb_port', 'nullable|required_if:provider,reverb|integer'],
            ['reverb_scheme', 'lang:igniter.broadcast::default.label_reverb_scheme', 'nullable|required_if:provider,reverb|string'],
            ['reverb_app_id', 'lang:igniter.broadcast::default.label_reverb_app_id', 'nullable|required_if:provider,reverb|integer'],
            ['reverb_key', 'lang:igniter.broadcast::default.label_reverb_key', 'nullable|required_if:provider,reverb|string'],
            ['reverb_secret', 'lang:igniter.broadcast::default.label_reverb_secret', 'nullable|required_if:provider,reverb|string'],
            ['app_id', 'lang:igniter.broadcast::default.label_app_id', 'nullable|required_if:provider,pusher|integer'],
            ['key', 'lang:igniter.broadcast::default.label_key', 'nullable|required_if:provider,pusher|string'],
            ['secret', 'lang:igniter.broadcast::default.label_secret', 'nullable|required_if:provider,pusher|string'],
            ['cluster', 'lang:igniter.broadcast::default.label_cluster', 'nullable|required_if:provider,pusher|string'],
            ['encrypted', 'lang:igniter.broadcast::default.label_encrypted', 'nullable|required_if:provider,pusher|boolean'],
            ['ably_key', 'lang:igniter.broadcast::default.label_key', 'nullable|required_if:provider,ably|string'],
        ],
    ],
];
