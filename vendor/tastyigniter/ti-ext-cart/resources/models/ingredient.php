<?php

$config['list']['filter'] = [
    'search' => [
        'prompt' => 'lang:igniter.cart::default.ingredients.text_filter_search',
        'mode' => 'all',
    ],
    'scopes' => [
        'status' => [
            'label' => 'lang:igniter::admin.text_filter_status',
            'type' => 'switch', // checkbox, switch, date, daterange
            'conditions' => 'status = :filtered',
        ],
    ],
];

$config['list']['toolbar'] = [
    'buttons' => [
        'create' => [
            'label' => 'lang:igniter::admin.button_new',
            'class' => 'btn btn-primary',
            'href' => 'ingredients/create',
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
                'menu_options' => [
                    'label' => 'lang:igniter.cart::default.menu_options.text_options',
                    'class' => 'dropdown-item',
                    'href' => 'menu_options',
                    'permission' => 'Admin.Menus',
                ],
            ],
        ],
    ],
];

$config['list']['bulkActions'] = [
    'status' => [
        'label' => 'lang:igniter::admin.list.actions.label_status',
        'type' => 'dropdown',
        'class' => 'btn btn-light',
        'statusColumn' => 'status',
        'menuItems' => [
            'enable' => [
                'label' => 'lang:igniter::admin.list.actions.label_enable',
                'type' => 'button',
                'class' => 'dropdown-item',
            ],
            'disable' => [
                'label' => 'lang:igniter::admin.list.actions.label_disable',
                'type' => 'button',
                'class' => 'dropdown-item text-danger',
            ],
        ],
    ],
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
            'href' => 'ingredients/edit/{ingredient_id}',
        ],
    ],
    'name' => [
        'label' => 'lang:igniter::admin.label_name',
        'type' => 'text',
        'searchable' => true,
    ],
    'is_allergen' => [
        'label' => 'lang:igniter.cart::default.ingredients.column_is_allergen',
        'type' => 'switch',
    ],
    'status' => [
        'label' => 'lang:igniter::admin.label_status',
        'type' => 'switch',
    ],
    'ingredient_id' => [
        'label' => 'lang:igniter::admin.column_id',
        'invisible' => true,
    ],
    'created_at' => [
        'label' => 'lang:igniter::admin.column_date_added',
        'invisible' => true,
        'type' => 'datetime',
    ],
    'updated_at' => [
        'label' => 'lang:igniter::admin.column_date_updated',
        'invisible' => true,
        'type' => 'datetime',
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
            'context' => ['edit'],
            'class' => 'btn btn-danger',
            'data-request' => 'onDelete',
            'data-request-confirm' => 'lang:igniter::admin.alert_warning_confirm',
            'data-progress-indicator' => 'igniter::admin.text_deleting',
        ],
    ],
];

$config['form']['fields'] = [
    'name' => [
        'label' => 'lang:igniter::admin.label_name',
        'type' => 'text',
        'span' => 'left',
    ],
    'status' => [
        'label' => 'lang:igniter::admin.label_status',
        'type' => 'switch',
        'span' => 'right',
        'default' => 1,
    ],
    'description' => [
        'label' => 'lang:igniter::admin.label_description',
        'type' => 'textarea',
        'span' => 'left',
        'attributes' => [
            'rows' => 5,
        ],
    ],
    'thumb' => [
        'label' => 'lang:igniter.cart::default.ingredients.label_image',
        'type' => 'mediafinder',
        'useAttachment' => true,
        'span' => 'right',
        'comment' => 'lang:igniter.cart::default.ingredients.help_photo',
    ],
    'is_allergen' => [
        'label' => 'lang:igniter.cart::default.ingredients.label_is_allergen',
        'type' => 'switch',
        'span' => 'left',
        'default' => 0,
    ],
];

return $config;
