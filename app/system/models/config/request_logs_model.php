<?php
$config['list']['filter'] = [
    'search' => [
        'prompt' => 'lang:system::lang.request_logs.text_filter_search',
        'mode' => 'all' // or any, exact
    ],
];

$config['list']['toolbar'] = [
    'buttons' => [
        'back' => [
            'label' => 'lang:admin::lang.button_icon_back',
            'class' => 'btn btn-default',
            'href' => 'system_logs',
        ],
        'refresh' => [
            'label' => 'lang:admin::lang.button_refresh',
            'class' => 'btn btn-primary',
            'href' => 'request_logs',
        ],
        'delete' => [
            'label' => 'lang:admin::lang.button_delete',
            'class' => 'btn btn-danger',
            'data-attach-loading' => '',
            'data-request' => 'onDelete',
            'data-request-form' => '#list-form',
            'data-request-data' => "_method:'DELETE'",
            'data-request-confirm' => 'lang:admin::lang.alert_warning_confirm',
        ],
        'empty_log' => [
            'label' => 'lang:system::lang.system_logs.button_empty',
            'class' => 'btn btn-danger',
            'data-attach-loading' => '',
            'data-request' => 'onEmptyLog',
            'data-request-form' => '#list-form',
            'data-request-data' => "_method:'DELETE'",
            'data-request-confirm' => 'lang:admin::lang.alert_warning_confirm',
        ],
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
        'label' => 'lang:system::lang.request_logs.column_status_code',
        'type' => 'text',
        'searchable' => TRUE,
    ],
    'url' => [
        'label' => 'lang:system::lang.request_logs.column_url',
        'type' => 'text',
        'searchable' => TRUE,
    ],
    'count' => [
        'label' => 'lang:system::lang.request_logs.column_count',
        'type' => 'text',
    ],
];

$config['form']['toolbar'] = [
    'buttons' => [
        'back' => [
            'label' => 'lang:admin::lang.button_icon_back',
            'class' => 'btn btn-default',
            'href' => 'request_logs',
        ],
    ],
];

$config['form']['fields'] = [
    'currency_id' => [
        'label' => 'lang:admin::lang.column_id',
        'type' => 'number',
        'span' => 'left',
        'cssClass' => 'flex-width',
    ],
    'status_code' => [
        'label' => 'lang:system::lang.request_logs.column_status_code',
        'type' => 'number',
        'span' => 'left',
        'cssClass' => 'flex-width',
    ],
    'count' => [
        'label' => 'lang:system::lang.request_logs.column_count',
        'type' => 'number',
        'span' => 'left',
        'cssClass' => 'flex-width',
    ],
    'url' => [
        'label' => 'lang:system::lang.request_logs.label_url',
        'type' => 'text',
    ],
    'referrer' => [
        'label' => 'lang:system::lang.request_logs.label_referer',
        'type' => 'partial',
        'path' => 'field_referrer',
    ],
];

return $config;