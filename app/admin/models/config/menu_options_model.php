<?php
$config['form']['fields'] = [
    'option_name' => [
        'label' => 'lang:admin::lang.menu_options.label_option_name',
        'type' => 'text',
    ],
    'locations' => [
        'label' => 'lang:admin::lang.label_location',
        'type' => 'relation',
        'valueFrom' => 'locations',
        'nameFrom' => 'location_name',
        'locationAware' => 'hide',
    ],
    'display_type' => [
        'label' => 'lang:admin::lang.menu_options.label_display_type',
        'type' => 'radiotoggle',
        'default' => 'radio',
    ],
    'option_values' => [
        'label' => 'lang:admin::lang.menu_options.text_tab_values',
        'type' => 'repeater',
        'form' => 'menu_option_values_model',
    ],
];

return $config;
