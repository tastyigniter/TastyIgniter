<?php

$config['list']['filter'] = [
    'search' => [
        'prompt' => 'lang:igniter.payregister::default.text_filter_search',
        'mode' => 'all',
    ],
    'scopes' => [
        'status' => [
            'label' => 'lang:igniter::admin.text_filter_status',
            'type' => 'switch',
            'conditions' => 'status = :filtered',
        ],
    ],
];

$config['list']['toolbar'] = [
    'buttons' => [
        'create' => [
            'label' => 'lang:igniter::admin.button_new',
            'class' => 'btn btn-primary',
            'href' => 'payments/create',
        ],
    ],
];

$config['list']['bulkActions'] = [
    'status' => [
        'label' => 'lang:igniter::admin.list.actions.label_status',
        'type' => 'dropdown',
        'class' => 'btn btn-light',
        'statusColumn' => 'status',
        'menuItems' => [
            'enable' => [
                'label' => 'lang:igniter::admin.list.actions.label_enable',
                'type' => 'button',
                'class' => 'dropdown-item',
            ],
            'disable' => [
                'label' => 'lang:igniter::admin.list.actions.label_disable',
                'type' => 'button',
                'class' => 'dropdown-item text-danger',
            ],
        ],
    ],
    'delete' => [
        'label' => 'lang:igniter::admin.button_delete',
        'class' => 'btn btn-light text-danger',
        'data-request-confirm' => 'lang:igniter::admin.alert_warning_confirm',
    ],
];

$config['list']['columns'] = [
    'edit' => [
        'type' => 'button',
        'iconCssClass' => 'fa fa-pencil',
        'attributes' => [
            'class' => 'btn btn-edit',
            'href' => 'payments/edit/{code}',
        ],
    ],
    'default' => [
        'type' => 'button',
        'iconCssClass' => 'fa fa-star-o',
        'attributes' => [
            'class' => 'btn btn-light text-warning',
            'data-request' => 'onSetDefault',
            'data-request-data' => 'default:"{code}"',
        ],
    ],
    'name' => [
        'label' => 'lang:igniter::admin.label_name',
        'type' => 'text',
        'searchable' => true,
    ],
    'description' => [
        'label' => 'lang:igniter::admin.label_description',
        'searchable' => true,
    ],
    'status' => [
        'label' => 'lang:igniter::admin.label_status',
        'type' => 'switch',
    ],
    'is_default' => [
        'label' => 'lang:igniter.payregister::default.label_default',
        'type' => 'switch',
        'onText' => 'igniter::admin.text_yes',
        'offText' => 'igniter::admin.text_no',
    ],
    'updated_at' => [
        'label' => 'lang:igniter::admin.column_date_updated',
        'type' => 'timetense',
    ],
    'payment_id' => [
        'label' => 'lang:igniter::admin.column_id',
        'invisible' => true,
    ],

];

$config['form']['toolbar'] = [
    'buttons' => [
        'save' => [
            'label' => 'lang:igniter::admin.button_save',
            'context' => ['create', 'edit'],
            'partial' => 'form/toolbar_save_button',
            'class' => 'btn btn-primary',
            'data-request' => 'onSave',
            'data-progress-indicator' => 'igniter::admin.text_saving',
        ],
        'delete' => [
            'label' => 'lang:igniter::admin.button_icon_delete',
            'class' => 'btn btn-danger',
            'data-request' => 'onDelete',
            'data-request-data' => "_method:'DELETE'",
            'data-request-confirm' => 'lang:igniter::admin.alert_warning_confirm',
            'data-progress-indicator' => 'igniter::admin.text_deleting',
            'context' => ['edit'],
        ],
    ],
];

$config['form']['fields'] = [
    'payment' => [
        'label' => 'lang:igniter.payregister::default.label_payments',
        'type' => 'select',
        'options' => 'listGateways',
        'context' => ['create'],
        'placeholder' => 'lang:igniter::admin.text_please_select',
    ],
    'name' => [
        'label' => 'lang:igniter::admin.label_name',
        'type' => 'text',
        'span' => 'left',
    ],
    'priority' => [
        'label' => 'lang:igniter.payregister::default.label_priority',
        'type' => 'number',
        'span' => 'right',
        'cssClass' => 'flex-width',
        'default' => 999,
    ],
    'code' => [
        'label' => 'lang:igniter.payregister::default.label_code',
        'type' => 'text',
        'span' => 'right',
        'cssClass' => 'flex-width',
    ],
    'description' => [
        'label' => 'lang:igniter::admin.label_description',
        'type' => 'textarea',
        'span' => 'left',
    ],
    'is_default' => [
        'label' => 'lang:igniter.payregister::default.label_default',
        'type' => 'switch',
        'span' => 'right',
        'cssClass' => 'flex-width',
    ],
    'status' => [
        'label' => 'lang:igniter::admin.label_status',
        'type' => 'switch',
        'span' => 'right',
        'cssClass' => 'flex-width',
    ],
];

return $config;
