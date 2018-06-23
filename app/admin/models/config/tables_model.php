<?php
$config['list']['filter'] = [
    'search' => [
        'prompt' => 'lang:admin::tables.text_filter_search',
        'mode'   => 'all' // or any, exact
    ],
    'scopes' => [
        'status' => [
            'label'      => 'lang:admin::tables.text_filter_status',
            'type'       => 'switch',
            'conditions' => 'table_status = :filtered',
        ],
    ],
];

$config['list']['toolbar'] = [
    'buttons' => [
        'create' => ['label' => 'lang:admin::default.button_new', 'class' => 'btn btn-primary', 'href' => 'tables/create'],
        'delete' => ['label' => 'lang:admin::default.button_delete', 'class' => 'btn btn-danger', 'data-request-form' => '#list-form', 'data-request' => 'onDelete', 'data-request-data' => "_method:'DELETE'", 'data-request-confirm' => 'lang:admin::default.alert_warning_confirm'],
        'filter' => ['label' => 'lang:admin::default.button_icon_filter', 'class' => 'btn btn-default btn-filter', 'data-toggle' => 'list-filter', 'data-target' => '.list-filter'],
    ],
];

$config['list']['columns'] = [
    'edit'         => [
        'type'         => 'button',
        'iconCssClass' => 'fa fa-pencil',
        'attributes'   => [
            'class' => 'btn btn-edit',
            'href'  => 'tables/edit/{table_id}',
        ],
    ],
    'table_name'   => [
        'label'      => 'lang:admin::tables.column_name',
        'type'       => 'text',
        'searchable' => TRUE,
    ],
    'min_capacity' => [
        'label'      => 'lang:admin::tables.column_min_capacity',
        'type'       => 'text',
        'searchable' => TRUE,
    ],
    'max_capacity' => [
        'label' => 'lang:admin::tables.column_capacity',
        'type'  => 'number',
    ],
    'table_status' => [
        'label' => 'lang:admin::tables.column_status',
        'type'  => 'switch',
    ],
    'table_id'     => [
        'label'     => 'lang:admin::default.column_id',
        'invisible' => TRUE,
    ],

];

$config['form']['toolbar'] = [
    'buttons' => [
        'save'      => ['label' => 'lang:admin::default.button_save', 'class' => 'btn btn-primary', 'data-request-form' => '#edit-form', 'data-request' => 'onSave'],
        'saveClose' => [
            'label'             => 'lang:admin::default.button_save_close',
            'class'             => 'btn btn-default',
            'data-request'      => 'onSave',
            'data-request-form' => '#edit-form',
            'data-request-data' => 'close:1',
        ],
        'delete'    => [
            'label'                => 'lang:admin::default.button_icon_delete', 'class' => 'btn btn-danger',
            'data-request-form'    => '#edit-form', 'data-request' => 'onDelete', 'data-request-data' => "_method:'DELETE'",
            'data-request-confirm' => 'lang:admin::default.alert_warning_confirm', 'context' => ['edit'],
        ],
    ],
];

$config['form']['fields'] = [
    'table_name'   => [
        'label' => 'lang:admin::tables.label_name',
        'type'  => 'text',
    ],
    'min_capacity' => [
        'label' => 'lang:admin::tables.label_min_capacity',
        'type'  => 'number',
    ],
    'max_capacity' => [
        'label' => 'lang:admin::tables.label_capacity',
        'type'  => 'number',
    ],
    'table_status' => [
        'label'   => 'lang:admin::default.label_status',
        'type'    => 'switch',
        'default' => 1,
    ],
];

return $config;