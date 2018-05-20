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
    'name'                 => [
        'label'    => 'lang:system::themes.label_name',
        'type'     => 'text',
        'span'     => 'left',
        'disabled' => TRUE,
    ],
    'code'                 => [
        'label'    => 'lang:system::themes.label_code',
        'type'     => 'text',
        'span'     => 'right',
        'disabled' => TRUE,
    ],
    'file'                 => [
        'label'       => 'lang:system::themes.label_file',
        'type'        => 'partial',
        'path'        => 'form/field_source',
        'placeholder' => 'lang:system::themes.text_select_file',
        'context'     => ['source'],
        'attributes'  => [
            'data-request'      => 'onChooseFile',
            'data-request-form' => '#edit-form',
        ],
    ],
    'settings[components]' => [
        'label'   => 'lang:system::themes.text_tab_components',
        'type'    => 'components',
        'context' => ['_source'],
        'prompt'  => 'lang:system::themes.button_choose',
        'comment' => 'lang:system::themes.help_components',
        'form'    => [
            'fields' => [
                'code'  => ['type' => 'hidden',],
                'alias' => [
                    'label'      => 'lang:system::themes.label_component_alias',
                    'type'       => 'text',
                    'attributes' => [
                        'data-toggle' => 'disabled',
                    ],
                ],
            ],
        ],
    ],
];

$config['form']['tabs'] = [
    'cssClass' => 'theme-editor',
    'fields'   => [
        'markup'                => [
            'tab'  => 'lang:system::themes.text_tab_markup',
            'type' => 'codeeditor',
            'mode' => 'css',
        ],
        'codeSection'           => [
            'tab'     => 'lang:system::themes.text_tab_php_section',
            'type'    => 'codeeditor',
            'mode'    => 'php',
            'context' => ['_source'],
        ],
        'settings[title]'       => [
            'label' => 'lang:system::themes.label_title',
            'tab'   => 'lang:system::themes.text_tab_meta',
            'type'  => 'text',
            'span'  => 'left',
        ],
        'settings[permalink]'   => [
            'tab'   => 'lang:system::themes.text_tab_meta',
            'label' => 'lang:system::themes.label_permalink',
            'type'  => 'text',
            'span'  => 'right',
        ],
        'settings[description]' => [
            'tab'   => 'lang:system::themes.text_tab_meta',
            'label' => 'lang:system::themes.label_description',
            'type'  => 'textarea',
        ],
        'settings[layout]'      => [
            'tab'   => 'lang:system::themes.text_tab_meta',
            'label' => 'lang:system::themes.label_layout',
            'type'  => 'text',
        ],
    ],
];

return $config;