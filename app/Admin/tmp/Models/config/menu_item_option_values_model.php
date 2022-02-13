<?php
$config['form']['fields'] = [
    'menu_option_value_id' => [
        'type' => 'hidden',
    ],
    'priority' => [
        'type' => 'hidden',
    ],
    'option_value[value]' => [
        'label' => 'lang:admin::lang.menu_options.label_option_value',
        'type' => 'text',
        'disabled' => TRUE,
    ],
    'price' => [
        'label' => 'lang:admin::lang.menu_options.label_new_price',
        'type' => 'currency',
    ],
    'is_default' => [
        'label' => 'lang:admin::lang.menu_options.label_option_default_value',
        'type' => 'checkbox',
        'options' => [],
    ],
];

return $config;
