<?php
$config['list']['filter'] = [
    'search' => [
        'prompt' => 'lang:admin::lang.menu_options.text_filter_search',
        'mode' => 'all',
    ],
    'scopes' => [
        'display_type' => [
            'label' => 'lang:admin::lang.menu_options.text_filter_display_type',
            'type' => 'select',
            'conditions' => 'display_type = :filtered',
            'options' => ['Admin\Models\MenuOption', 'getDisplayTypeOptions'],
        ],
    ],
];

$config['list']['toolbar'] = [
    'buttons' => [
        'back' => [
            'label' => 'lang:admin::lang.button_icon_back',
            'class' => 'btn btn-default',
            'href' => 'menus',
        ],
        'create' => [
            'label' => 'lang:admin::lang.button_new',
            'class' => 'btn btn-primary',
            'href' => 'menu_options/create',
        ],
    ],
];

$config['list']['bulkActions'] = [
    'delete' => [
        'label' => 'lang:admin::lang.button_delete',
        'class' => 'btn btn-light text-danger',
        'data-request-confirm' => 'lang:admin::lang.alert_warning_confirm',
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
        'label' => 'lang:admin::lang.menu_options.column_name',
        'type' => 'text',
        'searchable' => TRUE,
    ],
    'display_type' => [
        'label' => 'lang:admin::lang.menu_options.column_display_type',
        'type' => 'text',
        'searchable' => TRUE,
        'formatter' => function ($record, $column, $value) {
            return $value ? ucwords($value) : '--';
        },
    ],
    'is_required' => [
        'label' => 'lang:admin::lang.menu_options.label_option_required',
        'type' => 'switch',
        'onText' => 'admin::lang.text_yes',
        'offText' => 'admin::lang.text_no',
    ],
    'min_selected' => [
        'label' => 'lang:admin::lang.menu_options.label_min_selected',
        'type' => 'number',
    ],
    'max_selected' => [
        'label' => 'lang:admin::lang.menu_options.label_max_selected',
        'type' => 'number',
    ],
    'locations' => [
        'label' => 'lang:admin::lang.column_location',
        'type' => 'text',
        'relation' => 'locations',
        'select' => 'location_name',
        'invisible' => TRUE,
        'locationAware' => TRUE,
    ],
    'option_id' => [
        'label' => 'lang:admin::lang.column_id',
        'invisible' => TRUE,
    ],

];

$config['form']['toolbar'] = [
    'buttons' => [
        'back' => [
            'label' => 'lang:admin::lang.button_icon_back',
            'class' => 'btn btn-default',
            'href' => 'menu_options',
        ],
        'save' => [
            'label' => 'lang:admin::lang.button_save',
            'context' => ['create', 'edit'],
            'partial' => 'form/toolbar_save_button',
            'class' => 'btn btn-primary',
            'data-request' => 'onSave',
            'data-progress-indicator' => 'admin::lang.text_saving',
        ],
        'delete' => [
            'label' => 'lang:admin::lang.button_icon_delete',
            'class' => 'btn btn-danger',
            'data-request' => 'onDelete',
            'data-request-data' => "_method:'DELETE'",
            'data-request-confirm' => 'lang:admin::lang.alert_warning_confirm',
            'data-progress-indicator' => 'admin::lang.text_deleting',
            'context' => ['edit'],
        ],
    ],
];

$config['form']['fields'] = [
    'option_name' => [
        'label' => 'lang:admin::lang.menu_options.label_option_name',
        'type' => 'text',
        'span' => 'left',
    ],
    'locations' => [
        'label' => 'lang:admin::lang.label_location',
        'type' => 'relation',
        'span' => 'right',
        'valueFrom' => 'locations',
        'nameFrom' => 'location_name',
    ],
    'display_type' => [
        'label' => 'lang:admin::lang.menu_options.label_display_type',
        'type' => 'radiotoggle',
        'default' => 'radio',
        'span' => 'left',
    ],
    'is_required' => [
        'label' => 'lang:admin::lang.menu_options.label_option_required',
        'type' => 'switch',
        'span' => 'right',
    ],
    'min_selected' => [
        'label' => 'lang:admin::lang.menu_options.label_min_selected',
        'type' => 'number',
        'span' => 'left',
        'default' => 0,
        'comment' => 'lang:admin::lang.menu_options.help_min_selected',
    ],
    'max_selected' => [
        'label' => 'lang:admin::lang.menu_options.label_max_selected',
        'type' => 'number',
        'span' => 'right',
        'default' => 0,
        'comment' => 'lang:admin::lang.menu_options.help_max_selected',
    ],
    'option_values' => [
        'label' => 'lang:admin::lang.menu_options.text_tab_values',
        'type' => 'repeater',
        'form' => 'menuoptionvalue',
        'sortable' => TRUE,
    ],
];

return $config;
