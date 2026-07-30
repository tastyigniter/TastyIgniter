<?php

$config['list']['filter'] = [
    'search' => [
        'prompt' => 'lang:igniter.reservation::default.tables.text_filter_search',
        'mode' => 'all', // or any, exact
    ],
    'scopes' => [
        'status' => [
            'label' => 'lang:igniter::admin.text_filter_status',
            'type' => 'switch',
            'conditions' => 'table_status = :filtered',
        ],
    ],
];

$config['list']['toolbar'] = [
    'buttons' => [
        'create' => [
            'label' => 'lang:igniter::admin.button_new',
            'class' => 'btn btn-primary',
            'href' => 'tables/create',
        ],
    ],
];

$config['list']['bulkActions'] = [
    'status' => [
        'label' => 'lang:igniter::admin.list.actions.label_status',
        'type' => 'dropdown',
        'class' => 'btn btn-light',
        'statusColumn' => 'table_status',
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
            'href' => 'tables/edit/{table_id}',
        ],
    ],
    'table_name' => [
        'label' => 'lang:igniter::admin.label_name',
        'type' => 'text',
        'searchable' => true,
    ],
    'min_capacity' => [
        'label' => 'lang:igniter.reservation::default.tables.column_min_capacity',
        'type' => 'text',
        'searchable' => true,
    ],
    'max_capacity' => [
        'label' => 'lang:igniter.reservation::default.tables.column_capacity',
        'type' => 'number',
    ],
    'extra_capacity' => [
        'label' => 'lang:igniter.reservation::default.tables.column_extra_capacity',
        'type' => 'number',
        'invisible' => true,
    ],
    'priority' => [
        'label' => 'lang:igniter.reservation::default.tables.column_priority',
        'type' => 'number',
        'invisible' => true,
    ],
    'location_name' => [
        'label' => 'lang:igniter::admin.column_location',
        'type' => 'text',
        'relation' => 'locations',
        'select' => 'location_name',
        'locationAware' => true,
    ],
    'is_joinable' => [
        'label' => 'lang:igniter.reservation::default.tables.label_joinable',
        'type' => 'switch',
        'onText' => 'lang:igniter::admin.text_yes',
        'offText' => 'lang:igniter::admin.text_no',
    ],
    'table_status' => [
        'label' => 'lang:igniter::admin.label_status',
        'type' => 'switch',
    ],
    'table_id' => [
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
    'table_name' => [
        'label' => 'lang:igniter::admin.label_name',
        'type' => 'text',
        'span' => 'left',
    ],
    'priority' => [
        'label' => 'lang:igniter.reservation::default.tables.label_priority',
        'type' => 'number',
        'span' => 'right',
    ],
    'min_capacity' => [
        'label' => 'lang:igniter.reservation::default.tables.label_min_capacity',
        'type' => 'number',
        'span' => 'left',
    ],
    'max_capacity' => [
        'label' => 'lang:igniter.reservation::default.tables.label_capacity',
        'type' => 'number',
        'span' => 'right',
    ],
    'table_status' => [
        'label' => 'lang:igniter::admin.label_status',
        'type' => 'switch',
        'span' => 'left',
        'default' => 1,
    ],
    'is_joinable' => [
        'label' => 'lang:igniter.reservation::default.tables.label_joinable',
        'type' => 'switch',
        'span' => 'right',
        'default' => 1,
        'on' => 'lang:igniter::admin.text_yes',
        'off' => 'lang:igniter::admin.text_no',
    ],
    'locations' => [
        'label' => 'lang:igniter::admin.label_location',
        'type' => 'relation',
        'valueFrom' => 'locations',
        'nameFrom' => 'location_name',
    ],
    'extra_capacity' => [
        'label' => 'lang:igniter.reservation::default.tables.label_extra_capacity',
        'type' => 'number',
        'comment' => 'lang:igniter.reservation::default.tables.help_extra_capacity',
    ],
];

return $config;
