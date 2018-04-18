<?php
$config['list']['toolbar'] = [
    'buttons' => [
        'create' => ['label' => 'lang:admin::default.button_new', 'class' => 'btn btn-primary', 'href' => 'staff_groups/create'],
        'delete' => ['label' => 'lang:admin::default.button_delete', 'class' => 'btn btn-danger', 'data-request-form' => '#list-form', 'data-request' => 'onDelete', 'data-request-data' => "_method:'DELETE'", 'data-request-confirm' => 'lang:admin::default.alert_warning_confirm'],
    ],
];

$config['list']['columns'] = [
    'edit'             => [
        'type'         => 'button',
        'iconCssClass' => 'fa fa-pencil',
        'attributes'   => [
            'class' => 'btn btn-edit',
            'href'  => 'staff_groups/edit/{staff_group_id}',
        ],
    ],
    'staff_group_name' => [
        'label'      => 'lang:admin::staff_groups.column_name',
        'type'       => 'text',
        'searchable' => TRUE,
    ],
    'staff_count'      => [
        'label'      => 'lang:admin::staff_groups.column_users',
        'type'       => 'number',
        'searchable' => TRUE,
    ],
    'staff_group_id'   => [
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
        'back'      => ['label' => 'lang:admin::default.button_icon_back', 'class' => 'btn btn-default', 'href' => 'staff_groups'],
    ],
];

$config['form']['fields'] = [
    'staff_group_name'        => [
        'label' => 'lang:admin::staff_groups.label_name',
        'type'  => 'text',
    ],
    'customer_account_access' => [
        'label'   => 'lang:admin::staff_groups.label_customer_account_access',
        'type'    => 'switch',
        'comment' => 'lang:admin::staff_groups.help_customer_account_access',
    ],
    'location_access'         => [
        'label'   => 'lang:admin::staff_groups.label_location_access',
        'type'    => 'switch',
        'comment' => 'lang:admin::staff_groups.help_location',
    ],
    'permission'              => [
        'label' => 'lang:admin::staff_groups.text_tab_permission',
        'type'  => 'section',
    ],
    'permissions'             => [
        'type' => 'permissioneditor',
    ],
];

return $config;