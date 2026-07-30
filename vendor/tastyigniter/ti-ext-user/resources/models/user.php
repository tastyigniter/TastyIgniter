<?php

use Igniter\User\Models\UserRole;

$config['list']['filter'] = [
    'search' => [
        'prompt' => 'lang:igniter.user::default.staff.text_filter_search',
        'mode' => 'all', // or any, exact
    ],
    'scopes' => [
        'role' => [
            'label' => 'lang:igniter.user::default.staff.text_filter_role',
            'type' => 'select',
            'conditions' => 'user_role_id in (:filtered)',
            'modelClass' => UserRole::class,
        ],
        'status' => [
            'label' => 'lang:igniter::admin.text_filter_status',
            'type' => 'switch',
        ],
        'date' => [
            'label' => 'lang:igniter::admin.text_filter_date',
            'type' => 'date',
            'conditions' => 'YEAR(created_at) = :year AND MONTH(created_at) = :month AND DAY(created_at) = :day',
        ],
    ],
];

$config['list']['toolbar'] = [
    'buttons' => [
        'create' => [
            'label' => 'lang:igniter::admin.button_new',
            'class' => 'btn btn-primary',
            'href' => 'users/create',
        ],
        'groups' => [
            'label' => 'lang:igniter.user::default.text_side_menu_user_group',
            'class' => 'btn btn-default',
            'href' => 'user_groups',
            'permission' => 'Admin.StaffGroups',
        ],
        'roles' => [
            'label' => 'lang:igniter.user::default.text_side_menu_user_role',
            'class' => 'btn btn-default',
            'href' => 'user_roles',
        ],
    ],
];

$config['list']['bulkActions'] = [
    'status' => [
        'label' => 'lang:igniter::admin.list.actions.label_status',
        'type' => 'dropdown',
        'class' => 'btn btn-light',
        'statusColumn' => 'status',
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
            'href' => 'users/edit/{user_id}',
        ],
    ],
    'impersonate' => [
        'type' => 'button',
        'iconCssClass' => 'fa fa-user-secret',
        'permissions' => 'Admin.Impersonate',
        'attributes' => [
            'class' => 'btn btn-edit',
            'data-request' => 'onImpersonate',
            'data-request-data' => 'recordId: \'{user_id}\'',
            'data-request-confirm' => 'igniter.user::default.customers.alert_impersonate_confirm',
        ],
    ],
    'name' => [
        'label' => 'lang:igniter.user::default.staff.label_full_name',
        'type' => 'text',
        'searchable' => true,
    ],
    'email' => [
        'label' => 'lang:igniter::admin.label_email',
        'type' => 'text',
        'searchable' => true,
    ],
    'user_group_name' => [
        'label' => 'lang:igniter.user::default.staff.column_group',
        'relation' => 'groups',
        'select' => 'user_group_name',
    ],
    'staff_role_name' => [
        'label' => 'lang:igniter.user::default.staff.column_role',
        'relation' => 'role',
        'select' => 'name',
    ],
    'location_name' => [
        'label' => 'lang:igniter.user::default.staff.column_location',
        'relation' => 'locations',
        'select' => 'location_name',
        'searchable' => true,
        'locationAware' => true,
    ],
    'last_login' => [
        'label' => 'lang:igniter.user::default.staff.column_last_login',
        'type' => 'timetense',
    ],
    'status' => [
        'label' => 'lang:igniter::admin.label_status',
        'type' => 'switch',
        'invisible' => true,
    ],
    'user_id' => [
        'label' => 'lang:igniter::admin.column_id',
        'invisible' => true,
    ],
    'created_at' => [
        'label' => 'lang:igniter::admin.column_date_added',
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
        'save_account' => [
            'label' => 'lang:igniter::admin.button_save',
            'context' => ['account'],
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
        'impersonate' => [
            'label' => 'lang:igniter.user::default.staff.text_impersonate',
            'class' => 'btn btn-default',
            'data-request' => 'onImpersonate',
            'data-request-confirm' => 'igniter.user::default.customers.alert_impersonate_confirm',
            'context' => ['edit'],
            'permission' => 'Admin.Impersonate',
        ],
    ],
];

