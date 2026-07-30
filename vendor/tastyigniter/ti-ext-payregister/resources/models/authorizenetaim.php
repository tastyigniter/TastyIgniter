<?php

use Igniter\Admin\Models\Status;

return [
    'fields' => [
        'transaction_mode' => [
            'label' => 'lang:igniter.payregister::default.authorize_net_aim.label_transaction_mode',
            'type' => 'radiotoggle',
            'span' => 'left',
            'default' => 'test',
            'options' => [
                'test' => 'lang:igniter.payregister::default.authorize_net_aim.text_test',
                'test_live' => 'lang:igniter.payregister::default.authorize_net_aim.text_test_live',
                'live' => 'lang:igniter.payregister::default.authorize_net_aim.text_go_live',
            ],
        ],
        'transaction_type' => [
            'label' => 'lang:igniter.payregister::default.authorize_net_aim.label_transaction_type',
            'type' => 'radiotoggle',
            'span' => 'right',
            'default' => 'auth_capture',
            'options' => [
                'auth_only' => 'lang:igniter.payregister::default.authorize_net_aim.text_auth_only',
                'auth_capture' => 'lang:igniter.payregister::default.authorize_net_aim.text_auth_capture',
            ],
        ],
        'api_login_id' => [
            'label' => 'lang:igniter.payregister::default.authorize_net_aim.label_api_login_id',
            'type' => 'text',
        ],
        'client_key' => [
            'label' => 'lang:igniter.payregister::default.authorize_net_aim.label_client_key',
            'type' => 'text',
        ],
        'transaction_key' => [
            'label' => 'lang:igniter.payregister::default.authorize_net_aim.label_transaction_key',
            'type' => 'text',
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
            'type' => 'number',
            'span' => 'right',
            'default' => 0,
            'comment' => 'lang:igniter.payregister::default.help_order_fee',
        ],
        'order_total' => [
            'label' => 'lang:igniter.payregister::default.label_order_total',
            'type' => 'currency',
            'comment' => 'lang:igniter.payregister::default.help_order_total',
        ],
        'capture_status' => [
            'label' => 'lang:igniter.payregister::default.label_capture_status',
            'type' => 'select',
            'options' => [Status::class, 'getDropdownOptionsForOrder'],
            'comment' => 'lang:igniter.payregister::default.help_capture_status',
        ],
        'order_status' => [
            'label' => 'lang:igniter.payregister::default.label_order_status',
            'type' => 'select',
            'options' => [Status::class, 'getDropdownOptionsForOrder'],
            'comment' => 'lang:igniter.payregister::default.help_order_status',
        ],
    ],
    'rules' => [
        ['api_login_id', 'lang:igniter.payregister::default.authorize_net_aim.label_api_login_id', 'string'],
        ['client_key', 'lang:igniter.payregister::default.authorize_net_aim.label_client_key', 'string'],
        ['transaction_key', 'lang:igniter.payregister::default.authorize_net_aim.label_transaction_key', 'string'],
        ['transaction_mode', 'lang:igniter.payregister::default.authorize_net_aim.label_transaction_mode', 'string'],
        ['transaction_type', 'lang:igniter.payregister::default.authorize_net_aim.label_transaction_type', 'string'],
        ['order_fee_type', 'lang:igniter.payregister::default.label_order_fee_type', 'integer'],
        ['order_fee', 'lang:igniter.payregister::default.label_order_fee', 'nullable|numeric'],
        ['order_total', 'lang:igniter.payregister::default.label_order_total', 'nullable|numeric'],
        ['order_status', 'lang:igniter.payregister::default.label_order_status', 'nullable|integer'],
    ],
];
