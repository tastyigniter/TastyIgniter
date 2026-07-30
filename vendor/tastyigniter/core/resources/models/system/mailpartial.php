<?php

$config['list']['toolbar'] = [
    'buttons' => [
        'create' => [
            'label' => 'lang:igniter::admin.button_new',
            'class' => 'btn btn-primary',
            'href' => 'mail_partials/create',
        ],
        'templates' => [
            'label' => 'igniter::system.mail_templates.text_templates',
            'class' => 'btn btn-default',
            'href' => 'mail_templates',
        ],
        'layouts' => [
            'label' => 'igniter::system.mail_templates.text_layouts',
            'class' => 'btn btn-default',
            'href' => 'mail_layouts',
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
            'href' => 'mail_partials/edit/{partial_id}',
        ],
    ],
    'name' => [
        'label' => 'lang:igniter::admin.label_name',
        'type' => 'text',
        'searchable' => true,
    ],
    'code' => [
        'label' => 'igniter::system.mail_templates.column_code',
        'type' => 'text',
        'searchable' => true,
    ],
    'partial_id' => [
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
    ],
    'code' => [
        'label' => 'igniter::system.mail_templates.label_code',
        'span' => 'right',
        'type' => 'text',
    ],
];

$config['form']['tabs'] = [
    'fields' => [
        'html' => [
            'tab' => 'igniter::system.mail_templates.label_body',
            'type' => 'codeeditor',
            'mode' => 'application/x-httpd-php',
        ],
        'text' => [
            'tab' => 'igniter::system.mail_templates.label_plain',
            'type' => 'codeeditor',
            'mode' => 'application/x-httpd-php',
        ],
    ],
];

return $config;
