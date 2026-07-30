<?php

return [
    'form' => [
        'fields' => [
            'is_enabled' => [
                'label' => 'lang:igniter.local::default.label_offer_collection',
                'accordion' => 'lang:igniter.local::default.text_tab_collection_order',
                'default' => 1,
                'type' => 'switch',
                'span' => 'left',
            ],
            'add_lead_time' => [
                'label' => 'lang:igniter.local::default.label_collection_add_lead_time',
                'accordion' => 'lang:igniter.local::default.text_tab_collection_order',
                'type' => 'switch',
                'span' => 'right',
                'default' => 0,
                'comment' => 'lang:igniter.local::default.help_collection_add_lead_time',
                'trigger' => [
                    'action' => 'enable',
                    'field' => 'is_enabled',
                    'condition' => 'checked',
                ],
            ],
            'time_interval' => [
                'label' => 'lang:igniter.local::default.label_collection_time_interval',
                'accordion' => 'lang:igniter.local::default.text_tab_collection_order',
                'default' => 15,
                'type' => 'number',
                'span' => 'left',
                'comment' => 'lang:igniter.local::default.help_collection_time_interval',
                'trigger' => [
                    'action' => 'enable',
                    'field' => 'is_enabled',
                    'condition' => 'checked',
                ],
            ],
            'lead_time' => [
                'label' => 'lang:igniter.local::default.label_collection_lead_time',
                'accordion' => 'lang:igniter.local::default.text_tab_collection_order',
                'default' => 25,
                'type' => 'number',
                'span' => 'right',
                'comment' => 'lang:igniter.local::default.help_collection_lead_time',
                'trigger' => [
                    'action' => 'enable',
                    'field' => 'is_enabled',
                    'condition' => 'checked',
                ],
            ],
            'time_restriction' => [
                'label' => 'lang:igniter.local::default.label_collection_time_restriction',
                'accordion' => 'lang:igniter.local::default.text_tab_collection_order',
                'type' => 'radiotoggle',
                'span' => 'right',
                'comment' => 'lang:igniter.local::default.help_collection_time_restriction',
                'options' => [
                    'lang:admin::lang.text_none',
                    'lang:igniter.local::default.text_asap_only',
                    'lang:igniter.local::default.text_later_only',
                ],
                'trigger' => [
                    'action' => 'disable',
                    'field' => 'future_orders[is_enabled]',
                    'condition' => 'checked',
                ],
            ],
            'cancellation_timeout' => [
                'label' => 'lang:igniter.local::default.label_collection_cancellation_timeout',
                'accordion' => 'lang:igniter.local::default.text_tab_collection_order',
                'type' => 'number',
                'span' => 'left',
                'default' => 0,
                'comment' => 'lang:igniter.local::default.help_collection_cancellation_timeout',
                'trigger' => [
                    'action' => 'enable',
                    'field' => 'is_enabled',
                    'condition' => 'checked',
                ],
            ],
            'min_order_amount' => [
                'label' => 'lang:igniter.local::default.label_collection_min_order_amount',
                'accordion' => 'lang:igniter.local::default.text_tab_collection_order',
                'type' => 'currency',
                'span' => 'right',
                'default' => 0,
                'comment' => 'lang:igniter.local::default.help_collection_min_order_amount',
                'trigger' => [
                    'action' => 'enable',
                    'field' => 'is_enabled',
                    'condition' => 'checked',
                ],
            ],

            'future_orders[is_enabled]' => [
                'label' => 'lang:igniter.local::default.label_future_collection_order',
                'accordion' => 'lang:igniter.local::default.text_tab_collection_order',
                'type' => 'switch',
                'span' => 'full',
                'trigger' => [
                    'action' => 'enable',
                    'field' => 'is_enabled',
                    'condition' => 'checked',
                ],
            ],
            'future_orders[min_days]' => [
                'label' => 'lang:igniter.local::default.label_future_min_collection_days',
                'accordion' => 'lang:igniter.local::default.text_tab_collection_order',
                'type' => 'number',
                'default' => 0,
                'span' => 'left',
                'comment' => 'lang:igniter.local::default.help_future_min_collection_days',
                'trigger' => [
                    'action' => 'enable',
                    'field' => 'future_orders[is_enabled]',
                    'condition' => 'checked',
                ],
            ],
            'future_orders[days]' => [
                'label' => 'lang:igniter.local::default.label_future_collection_days',
                'accordion' => 'lang:igniter.local::default.text_tab_collection_order',
                'type' => 'number',
                'default' => 5,
                'span' => 'right',
                'comment' => 'lang:igniter.local::default.help_future_collection_days',
                'trigger' => [
                    'action' => 'enable',
                    'field' => 'future_orders[is_enabled]',
                    'condition' => 'checked',
                ],
            ],
        ],
    ],
];