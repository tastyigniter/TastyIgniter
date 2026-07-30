<?php

use Igniter\Local\Models\Location;

$config['list']['filter'] = [
    'search' => [
        'prompt' => 'lang:igniter.coupons::default.text_filter_search',
        'mode' => 'all',
    ],
    'scopes' => [
        'type' => [
            'label' => 'lang:igniter.coupons::default.text_filter_type',
            'type' => 'select',
            'conditions' => 'type = :filtered',
            'options' => [
                'F' => 'lang:igniter.coupons::default.text_fixed_amount',
                'P' => 'lang:igniter.coupons::default.text_percentage',
            ],
        ],
        'status' => [
            'label' => 'lang:admin::lang.text_filter_status',
            'type' => 'switch',
            'conditions' => 'status = :filtered',
        ],
    ],
];

$config['list']['toolbar'] = [
    'buttons' => [
        'create' => [
            'label' => 'lang:admin::lang.button_new',
            'class' => 'btn btn-primary',
            'href' => admin_url('igniter/coupons/coupons/create'),
        ],
        'redemptions' => [
            'label' => 'lang:igniter.coupons::default.button_redemptions',
            'class' => 'btn btn-default',
            'href' => admin_url('igniter/coupons/redemptions'),
        ],
    ],
];

$config['list']['bulkActions'] = [
    'status' => [
        'label' => 'lang:admin::lang.list.actions.label_status',
        'type' => 'dropdown',
        'class' => 'btn btn-light',
        'statusColumn' => 'status',
        'menuItems' => [
            'enable' => [
                'label' => 'lang:admin::lang.list.actions.label_enable',
                'type' => 'button',
                'class' => 'dropdown-item',
            ],
            'disable' => [
                'label' => 'lang:admin::lang.list.actions.label_disable',
                'type' => 'button',
                'class' => 'dropdown-item text-danger',
            ],
        ],
    ],
    'delete' => [
        'label' => 'lang:admin::lang.button_delete',
        'class' => 'btn btn-light text-danger',
        'data-request-confirm' => 'lang:admin::lang.alert_warning_confirm',
    ],
];

$config['list']['columns'] = [
    'edit' => [
        'type' => 'button',
        'iconCssClass' => 'fa fa-pencil',
        'attributes' => [
            'class' => 'btn btn-edit',
            'href' => admin_url('igniter/coupons/coupons/edit/{coupon_id}'),
        ],
    ],
    'name' => [
        'label' => 'lang:admin::lang.label_name',
        'type' => 'text',
        'searchable' => true,
    ],
    'code' => [
        'label' => 'lang:igniter.coupons::default.column_code',
        'type' => 'text',
        'searchable' => true,
    ],
    'location_name' => [
        'label' => 'lang:admin::lang.column_location',
        'type' => 'text',
        'relation' => 'locations',
        'select' => 'location_name',
        'locationAware' => true,
    ],
    'formatted_discount' => [
        'label' => 'lang:igniter.coupons::default.column_discount',
        'type' => 'text',
        'sortable' => false,
        'formatter' => function($record, $column, $value) {
            return $record->isFixed() ? currency_format($value) : $value;
        },
    ],
    'validity' => [
        'label' => 'lang:igniter.coupons::default.column_validity',
        'type' => 'text',
        'searchable' => true,
        'formatter' => function($record, $column, $value) {
            return $value ? ucwords($value) : null;
        },
    ],
    'status' => [
        'label' => 'lang:admin::lang.label_status',
        'type' => 'switch',
    ],
    'coupon_id' => [
        'label' => 'lang:admin::lang.column_id',
        'invisible' => true,
    ],

];

$config['form']['toolbar'] = [
    'buttons' => [
        'save' => [
            'label' => 'lang:admin::lang.button_save',
            'context' => ['create', 'edit'],
            'partial' => 'form/toolbar_save_button',
            'class' => 'btn btn-primary',
            'data-request' => 'onSave',
            'data-progress-indicator' => 'admin::lang.text_saving',
        ],
        'delete' => [
            'label' => 'lang:admin::lang.button_icon_delete',
            'class' => 'btn btn-danger',
            'data-request' => 'onDelete',
            'data-request-data' => "_method:'DELETE'",
            'data-request-confirm' => 'lang:admin::lang.alert_warning_confirm',
            'data-progress-indicator' => 'admin::lang.text_deleting',
            'context' => ['edit'],
        ],
    ],
];