$config['form']['fields'] = [
    'name' => [
        'label' => 'lang:igniter.user::default.staff.label_full_name',
        'type' => 'text',
        'span' => 'left',
    ],
    'email' => [
        'label' => 'lang:igniter::admin.label_email',
        'type' => 'text',
        'span' => 'right',
        'cssClass' => 'flex-width',
    ],
    'telephone' => [
        'label' => 'lang:igniter.user::default.staff.label_telephone',
        'type' => 'text',
        'span' => 'right',
        'cssClass' => 'flex-width',
    ],
    'username' => [
        'label' => 'lang:igniter.user::default.staff.label_username',
        'type' => 'text',
        'span' => 'left',
    ],
    'language_id' => [
        'label' => 'lang:igniter.user::default.staff.label_language',
        'type' => 'relation',
        'relationFrom' => 'language',
        'nameFrom' => 'name',
        'span' => 'right',
        'placeholder' => 'lang:igniter::admin.text_please_select',
    ],
    'send_invite' => [
        'label' => 'lang:igniter.user::default.staff.label_send_invite',
        'type' => 'checkbox',
        'default' => true,
        'context' => 'create',
        'options' => [],
        'placeholder' => 'lang:igniter.user::default.staff.help_send_invite',
    ],
    'password' => [
        'label' => 'lang:igniter.user::default.staff.label_password',
        'type' => 'password',
        'span' => 'left',
        'trigger' => [
            'action' => 'show',
            'field' => 'send_invite',
            'condition' => 'unchecked',
        ],
    ],
    'password_confirm' => [
        'label' => 'lang:igniter.user::default.staff.label_confirm_password',
        'type' => 'password',
        'span' => 'right',
        'trigger' => [
            'action' => 'show',
            'field' => 'send_invite',
            'condition' => 'unchecked',
        ],
    ],
    'locations' => [
        'label' => 'lang:igniter.user::default.staff.label_location',
        'type' => 'relation',
        'context' => ['create', 'edit'],
        'span' => 'left',
        'nameFrom' => 'location_name',
        'comment' => 'lang:igniter.user::default.staff.help_location',
    ],
    'groups' => [
        'label' => 'lang:igniter.user::default.staff.label_group',
        'type' => 'relation',
        'context' => ['create', 'edit'],
        'span' => 'right',
        'relationFrom' => 'groups',
        'nameFrom' => 'user_group_name',
        'comment' => 'lang:igniter.user::default.staff.help_groups',
    ],
    'user_role_id' => [
        'label' => 'lang:igniter.user::default.staff.label_role',
        'type' => 'radiolist',
        'span' => 'left',
        'context' => ['create', 'edit'],
        'options' => [UserRole::class, 'listDropdownOptions'],
        'commentAbove' => 'lang:igniter.user::default.staff.help_role',
    ],
    'super_user' => [
        'label' => 'lang:igniter.user::default.staff.label_super_staff',
        'type' => 'switch',
        'context' => ['create', 'edit'],
        'span' => 'right',
        'cssClass' => 'flex-width',
        'comment' => 'lang:igniter.user::default.staff.help_super_staff',
    ],
    'status' => [
        'label' => 'lang:igniter::admin.label_status',
        'type' => 'switch',
        'context' => ['create', 'edit'],
        'span' => 'right',
        'cssClass' => 'flex-width',
        'default' => 1,
    ],
    'sale_permission' => [
        'label' => 'lang:igniter.user::default.staff.label_sale_permission',
        'type' => 'radiolist',
        'context' => ['create', 'edit'],
        'default' => 1,
        'options' => [
            1 => ['lang:igniter.user::default.staff.text_sale_permission_global_access', 'lang:igniter.user::default.staff.help_sale_permission_global_access'],
            2 => ['lang:igniter.user::default.staff.text_sale_permission_groups', 'lang:igniter.user::default.staff.help_sale_permission_groups'],
            3 => ['lang:igniter.user::default.staff.text_sale_permission_restricted', 'lang:igniter.user::default.staff.help_sale_permission_restricted'],
        ],
    ],
];

return $config;
