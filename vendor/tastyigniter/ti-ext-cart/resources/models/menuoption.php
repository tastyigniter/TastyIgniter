<?php

use Igniter\Cart\Models\MenuOption;

$config['list']['filter'] = [
    'search' => [
        'prompt' => 'lang:igniter.cart::default.menu_options.text_filter_search',
        'mode' => 'all',
    ],
    'scopes' => [
        'display_type' => [
            'label' => 'lang:igniter.cart::default.menu_options.text_filter_display_type',
            'type' => 'select',
            'conditions' => 'display_type = :filtered',
            'options' => [MenuOption::class, 'getDisplayTypeOptions'],
        ],
    ],
];

$config['list']['toolbar'] = [
    'buttons' => [
        'create' => [
            'label' => 'lang:igniter::admin.button_new',
            'class' => 'btn btn-primary',
            'href' => 'menu_options/create',
        ],
        'more' => [
            'label' => '<i class="fa fa-ellipsis"></i>',
            'class' => 'btn btn-default',
            'type' => 'dropdown',
            'menuItems' => [
                'menus' => [
                    'label' => 'lang:igniter.cart::default.text_side_menu_menu',
                    'class' => 'dropdown-item',
                    'href' => 'menus',
                    'permission' => 'Admin.Menus',
                ],
                'categories' => [
                    'label' => 'lang:igniter.cart::default.text_side_menu_category',
                    'class' => 'dropdown-item',
                    'href' => 'categories',
                    'permission' => 'Admin.Categories',
                ],
                'ingredients' => [
                    'label' => 'lang:igniter.cart::default.ingredients.text_ingredients',
                    'class' => 'dropdown-item',
                    'href' => 'ingredients',
                    'permission' => 'Admin.Ingredients',
                ],
            ],
        ],
    ],
];

$config['list']['bulkActions'] = [
    'delete' => [
        'label' => 'lang:igniter::admin.button_delete',
        'class' => 'btn btn-light text-danger',
        'data-request-confirm' => 'lang:igniter::admin.alert_warning_confirm',
    ],
];

$config['list']['columns'] = [
    'edit' => [
        'type' => 'button',
        'iconCssClass' => 'fa fa-pencil',
        'attributes' => [
            'class' => 'btn btn-edit',
            'href' => 'menu_options/edit/{option_id}',
        ],
    ],
    'option_name' => [
        'label' => 'lang:igniter.cart::default.menu_options.column_name',
        'type' => 'text',
        'searchable' => true,
    ],
    'display_type' => [
        'label' => 'lang:igniter.cart::default.menu_options.column_display_type',
        'type' => 'text',
        'searchable' => true,
        'formatter' => function($record, $column, $value) {
            return $value ? ucwords($value) : '--';
        },
    ],
    'location_name' => [
        'label' => 'lang:igniter::admin.column_location',
        'type' => 'text',
        'relation' => 'locations',
        'select' => 'location_name',
        'locationAware' => true,
    ],
    'option_id' => [
        'label' => 'lang:igniter::admin.column_id',
        'invisible' => true,
    ],

];

$config['form']['toolbar'] = [
    'buttons' => [
        'save' => [
            'label' => 'lang:igniter::admin.button_save',
            'context' => ['create', 'edit'],
            'partial' => 'form/toolbar_save_button',
            'class' => 'btn btn-primary',
            'data-request' => 'onSave',
            'data-progress-indicator' => 'igniter::admin.text_saving',
        ],
        'delete' => [
            'label' => 'lang:igniter::admin.button_icon_delete',
            'class' => 'btn btn-danger',
            'data-request' => 'onDelete',
            'data-request-data' => "_method:'DELETE'",
            'data-request-confirm' => 'lang:igniter::admin.alert_warning_confirm',
            'data-progress-indicator' => 'igniter::admin.text_deleting',
            'context' => ['edit'],
        ],
    ],
];

$config['form']['fields'] = [
    'option_name' => [
        'label' => 'lang:igniter.cart::default.menu_options.label_option_group_name',
        'type' => 'text',
        'span' => 'left',
    ],
    'display_type' => [
        'label' => 'lang:igniter.cart::default.menu_options.label_display_type',
        'type' => 'radiotoggle',
        'default' => 'radio',
        'span' => 'right',
    ],
    'locations' => [
        'label' => 'lang:igniter::admin.label_location',
        'type' => 'relation',
        'span' => 'left',
        'valueFrom' => 'locations',
        'nameFrom' => 'location_name',
    ],
    'values' => [
        'label' => 'lang:igniter.cart::default.menu_options.text_tab_values',
        'type' => 'repeater',
        'valueFrom' => 'option_values',
        'form' => 'menuoptionvalue',
        'sortable' => true,
    ],
];

return $config;
