<?php
$config['list']['filter'] = [
    'search' => [
        'prompt' => 'lang:admin::lang.staff.text_filter_search',
        'mode' => 'all' // or any, exact
    ],
    'scopes' => [
        'role' => [
            'label' => 'lang:admin::lang.staff.text_filter_role',
            'type' => 'select',
            'conditions' => 'staff_role_id = :filtered',
            'modelClass' => 'Admin\Models\Staff_roles_model',
        ],
        'status' => [
            'label' => 'lang:admin::lang.text_filter_status',
            'type' => 'switch',
        ],
        'date' => [
            'label' => 'lang:admin::lang.text_filter_date',
            'type' => 'date',
            'conditions' => 'YEAR(date_added) = :year AND MONTH(date_added) = :month AND DAY(date_added) = :day',
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
        'delete' => [
            'label' => 'lang:admin::lang.button_delete',
            'class' => 'btn btn-danger',
            'data-attach-loading' => '',
            'data-request' => 'onDelete',
            'data-request-form' => '#list-form',
            'data-request-data' => "_method:'DELETE'",
            'data-request-confirm' => 'lang:admin::lang.alert_warning_confirm',
        ],
        'groups' => [
            'label' => 'lang:admin::lang.side_menu.staff_group',
            'class' => 'btn btn-default',
            'href' => 'staff_groups',
        ],
        'roles' => [
            'label' => 'lang:admin::lang.side_menu.staff_role',
            'class' => 'btn btn-default',
            'href' => 'staff_roles',
        ],
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
    'staff_name' => [
        'label' => 'lang:admin::lang.label_name',
        'type' => 'text',
        'searchable' => TRUE,
    ],
    'staff_email' => [
        'label' => 'lang:admin::lang.label_email',
        'type' => 'text',
        'searchable' => TRUE,
        'invisible' => TRUE,
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
        'searchable' => TRUE,
    ],
    'last_login' => [
        'label' => 'lang:admin::lang.staff.column_last_login',
        'type' => 'timetense',
        'relation' => 'user',
        'select' => 'last_login',
    ],
    'date_added' => [
        'label' => 'lang:admin::lang.column_date_added',
        'type' => 'datesince',
    ],
    'staff_status' => [
        'label' => 'lang:admin::lang.label_status',
        'type' => 'switch',
        'invisible' => TRUE,
    ],
    'staff_id' => [
        'label' => 'lang:admin::lang.column_id',
        'invisible' => TRUE,
    ],
];

$config['form']['toolbar'] = [
    'buttons' => [
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
    'user[password]' => [
        'label' => 'lang:admin::lang.staff.label_password',
        'type' => 'password',
        'span' => 'left',
    ],
    'user[password_confirm]' => [
        'label' => 'lang:admin::lang.staff.label_confirm_password',
        'type' => 'password',
        'span' => 'right',
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
    'sale_permission' => [
        'label' => 'lang:admin::lang.staff.label_sale_permission',
        'type' => 'radiolist',
        'context' => ['create', 'edit'],
        'span' => 'left',
        'default' => 1,
        'options' => [
            1 => ['lang:admin::lang.staff.text_sale_permission_global_access', 'lang:admin::lang.staff.help_sale_permission_global_access'],
            2 => ['lang:admin::lang.staff.text_sale_permission_groups', 'lang:admin::lang.staff.help_sale_permission_groups'],
            3 => ['lang:admin::lang.staff.text_sale_permission_restricted', 'lang:admin::lang.staff.help_sale_permission_restricted'],
        ],
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
    'staff_role_id' => [
        'label' => 'lang:admin::lang.staff.label_role',
        'type' => 'radiolist',
        'context' => ['create', 'edit'],
        'options' => ['Admin\Models\Staff_roles_model', 'listDropdownOptions'],
        'commentAbove' => 'lang:admin::lang.staff.help_role',
    ],
];

return $config;