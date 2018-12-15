<?php
$config['list']['toolbar'] = [
    'buttons' => [
        'create' => ['label' => 'lang:admin::lang.button_new', 'class' => 'btn btn-primary', 'href' => 'mail_layouts/create'],
        'delete' => [
            'label' => 'lang:admin::lang.button_delete', 'class' => 'btn btn-danger', 'data-request-form' => '#list-form',
            'data-request' => 'onDelete', 'data-request-data' => "_method:'DELETE'",
            'data-request-confirm' => 'lang:admin::lang.alert_warning_confirm',
        ],
        'templates' => [
            'label' => 'lang:system::lang.mail_templates.text_templates',
            'class' => 'btn btn-default',
            'href' => 'mail_templates',
        ],
    ],
];

$config['list']['columns'] = [
    'edit' => [
        'type' => 'button',
        'iconCssClass' => 'fa fa-pencil',
        'attributes' => [
            'class' => 'btn btn-edit',
            'href' => 'mail_layouts/edit/{template_id}',
        ],
    ],
    'code' => [
        'label' => 'lang:system::lang.mail_templates.column_code',
        'type' => 'text',
        'searchable' => TRUE,
    ],
    'name' => [
        'label' => 'lang:system::lang.mail_templates.column_name',
        'type' => 'text',
        'searchable' => TRUE,
    ],
    'status' => [
        'label' => 'lang:system::lang.mail_templates.column_status',
        'type' => 'switch',
    ],
    'date_updated' => [
        'label' => 'lang:system::lang.mail_templates.column_date_updated',
        'type' => 'datesince',
        'searchable' => TRUE,
    ],
    'date_added' => [
        'label' => 'lang:system::lang.mail_templates.column_date_added',
        'type' => 'datesince',
        'searchable' => TRUE,
    ],
    'template_id' => [
        'label' => 'lang:admin::lang.column_id',
        'invisible' => TRUE,
    ],

];

$config['form']['toolbar'] = [
    'buttons' => [
        'save' => [
            'label' => 'lang:admin::lang.button_save', 'class' => 'btn btn-primary', 'data-request-submit' => 'true', 'data-request' => 'onSave',
        ],
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
        'templates' => [
            'label' => 'lang:system::lang.mail_templates.text_templates',
            'class' => 'btn btn-default',
            'href' => 'mail_templates',
        ],
    ],
];

$config['form']['fields'] = [
    'name' => [
        'label' => 'lang:system::lang.mail_templates.label_name',
        'span' => 'left',
        'type' => 'text',
    ],
    'code' => [
        'label' => 'lang:system::lang.mail_templates.label_code',
        'span' => 'right',
        'type' => 'text',
    ],
    'language_id' => [
        'label' => 'lang:system::lang.mail_templates.label_language',
        'span' => 'left',
        'type' => 'relation',
        'relationFrom' => 'language',
        'placeholder' => 'lang:admin::lang.text_please_select',
    ],
    'status' => [
        'label' => 'lang:admin::lang.label_status',
        'type' => 'switch',
        'span' => 'right',
        'default' => TRUE,
    ],
];

$config['form']['tabs'] = [
    'fields' => [
        'layout' => [
            'tab' => 'lang:system::lang.mail_templates.label_body',
            'type' => 'codeeditor',
        ],
        'layout_css' => [
            'tab' => 'lang:system::lang.mail_templates.label_layout_css',
            'type' => 'codeeditor',
        ],
        'plain_layout' => [
            'tab' => 'lang:system::lang.mail_templates.label_plain_layout',
            'type' => 'textarea',
            'attributes' => [
                'rows' => 10,
            ],
        ],
    ],
];

return $config;