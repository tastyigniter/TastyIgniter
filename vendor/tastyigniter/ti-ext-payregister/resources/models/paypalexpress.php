<?php

use Igniter\Admin\Models\Status;

return [
    'fields' => [
        'setup' => [
            'type' => 'partial',
            'path' => 'igniter.payregister::paypalexpress.info',
        ],
        'api_mode' => [
            'label' => 'lang:igniter.payregister::default.paypal.label_api_mode',
            'type' => 'radiotoggle',
            'span' => 'left',
            'default' => 'sandbox',
            'options' => [
                'live' => 'lang:igniter.payregister::default.paypal.text_go_live',
                'sandbox' => 'lang:igniter.payregister::default.paypal.text_sandbox',
            ],
        ],
        'api_action' => [
            'label' => 'lang:igniter.payregister::default.paypal.label_api_action',
            'type' => 'radiotoggle',
            'span' => 'right',
            'default' => 'sale',
            'options' => [
                'sale' => 'lang:igniter.payregister::default.paypal.text_sale',
                'authorization' => 'lang:igniter.payregister::default.paypal.text_authorization',
            ],
        ],
        'api_user' => [
            'label' => 'lang:igniter.payregister::default.paypal.label_api_user',
            'type' => 'text',
            'span' => 'left',
            'trigger' => [
                'action' => 'show',
                'field' => 'api_mode',
                'condition' => 'value[live]',
            ],
        ],
        'api_pass' => [
            'label' => 'lang:igniter.payregister::default.paypal.label_api_pass',
            'type' => 'text',
            'span' => 'right',
            'trigger' => [
                'action' => 'show',
                'field' => 'api_mode',
                'condition' => 'value[live]',
            ],
        ],
        'api_sandbox_user' => [
            'label' => 'lang:igniter.payregister::default.paypal.label_api_sandbox_user',
            'type' => 'text',
            'span' => 'left',
            'trigger' => [
                'action' => 'show',
                'field' => 'api_mode',
                'condition' => 'value[sandbox]',
            ],
        ],
        'api_sandbox_pass' => [
            'label' => 'lang:igniter.payregister::default.paypal.label_api_sandbox_pass',
            'type' => 'text',
            'span' => 'right',
            'trigger' => [
                'action' => 'show',
                'field' => 'api_mode',
                'condition' => 'value[sandbox]',
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
        ['api_mode', 'lang:igniter.payregister::default.paypal.label_api_mode', 'string'],
        ['api_user', 'lang:igniter.payregister::default.paypal.label_api_user', 'nullable|required_if:api_mode,live|string'],
        ['api_pass', 'lang:igniter.payregister::default.paypal.label_api_pass', 'nullable|required_if:api_mode,live|string'],
        ['api_sandbox_user', 'lang:igniter.payregister::default.paypal.label_api_sandbox_user', 'nullable|required_if:api_mode,sandbox|string'],
        ['api_sandbox_pass', 'lang:igniter.payregister::default.paypal.label_api_sandbox_pass', 'nullable|required_if:api_mode,sandbox|string'],
        ['api_action', 'lang:igniter.payregister::default.paypal.label_api_action', 'in:sale,authorization'],
        ['order_fee_type', 'lang:igniter.payregister::default.label_order_fee_type', 'integer'],
        ['order_fee', 'lang:igniter.payregister::default.label_order_fee', 'nullable|numeric'],
        ['order_total', 'lang:igniter.payregister::default.label_order_total', 'nullable|numeric'],
        ['order_status', 'lang:igniter.payregister::default.label_order_status', 'nullable|integer'],
    ],
];
