<?php
$config['list']['filter'] = [
    'search' => [
        'prompt' => 'lang:admin::menu_options.text_filter_search',
        'mode'   => 'all',
    ],
    'scopes' => [
        'display_type' => [
            'label'      => 'lang:admin::menu_options.text_filter_display_type',
            'type'       => 'select',
            'conditions' => 'display_type = :filtered',
            'options'    => [
                'radio'    => 'lang:admin::menu_options.text_radio',
                'checkbox' => 'lang:admin::menu_options.text_checkbox',
                'select'   => 'lang:admin::menu_options.text_select',
            ],
        ],
    ],
];

$config['list']['toolbar'] = [
    'buttons' => [
        'create' => ['label' => 'lang:admin::default.button_new', 'class' => 'btn btn-primary', 'href' => 'menu_options/create'],
        'delete' => ['label' => 'lang:admin::default.button_delete', 'class' => 'btn btn-danger', 'data-request-form' => '#list-form', 'data-request' => 'onDelete', 'data-request-data' => "_method:'DELETE'", 'data-request-confirm' => 'lang:admin::default.alert_warning_confirm'],
        'filter' => ['label' => 'lang:admin::default.button_icon_filter', 'class' => 'btn btn-default btn-filter', 'data-toggle' => 'list-filter', 'data-target' => '.panel-filter .panel-body'],
    ],
];

$config['list']['columns'] = [
    'edit'         => [
        'type'         => 'button',
        'iconCssClass' => 'fa fa-pencil',
        'attributes'   => [
            'class' => 'btn btn-edit',
            'href'  => 'menu_options/edit/{option_id}',
        ],
    ],
    'option_name'  => [
        'label'      => 'lang:admin::menu_options.column_name',
        'type'       => 'text',
        'searchable' => TRUE,
    ],
    'display_type' => [
        'label'      => 'lang:admin::menu_options.column_display_type',
        'type'       => 'text',
        'searchable' => TRUE,
        'formatter'  => function ($record, $column, $value) {
            return $value ? ucwords($value) : '--';
        },
    ],
    'option_id'    => [
        'label'     => 'lang:admin::menu_options.column_id',
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
            'data-request-confirm' => 'lang:admin::default.alert_warning_confirm',
        ],
        'back'      => ['label' => 'lang:admin::default.button_icon_back', 'class' => 'btn btn-default', 'href' => 'menu_options'],
    ],
];

$config['form']['fields'] = [
    'option_name'   => [
        'label' => 'lang:admin::menu_options.label_option_name',
        'type'  => 'text',
    ],
    'display_type'  => [
        'label'   => 'lang:admin::menu_options.label_display_type',
        'type'    => 'radio',
        'default' => 'radio',
        'options' => [
            'radio'    => 'lang:admin::menu_options.text_radio',
            'checkbox' => 'lang:admin::menu_options.text_checkbox',
            'select'   => 'lang:admin::menu_options.text_select',
        ],
    ],
    'option_values' => [
        'label' => 'lang:admin::menu_options.text_tab_values',
        'type'  => 'repeater',
        'form'  => [
            'fields' => [
                'option_id'       => [
                    'label' => 'lang:admin::menu_options.label_option_id',
                    'type'  => 'hidden',
                ],
                'value'           => [
                    'label' => 'lang:admin::menu_options.label_option_value',
                    'type'  => 'text',
                ],
                'price'           => [
                    'label' => 'lang:admin::menu_options.label_option_price',
                    'type'  => 'number',
                ],
                'priority'        => [
                    'label' => 'lang:admin::menu_options.label_priority',
                    'type'  => 'hidden',
                ],
                'option_value_id' => [
                    'type' => 'hidden',
                ],
            ],
        ],
    ],
];

return $config;