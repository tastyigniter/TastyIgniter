<?php

return [
    'form' => [
        'fields' => [
            'payment_log_id' => [
                'type' => 'hidden',
            ],
            'refund_type' => [
                'type' => 'radiotoggle',
                'default' => 'full',
                'options' => [
                    'full' => 'igniter.payregister::default.text_refund_full',
                    'partial' => 'igniter.payregister::default.text_refund_partial',
                ],
            ],
            'refund_amount' => [
                'label' => 'igniter.payregister::default.label_refund_amount',
                'type' => 'currency',
                'trigger' => [
                    'action' => 'show',
                    'field' => 'refund_type',
                    'condition' => 'value[partial]',
                ],
            ],
            'refund_reason' => [
                'label' => 'igniter.payregister::default.label_refund_reason',
                'type' => 'textarea',
            ],
        ],
        'rules' => [
            ['payment_log_id', 'admin::lang.column_id', 'required|integer|exists:payment_logs'],
            ['refund_type', 'igniter.payregister::default.label_refund_type', 'string|in:full,partial'],
            ['refund_amount', 'igniter.payregister::default.label_refund_amount', 'required|numeric'],
            ['refund_reason', 'igniter.payregister::default.label_refund_reason', 'nullable|string|max:250'],
        ],
    ],
];
