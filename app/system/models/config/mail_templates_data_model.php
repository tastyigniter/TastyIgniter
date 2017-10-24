<?php
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
            'data-request-confirm' => 'lang:admin::default.alert_warning_confirm',
        ],
        'back'      => ['label' => 'lang:admin::default.button_icon_back', 'class' => 'btn btn-default', 'href' => 'mail_layouts'],
    ],
];

$config['form']['fields'] = [
    'title'        => [
        'label' => 'lang:system::mail_templates.label_name',
        'span'  => 'left',
        'type'  => 'text',
    ],
    'code'        => [
        'label' => 'lang:system::mail_templates.label_code',
        'span'  => 'right',
        'type'  => 'text',
    ],
    'subject'        => [
        'label' => 'lang:system::mail_templates.label_subject',
        'span'  => 'left',
        'type'  => 'text',
    ],
    'template_id'        => [
        'label' => 'lang:system::mail_templates.label_layout',
        'span'  => 'right',
        'type'  => 'relation',
        'relationFrom'  => 'template',
        'placeholder'  => 'lang:admin::default.text_please_select',
    ],
];

$config['form']['tabs'] = [
    'fields' => [
        'body' => [
            'tab'    => 'lang:system::mail_templates.label_body',
            'type'      => 'richeditor',
        ],
        'plain_body' => [
            'tab'    => 'lang:system::mail_templates.label_plain_body',
            'type'      => 'textarea',
            'attributes' => [
                'rows'      => 10
            ],
        ],
        'variables' => [
            'tab'    => 'lang:system::mail_templates.text_variables',
            'type'      => 'partial',
            'path'      => 'mailtemplates/variables',
            'disabled'      => true,
        ],
    ]
];

return $config;