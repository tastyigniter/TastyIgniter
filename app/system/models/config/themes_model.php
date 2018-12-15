<?php
$config['list']['toolbar'] = [
    'buttons' => [
        'upload' => ['label' => 'lang:system::lang.themes.button_new', 'class' => 'btn btn-primary', 'href' => 'themes/upload'],
        'browse' => ['label' => 'lang:system::lang.themes.button_browse', 'class' => 'btn btn-default', 'href' => 'updates/browse/themes'],
        'check' => ['label' => 'lang:system::lang.themes.button_check', 'class' => 'btn btn-success', 'href' => 'updates'],
    ],
];

$config['list']['columns'] = [
    'edit' => [
        'type' => 'button',
        'iconCssClass' => 'fa fa-paint-brush',
        'attributes' => [
            'class' => 'btn btn-outline-default',
            'href' => 'themes/edit/{code}',
        ],
    ],
    'source' => [
        'type' => 'button',
        'iconCssClass' => 'fa fa-pencil',
        'attributes' => [
            'class' => 'btn btn-outline-default',
            'href' => 'themes/source/{code}',
        ],
    ],
    'default' => [
        'type' => 'button',
        'iconCssClass' => 'fa fa-star-o',
        'attributes' => [
            'class' => 'btn btn-outline-warning',
            'title' => 'lang:system::lang.themes.text_set_default',
            'data-request' => 'onSetDefault',
            'data-request-form' => '#list-form',
            'data-request-data' => 'code:\'{code}\'',
        ],
    ],
    'delete' => [
        'type' => 'button',
        'iconCssClass' => 'fa fa-trash-o',
        'attributes' => [
            'class' => 'btn btn-outline-danger',
            'href' => 'themes/delete/{code}',
        ],
    ],
    'name' => [
        'label' => 'lang:system::lang.themes.column_name',
        'type' => 'text',
        'searchable' => TRUE,
    ],
    'theme_id' => [
        'label' => 'lang:admin::lang.column_id',
        'invisible' => TRUE,
    ],
];

$config['form']['toolbar'] = [
    'buttons' => [
        'save' => ['label' => 'lang:admin::lang.button_save', 'class' => 'btn btn-primary', 'data-request-submit' => 'true', 'data-request' => 'onSave'],
        'saveClose' => [
            'label' => 'lang:admin::lang.button_save_close',
            'class' => 'btn btn-default',
            'data-request' => 'onSave',
            'data-request-submit' => 'true',
            'data-request-data' => 'close:1',
        ],
    ],
];

$config['form']['fields'] = [
    'name' => [
        'label' => 'lang:system::lang.themes.label_name',
        'type' => 'text',
        'span' => 'left',
        'disabled' => TRUE,
    ],
    'code' => [
        'label' => 'lang:system::lang.themes.label_code',
        'type' => 'text',
        'span' => 'right',
        'disabled' => TRUE,
    ],
    'file' => [
        'label' => 'lang:system::lang.themes.label_file',
        'type' => 'partial',
        'path' => 'form/field_source',
        'placeholder' => 'lang:system::lang.themes.text_select_file',
        'context' => ['source'],
        'attributes' => [
            'data-request' => 'onChooseFile',
            'data-request-submit' => 'true',
        ],
    ],
    'settings[components]' => [
        'label' => 'lang:system::lang.themes.text_tab_components',
        'type' => 'components',
        'context' => ['_source'],
        'prompt' => 'lang:system::lang.themes.button_choose',
        'comment' => 'lang:system::lang.themes.help_components',
        'form' => [
            'fields' => [
                'code' => ['type' => 'hidden',],
                'alias' => [
                    'label' => 'lang:system::lang.themes.label_component_alias',
                    'type' => 'text',
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
    'fields' => [
        'markup' => [
            'tab' => 'lang:system::lang.themes.text_tab_markup',
            'type' => 'codeeditor',
            'mode' => 'css',
        ],
        'codeSection' => [
            'tab' => 'lang:system::lang.themes.text_tab_php_section',
            'type' => 'codeeditor',
            'mode' => 'php',
            'context' => ['_source'],
        ],
        'settings[title]' => [
            'label' => 'lang:system::lang.themes.label_title',
            'tab' => 'lang:system::lang.themes.text_tab_meta',
            'type' => 'text',
            'span' => 'left',
        ],
        'settings[permalink]' => [
            'tab' => 'lang:system::lang.themes.text_tab_meta',
            'label' => 'lang:system::lang.themes.label_permalink',
            'type' => 'text',
            'span' => 'right',
        ],
        'settings[description]' => [
            'tab' => 'lang:system::lang.themes.text_tab_meta',
            'label' => 'lang:system::lang.themes.label_description',
            'type' => 'textarea',
        ],
        'settings[layout]' => [
            'tab' => 'lang:system::lang.themes.text_tab_meta',
            'label' => 'lang:system::lang.themes.label_layout',
            'type' => 'text',
        ],
    ],
];

return $config;