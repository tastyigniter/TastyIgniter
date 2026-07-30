<?php

$config['list']['filter'] = [
    'search' => [
        'prompt' => 'lang:igniter::system.countries.text_filter_search',
        'mode' => 'all', // or any, exact
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
            'href' => 'countries/create',
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
            'href' => 'countries/edit/{country_id}',
        ],
    ],
    'default' => [
        'type' => 'button',
        'iconCssClass' => 'fa fa-star-o',
        'attributes' => [
            'class' => 'btn btn-light text-warning',
            'data-request' => 'onSetDefault',
            'data-request-data' => 'default:{country_id}',
        ],
    ],
    'country_name' => [
        'label' => 'lang:igniter::admin.label_name',
        'type' => 'text',
        'searchable' => true,
    ],
    'iso_code_2' => [
        'label' => 'lang:igniter::system.countries.column_iso_code2',
        'type' => 'text',
        'searchable' => true,
    ],
    'iso_code_3' => [
        'label' => 'lang:igniter::system.countries.column_iso_code3',
        'type' => 'text',
        'searchable' => true,
    ],
    'status' => [
        'label' => 'lang:igniter::system.countries.column_status',
        'type' => 'switch',
        'searchable' => true,
    ],
    'country_id' => [
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
    'country_name' => [
        'label' => 'lang:igniter::admin.label_name',
        'type' => 'text',
        'span' => 'left',
    ],
    'priority' => [
        'label' => 'lang:igniter::system.countries.label_priority',
        'type' => 'number',
        'default' => 0,
        'span' => 'right',
    ],
    'iso_code_2' => [
        'label' => 'lang:igniter::system.countries.label_iso_code2',
        'type' => 'text',
        'span' => 'left',
        'comment' => 'lang:igniter::system.countries.help_iso',
    ],
    'iso_code_3' => [
        'label' => 'lang:igniter::system.countries.label_iso_code3',
        'type' => 'text',
        'span' => 'right',
    ],
    'format' => [
        'label' => 'lang:igniter::system.countries.label_format',
        'type' => 'textarea',
        'comment' => 'lang:igniter::system.countries.help_format',
    ],
    'status' => [
        'label' => 'lang:igniter::admin.label_status',
        'type' => 'switch',
    ],
];

return $config;
