<?php
$config['list']['filter'] = [
    'search' => [
        'prompt' => 'lang:admin::menus.text_filter_search',
        'mode'   => 'all',
    ],
    'scopes' => [
        'category'    => [
            'label'      => 'lang:admin::menus.text_filter_category',
            'type'       => 'select',
            'conditions' => 'menu_category_id = :filtered',
            'modelClass' => 'Admin\Models\Categories_model',
            'nameFrom'   => 'name',
        ],
        'menu_status' => [
            'label'      => 'lang:admin::menus.text_filter_status',
            'type'       => 'switch',
            'conditions' => 'menu_status = :filtered',
        ],
    ],
];

$config['list']['toolbar'] = [
    'buttons' => [
        'create' => ['label' => 'lang:admin::default.button_new', 'class' => 'btn btn-primary', 'href' => 'menus/create'],
        'delete' => ['label' => 'lang:admin::default.button_delete', 'class' => 'btn btn-danger', 'data-request-form' => '#list-form', 'data-request' => 'onDelete', 'data-request-data' => "_method:'DELETE'", 'data-request-data' => "_method:'DELETE'", 'data-request-confirm' => 'lang:admin::default.alert_warning_confirm'],
        'filter' => ['label' => 'lang:admin::default.button_icon_filter', 'class' => 'btn btn-default btn-filter', 'data-toggle' => 'list-filter', 'data-target' => '.list-filter'],
    ],
];

$config['list']['columns'] = [
    'edit'           => [
        'type'         => 'button',
        'iconCssClass' => 'fa fa-pencil',
        'attributes'   => [
            'class' => 'btn btn-edit',
            'href'  => 'menus/edit/{menu_id}',
        ],
    ],
    'menu_name'      => [
        'label'      => 'lang:admin::menus.column_name',
        'type'       => 'text', // number, switch, date_time, time, date, timesince, timetense, select, relation, partial
        'searchable' => TRUE,
    ],
    'category'       => [
        'label'      => 'lang:admin::menus.column_category',
        'relation'   => 'categories',
        'select'     => 'name',
        'searchable' => TRUE,
    ],
    'menu_price'     => [
        'label'      => 'lang:admin::menus.column_price',
        'type'       => 'money',
        'searchable' => TRUE,
    ],
    'stock_qty'      => [
        'label' => 'lang:admin::menus.column_stock_qty',
        'type'  => 'number',
    ],
    'special_status' => [
        'label'    => 'lang:admin::menus.label_special_status',
        'type'     => 'switch',
        'relation' => 'special',
        'select'   => 'special_status',
    ],
    'menu_status'    => [
        'label' => 'lang:admin::menus.column_status',
        'type'  => 'switch',
    ],
    'menu_id'        => [
        'label'     => 'lang:admin::default.column_id',
        'invisible' => TRUE,
    ],

];

$config['form']['toolbar'] = [
    'buttons' => [
        'save'      => ['label' => 'lang:admin::default.button_save', 'class' => 'btn btn-primary', 'data-request-form' => '#edit-form', 'data-request' => 'onSave'],
        'saveClose' => [
            'label'             => 'lang:admin::default.button_save_close',
            'class'             => 'btn btn-default',
            'data-request'      => 'onSave',
            'data-request-form' => '#edit-form',
            'data-request-data' => 'close:1',
        ],
        'delete'    => [
            'label'                => 'lang:admin::default.button_icon_delete', 'class' => 'btn btn-danger',
            'data-request-form'    => '#edit-form', 'data-request' => 'onDelete', 'data-request-data' => "_method:'DELETE'",
            'data-request-confirm' => 'lang:admin::default.alert_warning_confirm', 'context' => ['edit'],
        ],
    ],
];

