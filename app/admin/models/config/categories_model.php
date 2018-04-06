<?php
$config['list']['filter'] = [
    'search' => [
        'prompt' => 'lang:admin::categories.text_filter_search',
        'mode'   => 'all' // or any, exact
    ],
    'scopes' => [
        'status' => [
            'label'      => 'lang:admin::categories.text_filter_status',
            'type'       => 'switch', // checkbox, switch, date, daterange
            'conditions' => 'status = :filtered',
        ],
    ],
];

$config['list']['toolbar'] = [
    'buttons' => [
        'create' => ['label' => 'lang:admin::default.button_new', 'class' => 'btn btn-primary', 'href' => 'categories/create'],
        'delete' => ['label' => 'lang:admin::default.button_delete', 'class' => 'btn btn-danger', 'data-request-form' => '#list-form', 'data-request' => 'onDelete', 'data-request-data' => "_method:'DELETE'", 'data-request-confirm' => 'lang:admin::default.alert_warning_confirm'],
        'filter' => ['label' => 'lang:admin::default.button_icon_filter', 'class' => 'btn btn-default btn-filter', 'data-toggle' => 'list-filter', 'data-target' => '.panel-filter .panel-body'],
    ],
];

$config['list']['columns'] = [
    'edit'        => [
        'type'         => 'button',
        'iconCssClass' => 'fa fa-pencil',
        'attributes'   => [
            'class' => 'btn btn-edit',
            'href'  => 'categories/edit/{category_id}',
        ],
    ],
    'name'        => [
        'label'      => 'lang:admin::categories.column_name',
        'type'       => 'text',
        'searchable' => TRUE,
    ],
    'parent_cat'  => [
        'label'      => 'lang:admin::categories.column_parent',
        'type'       => 'text',
        'relation'   => 'parent_cat',
        'select'     => 'name',
        'searchable' => TRUE,
    ],
    'priority'    => [
        'label'      => 'lang:admin::categories.column_priority',
        'type'       => 'text',
        'searchable' => TRUE,
    ],
    'status'      => [
        'label' => 'lang:admin::categories.column_status',
        'type'  => 'switch',
    ],
    'category_id' => [
        'label'     => 'lang:admin::categories.column_id',
        'invisible' => TRUE,
    ],

];

$config['form']['toolbar'] = [
    'buttons' => [
        'save'      => [
            'label'        => 'lang:admin::default.button_save',
            'context'      => ['create', 'edit'],
            'class'        => 'btn btn-primary',
            'data-request' => 'onSave',
        ],
        'saveClose' => [
            'label'             => 'lang:admin::default.button_save_close',
            'context'           => ['create', 'edit'],
            'class'             => 'btn btn-default',
            'data-request'      => 'onSave',
            'data-request-data' => 'close:1',
        ],
        'delete'    => [
            'label'                => 'lang:admin::default.button_icon_delete',
            'context'              => ['edit'],
            'class'                => 'btn btn-danger',
            'data-request'         => 'onDelete',
            'data-request-confirm' => 'lang:admin::default.alert_warning_confirm',
        ],
        'back'      => [
            'label' => 'lang:admin::default.button_icon_back',
            'class' => 'btn btn-default',
            'href'  => 'categories',
        ],
    ],
];

$config['form']['fields'] = [
    'name'           => [
        'label' => 'lang:admin::categories.label_name',
        'type'  => 'text',
        'span'  => 'left',
    ],
    'priority'       => [
        'label' => 'lang:admin::categories.label_priority',
        'type'  => 'number',
        'span'  => 'right',
    ],
    'permalink_slug' => [
        'label'   => 'lang:admin::categories.label_permalink_slug',
        'type'    => 'permalink',
        'comment' => 'lang:admin::categories.help_permalink',
    ],
    'parent_id'      => [
        'label'        => 'lang:admin::categories.label_parent',
        'type'         => 'relation',
        'relationFrom' => 'parent_cat',
        'placeholder'  => 'lang:admin::default.text_please_select',
    ],
    'description'    => [
        'label' => 'lang:admin::categories.label_description',
        'type'  => 'textarea',
    ],
    'image'          => [
        'label'   => 'lang:admin::categories.label_image',
        'type'    => 'mediafinder',
        'comment' => 'lang:admin::categories.help_photo',
    ],
    'status'         => [
        'label'   => 'lang:admin::default.label_status',
        'type'    => 'switch',
        'default' => 1,
    ],
];

return $config;