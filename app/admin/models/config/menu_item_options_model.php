<?php
$config['form']['fields'] = [
    'option_id' => [
        'type' => 'hidden',
    ],
    'menu_id' => [
        'type' => 'hidden',
    ],
    'priority' => [
        'type' => 'hidden',
    ],
    'menu_option_id' => [
        'type' => 'hidden',
    ],
    'option[option_name]' => [
        'label' => 'lang:admin::lang.menus.label_option_name',
        'type' => 'text',
        'span' => 'left',
        'disabled' => true,
    ],
    'option[display_type]' => [
        'label' => 'lang:admin::lang.menus.label_option_display_type',
        'type' => 'text',
        'span' => 'right',
        'disabled' => true,
    ],
    'required' => [
        'label' => 'lang:admin::lang.menus.label_option_required',
        'type' => 'switch',
        'comment' => 'lang:admin::lang.menus.help_option_required',
    ],
    'min_selected' => [
        'label' => 'lang:admin::lang.menus.label_min_selected',
        'type' => 'number',
        'span' => 'left',
        'comment' => 'lang:admin::lang.menus.help_min_selected',
    ],
    'max_selected' => [
        'label' => 'lang:admin::lang.menus.label_max_selected',
        'type' => 'number',
        'span' => 'right',
        'comment' => 'lang:admin::lang.menus.help_max_selected',
    ],
    'menu_option_values' => [
        'type' => 'repeater',
        'form' => 'menu_item_option_values_model',
        'sortable' => true,
    ],
];

return $config;
