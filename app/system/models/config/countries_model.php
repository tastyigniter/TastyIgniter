<?php
$config['list']['filter'] = [
    'search' => [
        'prompt' => 'lang:system::lang.countries.text_filter_search',
        'mode' => 'all' // or any, exact
    ],
    'scopes' => [
        'status' => [
            'label' => 'lang:system::lang.countries.text_filter_status',
            'type' => 'switch',
            'conditions' => 'status = :filtered',
        ],
    ],
];

$config['list']['toolbar'] = [
    'buttons' => [
        'create' => ['label' => 'lang:admin::lang.button_new', 'class' => 'btn btn-primary', 'href' => 'countries/create'],
        'delete' => ['label' => 'lang:admin::lang.button_delete', 'class' => 'btn btn-danger', 'data-request-form' => '#list-form', 'data-request' => 'onDelete', 'data-request-data' => "_method:'DELETE'", 'data-request-confirm' => 'lang:admin::lang.alert_warning_confirm'],
        'filter' => ['label' => 'lang:admin::lang.button_icon_filter', 'class' => 'btn btn-default btn-filter', 'data-toggle' => 'list-filter', 'data-target' => '.list-filter'],
    ],
];

$config['list']['columns'] = [
    'edit' => [
        'type' => 'button',
        'iconCssClass' => 'fa fa-pencil',
        'attributes' => [
            'class' => 'btn btn-edit',
            'href' => 'countries/edit/{country_id}',
        ],
    ],
    'flag_url' => [
        'label' => 'lang:system::lang.countries.column_flag',
        'type' => 'partial',
        'path' => 'countries/flag_column',
        'cssClass' => 'text-center',
    ],
    'country_name' => [
        'label' => 'lang:system::lang.countries.column_name',
        'type' => 'text',
        'searchable' => TRUE,
    ],
    'iso_code_2' => [
        'label' => 'lang:system::lang.countries.column_iso_code2',
        'type' => 'text',
        'searchable' => TRUE,
    ],
    'iso_code_3' => [
        'label' => 'lang:system::lang.countries.column_iso_code3',
        'type' => 'text',
        'searchable' => TRUE,
    ],
    'status' => [
        'label' => 'lang:system::lang.countries.column_status',
        'type' => 'switch',
        'searchable' => TRUE,
    ],
    'country_id' => [
        'label' => 'lang:admin::lang.column_id',
        'invisible' => TRUE,
    ],

];

$config['form']['toolbar'] = [
    'buttons' => [
        'save' => ['label' => 'lang:admin::lang.button_save', 'class' => 'btn btn-primary', 'data-request-submit' => 'true', 'data-request' => 'onSave'],
        'saveClose' => [
            'label' => 'lang:admin::lang.button_save_close',
            'class' => 'btn btn-default',
            'data-request' => 'onSave',
            'data-request-submit' => 'true',
            'data-request-data' => 'close:1',
        ],
        'delete' => [
            'label' => 'lang:admin::lang.button_icon_delete', 'class' => 'btn btn-danger',
            'data-request-submit' => 'true', 'data-request' => 'onDelete', 'data-request-data' => "_method:'DELETE'",
            'data-request-confirm' => 'lang:admin::lang.alert_warning_confirm', 'context' => 'edit',
        ],
    ],
];

$config['form']['fields'] = [
    'country_name' => [
        'label' => 'lang:system::lang.countries.label_name',
        'type' => 'text',
        'span' => 'left',
    ],
    'priority' => [
        'label' => 'lang:system::lang.countries.label_priority',
        'type' => 'number',
        'default' => 0,
        'span' => 'right',
    ],
    'iso_code_2' => [
        'label' => 'lang:system::lang.countries.label_iso_code2',
        'type' => 'text',
        'span' => 'left',
        'comment' => 'lang:system::lang.countries.help_iso',
    ],
    'iso_code_3' => [
        'label' => 'lang:system::lang.countries.label_iso_code3',
        'type' => 'text',
        'span' => 'right',
    ],
    'flag' => [
        'label' => 'lang:system::lang.countries.label_flag',
        'type' => 'mediafinder',
        'mode' => 'inline',
    ],
    'format' => [
        'label' => 'lang:system::lang.countries.label_format',
        'type' => 'textarea',
        'comment' => 'lang:system::lang.countries.help_format',
    ],
    'status' => [
        'label' => 'lang:admin::lang.label_status',
        'type' => 'switch',
    ],
];

return $config;