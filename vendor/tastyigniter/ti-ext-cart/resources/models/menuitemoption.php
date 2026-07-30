<?php

$config['form']['fields'] = [
    'option_name' => [
        'label' => 'lang:igniter.cart::default.menu_options.label_option_group_name',
        'type' => 'text',
        'span' => 'left',
        'disabled' => true,
    ],
    'display_type' => [
        'label' => 'lang:igniter.cart::default.menu_options.label_option_display_type',
        'type' => 'text',
        'span' => 'right',
        'disabled' => true,
    ],
    'is_required' => [
        'label' => 'lang:igniter.cart::default.menu_options.label_option_required',
        'type' => 'switch',
    ],
    'min_selected' => [
        'label' => 'lang:igniter.cart::default.menu_options.label_min_selected',
        'type' => 'number',
        'span' => 'left',
        'comment' => 'lang:igniter.cart::default.menu_options.help_min_selected',
    ],
    'max_selected' => [
        'label' => 'lang:igniter.cart::default.menu_options.label_max_selected',
        'type' => 'number',
        'span' => 'right',
        'comment' => 'lang:igniter.cart::default.menu_options.help_max_selected',
    ],
    'free_quantity' => [
        'label' => 'lang:igniter.cart::default.menu_options.label_free_quantity',
        'type' => 'number',
        'comment' => 'lang:igniter.cart::default.menu_options.help_free_quantity',
        'trigger' => [
            'action' => 'hide',
            'field' => 'display_type',
            'condition' => 'value[radio][select]',
        ],
    ],
    'linked_option_value_ids' => [
        'label' => 'lang:igniter.cart::default.menu_options.label_linked_option_values',
        'type' => 'selectlist',
        'mode' => 'checkbox',
        'options' => 'getLinkedMenuOptionValueOptions',
        'valueFrom' => 'linked_option_value_ids',
        'comment' => 'lang:igniter.cart::default.menu_options.help_linked_option_values',
    ],
    'menu_option_values' => [
        'type' => 'repeater',
        'form' => 'menuitemoptionvalue',
        'valueFrom' => 'option_values',
        'sortable' => true,
        'showAddButton' => false,
        'showRemoveButton' => false,
    ],
];

return $config;
