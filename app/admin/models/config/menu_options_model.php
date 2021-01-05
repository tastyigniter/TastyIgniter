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
        'sortable' => TRUE,
    ],
    'update_related_menu_item' => [
        'label' => 'lang:admin::lang.menu_options.label_update_related_menu_item',
        'type' => 'switch',
        'default' => FALSE,
        'context' => ['edit'],
        'on' => 'lang:admin::lang.text_yes',
        'off' => 'lang:admin::lang.text_no',
    ],
];

return $config;
