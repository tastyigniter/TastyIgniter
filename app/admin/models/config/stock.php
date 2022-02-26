<?php

return [
    'form' => [
        'toolbar' => [

        ],
        'fields' => [
            'id' => [
                'type' => 'hidden',
            ],
            'location_id' => [
                'type' => 'hidden',
            ],
            'is_tracked' => [
                'label' => 'lang:admin::lang.stocks.label_is_tracked',
                'type' => 'switch',
                'comment' => 'lang:admin::lang.stocks.help_is_tracked',
            ],
            'quantity' => [
                'label' => 'lang:admin::lang.stocks.label_quantity',
                'type' => 'number',
                'default' => 0,
                'disabled' => TRUE,
            ],
            'stock_action[state]' => [
                'label' => 'lang:admin::lang.stocks.label_stock_action',
                'type' => 'select',
                'options' => 'getStockActionOptions',
                'trigger' => [
                    'action' => 'show',
                    'field' => 'is_tracked',
                    'condition' => 'checked',
                ],
            ],
            'stock_action[quantity]' => [
                'type' => 'number',
                'placeholder' => lang('admin::lang.stocks.label_stock_quantity'),
                'trigger' => [
                    'action' => 'hide',
                    'field' => 'stock_action[state]',
                    'condition' => 'value[none]',
                ],
            ],
            'low_stock_alert' => [
                'label' => 'lang:admin::lang.stocks.label_low_stock_alert',
                'type' => 'switch',
                'comment' => 'lang:admin::lang.stocks.help_low_stock_alert',
                'trigger' => [
                    'action' => 'show',
                    'field' => 'is_tracked',
                    'condition' => 'checked',
                ],
            ],
            'low_stock_threshold' => [
                'label' => 'lang:admin::lang.stocks.label_low_stock_threshold',
                'type' => 'number',
                'default' => 0,
                'trigger' => [
                    'action' => 'show',
                    'field' => 'low_stock_alert',
                    'condition' => 'checked',
                ],
            ],

        ],
    ],
];
