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
    'values' => [
        'label' => 'lang:admin::lang.menu_options.text_tab_values',
        'type' => 'repeater',
        'valueFrom' => 'option_values',
        'form' => 'menu_option_values_model',
        'sortable' => true,
    ],
    'update_related_menu_item' => [
        'label' => 'lang:admin::lang.menu_options.label_update_related_menu_item',
        'type' => 'switch',
        'default' => false,
        'context' => ['edit'],
        'on' => 'lang:admin::lang.text_yes',
        'off' => 'lang:admin::lang.text_no',
    ],
];

$config['form']['rules'] = [
    ['option_name', 'lang:admin::lang.menu_options.label_option_name', 'required|min:2|max:32'],
    ['display_type', 'lang:admin::lang.menu_options.label_display_type', 'required|alpha'],
    ['locations.*', 'lang:admin::lang.label_location', 'integer'],
];

return $config;
