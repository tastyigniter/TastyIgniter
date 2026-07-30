<?php

$config['list']['toolbar'] = [
    'buttons' => [
        'create' => [
            'label' => 'lang:igniter::admin.button_new',
            'class' => 'btn btn-primary',
            'href' => 'mail_layouts/create',
        ],
        'templates' => [
            'label' => 'lang:igniter::system.mail_templates.text_templates',
            'class' => 'btn btn-default',
            'href' => 'mail_templates',
        ],
        'partials' => [
            'label' => 'lang:igniter::system.mail_templates.text_partials',
            'class' => 'btn btn-default',
            'href' => 'mail_partials',
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
            'href' => 'mail_layouts/edit/{layout_id}',
        ],
    ],
    'code' => [
        'label' => 'lang:igniter::system.mail_templates.column_code',
        'type' => 'text',
        'searchable' => true,
    ],
    'name' => [
        'label' => 'lang:igniter::admin.label_name',
        'type' => 'text',
        'searchable' => true,
    ],
    'updated_at' => [
        'label' => 'lang:igniter::admin.column_date_updated',
        'type' => 'timetense',
    ],
    'created_at' => [
        'label' => 'lang:igniter::admin.column_date_added',
        'type' => 'timetense',
    ],
    'layout_id' => [
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
            'context' => 'edit',
        ],
    ],
];

$config['form']['fields'] = [
    'name' => [
        'label' => 'lang:igniter::admin.label_name',
        'span' => 'left',
        'type' => 'text',
        'cssClass' => 'flex-width',
    ],
    'code' => [
        'label' => 'lang:igniter::system.mail_templates.label_code',
        'span' => 'left',
        'cssClass' => 'flex-width',
        'type' => 'text',
    ],
    'language_id' => [
        'label' => 'lang:igniter::system.mail_templates.label_language',
        'type' => 'relation',
        'span' => 'right',
        'relationFrom' => 'language',
        'placeholder' => 'lang:admin::lang.text_please_select',
    ],
];

$config['form']['tabs'] = [
    'fields' => [
        'layout' => [
            'tab' => 'lang:igniter::system.mail_templates.label_body',
            'type' => 'codeeditor',
            'mode' => 'application/x-httpd-php',
        ],
        'plain_layout' => [
            'tab' => 'lang:igniter::system.mail_templates.label_plain',
            'type' => 'codeeditor',
            'mode' => 'application/x-httpd-php',
        ],
        'layout_css' => [
            'tab' => 'lang:igniter::system.mail_templates.label_layout_css',
            'type' => 'codeeditor',
            'mode' => 'application/x-httpd-php',
        ],
    ],
];

return $config;
