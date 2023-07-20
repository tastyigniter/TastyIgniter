<?php

$config['list']['filter'] = [
    'search' => [
        'prompt' => 'lang:admin::lang.staff.text_filter_search',
        'mode' => 'all', // or any, exact
    ],
    'scopes' => [
        'location' => [
            'label' => 'lang:admin::lang.text_filter_location',
            'type' => 'selectlist',
            'scope' => 'whereHasLocation',
            'modelClass' => 'Admin\Models\Locations_model',
            'nameFrom' => 'location_name',
            'locationAware' => true,
        ],
        'role' => [
            'label' => 'lang:admin::lang.staff.text_filter_role',
            'type' => 'selectlist',
            'conditions' => 'staff_role_id in (:filtered)',
            'modelClass' => 'Admin\Models\Staff_roles_model',
        ],
        'status' => [
            'label' => 'lang:admin::lang.text_filter_status',
            'type' => 'switch',
        ],
        'date' => [
            'label' => 'lang:admin::lang.text_filter_date',
            'type' => 'date',
            'conditions' => 'YEAR(created_at) = :year AND MONTH(created_at) = :month AND DAY(created_at) = :day',
        ],
    ],
];

$config['list']['toolbar'] = [
    'buttons' => [
        'create' => [
            'label' => 'lang:admin::lang.button_new',
            'class' => 'btn btn-primary',
            'href' => 'staffs/create',
        ],
        'groups' => [
            'label' => 'lang:admin::lang.side_menu.staff_group',
            'class' => 'btn btn-default',
            'href' => 'staff_groups',
            'permission' => 'Admin.StaffGroups',
        ],
        'roles' => [
            'label' => 'lang:admin::lang.side_menu.staff_role',
            'class' => 'btn btn-default',
            'href' => 'staff_roles',
        ],
    ],
];

$config['list']['bulkActions'] = [
    'status' => [
        'label' => 'lang:admin::lang.list.actions.label_status',
        'type' => 'dropdown',
        'class' => 'btn btn-light',
        'statusColumn' => 'staff_status',
        'menuItems' => [
            'enable' => [
                'label' => 'lang:admin::lang.list.actions.label_enable',
                'type' => 'button',
                'class' => 'dropdown-item',
            ],
            'disable' => [
                'label' => 'lang:admin::lang.list.actions.label_disable',
                'type' => 'button',
                'class' => 'dropdown-item text-danger',
            ],
        ],
    ],
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
            'href' => 'staffs/edit/{staff_id}',
        ],
    ],
    'impersonate' => [
        'type' => 'button',
        'iconCssClass' => 'fa fa-user',
        'permissions' => 'Admin.Impersonate',
        'attributes' => [
            'class' => 'btn btn-outline-secondary',
            'data-request' => 'onImpersonate',
            'data-request-data' => 'recordId: \'{staff_id}\'',
            'data-request-confirm' => 'admin::lang.customers.alert_impersonate_confirm',
        ],
    ],
    'staff_name' => [
        'label' => 'lang:admin::lang.label_name',
        'type' => 'text',
        'searchable' => true,
    ],
    'staff_email' => [
        'label' => 'lang:admin::lang.label_email',
        'type' => 'text',
        'searchable' => true,
        'invisible' => true,
    ],
    'staff_group_name' => [
        'label' => 'lang:admin::lang.staff.column_group',
        'relation' => 'groups',
        'select' => 'staff_group_name',
    ],
    'staff_role_name' => [
        'label' => 'lang:admin::lang.staff.column_role',
        'relation' => 'role',
        'select' => 'name',
    ],
    'location_name' => [
        'label' => 'lang:admin::lang.staff.column_location',
        'relation' => 'locations',
        'select' => 'location_name',
        'searchable' => true,
        'locationAware' => true,
    ],
    'last_login' => [
        'label' => 'lang:admin::lang.staff.column_last_login',
        'type' => 'timetense',
        'relation' => 'user',
        'select' => 'last_login',
    ],
    'staff_status' => [
        'label' => 'lang:admin::lang.label_status',
        'type' => 'switch',
        'invisible' => true,
    ],
    'staff_id' => [
        'label' => 'lang:admin::lang.column_id',
        'invisible' => true,
    ],
    'created_at' => [
        'label' => 'lang:admin::lang.column_date_added',
        'type' => 'datetime',
    ],
    'updated_at' => [
        'label' => 'lang:admin::lang.column_date_updated',
        'invisible' => true,
        'type' => 'datetime',
    ],
];

