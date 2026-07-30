<?php

$config['list']['filter'] = [
    'search' => [
        'prompt' => 'igniter::system.currencies.text_filter_search',
        'mode' => 'all', // or any, exact
    ],
    'scopes' => [
        'status' => [
            'label' => 'lang:igniter::admin.text_filter_status',
            'type' => 'switch',
            'conditions' => 'currency_status = :filtered',
        ],
    ],
];

$config['list']['toolbar'] = [
    'buttons' => [
        'create' => [
            'label' => 'lang:igniter::admin.button_new',
            'class' => 'btn btn-primary',
            'href' => 'currencies/create',
        ],
    ],
];

$config['list']['bulkActions'] = [
    'status' => [
        'label' => 'lang:igniter::admin.list.actions.label_status',
        'type' => 'dropdown',
        'class' => 'btn btn-light',
        'statusColumn' => 'currency_status',
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
            'href' => 'currencies/edit/{currency_id}',
        ],
    ],
    'default' => [
        'type' => 'button',
        'iconCssClass' => 'fa fa-star-o',
        'attributes' => [
            'class' => 'btn btn-light text-warning',
            'data-request' => 'onSetDefault',
            'data-request-data' => 'default:{currency_id}',
        ],
    ],
    'currency_name' => [
        'label' => 'lang:igniter::admin.label_name',
        'type' => 'text',
        'searchable' => true,
    ],
    'currency_code' => [
        'label' => 'igniter::system.currencies.column_code',
        'type' => 'text',
        'searchable' => true,
    ],
    'currency_symbol' => [
        'label' => 'igniter::system.currencies.column_symbol',
        'type' => 'text',
    ],
    'country_name' => [
        'label' => 'igniter::system.currencies.column_country',
        'relation' => 'country',
        'select' => 'country_name',
        'searchable' => true,
    ],
    'currency_rate' => [
        'label' => 'igniter::system.currencies.column_rate',
        'type' => 'number',
        'invisible' => true,
    ],
    'currency_status' => [
        'label' => 'igniter::system.currencies.column_status',
        'type' => 'switch',
    ],
    'currency_id' => [
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
    'currency_name' => [
        'label' => 'igniter::system.currencies.label_title',
        'type' => 'text',
        'span' => 'left',
    ],
    'currency_code' => [
        'label' => 'igniter::system.currencies.label_code',
        'type' => 'text',
        'span' => 'right',
        'comment' => 'igniter::system.currencies.help_iso',
    ],
    'country_id' => [
        'label' => 'igniter::system.currencies.label_country',
        'type' => 'relation',
        'relationFrom' => 'country',
        'nameFrom' => 'country_name',
        'span' => 'left',
        'placeholder' => 'lang:igniter::admin.text_please_select',
    ],
    'currency_rate' => [
        'label' => 'igniter::system.currencies.label_rate',
        'type' => 'number',
        'span' => 'right',
    ],
    'symbol_position' => [
        'label' => 'igniter::system.currencies.label_symbol_position',
        'type' => 'radiotoggle',
        'span' => 'left',
        'options' => [
            'igniter::system.currencies.text_left',
            'igniter::system.currencies.text_right',
        ],
    ],
    'currency_symbol' => [
        'label' => 'igniter::system.currencies.label_symbol',
        'type' => 'text',
        'span' => 'right',
    ],
    'thousand_sign' => [
        'label' => 'igniter::system.currencies.label_thousand_sign',
        'type' => 'text',
        'span' => 'left',
    ],
    'decimal_sign' => [
        'label' => 'igniter::system.currencies.label_decimal_sign',
        'type' => 'text',
        'span' => 'right',
    ],
    'decimal_position' => [
        'label' => 'igniter::system.currencies.label_decimal_position',
        'type' => 'number',
        'span' => 'left',
    ],
    'currency_status' => [
        'label' => 'lang:igniter::admin.label_status',
        'type' => 'switch',
        'span' => 'right',
        'default' => true,
    ],
];

return $config;
