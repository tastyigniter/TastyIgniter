<?php
$config['list']['filter'] = [
    'search' => [
        'prompt' => 'lang:admin::lang.menus.text_filter_search',
        'mode' => 'all',
    ],
    'scopes' => [
        'location' => [
            'label' => 'lang:admin::lang.text_filter_location',
            'type' => 'select',
            'scope' => 'whereHasLocation',
            'modelClass' => 'Admin\Models\Locations_model',
            'nameFrom' => 'location_name',
        ],
        'category' => [
            'label' => 'lang:admin::lang.menus.text_filter_category',
            'type' => 'select',
            'scope' => 'whereHasCategory',
            'modelClass' => 'Admin\Models\Categories_model',
            'nameFrom' => 'name',
        ],
        'menu_status' => [
            'label' => 'lang:admin::lang.menus.text_filter_status',
            'type' => 'switch',
            'conditions' => 'menu_status = :filtered',
        ],
    ],
];

$config['list']['toolbar'] = [
    'buttons' => [
        'create' => ['label' => 'lang:admin::lang.button_new', 'class' => 'btn btn-primary', 'href' => 'menus/create'],
        'delete' => ['label' => 'lang:admin::lang.button_delete', 'class' => 'btn btn-danger', 'data-request-form' => '#list-form', 'data-request' => 'onDelete', 'data-request-data' => "_method:'DELETE'", 'data-request-data' => "_method:'DELETE'", 'data-request-confirm' => 'lang:admin::lang.alert_warning_confirm'],
        'filter' => ['label' => 'lang:admin::lang.button_icon_filter', 'class' => 'btn btn-default btn-filter', 'data-toggle' => 'list-filter', 'data-target' => '.list-filter'],
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
        'label' => 'lang:admin::lang.menus.column_name',
        'type' => 'text',
        'searchable' => TRUE,
    ],
    'category' => [
        'label' => 'lang:admin::lang.menus.column_category',
        'relation' => 'categories',
        'select' => 'name',
    ],
    'locations' => [
        'label' => 'lang:admin::lang.column_location',
        'type' => 'text',
        'relation' => 'locations',
        'select' => 'location_name',
        'invisible' => TRUE,
    ],
    'menu_price' => [
        'label' => 'lang:admin::lang.menus.column_price',
        'type' => 'money',
        'searchable' => TRUE,
    ],
    'stock_qty' => [
        'label' => 'lang:admin::lang.menus.column_stock_qty',
        'type' => 'number',
        'searchable' => TRUE,
    ],
    'special_status' => [
        'label' => 'lang:admin::lang.menus.label_special_status',
        'type' => 'switch',
        'relation' => 'special',
        'select' => 'special_status',
        'onText' => 'lang:admin::lang.text_active',
        'offText' => 'lang:admin::lang.text_dashes',
    ],
    'menu_status' => [
        'label' => 'lang:admin::lang.menus.column_status',
        'type' => 'switch',
    ],
    'menu_id' => [
        'label' => 'lang:admin::lang.column_id',
        'invisible' => TRUE,
    ],

];

$config['form']['toolbar'] = [
    'buttons' => [
        'save' => ['label' => 'lang:admin::lang.button_save', 'class' => 'btn btn-primary', 'data-request-submit' => 'true', 'data-request' => 'onSave'],
        'saveClose' => [
            'label' => 'lang:admin::lang.button_save_close',
            'class' => 'btn btn-default',
            'data-request' => 'onSave',
            'data-request-submit' => 'true',
            'data-request-data' => 'close:1',
        ],
        'delete' => [
            'label' => 'lang:admin::lang.button_icon_delete', 'class' => 'btn btn-danger',
            'data-request-submit' => 'true', 'data-request' => 'onDelete', 'data-request-data' => "_method:'DELETE'",
            'data-request-confirm' => 'lang:admin::lang.alert_warning_confirm', 'context' => ['edit'],
        ],
    ],
];

