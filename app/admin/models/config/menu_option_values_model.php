<?php
$config['form'] = [
    'fields' => [
        'option_id'       => [
            'label'       => 'lang:admin::lang.menu_options.label_option_id',
            'type'        => 'relation',
            'valueFrom'   => 'options',
            'nameFrom'    => 'option_name',
            'placeholder' => 'lang:admin::lang.text_please_select',
        ],
        'value'           => [
            'label' => 'lang:admin::lang.menu_options.label_option_value',
            'type'  => 'text',
        ],
        'price'           => [
            'label' => 'lang:admin::lang.menu_options.label_option_price',
            'type'  => 'number',
        ],
        'priority'        => [
            'label' => 'lang:admin::lang.menu_options.label_priority',
            'type'  => 'number',
        ],
        'option_value_id' => [
            'type'      => 'number',
            'invisible' => TRUE,
        ],
    ],
];

return $config;