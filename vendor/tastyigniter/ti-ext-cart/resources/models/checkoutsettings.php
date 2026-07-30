<?php

use Igniter\Cart\Models\Category;
use Igniter\Local\Models\Location;
use Igniter\Local\Models\WorkingHour;
use Igniter\PayRegister\Models\Payment;

return [
    'form' => [
        'fields' => [
            'guest_order' => [
                'label' => 'lang:igniter.cart::default.label_guest_order',
                'accordion' => 'lang:igniter.local::default.text_tab_general_options',
                'type' => 'radiotoggle',
                'comment' => 'lang:igniter.local::default.help_guest_order',
                'default' => -1,
                'options' => [
                    -1 => 'lang:igniter::admin.text_use_default',
                    0 => 'lang:igniter::admin.text_no',
                    1 => 'lang:igniter::admin.text_yes',
                ],
            ],
            'limit_orders' => [
                'label' => 'lang:igniter.cart::default.checkout.label_limit_orders',
                'type' => 'radiotoggle',
                'default' => 0,
                'comment' => 'lang:igniter.cart::default.checkout.help_limit_orders',
                'span' => 'left',
                'options' => [
                    'lang:igniter::admin.text_disabled',
                    'lang:igniter.cart::default.checkout.text_per_timeslot',
                    'lang:igniter.cart::default.checkout.text_per_period',
                ],
            ],
            'limit_orders_count' => [
                'label' => 'lang:igniter.cart::default.checkout.label_limit_orders_count',
                'type' => 'number',
                'default' => 50,
                'span' => 'right',
                'comment' => 'lang:igniter.cart::default.checkout.help_limit_orders_interval',
                'trigger' => [
                    'action' => 'show',
                    'field' => 'limit_orders',
                    'condition' => 'value[1]',
                ],
            ],
            'limit_orders_period' => [
                'label' => 'lang:igniter.cart::default.checkout.label_limit_orders_period',
                'type' => 'repeater',
                'commentAbove' => 'lang:igniter.cart::default.checkout.help_limit_orders_period',
                'trigger' => [
                    'action' => 'show',
                    'field' => 'limit_orders',
                    'condition' => 'value[2]',
                ],
                'form' => [
                    'fields' => [
                        'day_of_week' => [
                            'label' => 'lang:igniter.cart::default.checkout.label_day_of_week',
                            'type' => 'selectlist',
                            'span' => 'left',
                            'options' => fn() => WorkingHour::$weekDays,
                        ],
                        'start_time' => [
                            'label' => 'lang:igniter.cart::default.checkout.label_start_time',
                            'type' => 'datepicker',
                            'mode' => 'time',
                            'span' => 'left',
                        ],
                        'end_time' => [
                            'label' => 'lang:igniter.cart::default.checkout.label_end_time',
                            'type' => 'datepicker',
                            'mode' => 'time',
                            'span' => 'right',
                        ],
                        'max_type' => [
                            'label' => 'lang:igniter.cart::default.checkout.label_max_type',
                            'type' => 'select',
                            'span' => 'left',
                            'options' => [
                                'order' => 'lang:igniter.cart::default.checkout.text_order_count',
                                'category' => 'lang:igniter.cart::default.checkout.text_category_count',
                            ],
                        ],
                        'max_count' => [
                            'label' => 'lang:igniter.cart::default.checkout.label_max_count',
                            'type' => 'number',
                            'span' => 'right',
                        ],
                        'order_type' => [
                            'label' => 'lang:igniter.cart::default.checkout.label_order_type',
                            'type' => 'selectlist',
                            'span' => 'right',
                            'options' => [Location::class, 'getOrderTypeOptions'],
                        ],
                        'categories' => [
                            'label' => 'lang:igniter.cart::default.checkout.label_categories',
                            'type' => 'selectlist',
                            'options' => [Category::class, 'getDropdownOptions'],
                            'trigger' => [
                                'action' => 'show',
                                'field' => 'limit_orders_period[*][max_type]',
                                'condition' => 'value[category]',
                            ],
                        ],
                        'status' => [
                            'label' => 'lang:igniter::admin.label_status',
                            'type' => 'switch',
                            'span' => 'right',
                        ],
                    ],
                ],
            ],
            'payments' => [
                'label' => 'lang:igniter.payregister::default.label_payments',
                'accordion' => 'lang:igniter.local::default.text_tab_general_options',
                'type' => 'checkboxlist',
                'options' => [Payment::class, 'listDropdownOptions'],
                'commentAbove' => 'lang:igniter.payregister::default.help_payments',
                'placeholder' => 'lang:igniter.payregister::default.help_no_payments',
            ],
        ],
    ],
];
