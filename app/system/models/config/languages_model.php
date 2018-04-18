<?php
$config['list']['filter'] = [
    'search' => [
        'prompt' => 'lang:system::languages.text_filter_search',
        'mode'   => 'all' // or any, exact
    ],
    'scopes' => [
        'status' => [
            'label'      => 'lang:system::languages.text_filter_status',
            'type'       => 'switch',
            'conditions' => 'status = :filtered',
        ],
    ],
];

$config['list']['toolbar'] = [
    'buttons' => [
        'create' => ['label' => 'lang:admin::default.button_new', 'class' => 'btn btn-primary', 'href' => 'languages/create'],
        'delete' => ['label' => 'lang:admin::default.button_delete', 'class' => 'btn btn-danger', 'data-request-form' => '#list-form', 'data-request' => 'onDelete', 'data-request-data' => "_method:'DELETE'", 'data-request-confirm' => 'lang:admin::default.alert_warning_confirm'],
        'filter' => ['label' => 'lang:admin::default.button_icon_filter', 'class' => 'btn btn-default btn-filter', 'data-toggle' => 'list-filter', 'data-target' => '.panel-filter .panel-body'],
    ],
];

$config['list']['columns'] = [
    'edit'        => [
        'type'         => 'button',
        'iconCssClass' => 'fa fa-pencil',
        'attributes'   => [
            'class' => 'btn btn-edit',
            'href'  => 'languages/edit/{language_id}',
        ],
    ],
    'name'        => [
        'label'      => 'lang:system::languages.column_name',
        'type'       => 'text',
        'searchable' => TRUE,
    ],
    'code'        => [
        'label'      => 'lang:system::languages.column_code',
        'type'       => 'text',
        'searchable' => TRUE,
    ],
    'status'      => [
        'label'      => 'lang:system::languages.column_status',
        'type'       => 'switch',
        'searchable' => TRUE,
    ],
    'language_id' => [
        'label'     => 'lang:admin::default.column_id',
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
            'data-request-confirm' => 'lang:admin::default.alert_warning_confirm', 'context' => 'edit',
        ],
        'back'      => ['label' => 'lang:admin::default.button_icon_back', 'class' => 'btn btn-default', 'href' => 'languages'],
    ],
];

$config['form']['tabs'] = [
    'defaultTab' => 'lang:system::languages.text_tab_general',
    'fields'     => [
        'name'       => [
            'label' => 'lang:system::languages.label_name',
            'type'  => 'text',
        ],
        'code'       => [
            'label'   => 'lang:system::languages.label_code',
            'type'    => 'text',
            'span'    => 'left',
            'comment' => 'lang:system::languages.help_language',
        ],
        'idiom'      => [
            'label'   => 'lang:system::languages.label_idiom',
            'type'    => 'text',
            'span'    => 'right',
            'comment' => 'lang:system::languages.help_idiom',
        ],
        'image'      => [
            'label'   => 'lang:system::languages.label_image',
            'type'    => 'mediafinder',
            'mode'    => 'inline',
            'default' => 'flags/no_flag.png',
        ],
        'can_delete' => [
            'label' => 'lang:system::languages.label_can_delete',
            'type'  => 'switch',
        ],
        'status'     => [
            'label'   => 'lang:admin::default.label_status',
            'default' => TRUE,
            'type'    => 'switch',
        ],
        'files'      => [
            'type'    => 'partial',
            'tab'     => 'lang:system::languages.text_tab_files',
            'context' => 'edit',
            'path'    => 'languages/lang_files_list',
            'options' => 'listAllFiles',
        ],
        'file'       => [
            'tab'     => 'lang:system::languages.text_tab_edit_file',
            'type'    => 'partial',
            'context' => 'edit',
            'path'    => 'languages/lang_file',
        ],
    ],
];

return $config;