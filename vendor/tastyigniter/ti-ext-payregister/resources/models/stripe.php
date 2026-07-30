<?php

use Igniter\Admin\Models\Status;

return [
    'fields' => [
        'setup' => [
            'type' => 'partial',
            'path' => 'igniter.payregister::stripe.info',
        ],
        'offsite_enabled' => [
            'label' => 'lang:igniter.payregister::default.stripe.label_offsite_enabled',
            'type' => 'switch',
            'comment' => 'lang:igniter.payregister::default.stripe.help_offsite_enabled',
        ],
        'transaction_mode' => [
            'label' => 'lang:igniter.payregister::default.stripe.label_transaction_mode',
            'type' => 'radiotoggle',
            'default' => 'test',
            'span' => 'left',
            'options' => [
                'live' => 'lang:igniter.payregister::default.stripe.text_live',
                'test' => 'lang:igniter.payregister::default.stripe.text_test',
            ],
        ],
        'transaction_type' => [
            'label' => 'lang:igniter.payregister::default.stripe.label_transaction_type',
            'type' => 'radiotoggle',
            'default' => 'auth_capture',
            'span' => 'right',
            'options' => [
                'auth_capture' => 'lang:igniter.payregister::default.stripe.text_auth_capture',
                'auth_only' => 'lang:igniter.payregister::default.stripe.text_auth_only',
            ],
        ],
        'live_publishable_key' => [
            'label' => 'lang:igniter.payregister::default.stripe.label_live_publishable_key',
            'type' => 'text',
            'span' => 'right',
            'trigger' => [
                'action' => 'show',
                'field' => 'transaction_mode',
                'condition' => 'value[live]',
            ],
        ],
        'live_secret_key' => [
            'label' => 'lang:igniter.payregister::default.stripe.label_live_secret_key',
            'type' => 'text',
            'span' => 'left',
            'trigger' => [
                'action' => 'show',
                'field' => 'transaction_mode',
                'condition' => 'value[live]',
            ],
        ],
        'live_webhook_secret' => [
            'label' => 'lang:igniter.payregister::default.stripe.label_live_webhook_secret',
            'type' => 'text',
            'span' => 'left',
            'trigger' => [
                'action' => 'show',
                'field' => 'transaction_mode',
                'condition' => 'value[live]',
            ],
        ],
        'test_publishable_key' => [
            'label' => 'lang:igniter.payregister::default.stripe.label_test_publishable_key',
            'type' => 'text',
            'span' => 'right',
            'trigger' => [
                'action' => 'show',
                'field' => 'transaction_mode',
                'condition' => 'value[test]',
            ],
        ],
        'test_secret_key' => [
            'label' => 'lang:igniter.payregister::default.stripe.label_test_secret_key',
            'type' => 'text',
            'span' => 'left',
            'trigger' => [
                'action' => 'show',
                'field' => 'transaction_mode',
                'condition' => 'value[test]',
            ],
        ],
        'test_webhook_secret' => [
            'label' => 'lang:igniter.payregister::default.stripe.label_test_webhook_secret',
            'type' => 'text',
            'span' => 'right',
            'trigger' => [
                'action' => 'show',
                'field' => 'transaction_mode',
                'condition' => 'value[test]',
            ],
        ],
        'locale_code' => [
            'label' => 'lang:igniter.payregister::default.stripe.label_locale_code',
            'type' => 'text',
            'span' => 'right',
        ],
        'order_fee_type' => [
            'label' => 'lang:igniter.payregister::default.label_order_fee_type',
            'type' => 'radiotoggle',
            'span' => 'right',
            'cssClass' => 'flex-width',
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
            'cssClass' => 'flex-width',
            'default' => 0,
            'comment' => 'lang:igniter.payregister::default.help_order_fee',
        ],
        'order_total' => [
            'label' => 'lang:igniter.payregister::default.label_order_total',
            'type' => 'currency',
            'span' => 'left',
            'comment' => 'lang:igniter.payregister::default.help_order_total',
        ],
        'capture_status' => [
            'label' => 'lang:igniter.payregister::default.label_capture_status',
            'type' => 'select',
            'span' => 'left',
            'options' => [Status::class, 'getDropdownOptionsForOrder'],
            'comment' => 'lang:igniter.payregister::default.help_capture_status',
        ],
        'order_status' => [
            'label' => 'lang:igniter.payregister::default.label_order_status',
            'type' => 'select',
            'options' => [Status::class, 'getDropdownOptionsForOrder'],
            'span' => 'right',
            'comment' => 'lang:igniter.payregister::default.help_order_status',
        ],
    ],
    'rules' => [
        ['offsite_enabled', 'lang:igniter.payregister::default.stripe.label_offsite_enabled', 'required|boolean'],
        ['transaction_mode', 'lang:igniter.payregister::default.stripe.label_transaction_mode', 'required|string'],
        ['transaction_type', 'lang:igniter.payregister::default.stripe.label_transaction_type', 'required|string'],
        ['live_secret_key', 'lang:igniter.payregister::default.stripe.label_live_secret_key', 'nullable|required_if:transaction_mode,live|string'],
        ['live_publishable_key', 'lang:igniter.payregister::default.stripe.label_live_publishable_key', 'nullable|required_if:transaction_mode,live|string'],
        ['test_secret_key', 'lang:igniter.payregister::default.stripe.label_test_secret_key', 'nullable|required_if:transaction_mode,test|string'],
        ['test_publishable_key', 'lang:igniter.payregister::default.stripe.label_test_publishable_key', 'nullable|required_if:transaction_mode,test|string'],
        ['test_webhook_secret', 'lang:igniter.payregister::default.stripe.label_test_webhook_secret', 'nullable|string'],
        ['live_webhook_secret', 'lang:igniter.payregister::default.stripe.label_live_webhook_secret', 'nullable|string'],
        ['locale_code', 'lang:igniter.payregister::default.stripe.label_locale_code', 'nullable|string'],
        ['order_fee_type', 'lang:igniter.payregister::default.label_order_fee_type', 'integer'],
        ['order_fee', 'lang:igniter.payregister::default.label_order_fee', 'nullable|numeric'],
        ['order_total', 'lang:igniter.payregister::default.label_order_total', 'nullable|numeric'],
        ['order_status', 'lang:igniter.payregister::default.label_order_status', 'nullable|integer'],
        ['capture_status', 'lang:igniter.payregister::default.label_capture_status', 'nullable|integer'],
    ],
];