$config['form']['tabs'] = [
    'defaultTab' => 'lang:admin::lang.menus.text_tab_general',
    'fields' => [
        'menu_name' => [
            'label' => 'lang:admin::lang.menus.label_name',
            'type' => 'text',
            'span' => 'left',
        ],
        'menu_price' => [
            'label' => 'lang:admin::lang.menus.label_price',
            'type' => 'number',
            'span' => 'right',
        ],
        'categories' => [
            'label' => 'lang:admin::lang.menus.label_category',
            'type' => 'relation',
            'span' => 'left',
        ],
        'menu_priority' => [
            'label' => 'lang:admin::lang.menus.label_menu_priority',
            'type' => 'number',
            'span' => 'right',
            'default' => 0,
        ],
        'mealtime_id' => [
            'label' => 'lang:admin::lang.menus.label_mealtime',
            'type' => 'relation',
            'span' => 'left',
            'relationFrom' => 'mealtime',
            'nameFrom' => 'mealtime_name',
            'comment' => 'lang:admin::lang.menus.help_mealtime',
            'placeholder' => 'lang:admin::lang.menus.text_mealtime_all',
        ],
        'locations' => [
            'label' => 'lang:admin::lang.label_location',
            'type' => 'relation',
            'span' => 'right',
            'valueFrom' => 'locations',
            'nameFrom' => 'location_name',
        ],
        'menu_description' => [
            'label' => 'lang:admin::lang.menus.label_description',
            'type' => 'textarea',
            'span' => 'left',
            'attributes' => [
                'rows' => 5,
            ],
        ],
        'thumb' => [
            'label' => 'lang:admin::lang.menus.label_image',
            'type' => 'mediafinder',
            'comment' => 'lang:admin::lang.menus.help_image',
            'span' => 'right',
            'useAttachment' => TRUE,
        ],
        'minimum_qty' => [
            'label' => 'lang:admin::lang.menus.label_minimum_qty',
            'type' => 'number',
            'span' => 'left',
            'default' => 1,
            'comment' => 'lang:admin::lang.menus.help_minimum_qty',
        ],
        'stock_qty' => [
            'label' => 'lang:admin::lang.menus.label_stock_qty',
            'type' => 'number',
            'span' => 'right',
            'default' => 0,
            'comment' => 'lang:admin::lang.menus.help_stock_qty',
        ],
        'subtract_stock' => [
            'label' => 'lang:admin::lang.menus.label_subtract_stock',
            'type' => 'switch',
            'span' => 'left',
            'comment' => 'lang:admin::lang.menus.help_subtract_stock',
        ],
        'menu_status' => [
            'label' => 'lang:admin::lang.label_status',
            'type' => 'switch',
            'default' => 1,
            'span' => 'right',
        ],

        '_options' => [
            'label' => 'lang:admin::lang.menus.label_option',
            'tab' => 'lang:admin::lang.menus.text_tab_menu_option',
            'type' => 'recordeditor',
            'context' => ['edit', 'preview'],
            'form' => 'menu_options_model',
            'modelClass' => 'Admin\Models\Menu_options_model',
            'placeholder' => 'lang:admin::lang.menus.help_menu_option',
            'formName' => 'lang:admin::lang.menu_options.text_option',
            'addonRight' => [
                'label' => '<i class="fa fa-long-arrow-down"></i> Add to Menu',
                'tag' => 'button',
                'attributes' => [
                    'class' => 'btn btn-default',
                    'data-control' => 'choose-record',
                    'data-request' => 'onChooseMenuOption',
                    'data-request-success' => '$(\'[data-control="connector"]\').connector();',
                ],
            ],
        ],
        'menu_options' => [
            'label' => 'lang:admin::lang.menus.label_menu_option',
            'tab' => 'lang:admin::lang.menus.text_tab_menu_option',
            'type' => 'connector',
            'partial' => 'form/menu_options',
            'nameFrom' => 'option_name',
            'formName' => 'lang:admin::lang.menu_options.text_form_name',
            'form' => 'menu_item_options_model',
            'popupSize' => 'modal-lg',
            'sortable' => TRUE,
            'context' => ['edit', 'preview'],
        ],

        'special[special_id]' => [
            'tab' => 'lang:admin::lang.menus.text_tab_special',
            'type' => 'hidden',
        ],
        'special[special_status]' => [
            'label' => 'lang:admin::lang.menus.label_special_status',
            'tab' => 'lang:admin::lang.menus.text_tab_special',
            'type' => 'switch',
            'comment' => 'lang:admin::lang.menus.help_specials',
        ],
        'special[special_price]' => [
            'label' => 'lang:admin::lang.menus.label_special_price',
            'tab' => 'lang:admin::lang.menus.text_tab_special',
            'type' => 'money',
            'span' => 'left',
            'cssClass' => 'flex-width',
            'trigger' => [
                'action' => 'show',
                'field' => 'special[special_status]',
                'condition' => 'checked',
            ],
        ],
        'special[start_date]' => [
            'label' => 'lang:admin::lang.menus.label_start_date',
            'tab' => 'lang:admin::lang.menus.text_tab_special',
            'type' => 'datepicker',
            'span' => 'left',
            'cssClass' => 'flex-width',
            'trigger' => [
                'action' => 'show',
                'field' => 'special[special_status]',
                'condition' => 'checked',
            ],
        ],
        'special[end_date]' => [
            'label' => 'lang:admin::lang.menus.label_end_date',
            'tab' => 'lang:admin::lang.menus.text_tab_special',
            'type' => 'datepicker',
            'span' => 'left',
            'cssClass' => 'flex-width',
            'trigger' => [
                'action' => 'show',
                'field' => 'special[special_status]',
                'condition' => 'checked',
            ],
        ],
    ],
];

return $config;