<?php
$config['list']['filter'] = [
    'search' => [
        'prompt' => 'lang:system::lang.languages.text_filter_search',
        'mode' => 'all', // or any, exact
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
        'create' => [
            'label' => 'lang:admin::lang.button_new',
            'class' => 'btn btn-primary',
            'href' => 'languages/create',
        ],
        'browse' => [
            'label' => 'lang:system::lang.languages.button_browse',
            'class' => 'btn btn-default',
            'href' => 'https://tastyigniter.com/translate',
            'target' => '_blank',
        ],
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
            'href' => 'languages/edit/{language_id}',
        ],
    ],
    'name' => [
        'label' => 'lang:admin::lang.label_name',
        'type' => 'text',
        'searchable' => true,
    ],
    'code' => [
        'label' => 'lang:system::lang.languages.column_code',
        'type' => 'text',
        'searchable' => true,
    ],
    'status' => [
        'label' => 'lang:system::lang.languages.column_status',
        'type' => 'switch',
        'searchable' => true,
    ],
    'language_id' => [
        'label' => 'lang:admin::lang.column_id',
        'invisible' => true,
    ],
    'created_at' => [
        'label' => 'lang:admin::lang.column_date_added',
        'invisible' => true,
        'type' => 'timesense',
    ],
    'updated_at' => [
        'label' => 'lang:admin::lang.column_date_updated',
        'invisible' => true,
        'type' => 'timesense',
    ],
];

$config['form']['toolbar'] = [
    'buttons' => [
        'back' => [
            'label' => 'lang:admin::lang.button_icon_back',
            'class' => 'btn btn-default',
            'href' => 'languages',
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
    'code' => [
        'label' => 'lang:system::lang.languages.label_code',
        'type' => 'text',
        'span' => 'none',
        'cssClass' => 'pull-left flex-fill mr-3',
    ],
    'name' => [
        'label' => 'lang:admin::lang.label_name',
        'type' => 'text',
        'span' => 'none',
        'cssClass' => 'pull-left flex-fill mr-3',
    ],
    'status' => [
        'label' => 'lang:admin::lang.label_status',
        'type' => 'switch',
        'span' => 'none',
        'cssClass' => 'pull-left flex-fill',
        'default' => true,
    ],
    'section' => [
        'type' => 'section',
        'comment' => 'lang:system::lang.languages.help_language',
    ],
];
$config['form']['tabs'] = [
    'defaultTab' => 'lang:system::lang.languages.text_tab_general',
    'fields' => [
        '_file' => [
            'tab' => 'lang:system::lang.languages.text_tab_files',
            'type' => 'select',
            'context' => 'edit',
            'options' => [],
            'span' => 'none',
            'placeholder' => 'system::lang.languages.text_filter_file',
            'cssClass' => 'pull-left flex-fill mr-3',
            'attributes' => [
                'data-request' => 'onSubmitFilter',
            ],
        ],
        '_search' => [
            'tab' => 'lang:system::lang.languages.text_tab_files',
            'type' => 'text',
            'context' => 'edit',
            'span' => 'none',
            'cssClass' => 'pull-left flex-fill mr-3',
            'placeholder' => lang('system::lang.languages.text_filter_translations'),
            'attributes' => [
                'data-control' => 'search-translations',
                'data-request' => 'onSubmitFilter',
            ],
        ],
        '_string_filter' => [
            'tab' => 'lang:system::lang.languages.text_tab_files',
            'type' => 'radiotoggle',
            'context' => 'edit',
            'span' => 'none',
            'cssClass' => 'pull-left mr-3',
            'default' => 'all',
            'options' => [
                'all' => 'All',
                'unchanged' => 'Unchanged',
                'changed' => 'Changed',
            ],
            'attributes' => [
                'data-control' => 'string-filter',
                'data-request' => 'onSubmitFilter',
            ],
        ],
        'translations' => [
            'tab' => 'lang:system::lang.languages.text_tab_files',
            'type' => 'partial',
            'path' => 'translationseditor',
            'context' => 'edit',
        ],
    ],
];

return $config;
