<?php

$config['list']['filter'] = [
    'search' => [
        'prompt' => 'lang:igniter::system.request_logs.text_filter_search',
        'mode' => 'all', // or any, exact
    ],
];

$config['list']['toolbar'] = [
    'buttons' => [
        'refresh' => [
            'label' => 'lang:igniter::admin.button_refresh',
            'class' => 'btn btn-primary',
            'href' => 'request_logs',
        ],
        'empty_log' => [
            'label' => 'lang:igniter::system.system_logs.button_empty',
            'class' => 'btn btn-danger',
            'data-attach-loading' => '',
            'data-request' => 'onEmptyLog',
            'data-request-form' => '#lists-list-form',
            'data-request-data' => "_method:'DELETE'",
            'data-request-confirm' => 'lang:igniter::admin.alert_warning_confirm',
        ],
    ],
];

$config['list']['bulkActions'] = [
    'delete' => [
        'label' => 'lang:igniter::admin.button_delete',
        'class' => 'btn btn-light text-danger',
        'data-request-confirm' => 'lang:igniter::admin.alert_warning_confirm',
    ],
];

$config['list']['columns'] = [
    'preview' => [
        'type' => 'button',
        'iconCssClass' => 'fa fa-pencil',
        'attributes' => [
            'class' => 'btn btn-edit',
            'href' => 'request_logs/preview/{id}',
        ],
    ],
    'status_code' => [
        'label' => 'lang:igniter::system.request_logs.column_status_code',
        'type' => 'text',
        'searchable' => true,
    ],
    'url' => [
        'label' => 'lang:igniter::system.request_logs.column_url',
        'type' => 'text',
        'searchable' => true,
    ],
    'count' => [
        'label' => 'lang:igniter::system.request_logs.column_count',
        'type' => 'text',
    ],
];

$config['form']['fields'] = [
    'currency_id' => [
        'label' => 'lang:igniter::admin.column_id',
        'type' => 'number',
        'span' => 'left',
        'cssClass' => 'flex-width',
    ],
    'status_code' => [
        'label' => 'lang:igniter::system.request_logs.column_status_code',
        'type' => 'number',
        'span' => 'left',
        'cssClass' => 'flex-width',
    ],
    'count' => [
        'label' => 'lang:igniter::system.request_logs.column_count',
        'type' => 'number',
        'span' => 'left',
        'cssClass' => 'flex-width',
    ],
    'url' => [
        'label' => 'lang:igniter::system.request_logs.label_url',
        'type' => 'text',
    ],
    'referrer' => [
        'label' => 'lang:igniter::system.request_logs.label_referer',
        'type' => 'partial',
        'path' => 'field_referrer',
    ],
];

return $config;
