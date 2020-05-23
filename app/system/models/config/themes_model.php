<?php
$config['list']['toolbar'] = [
    'buttons' => [
        'browse' => [
            'label' => 'lang:system::lang.themes.button_browse',
            'class' => 'btn btn-primary',
            'href' => 'updates/browse/themes',
        ],
        'check' => [
            'label' => 'lang:system::lang.themes.button_check',
            'class' => 'btn btn-success',
            'href' => 'updates',
        ],
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
        'iconCssClass' => 'fa fa-file',
        'attributes' => [
            'class' => 'btn btn-outline-default',
            'href' => 'themes/source/{code}',
        ],
    ],
    'default' => [
        'type' => 'button',
        'iconCssClass' => 'fa fa-star-o',
        'attributes' => [
            'class' => 'btn btn-outline-warning bg-transparent',
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
        'label' => 'lang:admin::lang.label_name',
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
    ],
];

$config['form']['fields'] = [
    'name' => [
        'label' => 'lang:admin::lang.label_name',
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
    'template' => [
        'label' => 'lang:system::lang.themes.label_template',
        'type' => 'templateeditor',
        'form' => 'menu_options_model',
        'context' => ['source'],
    ],
];

$config['form']['tabs'] = [
    'cssClass' => 'theme-customizer',
    'fields' => [],
];

return $config;