$config['form']['tabs'] = [
    'defaultTab' => 'lang:admin::menus.text_tab_general',
    'fields'     => [
        'menu_name'        => [
            'label' => 'lang:admin::menus.label_name',
            'type'  => 'text',
            'span'  => 'left',
        ],
        'menu_price'       => [
            'label' => 'lang:admin::menus.label_price',
            'type'  => 'number',
            'span'  => 'right',
        ],
        'categories'       => [
            'label' => 'lang:admin::menus.label_category',
            'type'  => 'relation',
            'span'  => 'left',
        ],
        'menu_priority'    => [
            'label'   => 'lang:admin::menus.label_menu_priority',
            'type'    => 'number',
            'span'    => 'right',
            'default' => 0,
        ],
        'minimum_qty'      => [
            'label'   => 'lang:admin::menus.label_minimum_qty',
            'type'    => 'number',
            'span'    => 'left',
            'default' => 0,
            'comment' => 'lang:admin::menus.help_minimum_qty',
        ],
        'stock_qty'        => [
            'label'   => 'lang:admin::menus.label_stock_qty',
            'type'    => 'number',
            'span'    => 'right',
            'default' => 0,
            'comment' => 'lang:admin::menus.help_stock_qty',
        ],
        'menu_description' => [
            'label' => 'lang:admin::menus.label_description',
            'type'  => 'textarea',
        ],
        'mealtime_id'      => [
            'label'        => 'lang:admin::menus.label_mealtime',
            'type'         => 'relation',
            'relationFrom' => 'mealtime',
            'nameFrom'     => 'mealtime_name',
            'comment'      => 'lang:admin::menus.help_mealtime',
            'placeholder'  => 'lang:admin::menus.text_mealtime_all',
        ],
        'menu_photo'       => [
            'label'   => 'lang:admin::menus.label_image',
            'type'    => 'mediafinder',
            'comment' => 'lang:admin::menus.help_image',
        ],
        'subtract_stock'   => [
            'label' => 'lang:admin::menus.label_subtract_stock',
            'type'  => 'switch',
            'span'  => 'left',
        ],
        'menu_status'      => [
            'label'   => 'lang:admin::default.label_status',
            'type'    => 'switch',
            'default' => 1,
            'span'    => 'right',
        ],

        'options'      => [
            'label'       => 'lang:admin::menus.label_option',
            'tab'         => 'lang:admin::menus.text_tab_menu_option',
            'type'        => 'recordeditor',
            'context'     => ['edit', 'preview'],
            'form'        => 'menu_options_model',
            'modelClass'  => 'Admin\Models\Menu_options_model',
            'placeholder' => 'lang:admin::menus.help_menu_option',
            'formName'    => 'lang:admin::menu_options.text_option',
            'addonRight'  => [
                'label'      => '<i class="fa fa-long-arrow-down"></i>',
                'tag'        => 'button',
                'attributes' => [
                    'class'                => 'btn btn-default',
                    'data-control'         => 'choose-record',
                    'data-request'         => 'onChooseMenuOption',
                    'data-request-success' => '$(\'[data-control="connector"]\').connector();',
                ],
            ],
        ],
        'menu_options' => [
            'label'     => 'lang:admin::menus.label_menu_option',
            'tab'       => 'lang:admin::menus.text_tab_menu_option',
            'type'      => 'connector',
            'partial'   => 'form/menu_options',
            'nameFrom'  => 'option_name',
            'formName'  => 'lang:admin::menu_options.text_form_name',
            'form'      => 'menu_item_options_model',
            'popupSize' => 'modal-lg',
            'sortable'  => TRUE,
            'context'   => ['edit', 'preview'],
        ],

        'special[special_id]'     => [
            'tab'  => 'lang:admin::menus.text_tab_special',
            'type' => 'hidden',
        ],
        'special[special_status]' => [
            'label' => 'lang:admin::menus.label_special_status',
            'tab'   => 'lang:admin::menus.text_tab_special',
            'type'  => 'switch',
        ],
        'special[special_price]'  => [
            'label'    => 'lang:admin::menus.label_special_price',
            'tab'      => 'lang:admin::menus.text_tab_special',
            'type'     => 'money',
            'span'     => 'left',
            'cssClass' => 'flex-width',
            'trigger'  => [
                'action'    => 'show',
                'field'     => 'special[special_status]',
                'condition' => 'checked',
            ],
        ],
        'special[start_date]'     => [
            'label'    => 'lang:admin::menus.label_start_date',
            'tab'      => 'lang:admin::menus.text_tab_special',
            'type'     => 'datepicker',
            'span'     => 'left',
            'cssClass' => 'flex-width',
            'trigger'  => [
                'action'    => 'show',
                'field'     => 'special[special_status]',
                'condition' => 'checked',
            ],
        ],
        'special[end_date]'       => [
            'label'    => 'lang:admin::menus.label_end_date',
            'tab'      => 'lang:admin::menus.text_tab_special',
            'type'     => 'datepicker',
            'span'     => 'left',
            'cssClass' => 'flex-width',
            'trigger'  => [
                'action'    => 'show',
                'field'     => 'special[special_status]',
                'condition' => 'checked',
            ],
        ],
    ],
];

return $config;