<?php
$config['list']['filter'] = [
    'search' => [
        'prompt' => 'lang:admin::staffs.text_filter_search',
        'mode'   => 'all' // or any, exact
    ],
    'scopes' => [
        'group'    => [
            'label'      => 'lang:admin::staffs.text_filter_group',
            'type'       => 'select',
            'conditions' => 'staff_group_id = :filtered',
            'modelClass' => 'Admin\Models\Staff_groups_model',
            'nameFrom'   => 'staff_group_name',
        ],
        'location' => [
            'label'      => 'lang:admin::staffs.text_filter_location',
            'type'       => 'select',
            'conditions' => 'staff_location_id = :filtered',
            'modelClass' => 'Admin\Models\Locations_model',
            'nameFrom'   => 'location_name',
        ],
        'date'     => [
            'label'      => 'lang:admin::staffs.text_filter_date',
            'type'       => 'date',
            'conditions' => 'YEAR(date_added) = :year AND MONTH(date_added) = :month',
            'modelClass' => 'Admin\Models\Staffs_model',
            'options'    => 'getStaffDates',
        ],
        'status'   => [
            'label' => 'lang:admin::staffs.text_filter_status',
            'type'  => 'switch',
        ],
    ],
];

$config['list']['toolbar'] = [
    'buttons' => [
        'create' => ['label' => 'lang:admin::default.button_new', 'class' => 'btn btn-primary', 'href' => 'staffs/create'],
        'delete' => ['label' => 'lang:admin::default.button_delete', 'class' => 'btn btn-danger', 'data-request-form' => '#list-form', 'data-request' => 'onDelete', 'data-request-data' => "_method:'DELETE'", 'data-request-confirm' => 'lang:admin::default.alert_warning_confirm'],
        'filter' => ['label' => 'lang:admin::default.button_icon_filter', 'class' => 'btn btn-default btn-filter', 'data-toggle' => 'list-filter', 'data-target' => '.panel-filter .panel-body'],
    ],
];

$config['list']['columns'] = [
    'edit'             => [
        'type'         => 'button',
        'iconCssClass' => 'fa fa-pencil',
        'attributes'   => [
            'class' => 'btn btn-edit',
            'href'  => 'staffs/edit/{staff_id}',
        ],
    ],
    'staff_name'       => [
        'label'      => 'lang:admin::staffs.column_name',
        'type'       => 'text',
        'searchable' => TRUE,
    ],
    'staff_email'      => [
        'label'      => 'lang:admin::staffs.column_email',
        'type'       => 'text',
        'searchable' => TRUE,
    ],
    'staff_group_name' => [
        'label'    => 'lang:admin::staffs.column_group',
        'relation' => 'group',
        'select'   => 'staff_group_name',
    ],
    'location_name'    => [
        'label'    => 'lang:admin::staffs.column_location',
        'relation' => 'location',
        'select'   => 'location_name',
    ],
    'date_added'       => [
        'label' => 'lang:admin::staffs.column_date_added',
        'type'  => 'datesince',
    ],
    'staff_status'     => [
        'label' => 'lang:admin::staffs.column_status',
        'type'  => 'switch',
    ],
    'staff_id'         => [
        'label'     => 'lang:admin::staffs.column_id',
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
        'back'      => ['label' => 'lang:admin::default.button_icon_back', 'class' => 'btn btn-default', 'href' => 'staffs'],
    ],
];

$config['form']['fields'] = [
    'staff_name'             => [
        'label' => 'lang:admin::staffs.label_name',
        'type'  => 'text',
        'span'  => 'left',
    ],
    'staff_email'            => [
        'label' => 'lang:admin::staffs.label_email',
        'type'  => 'text',
        'span'  => 'right',
    ],
    'user[username]'         => [
        'label' => 'lang:admin::staffs.label_username',
        'type'  => 'text',
        'span'  => 'left',
    ],
    'language_id'      => [
        'label'        => 'lang:admin::staffs.label_language',
        'type'         => 'relation',
        'relationFrom' => 'language',
        'nameFrom'     => 'name',
        'span'         => 'right',
        'placeholder'  => 'lang:admin::default.text_please_select',
    ],
    'user[password]'         => [
        'label' => 'lang:admin::staffs.label_password',
        'type'  => 'password',
        'span'  => 'left',
    ],
    'user[password_confirm]' => [
        'label' => 'lang:admin::staffs.label_confirm_password',
        'type'  => 'password',
        'span'  => 'right',
    ],
    'staff_group_id'         => [
        'label'        => 'lang:admin::staffs.label_group',
        'type'         => 'relation',
        'relationFrom' => 'group',
        'nameFrom'     => 'staff_group_name',
        'span'         => 'left',
        'comment'      => 'lang:admin::staffs.help_groups',
        'placeholder'  => 'lang:admin::default.text_please_select',
    ],
    'staff_location_id'      => [
        'label'        => 'lang:admin::staffs.label_location',
        'type'         => 'relation',
        'relationFrom' => 'location',
        'nameFrom'     => 'location_name',
        'span'         => 'right',
        'placeholder'  => 'lang:admin::default.text_please_select',
    ],
    'user[super_user]'       => [
        'label'   => 'lang:admin::staffs.label_super_staff',
        'type'    => 'switch',
        'comment' => 'lang:admin::staffs.help_super_staff',
    ],
    'staff_status'           => [
        'label'   => 'lang:admin::default.label_status',
        'type'    => 'switch',
        'default' => 1,
    ],
];

return $config;