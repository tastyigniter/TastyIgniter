<?php

use Igniter\Cart\Models\Category;
use Igniter\Cart\Models\MenuOption;
use Igniter\Cart\Models\MenuSpecial;
use Igniter\Local\Models\Location;

$config['list']['filter'] = [
    'search' => [
        'prompt' => 'lang:igniter.cart::default.menus.text_filter_search',
        'mode' => 'all',
    ],
    'scopes' => [
        'category' => [
            'label' => 'lang:igniter.cart::default.menus.text_filter_category',
            'type' => 'selectlist',
            'scope' => 'whereHasCategory',
            'modelClass' => Category::class,
            'nameFrom' => 'name',
        ],
        'menu_status' => [
            'label' => 'lang:igniter::admin.text_filter_status',
            'type' => 'switch',
            'conditions' => 'menu_status = :filtered',
        ],
    ],
];

$config['list']['toolbar'] = [
    'buttons' => [
        'create' => [
            'label' => 'lang:igniter::admin.button_new',
            'class' => 'btn btn-primary',
            'href' => 'menus/create',
        ],
        'more' => [
            'label' => '<i class="fa fa-ellipsis"></i>',
            'class' => 'btn btn-default',
            'type' => 'dropdown',
            'menuItems' => [
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
        'statusColumn' => 'menu_status',
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
            'href' => 'menus/edit/{menu_id}',
        ],
    ],
    'menu_name' => [
        'label' => 'lang:igniter::admin.label_name',
        'type' => 'text',
        'searchable' => true,
    ],
    'category' => [
        'label' => 'lang:igniter.cart::default.menus.column_category',
        'relation' => 'categories',
        'select' => 'name',
    ],
    'location_name' => [
        'label' => 'lang:igniter::admin.column_location',
        'type' => 'text',
        'relation' => 'locations',
        'select' => 'location_name',
        'locationAware' => true,
    ],
    'menu_price' => [
        'label' => 'lang:igniter.cart::default.menus.column_price',
        'type' => 'currency',
        'searchable' => true,
    ],
    'stock_qty' => [
        'label' => 'lang:igniter.cart::default.menus.column_stock_qty',
        'type' => 'number',
        'sortable' => false,
    ],
    'special_status' => [
        'label' => 'lang:igniter.cart::default.menus.label_special_status',
        'type' => 'switch',
        'relation' => 'special',
        'select' => 'special_status',
        'onText' => 'lang:igniter::admin.text_active',
        'offText' => 'lang:igniter::admin.text_dashes',
    ],
    'menu_status' => [
        'label' => 'lang:igniter::admin.label_status',
        'type' => 'switch',
    ],
    'menu_id' => [
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
            'class' => 'btn btn-danger',
            'data-request' => 'onDelete',
            'data-request-data' => "_method:'DELETE'",
            'data-request-confirm' => 'lang:igniter::admin.alert_warning_confirm',
            'data-progress-indicator' => 'igniter::admin.text_deleting',
            'context' => ['edit'],
        ],
    ],
];

