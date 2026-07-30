<?php

$config['list']['toolbar'] = [
    'buttons' => [
        'create' => [
            'label' => 'lang:igniter::admin.button_new',
            'class' => 'btn btn-primary',
            'href' => 'user_roles/create',
        ],
    ],
];

$config['list']['bulkActions'] = [
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
            'href' => 'user_roles/edit/{user_role_id}',
        ],
    ],
    'name' => [
        'label' => 'lang:igniter::admin.label_name',
        'type' => 'text',
        'searchable' => true,
    ],
    'description' => [
        'label' => 'lang:igniter::admin.label_description',
        'type' => 'text',
        'searchable' => true,
    ],
    'staff_count' => [
        'label' => 'lang:igniter.user::default.user_groups.column_users',
        'type' => 'number',
        'searchable' => true,
        'sortable' => false,
    ],
    'user_role_id' => [
        'label' => 'lang:igniter::admin.column_id',
        'invisible' => true,
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

$config['form']['fields'] = [
    'name' => [
        'label' => 'lang:igniter::admin.label_name',
        'type' => 'text',
        'span' => 'left',
    ],
    'code' => [
        'label' => 'lang:igniter::admin.label_code',
        'type' => 'text',
        'span' => 'right',
    ],
    'description' => [
        'label' => 'lang:igniter::admin.label_description',
        'type' => 'textarea',
    ],
];

$config['form']['tabs'] = [
    'defaultTab' => 'lang:igniter.user::default.user_roles.text_tab_permission',
    'fields' => [
        'permissions' => [
            'type' => 'permissioneditor',
        ],
    ],
];

return $config;
