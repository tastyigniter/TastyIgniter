<?php
$config['list']['filter'] = [
    'search' => [
        'prompt' => 'lang:admin::pages.text_filter_search',
        'mode'   => 'all',
    ],
    'scopes' => [
        'status' => [
            'label'      => 'lang:admin::pages.text_filter_status',
            'type'       => 'switch',
            'conditions' => 'status = :filtered',
        ],
    ],
];

$config['list']['toolbar'] = [
    'buttons' => [
        'create' => ['label' => 'lang:admin::default.button_new', 'class' => 'btn btn-primary', 'href' => 'pages/create'],
        'delete' => ['label' => 'lang:admin::default.button_delete', 'class' => 'btn btn-danger', 'data-request-form' => '#list-form', 'data-request' => 'onDelete', 'data-request-data' => "_method:'DELETE'", 'data-request-confirm' => 'lang:admin::default.alert_warning_confirm'],
        'filter' => ['label' => 'lang:admin::default.button_icon_filter', 'class' => 'btn btn-default btn-filter', 'data-toggle' => 'list-filter', 'data-target' => '.panel-filter .panel-body'],
    ],
];

$config['list']['columns'] = [
    'edit'          => [
        'type'         => 'button',
        'iconCssClass' => 'fa fa-pencil',
        'attributes'   => [
            'class' => 'btn btn-edit',
            'href'  => 'pages/edit/{page_id}',
        ],
    ],
    'preview'       => [
        'type'         => 'button',
        'iconCssClass' => 'fa fa-eye',
        'attributes'   => [
            'class' => 'btn btn-info',
            'href'  => site_url('{permalink_slug}'),
            'target'  => '_blank',
        ],
    ],
    'name'          => [
        'label'      => 'lang:admin::pages.column_name',
        'type'       => 'text',
        'searchable' => TRUE,
    ],
    'language_name' => [
        'label'      => 'lang:admin::pages.column_language',
        'relation'   => 'language',
        'select'     => 'name',
        'searchable' => TRUE,
    ],
    'date_updated'  => [
        'label'      => 'lang:admin::pages.column_date_updated',
        'type'       => 'date',
        'searchable' => TRUE,
    ],
    'status'        => [
        'label' => 'lang:admin::pages.column_status',
        'type'  => 'switch',
    ],
    'page_id'       => [
        'label'     => 'lang:admin::pages.column_id',
        'invisible' => TRUE,
    ],

];

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
        'back'      => ['label' => 'lang:admin::default.button_icon_back', 'class' => 'btn btn-default', 'href' => 'pages'],
    ],
];

$config['form']['fields'] = [
    'name'            => [
        'label' => 'lang:admin::pages.label_name',
        'type'  => 'text',
        'span'  => 'left',
    ],
    'title'          => [
        'label' => 'lang:admin::pages.label_title',
        'type'  => 'text',
        'span'  => 'right',
    ],
    'content'          => [
        'label' => 'lang:admin::pages.label_content',
        'type'  => 'richeditor',
        'cssClass'  => 'richeditor-fluid',
    ],
    'permalink_slug'  => [
        'label'    => 'lang:admin::pages.label_permalink_slug',
        'type'     => 'text',
        'comment'  => 'lang:admin::pages.help_permalink',
    ],
    'navigation'       => [
        'label'   => 'lang:admin::pages.label_navigation',
        'type'    => 'checkbox',
        'default' => 'none',
        'comment' => 'lang:admin::pages.help_navigation',
        'options' => [
            'none'     => 'lang:admin::default.text_none',
            'header'   => 'lang:admin::pages.text_header',
            'side_bar' => 'lang:admin::pages.text_side_bar',
            'footer'   => 'lang:admin::pages.text_footer',
        ],
    ],
    'layout_id'        => [
        'label'        => 'lang:admin::pages.label_layout',
        'type'         => 'relation',
        'relationFrom' => 'layout',
        'span'         => 'left',
        'placeholder'  => 'lang:admin::default.text_please_select',
    ],
    'language_id'      => [
        'label'        => 'lang:admin::pages.label_language',
        'type'         => 'relation',
        'relationFrom' => 'language',
        'span'         => 'right',
        'placeholder'  => 'lang:admin::default.text_please_select',
    ],
    'meta_description' => [
        'label' => 'lang:admin::pages.label_meta_description',
        'type'  => 'textarea',
        'span'  => 'left',
    ],
    'meta_keywords'    => [
        'label' => 'lang:admin::pages.label_meta_keywords',
        'type'  => 'textarea',
        'span'  => 'right',
    ],
    'status'           => [
        'label'   => 'lang:admin::default.label_status',
        'type'    => 'switch',
        'default' => TRUE,
    ],
];

return $config;