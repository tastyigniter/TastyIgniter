<?php

return [
    'form' => [
        'fields' => [
            'is_enabled' => [
                'label' => 'lang:igniter.local::default.label_offer_delivery',
                'accordion' => 'lang:igniter.local::default.text_tab_delivery_order',
                'default' => 1,
                'type' => 'switch',
                'span' => 'left',
            ],
            'add_lead_time' => [
                'label' => 'lang:igniter.local::default.label_delivery_add_lead_time',
                'accordion' => 'lang:igniter.local::default.text_tab_delivery_order',
                'type' => 'switch',
                'span' => 'right',
                'default' => 0,
                'comment' => 'lang:igniter.local::default.help_delivery_add_lead_time',
                'trigger' => [
                    'action' => 'enable',
                    'field' => 'is_enabled',
                    'condition' => 'checked',
                ],
            ],
            'time_interval' => [
                'label' => 'lang:igniter.local::default.label_delivery_time_interval',
                'accordion' => 'lang:igniter.local::default.text_tab_delivery_order',
                'default' => 15,
                'type' => 'number',
                'span' => 'left',
                'comment' => 'lang:igniter.local::default.help_delivery_time_interval',
                'trigger' => [
                    'action' => 'enable',
                    'field' => 'is_enabled',
                    'condition' => 'checked',
                ],
            ],
            'lead_time' => [
                'label' => 'lang:igniter.local::default.label_delivery_lead_time',
                'accordion' => 'lang:igniter.local::default.text_tab_delivery_order',
                'default' => 25,
                'type' => 'number',
                'span' => 'right',
                'comment' => 'lang:igniter.local::default.help_delivery_lead_time',
                'trigger' => [
                    'action' => 'enable',
                    'field' => 'is_enabled',
                    'condition' => 'checked',
                ],
            ],
            'time_restriction' => [
                'label' => 'lang:igniter.local::default.label_delivery_time_restriction',
                'accordion' => 'lang:igniter.local::default.text_tab_delivery_order',
                'type' => 'radiotoggle',
                'span' => 'right',
                'comment' => 'lang:igniter.local::default.help_delivery_time_restriction',
                'options' => [
                    'lang:admin::lang.text_none',
                    'lang:igniter.local::default.text_asap_only',
                    'lang:igniter.local::default.text_later_only',
                ],
                'trigger' => [
                    'action' => 'enable',
                    'field' => 'future_orders[enable_delivery]',
                    'condition' => 'unchecked',
                ],
            ],
            'cancellation_timeout' => [
                'label' => 'lang:igniter.local::default.label_delivery_cancellation_timeout',
                'accordion' => 'lang:igniter.local::default.text_tab_delivery_order',
                'type' => 'number',
                'span' => 'left',
                'default' => 0,
                'comment' => 'lang:igniter.local::default.help_delivery_cancellation_timeout',
                'trigger' => [
                    'action' => 'enable',
                    'field' => 'is_enabled',
                    'condition' => 'checked',
                ],
            ],
            'min_order_amount' => [
                'label' => 'lang:igniter.local::default.label_delivery_min_order_amount',
                'accordion' => 'lang:igniter.local::default.text_tab_delivery_order',
                'type' => 'currency',
                'span' => 'right',
                'default' => 0,
                'comment' => 'lang:igniter.local::default.help_delivery_min_order_amount',
                'trigger' => [
                    'action' => 'enable',
                    'field' => 'is_enabled',
                    'condition' => 'checked',
                ],
            ],

            'future_orders[is_enabled]' => [
                'label' => 'lang:igniter.local::default.label_future_delivery_order',
                'accordion' => 'lang:igniter.local::default.text_tab_delivery_order',
                'type' => 'switch',
                'span' => 'full',
                'trigger' => [
                    'action' => 'enable',
                    'field' => 'is_enabled',
                    'condition' => 'checked',
                ],
            ],
            'future_orders[min_days]' => [
                'label' => 'lang:igniter.local::default.label_future_min_delivery_days',
                'accordion' => 'lang:igniter.local::default.text_tab_delivery_order',
                'type' => 'number',
                'default' => 0,
                'span' => 'left',
                'comment' => 'lang:igniter.local::default.help_future_min_delivery_days',
                'trigger' => [
                    'action' => 'enable',
                    'field' => 'future_orders[is_enabled]',
                    'condition' => 'checked',
                ],
            ],
            'future_orders[days]' => [
                'label' => 'lang:igniter.local::default.label_future_delivery_days',
                'accordion' => 'lang:igniter.local::default.text_tab_delivery_order',
                'type' => 'number',
                'default' => 5,
                'span' => 'right',
                'comment' => 'lang:igniter.local::default.help_future_delivery_days',
                'trigger' => [
                    'action' => 'enable',
                    'field' => 'future_orders[is_enabled]',
                    'condition' => 'checked',
                ],
            ],
        ],
    ],
];