<?php

use Igniter\Admin\Models\Status;

return [
    'fields' => [
        'transaction_mode' => [
            'label' => 'lang:igniter.payregister::default.mollie.label_transaction_mode',
            'type' => 'radiotoggle',
            'default' => 'test',
            'options' => [
                'test' => 'lang:igniter.payregister::default.mollie.text_test',
                'live' => 'lang:igniter.payregister::default.mollie.text_live',
            ],
        ],
        'live_api_key' => [
            'label' => 'lang:igniter.payregister::default.mollie.label_live_api_key',
            'type' => 'text',
            'trigger' => [
                'action' => 'show',
                'field' => 'transaction_mode',
                'condition' => 'value[live]',
            ],
        ],
        'test_api_key' => [
            'label' => 'lang:igniter.payregister::default.mollie.label_test_api_key',
            'type' => 'text',
            'trigger' => [
                'action' => 'show',
                'field' => 'transaction_mode',
                'condition' => 'value[test]',
            ],
        ],
        'order_fee_type' => [
            'label' => 'lang:igniter.payregister::default.label_order_fee_type',
            'type' => 'radiotoggle',
            'span' => 'left',
            'default' => 1,
            'options' => [
                1 => 'lang:igniter.cart::default.menus.text_fixed_amount',
                2 => 'lang:igniter.cart::default.menus.text_percentage',
            ],
        ],
        'order_fee' => [
            'label' => 'lang:igniter.payregister::default.label_order_fee',
            'type' => 'currency',
            'span' => 'right',
            'default' => 0,
            'comment' => 'lang:igniter.payregister::default.help_order_fee',
        ],
        'order_total' => [
            'label' => 'lang:igniter.payregister::default.label_order_total',
            'type' => 'currency',
            'comment' => 'lang:igniter.payregister::default.help_order_total',
        ],
        'order_status' => [
            'label' => 'lang:igniter.payregister::default.label_order_status',
            'type' => 'select',
            'options' => [Status::class, 'getDropdownOptionsForOrder'],
            'comment' => 'lang:igniter.payregister::default.help_order_status',
        ],
    ],
    'rules' => [
        ['transaction_mode', 'lang:igniter.payregister::default.mollie.label_transaction_mode', 'string'],
        ['live_api_key', 'lang:igniter.payregister::default.mollie.label_live_api_key', 'nullable|required_if:transaction_mode,live|string'],
        ['test_api_key', 'lang:igniter.payregister::default.mollie.label_test_api_key', 'nullable|required_if:transaction_mode,test|string'],
        ['order_fee_type', 'lang:igniter.payregister::default.label_order_fee_type', 'integer'],
        ['order_fee', 'lang:igniter.payregister::default.label_order_fee', 'nullable|numeric'],
        ['order_total', 'lang:igniter.payregister::default.label_order_total', 'nullable|numeric'],
        ['order_status', 'lang:igniter.payregister::default.label_order_status', 'nullable|integer'],
    ],
];
