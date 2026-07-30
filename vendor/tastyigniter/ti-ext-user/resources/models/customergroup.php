<?php

$config['list']['toolbar'] = [
    'buttons' => [
        'create' => [
            'label' => 'lang:igniter::admin.button_new',
            'class' => 'btn btn-primary',
            'href' => 'customer_groups/create',
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
    'edit' => [
        'type' => 'button',
        'iconCssClass' => 'fa fa-pencil',
        'attributes' => [
            'class' => 'btn btn-edit',
            'href' => 'customer_groups/edit/{customer_group_id}',
        ],
    ],
    'default' => [
        'type' => 'button',
        'iconCssClass' => 'fa fa-star-o',
        'attributes' => [
            'class' => 'btn btn-light text-warning',
            'data-request' => 'onSetDefault',
            'data-request-data' => 'default:{customer_group_id}',
        ],
    ],
    'group_name' => [
        'label' => 'lang:igniter::admin.label_name',
        'type' => 'text',
        'searchable' => true,
    ],
    'customer_count' => [
        'label' => 'lang:igniter.user::default.customer_groups.column_customers',
        'type' => 'number',
        'sortable' => false,
    ],
    'approval' => [
        'label' => 'lang:igniter.user::default.customer_groups.label_approval',
        'type' => 'switch',
    ],
    'customer_group_id' => [
        'label' => 'lang:igniter::admin.column_id',
        'invisible' => true,
    ],
    'created_at' => [
        'label' => 'lang:igniter::admin.column_date_added',
        'invisible' => true,
        'type' => 'datetime',
    ],
    'updated_at' => [
        'label' => 'lang:igniter::admin.column_date_updated',
        'invisible' => true,
        'type' => 'datetime',
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
            'context' => ['edit'],
            'label' => 'lang:igniter::admin.button_icon_delete',
            'class' => 'btn btn-danger',
            'data-request' => 'onDelete',
            'data-request-data' => "_method:'DELETE'",
            'data-request-confirm' => 'lang:igniter::admin.alert_warning_confirm',
            'data-progress-indicator' => 'igniter::admin.text_deleting',
        ],
    ],
];

$config['form']['fields'] = [
    'group_name' => [
        'label' => 'lang:igniter::admin.label_name',
        'type' => 'text',
    ],
    'approval' => [
        'label' => 'lang:igniter.user::default.customer_groups.label_approval',
        'type' => 'switch',
        'comment' => 'lang:igniter.user::default.customer_groups.help_approval',
    ],
    'description' => [
        'label' => 'lang:igniter::admin.label_description',
        'type' => 'textarea',
    ],
];

return $config;
