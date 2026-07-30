<?php

$config['form'] = [
    'fields' => [
        'option_value_id' => [
            'type' => 'hidden',
        ],
        'option_id' => [
            'label' => 'lang:igniter.cart::default.menu_options.label_option_id',
            'type' => 'hidden',
        ],
        'name' => [
            'label' => 'lang:igniter.cart::default.menu_options.label_option_name',
            'type' => 'text',
        ],
        'price' => [
            'label' => 'lang:igniter.cart::default.menu_options.label_option_price',
            'type' => 'currency',
            'default' => 0,
        ],
        'stock_qty' => [
            'label' => 'lang:igniter.cart::default.menus.label_stock_qty',
            'type' => 'stockeditor',
            'span' => 'right',
        ],
        'ingredients' => [
            'label' => 'lang:igniter.cart::default.menus.label_ingredients',
            'type' => 'relation',
            'span' => 'right',
            'attributes' => [
                'data-number-displayed' => 1,
            ],
        ],
        'priority' => [
            'label' => 'lang:igniter.cart::default.menu_options.label_priority',
            'type' => 'hidden',
        ],
    ],
];

return $config;
