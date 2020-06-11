<?php
$config['list']['filter'] = [
    'search' => [
        'prompt' => 'lang:system::lang.languages.text_filter_search',
        'mode' => 'all' // or any, exact
    ],
    'scopes' => [
        'status' => [
            'label' => 'lang:system::lang.languages.text_filter_status',
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
        'delete' => [
            'label' => 'lang:admin::lang.button_delete',
            'class' => 'btn btn-danger',
            'data-attach-loading' => '',
            'data-request' => 'onDelete',
            'data-request-form' => '#list-form',
            'data-request-data' => "_method:'DELETE'",
            'data-request-confirm' => 'lang:admin::lang.alert_warning_confirm',
        ],
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
        'searchable' => TRUE,
    ],
    'code' => [
        'label' => 'lang:system::lang.languages.column_code',
        'type' => 'text',
        'searchable' => TRUE,
    ],
    'status' => [
        'label' => 'lang:system::lang.languages.column_status',
        'type' => 'switch',
        'searchable' => TRUE,
    ],
    'language_id' => [
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
            'context' => ['edit'],
        ],
    ],
];

$config['form']['fields'] = [
    'name' => [
        'label' => 'lang:admin::lang.label_name',
        'type' => 'text',
        'span' => 'none',
        'cssClass' => 'pull-left flex-fill mr-3',
    ],
    'code' => [
        'label' => 'lang:system::lang.languages.label_code',
        'type' => 'text',
        'span' => 'none',
        'cssClass' => 'pull-left flex-fill mr-3',
    ],
    'status' => [
        'label' => 'lang:admin::lang.label_status',
        'type' => 'switch',
        'span' => 'none',
        'cssClass' => 'pull-left flex-fill',
        'default' => TRUE,
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
