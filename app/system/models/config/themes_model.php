<?php
$config['list']['filter'] = [
    'search' => [
        'prompt' => 'lang:system::themes.text_filter_search',
        'mode'   => 'all',
    ],
    'scopes' => [
        'status' => [
            'label'      => 'lang:system::themes.text_filter_status',
            'type'       => 'switch',
            'conditions' => 'status = :filtered',
        ],
    ],
];

$config['list']['toolbar'] = [
    'buttons' => [
        'upload' => ['label' => 'lang:system::themes.button_new', 'class' => 'btn btn-primary', 'href' => 'themes/upload'],
        'filter' => ['label' => 'lang:admin::default.button_icon_filter', 'class' => 'btn btn-default btn-filter', 'data-toggle' => 'list-filter', 'data-target' => '.list-filter'],
        'check'  => ['label' => 'lang:system::themes.button_check', 'class' => 'btn btn-success pull-right', 'href' => 'updates'],
        'browse' => ['label' => 'lang:system::themes.button_browse', 'class' => 'btn btn-default pull-right', 'href' => 'updates/browse/themes'],
    ],
];

$config['list']['columns'] = [
    'edit'     => [
        'type'         => 'button',
        'iconCssClass' => 'fa fa-paint-brush',
        'attributes'   => [
            'class' => 'btn btn-outline btn-default',
            'href'  => 'themes/edit/{code}',
        ],
    ],
    'source'   => [
        'type'         => 'button',
        'iconCssClass' => 'fa fa-pencil',
        'attributes'   => [
            'class' => 'btn btn-outline btn-default',
            'href'  => 'themes/source/{code}',
        ],
    ],
    'default'  => [
        'type'         => 'button',
        'iconCssClass' => 'fa fa-star-o',
        'attributes'   => [
            'class'             => 'btn btn-outline-warning',
            'title'             => 'lang:system::themes.text_set_default',
            'data-request'      => 'onSetDefault',
            'data-request-form' => '#list-form',
            'data-request-data' => 'code:\'{code}\'',
        ],
    ],
    'delete'   => [
        'type'         => 'button',
        'iconCssClass' => 'fa fa-trash-o',
        'attributes'   => [
            'class' => 'btn btn-outline btn-danger',
            'href'  => 'themes/delete/{code}',
        ],
    ],
    'name'     => [
        'label'      => 'lang:system::themes.column_name',
        'type'       => 'text',
        'searchable' => TRUE,
    ],
    'theme_id' => [
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
        'back'      => ['label' => 'lang:admin::default.button_icon_back', 'class' => 'btn btn-default', 'href' => 'themes'],
    ],
];

$config['form']['fields'] = [
    'name' => [
        'label'    => 'lang:system::themes.label_name',
        'type'     => 'text',
        'span'     => 'left',
        'disabled' => TRUE,
    ],
    'code' => [
        'label'    => 'lang:system::themes.label_code',
        'type'     => 'text',
        'span'     => 'right',
        'disabled' => TRUE,
    ],
];

$config['form']['tabs'] = [
    'cssClass' => 'theme-editor',
    'fields'   => [
        'file'  => [
            'tab'      => 'lang:system::themes.text_tab_edit_source',
            'type'     => 'select',
            'attributes'  => [
                'data-request' => 'onChooseFile',
                'data--request-form' => '#edit-form',
            ]
        //     'span'     => 'flex',
        //     'cssClass' => 'col-sm-3 span-left wrap-none',
        //     'path'     => 'themes/source_files',
        ],
        'source' => [
            'tab'      => 'lang:system::themes.text_tab_edit_source',
            'type'     => 'codeeditor',
            // 'span'     => 'flex',
            // 'cssClass' => 'col-sm-9 span-right wrap-none',
            'mode'     => 'css',
        ],
    ],
];

return $config;