<?php
$config['list']['filter'] = [
    'search' => [
        'prompt' => 'lang:admin::lang.staff.text_filter_search',
        'mode' => 'all' // or any, exact
    ],
    'scopes' => [
        'group' => [
            'label' => 'lang:admin::lang.staff.text_filter_group',
            'type' => 'select',
            'conditions' => 'staff_group_id = :filtered',
            'modelClass' => 'Admin\Models\Staff_groups_model',
            'nameFrom' => 'staff_group_name',
        ],
        'location' => [
            'label' => 'lang:admin::lang.staff.text_filter_location',
            'type' => 'select',
            'conditions' => 'staff_location_id = :filtered',
            'modelClass' => 'Admin\Models\Locations_model',
            'nameFrom' => 'location_name',
        ],
        'date' => [
            'label' => 'lang:admin::lang.staff.text_filter_date',
            'type' => 'date',
            'conditions' => 'YEAR(date_added) = :year AND MONTH(date_added) = :month',
            'modelClass' => 'Admin\Models\Staffs_model',
            'options' => 'getStaffDates',
        ],
        'status' => [
            'label' => 'lang:admin::lang.staff.text_filter_status',
            'type' => 'switch',
        ],
    ],
];

$config['list']['toolbar'] = [
    'buttons' => [
        'create' => ['label' => 'lang:admin::lang.button_new', 'class' => 'btn btn-primary', 'href' => 'staffs/create'],
        'delete' => ['label' => 'lang:admin::lang.button_delete', 'class' => 'btn btn-danger', 'data-request-form' => '#list-form', 'data-request' => 'onDelete', 'data-request-data' => "_method:'DELETE'", 'data-request-confirm' => 'lang:admin::lang.alert_warning_confirm'],
        'filter' => ['label' => 'lang:admin::lang.button_icon_filter', 'class' => 'btn btn-default btn-filter', 'data-toggle' => 'list-filter', 'data-target' => '.list-filter'],
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
        'label' => 'lang:admin::lang.staff.column_name',
        'type' => 'text',
        'searchable' => TRUE,
    ],
    'staff_email' => [
        'label' => 'lang:admin::lang.staff.column_email',
        'type' => 'text',
        'searchable' => TRUE,
    ],
    'staff_group_name' => [
        'label' => 'lang:admin::lang.staff.column_group',
        'relation' => 'group',
        'select' => 'staff_group_name',
    ],
    'location_name' => [
        'label' => 'lang:admin::lang.staff.column_location',
        'relation' => 'location',
        'select' => 'location_name',
    ],
    'date_added' => [
        'label' => 'lang:admin::lang.staff.column_date_added',
        'type' => 'datesince',
    ],
    'staff_status' => [
        'label' => 'lang:admin::lang.staff.column_status',
        'type' => 'switch',
    ],
    'staff_id' => [
        'label' => 'lang:admin::lang.column_id',
        'invisible' => TRUE,
    ],

];

$config['form']['toolbar'] = [
    'buttons' => [
        'save' => ['label' => 'lang:admin::lang.button_save', 'class' => 'btn btn-primary', 'data-request-submit' => 'true', 'data-request' => 'onSave'],
        'saveClose' => [
            'label' => 'lang:admin::lang.button_save_close',
            'class' => 'btn btn-default',
            'data-request' => 'onSave',
            'data-request-submit' => 'true',
            'data-request-data' => 'close:1',
        ],
        'delete' => [
            'label' => 'lang:admin::lang.button_icon_delete', 'class' => 'btn btn-danger',
            'data-request-submit' => 'true', 'data-request' => 'onDelete', 'data-request-data' => "_method:'DELETE'",
            'data-request-confirm' => 'lang:admin::lang.alert_warning_confirm', 'context' => ['edit'],
        ],
    ],
];

$config['form']['fields'] = [
    'staff_name' => [
        'label' => 'lang:admin::lang.staff.label_name',
        'type' => 'text',
        'span' => 'left',
    ],
    'staff_email' => [
        'label' => 'lang:admin::lang.staff.label_email',
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
    'staff_group_id' => [
        'label' => 'lang:admin::lang.staff.label_group',
        'type' => 'relation',
        'relationFrom' => 'group',
        'nameFrom' => 'staff_group_name',
        'span' => 'left',
        'comment' => 'lang:admin::lang.staff.help_groups',
        'placeholder' => 'lang:admin::lang.text_please_select',
    ],
    'staff_location_id' => [
        'label' => 'lang:admin::lang.staff.label_location',
        'type' => 'relation',
        'relationFrom' => 'location',
        'nameFrom' => 'location_name',
        'span' => 'right',
        'placeholder' => 'lang:admin::lang.text_please_select',
    ],
    'user[super_user]' => [
        'label' => 'lang:admin::lang.staff.label_super_staff',
        'type' => 'switch',
        'comment' => 'lang:admin::lang.staff.help_super_staff',
    ],
    'staff_status' => [
        'label' => 'lang:admin::lang.label_status',
        'type' => 'switch',
        'default' => 1,
    ],
];

return $config;