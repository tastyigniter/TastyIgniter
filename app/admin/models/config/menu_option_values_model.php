<?php
$config['list']['columns'] = [
    'value'  => [
        'label'    => 'lang:admin::menu_options.label_option_value',
    ],
    'price'  => [
        'label'    => 'lang:admin::menu_options.label_option_price',
    ],
    'priority'  => [
    ],
    'option_id'  => [
        'invisible'    => TRUE,
    ],
    'option_value_id'  => [
        'invisible'    => TRUE,
    ],
];

$config['form']['tabs'] = [
    'defaultTab' => 'lang:admin::menu_options.text_tab_general',
    'fields'     => [
        'option_id' => [
            'label'   => 'lang:admin::menu_options.label_option_id',
            'type'        => 'relation',
            'valueFrom'   => 'options',
            'nameFrom'   => 'option_name',
            'placeholder' => 'lang:admin::default.text_please_select',
        ],
        'value'     => [
            'label' => 'lang:admin::menu_options.label_option_value',
            'type'  => 'text',
        ],
        'price' => [
            'label'   => 'lang:admin::menu_options.label_option_price',
            'type'    => 'number',
        ],
        'priority' => [
            'label'   => 'lang:admin::menu_options.label_priority',
            'type'    => 'number',
        ],
        'option_value_id' => [
            'type'    => 'number',
            'invisible'    => TRUE,
        ],
    ],
];

return $config;