<?php
$config['list']['toolbar'] = [
    'buttons' => [
        'create' => ['label' => 'lang:admin::default.button_new', 'class' => 'btn btn-primary', 'href' => 'customer_groups/create'],
        'delete' => ['label' => 'lang:admin::default.button_delete', 'class' => 'btn btn-danger', 'data-request-form' => '#list-form', 'data-request' => 'onDelete', 'data-request-data' => "_method:'DELETE'", 'data-request-confirm' => 'lang:admin::default.alert_warning_confirm'],
    ],
];

$config['list']['columns'] = [
    'edit'              => [
        'type'         => 'button',
        'iconCssClass' => 'fa fa-pencil',
        'attributes'   => [
            'class' => 'btn btn-edit',
            'href'  => 'customer_groups/edit/{customer_group_id}',
        ],
    ],
    'group_name'        => [
        'label'      => 'lang:admin::customer_groups.column_name',
        'type'       => 'text',
        'searchable' => TRUE,
    ],
    'customer_count'    => [
        'label'    => 'lang:admin::customer_groups.column_customers',
        'type'     => 'number',
        'sortable' => FALSE,
    ],
    'approval'          => [
        'label' => 'lang:admin::customer_groups.label_approval',
        'type'  => 'switch',
    ],
    'customer_group_id' => [
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

$config['form']['fields'] = [
    'group_name'  => [
        'label' => 'lang:admin::customer_groups.label_name',
        'type'  => 'text',
    ],
    'approval'    => [
        'label'   => 'lang:admin::customer_groups.label_approval',
        'type'    => 'switch',
        'comment' => 'lang:admin::customer_groups.help_approval',
    ],
    'description' => [
        'label' => 'lang:admin::customer_groups.label_description',
        'type'  => 'textarea',
    ],
];

return $config;