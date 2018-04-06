<?php
$config['form']['fields'] = [
    'menu_option_value_id' => [
        'type' => 'hidden',
    ],
    'menu_option_id'       => [
        'type' => 'hidden',
    ],
    'menu_id'              => [
        'type' => 'hidden',
    ],
    'option_id'            => [
        'type' => 'hidden',
    ],
    'priority'             => [
        'type' => 'hidden',
    ],
    'is_default'           => [
        'type' => 'hidden',
    ],
    'option_value_id'      => [
        'label'   => 'lang:admin::menu_options.label_option_value',
        'type'    => 'select',
        'options' => 'listOptionValues',
    ],
    'new_price'            => [
        'label' => 'lang:admin::menus.label_option_price',
        'type'  => 'number',
    ],
    'quantity'             => [
        'label' => 'lang:admin::menus.label_option_qty',
        'type'  => 'number',
    ],
    'subtract_stock'       => [
        'label' => 'lang:admin::menus.label_option_subtract_stock',
        'type'  => 'switch',
    ],
];

return $config;