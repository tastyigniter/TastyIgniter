<?php
$config['list']['toolbar'] = [
    'buttons' => [
        'create' => [
            'label' => 'lang:admin::lang.button_new',
            'class' => 'btn btn-primary',
            'href' => 'mail_templates/create',
        ],
        'layouts' => [
            'label' => 'lang:system::lang.mail_templates.text_layouts',
            'class' => 'btn btn-default',
            'href' => 'mail_layouts',
        ],
        'partials' => [
            'label' => 'lang:system::lang.mail_templates.text_partials',
            'class' => 'btn btn-default',
            'href' => 'mail_partials',
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
            'href' => 'mail_templates/edit/{template_id}',
        ],
    ],
    'title' => [
        'label' => 'lang:system::lang.mail_templates.column_title',
        'type' => 'text',
        'searchable' => true,
        'sortable' => false,
    ],
    'code' => [
        'label' => 'lang:system::lang.mail_templates.column_code',
        'type' => 'text',
        'searchable' => true,
    ],
    'layout_id' => [
        'label' => 'lang:system::lang.mail_templates.column_layout',
        'relation' => 'layout',
        'valueFrom' => 'name',
        'sortable' => false,
    ],
    'updated_at' => [
        'label' => 'lang:admin::lang.column_date_updated',
        'type' => 'timetense',
        'searchable' => true,
    ],
    'created_at' => [
        'label' => 'lang:admin::lang.column_date_added',
        'type' => 'timetense',
        'searchable' => true,
        'invisible' => true,
    ],
    'template_id' => [
        'label' => 'lang:admin::lang.column_id',
        'invisible' => true,
    ],
];

$config['form']['toolbar'] = [
    'buttons' => [
        'back' => [
            'label' => 'lang:admin::lang.button_icon_back',
            'class' => 'btn btn-default',
            'href' => 'mail_templates',
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
            'context' => 'edit',
        ],
        'test_message' => [
            'label' => 'lang:system::lang.mail_templates.button_test_message',
            'class' => 'btn btn-default',
            'data-request' => 'onTestTemplate',
            'context' => 'edit',
        ],
    ],
];

$config['form']['fields'] = [
    'code' => [
        'label' => 'lang:system::lang.mail_templates.label_code',
        'span' => 'left',
        'type' => 'text',
    ],
    'label' => [
        'label' => 'lang:admin::lang.label_description',
        'span' => 'right',
        'valueFrom' => 'title',
        'type' => 'text',
    ],
    'subject' => [
        'label' => 'lang:system::lang.mail_templates.label_subject',
        'span' => 'left',
        'type' => 'text',
    ],
    'layout_id' => [
        'label' => 'lang:system::lang.mail_templates.label_layout',
        'span' => 'right',
        'type' => 'relation',
        'relationFrom' => 'layout',
        'placeholder' => 'lang:admin::lang.text_please_select',
    ],
];

$config['form']['tabs'] = [
    'fields' => [
        'body' => [
            'tab' => 'lang:system::lang.mail_templates.label_markdown',
            'type' => 'markdowneditor',
        ],
        'plain_body' => [
            'tab' => 'lang:system::lang.mail_templates.label_plain',
            'type' => 'textarea',
            'attributes' => [
                'rows' => 10,
            ],
        ],
    ],
];

return $config;
