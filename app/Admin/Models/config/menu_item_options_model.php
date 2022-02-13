<?php
$config['form']['fields'] = [
    'option_name' => [
        'label' => 'lang:admin::lang.menu_options.label_option_name',
        'type' => 'text',
        'span' => 'left',
        'disabled' => TRUE,
    ],
    'display_type' => [
        'label' => 'lang:admin::lang.menu_options.label_option_display_type',
        'type' => 'text',
        'span' => 'right',
        'disabled' => TRUE,
    ],
    'is_required' => [
        'label' => 'lang:admin::lang.menu_options.label_option_required',
        'type' => 'switch',
        'disabled' => TRUE,
    ],
    'min_selected' => [
        'label' => 'lang:admin::lang.menu_options.label_min_selected',
        'type' => 'number',
        'span' => 'left',
        'comment' => 'lang:admin::lang.menu_options.help_min_selected',
        'disabled' => TRUE,
    ],
    'max_selected' => [
        'label' => 'lang:admin::lang.menu_options.label_max_selected',
        'type' => 'number',
        'span' => 'right',
        'comment' => 'lang:admin::lang.menu_options.help_max_selected',
        'disabled' => TRUE,
    ],
    'menu_option_values' => [
        'type' => 'repeater',
        'form' => 'menu_item_option_values_model',
        'sortable' => TRUE,
        'showRemoveButton' => FALSE,
        'showAddButton' => FALSE,
    ],
];

return $config;
