<?php
$config['form']['fields'] = [
    'menu_option_value_id' => [
        'type' => 'hidden',
    ],
    'priority' => [
        'type' => 'hidden',
    ],
    'is_default' => [
        'label' => 'lang:admin::lang.menus.label_option_default_value',
        'type' => 'checkbox',
        'options' => [],
    ],
    'option_value_id' => [
        'label' => 'lang:admin::lang.menus.label_option_value',
        'type' => 'select',
    ],
    'new_price' => [
        'label' => 'lang:admin::lang.menus.label_option_price',
        'type' => 'currency',
    ],
];

return $config;
