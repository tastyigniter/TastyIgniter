<?php
$config['list']['toolbar'] = [
    'buttons' => [
        'back' => [
            'label' => 'lang:admin::lang.button_icon_back',
            'class' => 'btn btn-outline-secondary',
            'href' => 'staffs',
        ],
        'create' => [
            'label' => 'lang:admin::lang.button_new',
            'class' => 'btn btn-primary',
            'href' => 'staff_groups/create',
        ],
    ],
];

$config['list']['bulkActions'] = [
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
            'href' => 'staff_groups/edit/{staff_group_id}',
        ],
    ],
    'staff_group_name' => [
        'label' => 'lang:admin::lang.label_name',
        'type' => 'text',
        'searchable' => true,
    ],
    'description' => [
        'label' => 'lang:admin::lang.label_description',
        'type' => 'text',
        'searchable' => true,
    ],
    'staff_count' => [
        'label' => 'lang:admin::lang.staff_groups.column_users',
        'type' => 'text',
        'sortable' => false,
    ],
    'staff_group_id' => [
        'label' => 'lang:admin::lang.column_id',
        'invisible' => true,
    ],
    'created_at' => [
        'label' => 'lang:admin::lang.column_date_added',
        'invisible' => true,
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
            'href' => 'staff_groups',
        ],
        'save' => [
            'label' => 'lang:admin::lang.button_save',
            'context' => ['create', 'edit'],
            'partial' => 'form/toolbar_save_button',
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
    ],
];

$config['form']['fields'] = [
    'staff_group_name' => [
        'label' => 'lang:admin::lang.label_name',
        'type' => 'text',
    ],
    'description' => [
        'label' => 'lang:admin::lang.label_description',
        'type' => 'textarea',
    ],
    'auto_assign' => [
        'label' => 'lang:admin::lang.staff_groups.label_auto_assign',
        'type' => 'switch',
        'comment' => 'lang:admin::lang.staff_groups.help_auto_assign',
    ],
    'auto_assign_mode' => [
        'label' => 'lang:admin::lang.staff_groups.label_assignment_mode',
        'type' => 'radiolist',
        'span' => 'left',
        'default' => 1,
        'options' => [
            1 => ['admin::lang.staff_groups.text_round_robin', 'admin::lang.staff_groups.help_round_robin'],
            2 => ['admin::lang.staff_groups.text_load_balanced', 'admin::lang.staff_groups.help_load_balanced'],
        ],
        'trigger' => [
            'action' => 'show',
            'field' => 'auto_assign',
            'condition' => 'checked',
        ],
    ],
    'auto_assign_limit' => [
        'label' => 'lang:admin::lang.staff_groups.label_load_balanced_limit',
        'type' => 'number',
        'default' => 20,
        'comment' => 'lang:admin::lang.staff_groups.help_load_balanced_limit',
        'trigger' => [
            'action' => 'show',
            'field' => 'auto_assign',
            'condition' => 'checked',
        ],
    ],
    'auto_assign_availability' => [
        'label' => 'lang:admin::lang.staff_groups.label_assignment_availability',
        'type' => 'switch',
        'default' => true,
        'comment' => 'lang:admin::lang.staff_groups.help_assignment_availability',
        'trigger' => [
            'action' => 'show',
            'field' => 'auto_assign',
            'condition' => 'checked',
        ],
    ],
];

return $config;
