<?php

$config['form']['fields'] = [
    'menu_option_value_id' => [
        'type' => 'hidden',
    ],
    'menu_option_id' => [
        'type' => 'hidden',
    ],
    'option_value_id' => [
        'type' => 'hidden',
    ],
    'priority' => [
        'type' => 'hidden',
    ],
    'display_type' => [
        'type' => 'hidden',
    ],
    'name' => [
        'label' => 'lang:igniter.cart::default.menu_options.label_option_name',
        'type' => 'text',
        'disabled' => true,
    ],
    'price' => [
        'label' => 'lang:igniter.cart::default.menu_options.label_option_price',
        'disabled' => true,
        'type' => 'currency',
    ],
    'override_price' => [
        'label' => 'lang:igniter.cart::default.menu_options.label_new_price',
        'type' => 'currency',
    ],
    'is_default' => [
        'label' => 'lang:igniter.cart::default.menu_options.label_option_default_value',
        'type' => 'checkbox',
        'options' => [],
    ],
    'free_quantity' => [
        'label' => 'lang:igniter.cart::default.menu_options.label_value_free_quantity',
        'type' => 'number',
        'comment' => 'lang:igniter.cart::default.menu_options.help_value_free_quantity',
        'trigger' => [
            'action' => 'disable|empty',
            'field' => 'display_type',
            'condition' => 'value[radio][select]',
        ],
    ],
    'is_enabled' => [
        'label' => 'lang:igniter.cart::default.menu_options.label_option_enabled',
        'type' => 'checkbox',
        'options' => [],
    ],
];

return $config;
