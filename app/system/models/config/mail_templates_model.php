<?php
$config['list']['toolbar'] = [
    'buttons' => [
        'create' => [
            'label' => 'lang:admin::lang.button_new',
            'class' => 'btn btn-primary',
            'href' => 'mail_templates/create',
        ],
        'delete' => [
            'label' => 'lang:admin::lang.button_delete',
            'class' => 'btn btn-danger',
            'data-attach-loading' => '',
            'data-request' => 'onDelete',
            'data-request-form' => '#list-form',
            'data-request-data' => "_method:'DELETE'",
            'data-request-confirm' => 'lang:admin::lang.alert_warning_confirm',
            'data-progress-indicator' => 'admin::lang.text_deleting',
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
        'searchable' => TRUE,
        'sortable' => FALSE,
    ],
    'code' => [
        'label' => 'lang:system::lang.mail_templates.column_code',
        'type' => 'text',
        'searchable' => TRUE,
    ],
    'layout_id' => [
        'label' => 'lang:system::lang.mail_templates.column_layout',
        'relation' => 'layout',
        'valueFrom' => 'name',
        'sortable' => FALSE,
    ],
    'date_updated' => [
        'label' => 'lang:admin::lang.column_date_updated',
        'type' => 'timetense',
        'searchable' => TRUE,
    ],
    'date_added' => [
        'label' => 'lang:admin::lang.column_date_added',
        'type' => 'timetense',
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