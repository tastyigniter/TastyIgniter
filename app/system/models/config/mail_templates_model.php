<?php
$config['list']['toolbar'] = [
    'buttons' => [
        'create' => ['label' => 'lang:admin::default.button_new', 'class' => 'btn btn-primary', 'href' => 'mail_layouts/create'],
        'delete' => [
            'label'        => 'lang:admin::default.button_delete', 'class' => 'btn btn-danger', 'data-request-form' => '#list-form',
            'data-request' => 'onDelete', 'data-request-data' => "_method:'DELETE'", 'data-request-confirm' => 'lang:admin::default.alert_warning_confirm',
        ],
    ],
];

$config['list']['columns'] = [
    'edit'          => [
        'type'         => 'button',
        'iconCssClass' => 'fa fa-pencil',
        'attributes'   => [
            'class' => 'btn btn-edit',
            'href'  => 'mail_layouts/edit/{template_id}',
        ],
    ],
    'default'       => [
        'type'       => 'button',
        'attributes' => [
            'class'             => 'btn btn-mark',
            'data-request'      => 'onSetDefault',
            'data-request-data' => 'default:{template_id}',
        ],
        'formatter'  => function ($record, $column, $value) {
            $column->iconCssClass = 'fa fa-star-o';
            if ($record->getKey() == setting('mail_template_id')) {
                $column->iconCssClass = 'fa fa-star';

                return 'class="btn btn-mark disabled"';
            }
        },
    ],
    'name'          => [
        'label'      => 'lang:system::mail_templates.column_name',
        'type'       => 'text',
        'searchable' => TRUE,
    ],
    'original_name' => [
        'label'      => 'lang:system::mail_templates.column_original',
        'relation'   => 'original',
        'valueFrom'  => 'name',
        'searchable' => TRUE,
    ],
    'status'        => [
        'label' => 'lang:system::mail_templates.column_status',
        'type'  => 'switch',
    ],
    'date_updated'  => [
        'label'      => 'lang:system::mail_templates.column_date_updated',
        'type'       => 'datetime',
        'searchable' => TRUE,
    ],
    'date_added'    => [
        'label'      => 'lang:system::mail_templates.column_date_added',
        'type'       => 'datetime',
        'searchable' => TRUE,
    ],
    'template_id'   => [
        'label'     => 'lang:system::mail_templates.column_id',
        'invisible' => TRUE,
    ],

];

$config['form']['toolbar'] = [
    'buttons' => [
        'save'      => [
            'label' => 'lang:admin::default.button_save', 'class' => 'btn btn-primary', 'data-request-form' => '#edit-form', 'data-request' => 'onSave',
        ],
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
        'create'    => [
            'label'   => 'lang:system::mail_templates.button_new_template',
            'context' => ['preview', 'edit'],
            'class'   => 'btn btn-primary',
            'href'    => 'mail_templates/create',
        ],
        'back'      => ['label' => 'lang:admin::default.button_icon_back', 'class' => 'btn btn-default', 'href' => 'mail_layouts'],
        'changes'   => [
            'label'   => 'lang:system::mail_templates.button_icon_update', 'class' => 'btn btn-success pull-right',
            'title'   => 'lang:system::mail_templates.text_fetch_changes',
            'href'    => 'mail_layouts/changes',
            'context' => ['preview', 'edit'],
        ],
    ],
];

$config['form']['fields'] = [
    'name'        => [
        'label' => 'lang:system::mail_templates.label_name',
        'span'  => 'left',
        'type'  => 'text',
    ],
    'language_id' => [
        'label'        => 'lang:system::mail_templates.label_language',
        'span'         => 'right',
        'type'         => 'relation',
        'relationFrom' => 'language',
        'placeholder'  => 'lang:admin::default.text_please_select',
    ],
    'original_id' => [
        'label'        => 'lang:system::mail_templates.label_clone',
        'type'         => 'relation',
        'relationFrom' => 'original',
        'placeholder'  => 'lang:admin::default.text_please_select',
    ],
    'status'      => [
        'label'   => 'lang:admin::default.label_status',
        'type'    => 'switch',
        'default' => TRUE,
    ],
];

$config['form']['tabs'] = [
    'fields' => [
        'templates'    => [
            'tab'     => 'lang:system::mail_templates.text_tab_templates',
            'type'    => 'partial',
            'path'    => 'maillayouts/templates',
            'context' => ['preview', 'edit'],
        ],
        'plain_layout' => [
            'label'      => 'lang:system::mail_templates.label_plain_layout',
            'tab'        => 'lang:system::mail_templates.text_tab_layout',
            'type'       => 'textarea',
            'context'    => ['preview', 'edit'],
            'attributes' => [
                'rows' => 10,
            ],
        ],
        'layout'       => [
            'label'   => 'lang:system::mail_templates.label_layout',
            'tab'     => 'lang:system::mail_templates.text_tab_layout',
            'type'    => 'richeditor',
            'context' => ['preview', 'edit'],
        ],
    ],
];

return $config;