<?php
$config['list']['toolbar'] = [
    'buttons' => [
        'back' => [
            'label' => 'lang:admin::lang.button_icon_back',
            'class' => 'btn btn-default',
            'href' => 'staffs',
        ],
        'create' => [
            'label' => 'lang:admin::lang.button_new',
            'class' => 'btn btn-primary',
            'href' => 'staff_groups/create',
        ],
        'delete' => [
            'label' => 'lang:admin::lang.button_delete',
            'class' => 'btn btn-danger',
            'data-attach-loading' => '',
            'data-request' => 'onDelete',
            'data-request-form' => '#list-form',
            'data-request-data' => "_method:'DELETE'",
            'data-request-confirm' => 'lang:admin::lang.alert_warning_confirm',
        ],
    ],
];

$config['list']['columns'] = [
    'edit' => [
        'type' => 'button',
        'iconCssClass' => 'fa fa-pencil',
        'attributes' => [
            'class' => 'btn btn-edit',
            'href' => 'staff_groups/edit/{staff_group_id}',
        ],
    ],
    'staff_group_name' => [
        'label' => 'lang:admin::lang.label_name',
        'type' => 'text',
        'searchable' => TRUE,
    ],
    'staff_count' => [
        'label' => 'lang:admin::lang.staff_groups.column_users',
        'type' => 'number',
        'searchable' => TRUE,
        'sortable' => FALSE,
    ],
    'staff_group_id' => [
        'label' => 'lang:admin::lang.column_id',
        'invisible' => TRUE,
    ],

];

$config['form']['toolbar'] = [
    'buttons' => [
        'back' => [
            'label' => 'lang:admin::lang.button_icon_back',
            'class' => 'btn btn-default',
            'href' => 'staff_groups',
        ],
        'save' => [
            'label' => 'lang:admin::lang.button_save',
            'class' => 'btn btn-primary',
            'data-request' => 'onSave',
            'data-progress-indicator' => 'admin::lang.text_saving',
        ],
        'saveClose' => [
            'label' => 'lang:admin::lang.button_save_close',
            'class' => 'btn btn-default',
            'data-request' => 'onSave',
            'data-request-data' => 'close:1',
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
    'staff_group_name' => [
        'label' => 'lang:admin::lang.label_name',
        'type' => 'text',
    ],
    'customer_account_access' => [
        'label' => 'lang:admin::lang.staff_groups.label_customer_account_access',
        'type' => 'switch',
        'comment' => 'lang:admin::lang.staff_groups.help_customer_account_access',
    ],
    'location_access' => [
        'label' => 'lang:admin::lang.staff_groups.label_location_access',
        'type' => 'switch',
        'comment' => 'lang:admin::lang.staff_groups.help_location',
    ],
    'permission' => [
        'label' => 'lang:admin::lang.staff_groups.text_tab_permission',
        'type' => 'section',
    ],
    'permissions' => [
        'type' => 'permissioneditor',
    ],
];

return $config;