<?php
$config['list']['toolbar'] = [
    'buttons' => [
        'create' => [
            'label' => 'lang:admin::lang.button_new',
            'class' => 'btn btn-primary',
            'href' => 'mail_partials/create',
        ],
        'templates' => [
            'label' => 'lang:system::lang.mail_templates.text_templates',
            'class' => 'btn btn-default',
            'href' => 'mail_templates',
        ],
        'layouts' => [
            'label' => 'lang:system::lang.mail_templates.text_layouts',
            'class' => 'btn btn-default',
            'href' => 'mail_layouts',
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
            'href' => 'mail_partials/edit/{partial_id}',
        ],
    ],
    'name' => [
        'label' => 'lang:admin::lang.label_name',
        'type' => 'text',
        'searchable' => TRUE,
    ],
    'code' => [
        'label' => 'lang:system::lang.mail_templates.column_code',
        'type' => 'text',
        'searchable' => TRUE,
    ],
    'partial_id' => [
        'label' => 'lang:admin::lang.column_id',
        'invisible' => TRUE,
    ],
];

$config['form']['toolbar'] = [
    'buttons' => [
        'back' => [
            'label' => 'lang:admin::lang.button_icon_back',
            'class' => 'btn btn-default',
            'href' => 'mail_partials',
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
    ],
];

$config['form']['fields'] = [
    'name' => [
        'label' => 'lang:admin::lang.label_name',
        'span' => 'left',
        'type' => 'text',
    ],
    'code' => [
        'label' => 'lang:system::lang.mail_templates.label_code',
        'span' => 'right',
        'type' => 'text',
    ],
];

$config['form']['tabs'] = [
    'fields' => [
        'html' => [
            'tab' => 'lang:system::lang.mail_templates.label_body',
            'type' => 'codeeditor',
        ],
        'text' => [
            'tab' => 'lang:system::lang.mail_templates.label_plain',
            'type' => 'textarea',
            'attributes' => [
                'rows' => 10,
            ],
        ],
    ],
];

return $config;
