<?php

$config['list']['toolbar'] = [
    'buttons' => [
        'create' => [
            'label' => 'lang:igniter::admin.button_new',
            'class' => 'btn btn-primary',
            'href' => 'mail_templates/create',
        ],
        'layouts' => [
            'label' => 'lang:igniter::system.mail_templates.text_layouts',
            'class' => 'btn btn-default',
            'href' => 'mail_layouts',
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
            'href' => 'mail_templates/edit/{template_id}',
        ],
    ],
    'title' => [
        'label' => 'lang:igniter::system.mail_templates.column_title',
        'type' => 'text',
        'searchable' => true,
        'sortable' => false,
    ],
    'code' => [
        'label' => 'lang:igniter::system.mail_templates.column_code',
        'type' => 'text',
        'searchable' => true,
    ],
    'layout_id' => [
        'label' => 'lang:igniter::system.mail_templates.column_layout',
        'relation' => 'layout',
        'valueFrom' => 'name',
        'sortable' => false,
    ],
    'updated_at' => [
        'label' => 'lang:igniter::admin.column_date_updated',
        'type' => 'timetense',
        'searchable' => true,
    ],
    'created_at' => [
        'label' => 'lang:igniter::admin.column_date_added',
        'type' => 'timetense',
        'searchable' => true,
        'invisible' => true,
    ],
    'template_id' => [
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
        'test_message' => [
            'label' => 'lang:igniter::system.mail_templates.button_test_message',
            'class' => 'btn btn-default',
            'data-request' => 'onTestTemplate',
            'context' => 'edit',
        ],
    ],
];

$config['form']['fields'] = [
    'code' => [
        'label' => 'lang:igniter::system.mail_templates.label_code',
        'span' => 'left',
        'type' => 'text',
    ],
    'label' => [
        'label' => 'lang:igniter::admin.label_description',
        'span' => 'right',
        'valueFrom' => 'title',
        'type' => 'text',
    ],
    'subject' => [
        'label' => 'lang:igniter::system.mail_templates.label_subject',
        'span' => 'left',
        'type' => 'text',
    ],
    'layout_id' => [
        'label' => 'lang:igniter::system.mail_templates.label_layout',
        'span' => 'right',
        'type' => 'relation',
        'relationFrom' => 'layout',
        'placeholder' => 'lang:igniter::admin.text_please_select',
    ],
];

$config['form']['tabs'] = [
    'fields' => [
        'body' => [
            'tab' => 'lang:igniter::system.mail_templates.label_markdown',
            'type' => 'markdowneditor',
        ],
        'plain_body' => [
            'tab' => 'lang:igniter::system.mail_templates.label_plain',
            'type' => 'codeeditor',
            'mode' => 'application/x-httpd-php',
        ],
    ],
];

return $config;
