<?php

/**
 * Model configuration options for settings model.
 */

return [
    'form' => [
        'toolbar' => [
            'buttons' => [
                'save' => ['label' => 'lang:admin::lang.button_save', 'class' => 'btn btn-primary', 'data-request' => 'onSave'],
                'saveClose' => [
                    'label' => 'lang:admin::lang.button_save_close',
                    'class' => 'btn btn-default',
                    'data-request' => 'onSave',
                    'data-request-data' => 'close:1',
                ],
            ],
        ],
        'fields' => [
            'abandoned_cart' => [
                'label' => 'lang:igniter.cart::default.label_abandoned_cart',
                'type' => 'switch',
                'span' => 'left',
                'default' => false,
            ],
            'destroy_on_logout' => [
                'label' => 'lang:igniter.cart::default.label_destroy_on_logout',
                'type' => 'switch',
                'span' => 'right',
                'default' => false,
            ],
        ],
        'tabs' => [
            'fields' => [
                'conditions' => [
                    'tab' => 'lang:igniter.cart::default.label_cart_conditions',
                    'type' => 'repeater',
                    'sortable' => true,
                    'showAddButton' => false,
                    'showRemoveButton' => false,
                    'commentAbove' => 'lang:igniter.cart::default.help_cart_conditions',
                    'form' => [
                        'fields' => [
                            'priority' => [
                                'label' => 'lang:igniter.cart::default.column_condition_priority',
                                'type' => 'hidden',
                            ],
                            'label' => [
                                'label' => 'lang:igniter.cart::default.column_condition_title',
                                'type' => 'text',
                            ],
                            'name' => [
                                'label' => 'lang:igniter.cart::default.column_condition_name',
                                'type' => 'text',
                                'attributes' => [
                                    'readonly' => true,
                                ],
                            ],
                            'status' => [
                                'label' => 'lang:admin::lang.label_status',
                                'type' => 'switch',
                                'default' => true,
                            ],
                        ],
                    ],
                ],
                'enable_tipping' => [
                    'tab' => 'lang:igniter.cart::default.label_tipping',
                    'label' => 'lang:igniter.cart::default.label_enable_tipping',
                    'type' => 'switch',
                    'default' => false,
                    'on' => 'lang:admin::lang.text_yes',
                    'off' => 'lang:admin::lang.text_no',
                ],
                'tip_value_type' => [
                    'tab' => 'lang:igniter.cart::default.label_tipping',
                    'label' => 'lang:igniter.cart::default.label_tip_value_type',
                    'type' => 'radiotoggle',
                    'default' => 'F',
                    'options' => [
                        'F' => 'lang:igniter.cart::default.menus.text_fixed_amount',
                        'P' => 'lang:igniter.cart::default.menus.text_percentage',
                    ],
                    'trigger' => [
                        'action' => 'show',
                        'field' => 'enable_tipping',
                        'condition' => 'checked',
                    ],
                ],
                'tip_amounts' => [
                    'tab' => 'lang:igniter.cart::default.label_tipping',
                    'label' => 'lang:igniter.cart::default.label_tip_amounts',
                    'type' => 'repeater',
                    'span' => 'left',
                    'sortable' => true,
                    'showAddButton' => true,
                    'showRemoveButton' => true,
                    'form' => [
                        'fields' => [
                            'priority' => [
                                'label' => 'lang:igniter.cart::default.column_condition_priority',
                                'type' => 'hidden',
                            ],
                            'value' => [
                                'label' => 'lang:igniter.cart::default.column_tip_amount',
                                'type' => 'currency',
                            ],
                        ],
                    ],
                    'trigger' => [
                        'action' => 'show',
                        'field' => 'enable_tipping',
                        'condition' => 'checked',
                    ],
                ],
            ],
        ],
        'rules' => [
            ['abandoned_cart', 'igniter.cart::default.label_abandoned_cart', 'required|integer'],
            ['destroy_on_logout', 'igniter.cart::default.label_destroy_on_logout', 'required|integer'],
            ['conditions', 'igniter.cart::default.label_cart_conditions', 'required|array'],
            ['conditions.*.priority', 'igniter.cart::default.label_cart_conditions', 'required|integer'],
            ['conditions.*.name', 'igniter.cart::default.label_cart_conditions', 'required|string'],
            ['conditions.*.label', 'igniter.cart::default.label_cart_conditions', 'required|string'],
            ['conditions.*.status', 'igniter.cart::default.label_cart_conditions', 'required|integer'],
            ['enable_tipping', 'igniter.cart::default.label_tipping', 'required|integer'],
            ['tip_value_type', 'igniter.cart::default.label_tipping', 'required|in:F,P'],
            ['tip_amounts', 'igniter.cart::default.label_tipping', 'required_if:enable_tipping,1|array'],
            ['tip_amounts.*.priority', 'igniter.cart::default.label_tipping', 'required|integer'],
            ['tip_amounts.*.value', 'igniter.cart::default.label_tipping', 'required|numeric'],
        ],
    ],
];