$config['form']['tabs'] = [
    'defaultTab' => 'lang:igniter.coupons::default.text_tab_general',
    'fields' => [
        'name' => [
            'label' => 'lang:admin::lang.label_name',
            'type' => 'text',
            'span' => 'left',
        ],
        'code' => [
            'label' => 'lang:igniter.coupons::default.label_code',
            'type' => 'text',
            'span' => 'right',
        ],
        'description' => [
            'label' => 'lang:admin::lang.label_description',
            'type' => 'textarea',
        ],
        'type' => [
            'label' => 'lang:admin::lang.label_type',
            'type' => 'radiotoggle',
            'span' => 'left',
            'cssClass' => 'flex-width',
            'default' => 'F',
            'options' => [
                'F' => 'lang:igniter.coupons::default.text_fixed_amount',
                'P' => 'lang:igniter.coupons::default.text_percentage',
            ],
        ],
        'discount' => [
            'label' => 'lang:igniter.coupons::default.label_discount',
            'type' => 'currency',
            'span' => 'left',
            'cssClass' => 'flex-width',
        ],
        'status' => [
            'label' => 'lang:admin::lang.label_status',
            'type' => 'switch',
            'default' => 1,
            'span' => 'right',
        ],
        'validity' => [
            'label' => 'lang:igniter.coupons::default.label_validity',
            'type' => 'radiotoggle',
            'default' => 'forever',
            'span' => 'left',
            'options' => [
                'forever' => 'lang:igniter.coupons::default.text_forever',
                'fixed' => 'lang:igniter.coupons::default.text_fixed',
                'period' => 'lang:igniter.coupons::default.text_period',
                'recurring' => 'lang:igniter.coupons::default.text_recurring',
            ],
        ],
        'auto_apply' => [
            'label' => 'lang:igniter.coupons::default.label_auto_apply',
            'type' => 'switch',
            'default' => 1,
            'span' => 'right',
        ],

        'fixed_date' => [
            'label' => 'lang:igniter.coupons::default.label_fixed_date',
            'type' => 'datepicker',
            'mode' => 'date',
            'span' => 'left',
            'cssClass' => 'flex-width',
            'trigger' => [
                'action' => 'show',
                'field' => 'validity',
                'condition' => 'value[fixed]',
            ],
        ],
        'fixed_from_time' => [
            'label' => 'lang:igniter.coupons::default.label_fixed_from_time',
            'type' => 'datepicker',
            'mode' => 'time',
            'span' => 'left',
            'cssClass' => 'flex-width',
            'trigger' => [
                'action' => 'show',
                'field' => 'validity',
                'condition' => 'value[fixed]',
            ],
        ],
        'fixed_to_time' => [
            'label' => 'lang:igniter.coupons::default.label_fixed_to_time',
            'type' => 'datepicker',
            'mode' => 'time',
            'span' => 'left',
            'cssClass' => 'flex-width',
            'trigger' => [
                'action' => 'show',
                'field' => 'validity',
                'condition' => 'value[fixed]',
            ],
        ],
        'period_start_date' => [
            'label' => 'lang:igniter.coupons::default.label_period_start_date',
            'type' => 'datepicker',
            'mode' => 'date',
            'span' => 'left',
            'cssClass' => 'flex-width',
            'trigger' => [
                'action' => 'show',
                'field' => 'validity',
                'condition' => 'value[period]',
            ],
        ],
        'period_end_date' => [
            'label' => 'lang:igniter.coupons::default.label_period_end_date',
            'type' => 'datepicker',
            'mode' => 'date',
            'span' => 'left',
            'cssClass' => 'flex-width',
            'trigger' => [
                'action' => 'show',
                'field' => 'validity',
                'condition' => 'value[period]',
            ],
        ],
        'recurring_every' => [
            'label' => 'lang:igniter.coupons::default.label_recurring_every',
            'type' => 'checkboxtoggle',
            'trigger' => [
                'action' => 'show',
                'field' => 'validity',
                'condition' => 'value[recurring]',
            ],
        ],
        'recurring_from_time' => [
            'label' => 'lang:igniter.coupons::default.label_recurring_from_time',
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
        'recurring_to_time' => [
            'label' => 'lang:igniter.coupons::default.label_recurring_to_time',
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

        'min_total' => [
            'tab' => 'lang:igniter.coupons::default.text_tab_restrictions',
            'label' => 'lang:igniter.coupons::default.label_min_total',
            'type' => 'currency',
            'span' => 'left',
            'default' => 0,
        ],
        'order_restriction' => [
            'tab' => 'lang:igniter.coupons::default.text_tab_restrictions',
            'label' => 'lang:igniter.coupons::default.label_order_restriction',
            'type' => 'checkboxtoggle',
            'comment' => 'lang:igniter.coupons::default.help_order_restriction',
            'span' => 'right',
            'options' => [Location::class, 'getOrderTypeOptions'],
        ],
        'redemptions' => [
            'tab' => 'lang:igniter.coupons::default.text_tab_restrictions',
            'label' => 'lang:igniter.coupons::default.label_redemption',
            'type' => 'number',
            'span' => 'left',
            'default' => 0,
            'comment' => 'lang:igniter.coupons::default.help_redemption',
        ],
        'customer_redemptions' => [
            'tab' => 'lang:igniter.coupons::default.text_tab_restrictions',
            'label' => 'lang:igniter.coupons::default.label_customer_redemption',
            'type' => 'number',
            'span' => 'right',
            'default' => 0,
            'comment' => 'lang:igniter.coupons::default.help_customer_redemption',
        ],
        'customers' => [
            'tab' => 'lang:igniter.coupons::default.text_tab_restrictions',
            'label' => 'lang:igniter.coupons::default.label_customer',
            'type' => 'relation',
            'span' => 'left',
            'nameFrom' => 'full_name',
            'comment' => 'lang:igniter.coupons::default.help_customer',
        ],
        'customer_groups' => [
            'tab' => 'lang:igniter.coupons::default.text_tab_restrictions',
            'label' => 'lang:igniter.coupons::default.label_customer_group',
            'type' => 'relation',
            'span' => 'right',
            'nameFrom' => 'group_name',
            'comment' => 'lang:igniter.coupons::default.help_customer_group',
        ],
        'locations' => [
            'tab' => 'lang:igniter.coupons::default.text_tab_restrictions',
            'label' => 'lang:admin::lang.label_location',
            'type' => 'relation',
            'valueFrom' => 'locations',
            'nameFrom' => 'location_name',
            'comment' => 'lang:igniter.coupons::default.help_locations',
        ],
        'apply_coupon_on' => [
            'tab' => 'lang:igniter.coupons::default.text_tab_restrictions',
            'label' => 'lang:igniter.coupons::default.label_cart_restriction',
            'type' => 'radiotoggle',
            'default' => 'whole_cart',
            'options' => [
                'whole_cart' => 'lang:igniter.coupons::default.text_cart_restriction_whole_cart',
                'menu_items' => 'lang:igniter.coupons::default.text_cart_restriction_menu_items',
                'delivery_fee' => 'lang:igniter.coupons::default.text_cart_restriction_delivery_fee',
            ],
        ],
        'categories' => [
            'tab' => 'lang:igniter.coupons::default.text_tab_restrictions',
            'label' => 'lang:igniter.coupons::default.label_categories',
            'type' => 'relation',
            'comment' => 'lang:igniter.coupons::default.help_categories',
            'trigger' => [
                'action' => 'show',
                'field' => 'apply_coupon_on',
                'condition' => 'value[menu_items]',
            ],
        ],
        'menus' => [
            'tab' => 'lang:igniter.coupons::default.text_tab_restrictions',
            'label' => 'lang:igniter.coupons::default.label_menus',
            'type' => 'relation',
            'span' => 'left',
            'comment' => 'lang:igniter.coupons::default.help_menus',
            'nameFrom' => 'menu_name',
            'trigger' => [
                'action' => 'show',
                'field' => 'apply_coupon_on',
                'condition' => 'value[menu_items]',
            ],
        ],
        'min_menu_quantity' => [
            'tab' => 'lang:igniter.coupons::default.text_tab_restrictions',
            'label' => 'lang:igniter.coupons::default.label_min_menu_quantity',
            'type' => 'number',
            'span' => 'left',
            'default' => 0,
            'comment' => 'lang:igniter.coupons::default.help_min_menu_quantity',
            'trigger' => [
                'action' => 'show',
                'field' => 'apply_coupon_on',
                'condition' => 'value[menu_items]',
            ],
        ],
        'history' => [
            'tab' => 'lang:igniter.coupons::default.text_tab_history',
            'type' => 'datatable',
            'useAjax' => true,
            'defaultSort' => ['coupon_history_id', 'desc'],
            'columns' => [
                'date_used' => [
                    'title' => 'lang:igniter.coupons::default.column_date_used',
                ],
                'order_id' => [
                    'title' => 'lang:igniter.coupons::default.column_order_id',
                ],
                'customer_name' => [
                    'title' => 'lang:igniter.coupons::default.column_customer',
                ],
                'min_total' => [
                    'title' => 'lang:igniter.coupons::default.column_min_total',
                ],
                'amount' => [
                    'title' => 'lang:igniter.coupons::default.column_amount',
                ],
                'order_total' => [
                    'title' => 'lang:igniter.coupons::default.column_total',
                ],
            ],
        ],
    ],
];

return $config;
