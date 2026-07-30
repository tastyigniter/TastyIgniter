<?php

$config['list']['filter'] = [
    'search' => [
        'prompt' => 'lang:igniter.cart::default.categories.text_filter_search',
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
            'href' => 'categories/create',
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
                'menu_options' => [
                    'label' => 'lang:igniter.cart::default.menu_options.text_options',
                    'class' => 'dropdown-item',
                    'href' => 'menu_options',
                    'permission' => 'Admin.Menus',
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
            'href' => 'categories/edit/{category_id}',
        ],
    ],
    'name' => [
        'label' => 'lang:igniter::admin.label_name',
        'type' => 'text',
        'searchable' => true,
    ],
    'parent_cat' => [
        'label' => 'lang:igniter.cart::default.categories.column_parent',
        'type' => 'text',
        'relation' => 'parent_cat',
        'select' => 'name',
    ],
    'location_name' => [
        'label' => 'lang:igniter::admin.column_location',
        'type' => 'text',
        'relation' => 'locations',
        'select' => 'location_name',
        'locationAware' => true,
    ],
    'priority' => [
        'label' => 'lang:igniter.cart::default.categories.column_priority',
        'type' => 'text',
    ],
    'status' => [
        'label' => 'lang:igniter::admin.label_status',
        'type' => 'switch',
    ],
    'category_id' => [
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
    'permalink_slug' => [
        'label' => 'lang:igniter.cart::default.categories.label_permalink_slug',
        'type' => 'permalink',
        'comment' => 'lang:igniter::admin.help_permalink',
        'span' => 'right',
        'preset' => [
            'field' => 'name',
            'type' => 'slug',
        ],
    ],
    'parent_id' => [
        'label' => 'lang:igniter.cart::default.categories.label_parent',
        'type' => 'relation',
        'span' => 'left',
        'relationFrom' => 'parent_cat',
        'placeholder' => 'lang:igniter::admin.text_please_select',
    ],
    'locations' => [
        'label' => 'lang:igniter::admin.label_location',
        'type' => 'relation',
        'span' => 'right',
        'valueFrom' => 'locations',
        'nameFrom' => 'location_name',
    ],
    'priority' => [
        'label' => 'lang:igniter.cart::default.categories.label_priority',
        'type' => 'number',
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
        'label' => 'lang:igniter.cart::default.categories.label_image',
        'type' => 'mediafinder',
        'useAttachment' => true,
        'span' => 'right',
        'comment' => 'lang:igniter.cart::default.categories.help_photo',
    ],
];

return $config;
