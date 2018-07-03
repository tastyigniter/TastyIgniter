<?php
$config['form']['fields'] = [
    'option_name'   => [
        'label' => 'lang:admin::lang.menu_options.label_option_name',
        'type'  => 'text',
    ],
    'display_type'  => [
        'label'   => 'lang:admin::lang.menu_options.label_display_type',
        'type'    => 'radio',
        'default' => 'radio',
        'options' => [
            'radio'    => 'lang:admin::lang.menu_options.text_radio',
            'checkbox' => 'lang:admin::lang.menu_options.text_checkbox',
            'select'   => 'lang:admin::lang.menu_options.text_select',
        ],
    ],
    'option_values' => [
        'label' => 'lang:admin::lang.menu_options.text_tab_values',
        'type'  => 'repeater',
        'form'  => [
            'fields' => [
                'option_value_id' => [
                    'type' => 'hidden',
                ],
                'option_id'       => [
                    'label' => 'lang:admin::lang.menu_options.label_option_id',
                    'type'  => 'hidden',
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
                    'type'  => 'hidden',
                ],
            ],
        ],
    ],
];

return $config;