<?php

declare(strict_types=1);

$config['list']['filter'] = [
    'search' => [
        'prompt' => 'lang:igniter.pages::default.text_filter_search',
        'mode' => 'all',
    ],
    'scopes' => [
        'status' => [
            'label' => 'lang:admin::lang.text_filter_status',
            'type' => 'switch',
            'conditions' => 'status = :filtered',
        ],
    ],
];

$config['list']['toolbar'] = [
    'buttons' => [
        'create' => ['label' => 'lang:admin::lang.button_new', 'class' => 'btn btn-primary', 'href' => 'igniter/pages/pages/create'],
        'menus' => ['label' => 'igniter.pages::default.menu.button_menus', 'class' => 'btn btn-default', 'href' => 'igniter/pages/menus'],
    ],
];

$config['list']['bulkActions'] = [
    'status' => [
        'label' => 'lang:admin::lang.list.actions.label_status',
        'type' => 'dropdown',
        'class' => 'btn btn-light',
        'statusColumn' => 'status',
        'menuItems' => [
            'enable' => [
                'label' => 'lang:admin::lang.list.actions.label_enable',
                'type' => 'button',
                'class' => 'dropdown-item',
            ],
            'disable' => [
                'label' => 'lang:admin::lang.list.actions.label_disable',
                'type' => 'button',
                'class' => 'dropdown-item text-danger',
            ],
        ],
    ],
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
            'href' => 'igniter/pages/pages/edit/{page_id}',
        ],
    ],
    'preview' => [
        'type' => 'button',
        'iconCssClass' => 'fa fa-eye',
        'attributes' => [
            'class' => 'btn btn-light',
            'href' => page_url('{permalink_slug}'),
            'target' => '_blank',
        ],
    ],
    'title' => [
        'label' => 'lang:igniter.pages::default.label_title',
        'type' => 'text',
        'searchable' => true,
    ],
    'language_name' => [
        'label' => 'lang:igniter.pages::default.column_language',
        'relation' => 'language',
        'select' => 'name',
        'searchable' => true,
    ],
    'status' => [
        'label' => 'lang:admin::lang.label_status',
        'type' => 'switch',
    ],
    'updated_at' => [
        'label' => 'lang:admin::lang.column_date_updated',
        'type' => 'timetense',
        'searchable' => true,
    ],
    'page_id' => [
        'label' => 'lang:admin::lang.column_id',
        'invisible' => true,
    ],

];

$config['form']['toolbar'] = [
    'buttons' => [
        'back' => [
            'label' => 'admin::lang.button_icon_back',
            'class' => 'btn btn-outline-secondary',
            'href' => 'igniter/pages/pages',
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
            'context' => ['edit'],
        ],
    ],
];

$config['form']['fields'] = [
    'title' => [
        'label' => 'lang:igniter.pages::default.label_title',
        'type' => 'text',
        'span' => 'left',
    ],
    'permalink_slug' => [
        'label' => 'lang:igniter.pages::default.label_permalink_slug',
        'type' => 'text',
        'span' => 'right',
        'preset' => [
            'field' => 'title',
            'type' => 'slug',
        ],
    ],
];

$config['form']['tabs']['fields'] = [
    'content' => [
        'type' => 'richeditor',
        'tab' => 'lang:igniter.pages::default.text_tab_edit',
        'cssClass' => 'richeditor-fluid',
    ],
    'layout' => [
        'label' => 'lang:igniter.pages::default.label_layout',
        'type' => 'select',
        'span' => 'left',
        'tab' => 'lang:igniter.pages::default.text_tab_manage',
    ],
    'language_id' => [
        'label' => 'lang:igniter.pages::default.label_language',
        'type' => 'relation',
        'span' => 'right',
        'relationFrom' => 'language',
        'tab' => 'lang:igniter.pages::default.text_tab_manage',
        'placeholder' => 'lang:admin::lang.text_please_select',
    ],
    'meta_description' => [
        'label' => 'lang:igniter.pages::default.label_meta_description',
        'tab' => 'lang:igniter.pages::default.text_tab_manage',
        'type' => 'textarea',
        'span' => 'left',
    ],
    'meta_keywords' => [
        'label' => 'lang:igniter.pages::default.label_meta_keywords',
        'tab' => 'lang:igniter.pages::default.text_tab_manage',
        'type' => 'textarea',
        'span' => 'right',
    ],
    'metadata[navigation_hidden]' => [
        'label' => 'lang:igniter.pages::default.label_navigation',
        'tab' => 'lang:igniter.pages::default.text_tab_manage',
        'type' => 'switch',
        'span' => 'left',
        'default' => false,
    ],
    'status' => [
        'label' => 'lang:admin::lang.label_status',
        'tab' => 'lang:igniter.pages::default.text_tab_manage',
        'type' => 'switch',
        'span' => 'right',
        'default' => true,
    ],
];

return $config;
