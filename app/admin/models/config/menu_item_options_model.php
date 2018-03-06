<?php
$config['form']['fields'] = [
    'option_id'          => [
        'type' => 'hidden',
    ],
    'menu_id'            => [
        'type' => 'hidden',
    ],
    'priority'           => [
        'type' => 'hidden',
    ],
    'menu_option_id'     => [
        'type' => 'hidden',
    ],
    'required'           => [
        'label'   => 'lang:admin::menus.label_option_required',
        'type'    => 'switch',
        'comment' => 'lang:admin::menus.help_option_required',
    ],
    'menu_option_values' => [
        'type'       => 'repeater',
        'form'       => 'menu_item_option_values_model',
        'sortable'   => TRUE,
        'showRadios' => TRUE,
        'radioFrom'  => 'is_default',
    ],
];

return $config;