$config['form']['toolbar'] = [
    'buttons' => [
        'back' => [
            'label' => 'lang:admin::lang.button_icon_back',
            'class' => 'btn btn-outline-secondary',
            'href' => 'staffs',
        ],
        'save' => [
            'label' => 'lang:admin::lang.button_save',
            'context' => ['create', 'edit'],
            'partial' => 'form/toolbar_save_button',
            'class' => 'btn btn-primary',
            'data-request' => 'onSave',
            'data-progress-indicator' => 'admin::lang.text_saving',
        ],
        'save_account' => [
            'label' => 'lang:admin::lang.button_save',
            'context' => ['account'],
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
        'impersonate' => [
            'label' => 'lang:admin::lang.staff.text_impersonate',
            'class' => 'btn btn-default',
            'data-request' => 'onImpersonate',
            'data-request-confirm' => 'admin::lang.customers.alert_impersonate_confirm',
            'context' => ['edit'],
            'permission' => 'Admin.Impersonate',
        ],
    ],
];

$config['form']['fields'] = [
    'staff_name' => [
        'label' => 'lang:admin::lang.label_name',
        'type' => 'text',
        'span' => 'left',
    ],
    'staff_email' => [
        'label' => 'lang:admin::lang.label_email',
        'type' => 'text',
        'span' => 'right',
    ],
    'user[username]' => [
        'label' => 'lang:admin::lang.staff.label_username',
        'type' => 'text',
        'span' => 'left',
    ],
    'language_id' => [
        'label' => 'lang:admin::lang.staff.label_language',
        'type' => 'relation',
        'relationFrom' => 'language',
        'nameFrom' => 'name',
        'span' => 'right',
        'placeholder' => 'lang:admin::lang.text_please_select',
    ],
    'user[send_invite]' => [
        'label' => 'lang:admin::lang.staff.label_send_invite',
        'type' => 'checkbox',
        'default' => true,
        'context' => 'create',
        'options' => [],
        'placeholder' => 'lang:admin::lang.staff.help_send_invite',
    ],
    'user[password]' => [
        'label' => 'lang:admin::lang.staff.label_password',
        'type' => 'password',
        'span' => 'left',
        'trigger' => [
            'action' => 'show',
            'field' => 'user[send_invite]',
            'condition' => 'unchecked',
        ],
    ],
    'user[password_confirm]' => [
        'label' => 'lang:admin::lang.staff.label_confirm_password',
        'type' => 'password',
        'span' => 'right',
        'trigger' => [
            'action' => 'show',
            'field' => 'user[send_invite]',
            'condition' => 'unchecked',
        ],
    ],
    'locations' => [
        'label' => 'lang:admin::lang.staff.label_location',
        'type' => 'relation',
        'context' => ['create', 'edit'],
        'span' => 'left',
        'nameFrom' => 'location_name',
        'comment' => 'lang:admin::lang.staff.help_location',
    ],
    'groups' => [
        'label' => 'lang:admin::lang.staff.label_group',
        'type' => 'relation',
        'context' => ['create', 'edit'],
        'span' => 'right',
        'relationFrom' => 'groups',
        'nameFrom' => 'staff_group_name',
        'comment' => 'lang:admin::lang.staff.help_groups',
    ],
    'staff_role_id' => [
        'label' => 'lang:admin::lang.staff.label_role',
        'type' => 'radiolist',
        'span' => 'left',
        'context' => ['create', 'edit'],
        'options' => ['Admin\Models\Staff_roles_model', 'listDropdownOptions'],
        'commentAbove' => 'lang:admin::lang.staff.help_role',
    ],
    'user[super_user]' => [
        'label' => 'lang:admin::lang.staff.label_super_staff',
        'type' => 'switch',
        'context' => ['create', 'edit'],
        'span' => 'right',
        'cssClass' => 'flex-width',
        'comment' => 'lang:admin::lang.staff.help_super_staff',
    ],
    'staff_status' => [
        'label' => 'lang:admin::lang.label_status',
        'type' => 'switch',
        'context' => ['create', 'edit'],
        'span' => 'right',
        'cssClass' => 'flex-width',
        'default' => 1,
    ],
    'sale_permission' => [
        'label' => 'lang:admin::lang.staff.label_sale_permission',
        'type' => 'radiolist',
        'context' => ['create', 'edit'],
        'default' => 1,
        'options' => [
            1 => ['lang:admin::lang.staff.text_sale_permission_global_access', 'lang:admin::lang.staff.help_sale_permission_global_access'],
            2 => ['lang:admin::lang.staff.text_sale_permission_groups', 'lang:admin::lang.staff.help_sale_permission_groups'],
            3 => ['lang:admin::lang.staff.text_sale_permission_restricted', 'lang:admin::lang.staff.help_sale_permission_restricted'],
        ],
    ],
];

return $config;
