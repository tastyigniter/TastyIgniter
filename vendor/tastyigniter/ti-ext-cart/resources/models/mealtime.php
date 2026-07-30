<?php

$config['list']['filter'] = [
    'scopes' => [
        'status' => [
            'label' => 'lang:igniter::admin.text_filter_status',
            'type' => 'switch',
            'conditions' => 'mealtime_status = :filtered',
        ],
    ],
];

$config['list']['toolbar'] = [
    'buttons' => [
        'create' => [
            'label' => 'lang:igniter::admin.button_new',
            'class' => 'btn btn-primary',
            'href' => 'mealtimes/create',
        ],
    ],
];

$config['list']['bulkActions'] = [
    'status' => [
        'label' => 'lang:igniter::admin.list.actions.label_status',
        'type' => 'dropdown',
        'class' => 'btn btn-light',
        'statusColumn' => 'mealtime_status',
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
            'href' => 'mealtimes/edit/{mealtime_id}',
        ],
    ],
    'mealtime_name' => [
        'label' => 'lang:igniter::admin.label_name',
        'type' => 'text',
    ],
    'validity' => [
        'label' => 'lang:igniter.cart::default.mealtimes.column_validity',
        'type' => 'text',
        'formatter' => function($record, $column, $value) {
            return lang('igniter.cart::default.mealtimes.text_'.$value);
        },
    ],
    'start_time' => [
        'label' => 'lang:igniter.cart::default.mealtimes.column_start_time',
        'type' => 'time',
    ],
    'end_time' => [
        'label' => 'lang:igniter.cart::default.mealtimes.column_end_time',
        'type' => 'time',
    ],
    'start_at' => [
        'label' => 'lang:igniter.cart::default.mealtimes.column_start_at',
        'type' => 'datetime',
    ],
    'end_at' => [
        'label' => 'lang:igniter.cart::default.mealtimes.column_end_at',
        'type' => 'datetime',
    ],
    'mealtime_status' => [
        'label' => 'lang:igniter::admin.label_status',
        'type' => 'switch',
    ],
    'mealtime_id' => [
        'label' => 'lang:igniter::admin.column_id',
        'invisible' => true,
    ],
    'location_name' => [
        'label' => 'lang:igniter::admin.column_location',
        'type' => 'text',
        'relation' => 'locations',
        'select' => 'location_name',
        'locationAware' => true,
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
    'mealtime_name' => [
        'label' => 'lang:igniter.cart::default.mealtimes.label_mealtime_name',
        'type' => 'text',
        'span' => 'left',
    ],
    'locations' => [
        'label' => 'lang:igniter::admin.label_location',
        'type' => 'relation',
        'span' => 'right',
        'valueFrom' => 'locations',
        'nameFrom' => 'location_name',
    ],
    'validity' => [
        'label' => 'lang:igniter.cart::default.mealtimes.label_validity',
        'type' => 'radiotoggle',
        'default' => 'daily',
        'span' => 'left',
        'options' => [
            'daily' => 'lang:igniter.cart::default.mealtimes.text_daily',
            'period' => 'lang:igniter.cart::default.mealtimes.text_period',
            'recurring' => 'lang:igniter.cart::default.mealtimes.text_recurring',
        ],
    ],
    'mealtime_status' => [
        'label' => 'lang:igniter::admin.label_status',
        'type' => 'switch',
        'default' => true,
        'span' => 'right',
    ],
    'start_time' => [
        'label' => 'lang:igniter.cart::default.mealtimes.label_start_time',
        'type' => 'datepicker',
        'mode' => 'time',
        'span' => 'left',
        'cssClass' => 'flex-width',
        'trigger' => [
            'action' => 'show',
            'field' => 'validity',
            'condition' => 'value[daily]',
        ],
    ],
    'end_time' => [
        'label' => 'lang:igniter.cart::default.mealtimes.label_end_time',
        'type' => 'datepicker',
        'mode' => 'time',
        'span' => 'left',
        'cssClass' => 'flex-width',
        'trigger' => [
            'action' => 'show',
            'field' => 'validity',
            'condition' => 'value[daily]',
        ],
    ],
    'start_at' => [
        'label' => 'lang:igniter.cart::default.mealtimes.label_start_at',
        'type' => 'datepicker',
        'mode' => 'datetime',
        'span' => 'left',
        'cssClass' => 'flex-width',
        'trigger' => [
            'action' => 'show',
            'field' => 'validity',
            'condition' => 'value[period]',
        ],
    ],
    'end_at' => [
        'label' => 'lang:igniter.cart::default.mealtimes.label_end_at',
        'type' => 'datepicker',
        'mode' => 'datetime',
        'span' => 'left',
        'cssClass' => 'flex-width',
        'trigger' => [
            'action' => 'show',
            'field' => 'validity',
            'condition' => 'value[period]',
        ],
    ],
    'recurring_every' => [
        'label' => 'lang:igniter.cart::default.mealtimes.label_recurring_every',
        'type' => 'checkboxtoggle',
        'trigger' => [
            'action' => 'show',
            'field' => 'validity',
            'condition' => 'value[recurring]',
        ],
    ],
    'recurring_from' => [
        'label' => 'lang:igniter.cart::default.mealtimes.label_recurring_from',
        'type' => 'datepicker',
        'mode' => 'time',
        'span' => 'left',
        'cssClass' => 'flex-width',
        'trigger' => [
            'action' => 'show',
            'field' => 'validity',
            'condition' => 'value[recurring]',
        ],
    ],
    'recurring_to' => [
        'label' => 'lang:igniter.cart::default.mealtimes.label_recurring_to',
        'type' => 'datepicker',
        'mode' => 'time',
        'span' => 'left',
        'cssClass' => 'flex-width',
        'trigger' => [
            'action' => 'show',
            'field' => 'validity',
            'condition' => 'value[recurring]',
        ],
    ],
];

return $config;
