<?php
$config['list']['filter'] = [
    'search' => [
        'prompt' => 'lang:admin::payments.text_filter_search',
        'mode'   => 'all',
    ],
    'scopes' => [
        'status' => [
            'label'      => 'lang:admin::payments.text_filter_status',
            'type'       => 'switch',
            'conditions' => 'status = :filtered',
        ],
    ],
];

$config['list']['toolbar'] = [
    'buttons' => [
        'create' => ['label' => 'lang:admin::default.button_new', 'class' => 'btn btn-primary', 'href' => 'payments/create'],
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
            'href'  => 'payments/edit/{code}',
        ],
    ],
    'name'         => [
        'label'      => 'lang:admin::payments.column_name',
        'type'       => 'text',
        'searchable' => TRUE,
    ],
    'description'  => [
        'label'      => 'lang:admin::payments.column_description',
        'searchable' => TRUE,
    ],
    'status'       => [
        'label' => 'lang:admin::payments.column_status',
        'type'  => 'switch',
    ],
    'date_updated' => [
        'label' => 'lang:admin::payments.column_date_updated',
        'type'  => 'datesince',
    ],
    'payment_id'   => [
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

$config['form']['tabs'] = [
    'defaultTab' => 'lang:admin::payments.text_tab_config',
    'fields'     => [
        'payment'     => [
            'label'       => 'lang:admin::payments.label_payments',
            'type'        => 'select',
            'options'     => 'listGateways',
            'context'     => ['create'],
            'placeholder' => 'lang:admin::default.text_please_select',
        ],
        'name'        => [
            'label' => 'lang:admin::payments.label_name',
            'type'  => 'text',
            'span'  => 'left',
        ],
        'code'        => [
            'label' => 'lang:admin::payments.label_code',
            'type'  => 'text',
            'span'  => 'right',
        ],
        'priority'    => [
            'label'   => 'lang:admin::payments.label_priority',
            'type'    => 'number',
            'default' => 999,
        ],
        'description' => [
            'label' => 'lang:admin::payments.label_description',
            'type'  => 'textarea',
        ],
        'is_default'  => [
            'label' => 'lang:admin::payments.label_default',
            'type'  => 'switch',
            'span'  => 'left',
        ],
        'status'      => [
            'label' => 'lang:admin::default.label_status',
            'type'  => 'switch',
            'span'  => 'right',
        ],
    ],
];

return $config;