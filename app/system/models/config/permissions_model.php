<?php
$config['list']['filter'] = [
    'search' => [
        'prompt' => 'lang:system::lang.permissions.text_filter_search',
        'mode' => 'all',
    ],
    'scopes' => [
        'status' => [
            'label' => 'lang:system::lang.permissions.text_filter_status',
            'type' => 'switch',
            'conditions' => 'status = :filtered',
        ],
    ],
];

$config['list']['toolbar'] = [
    'buttons' => [
        'create' => ['label' => 'lang:admin::lang.button_new', 'class' => 'btn btn-primary', 'href' => 'permissions/create'],
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
            'href' => 'permissions/edit/{permission_id}',
        ],
    ],
    'name' => [
        'label' => 'lang:system::lang.permissions.column_name',
        'type' => 'text',
        'searchable' => TRUE,
    ],
    'action_text' => [
        'label' => 'lang:system::lang.permissions.column_actions',
        'sortable' => FALSE,
    ],
    'description' => [
        'label' => 'lang:system::lang.permissions.column_description',
        'type' => 'text',
        'searchable' => TRUE,
    ],
    'status' => [
        'label' => 'lang:system::lang.permissions.column_status',
        'type' => 'switch',
    ],
    'permission_id' => [
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
            'data-request-confirm' => 'lang:admin::lang.alert_warning_confirm', 'context' => 'edit',
        ],
    ],
];

$config['form']['fields'] = [
    'name' => [
        'label' => 'lang:system::lang.permissions.label_name',
        'type' => 'text',
        'comment' => 'lang:system::lang.permissions.help_name',
    ],
    'action' => [
        'label' => 'lang:system::lang.permissions.label_action',
        'type' => 'checkbox',
        'comment' => 'lang:system::lang.permissions.help_action',
    ],
    'description' => [
        'label' => 'lang:system::lang.permissions.label_description',
        'type' => 'textarea',
    ],
    'status' => [
        'label' => 'lang:admin::lang.label_status',
        'type' => 'switch',
    ],
];

return $config;