$config['form']['tabs'] = [
    'defaultTab' => 'lang:igniter.cart::default.menus.text_tab_general',
    'fields' => [
        'menu_name' => [
            'label' => 'lang:igniter::admin.label_name',
            'type' => 'text',
            'span' => 'left',
        ],
        'menu_price' => [
            'label' => 'lang:igniter.cart::default.menus.label_price',
            'type' => 'currency',
            'span' => 'right',
            'cssClass' => 'flex-width',
        ],
        'menu_priority' => [
            'label' => 'lang:igniter.cart::default.menus.label_menu_priority',
            'type' => 'number',
            'span' => 'right',
            'default' => 0,
            'cssClass' => 'flex-width',
        ],
        'categories' => [
            'label' => 'lang:igniter.cart::default.menus.label_category',
            'type' => 'relation',
            'span' => 'left',
        ],
        'ingredients' => [
            'label' => 'lang:igniter.cart::default.menus.label_ingredients',
            'type' => 'relation',
            'span' => 'right',
        ],
        'mealtimes' => [
            'label' => 'lang:igniter.cart::default.menus.label_mealtime',
            'type' => 'relation',
            'span' => 'left',
            'nameFrom' => 'mealtime_name',
            'comment' => 'lang:igniter.cart::default.menus.help_mealtime',
        ],
        'locations' => [
            'label' => 'lang:igniter::admin.label_location',
            'type' => 'relation',
            'span' => 'right',
            'valueFrom' => 'locations',
            'nameFrom' => 'location_name',
            'scope' => 'isEnabled',
        ],
        'minimum_qty' => [
            'label' => 'lang:igniter.cart::default.menus.label_minimum_qty',
            'type' => 'number',
            'span' => 'left',
            'default' => 1,
            'comment' => 'lang:igniter.cart::default.menus.help_minimum_qty',
        ],
        'stock_qty' => [
            'label' => 'lang:igniter.cart::default.menus.label_stock_qty',
            'type' => 'stockeditor',
            'span' => 'right',
            'context' => ['edit', 'preview'],
            'default' => 0,
            'comment' => 'lang:igniter.cart::default.menus.help_stock_qty',
        ],
        'order_restriction' => [
            'label' => 'lang:igniter.cart::default.menus.label_order_restriction',
            'type' => 'checkboxtoggle',
            'span' => 'left',
            'comment' => 'lang:igniter.cart::default.menus.help_order_restriction',
            'options' => [Location::class, 'getOrderTypeOptions'],
        ],
        'menu_status' => [
            'label' => 'lang:igniter::admin.label_status',
            'type' => 'switch',
            'default' => 1,
            'span' => 'right',
        ],
        'menu_description' => [
            'label' => 'lang:igniter::admin.label_description',
            'type' => 'textarea',
            'span' => 'left',
            'attributes' => [
                'rows' => 5,
            ],
        ],
        'thumb' => [
            'label' => 'lang:igniter.cart::default.menus.label_image',
            'type' => 'mediafinder',
            'comment' => 'lang:igniter.cart::default.menus.help_image',
            'span' => 'right',
            'context' => ['edit', 'preview'],
            'useAttachment' => true,
        ],

        '_options' => [
            'label' => 'lang:igniter.cart::default.menus.label_menu_option',
            'tab' => 'lang:igniter.cart::default.menus.text_tab_menu_option',
            'type' => 'recordeditor',
            'span' => 'flex',
            'cssClass' => 'col-md-4',
            'form' => 'menuoption',
            'modelClass' => MenuOption::class,
            'placeholder' => 'igniter.cart::default.menu_options.help_menu_option',
            'context' => ['edit', 'preview'],
            'popupSize' => 'modal-xl',
            'attachToField' => 'menu_options',
        ],
        'menu_options' => [
            'label' => 'lang:igniter.cart::default.menus.label_menu_item_option',
            'tab' => 'lang:igniter.cart::default.menus.text_tab_menu_option',
            'type' => 'connector',
            'span' => 'flex',
            'cssClass' => 'col-md-8',
            'popupSize' => 'modal-xl',
            'sortable' => true,
            'form' => 'menuitemoption',
            'context' => ['edit', 'preview'],
            'partial' => 'connector/menu_option_item',
        ],

        'special[special_id]' => [
            'tab' => 'lang:igniter.cart::default.menus.text_tab_special',
            'type' => 'hidden',
        ],
        'special[type]' => [
            'label' => 'lang:igniter.cart::default.menus.label_special_type',
            'tab' => 'lang:igniter.cart::default.menus.text_tab_special',
            'type' => 'radiotoggle',
            'span' => 'left',
            'cssClass' => 'flex-width',
            'default' => 'F',
            'options' => [
                'F' => 'lang:igniter.cart::default.menus.text_fixed_amount',
                'P' => 'lang:igniter.cart::default.menus.text_percentage',
            ],
        ],
        'special[special_price]' => [
            'label' => 'lang:igniter.cart::default.menus.label_special_price',
            'tab' => 'lang:igniter.cart::default.menus.text_tab_special',
            'type' => 'currency',
            'span' => 'left',
            'cssClass' => 'flex-width',
        ],
        'special[validity]' => [
            'label' => 'lang:igniter.cart::default.menus.label_validity',
            'tab' => 'lang:igniter.cart::default.menus.text_tab_special',
            'type' => 'radiotoggle',
            'default' => 'forever',
            'options' => [
                'forever' => 'lang:igniter.cart::default.menus.text_forever',
                'period' => 'lang:igniter.cart::default.menus.text_period',
                'recurring' => 'lang:igniter.cart::default.menus.text_recurring',
            ],
        ],
        'special[start_date]' => [
            'label' => 'lang:igniter.cart::default.menus.label_start_date',
            'tab' => 'lang:igniter.cart::default.menus.text_tab_special',
            'type' => 'datepicker',
            'mode' => 'datetime',
            'span' => 'left',
            'cssClass' => 'flex-width',
            'trigger' => [
                'action' => 'show',
                'field' => 'special[validity]',
                'condition' => 'value[period]',
            ],
            'containerAttributes' => [
                'style' => 'z-index:10',
            ],
        ],
        'special[end_date]' => [
            'label' => 'lang:igniter.cart::default.menus.label_end_date',
            'tab' => 'lang:igniter.cart::default.menus.text_tab_special',
            'type' => 'datepicker',
            'mode' => 'datetime',
            'span' => 'left',
            'cssClass' => 'flex-width',
            'trigger' => [
                'action' => 'show',
                'field' => 'special[validity]',
                'condition' => 'value[period]',
            ],
            'containerAttributes' => [
                'style' => 'z-index:10',
            ],
        ],
        'special[recurring_every]' => [
            'label' => 'lang:igniter.cart::default.menus.label_recurring_every',
            'tab' => 'lang:igniter.cart::default.menus.text_tab_special',
            'type' => 'checkboxtoggle',
            'options' => [MenuSpecial::class, 'getRecurringEveryOptions'],
            'trigger' => [
                'action' => 'show',
                'field' => 'special[validity]',
                'condition' => 'value[recurring]',
            ],
        ],
        'special[recurring_from]' => [
            'label' => 'lang:igniter.cart::default.menus.label_recurring_from_time',
            'tab' => 'lang:igniter.cart::default.menus.text_tab_special',
            'type' => 'datepicker',
            'mode' => 'time',
            'span' => 'left',
            'cssClass' => 'flex-width',
            'trigger' => [
                'action' => 'show',
                'field' => 'special[validity]',
                'condition' => 'value[recurring]',
            ],
        ],
        'special[recurring_to]' => [
            'label' => 'lang:igniter.cart::default.menus.label_recurring_to_time',
            'tab' => 'lang:igniter.cart::default.menus.text_tab_special',
            'type' => 'datepicker',
            'mode' => 'time',
            'span' => 'left',
            'cssClass' => 'flex-width',
            'trigger' => [
                'action' => 'show',
                'field' => 'special[validity]',
                'condition' => 'value[recurring]',
            ],
        ],
        'special[special_status]' => [
            'label' => 'lang:igniter.cart::default.menus.label_special_status',
            'tab' => 'lang:igniter.cart::default.menus.text_tab_special',
            'type' => 'switch',
            'comment' => 'lang:igniter.cart::default.menus.help_specials',
        ],
    ],
];

return $config;
