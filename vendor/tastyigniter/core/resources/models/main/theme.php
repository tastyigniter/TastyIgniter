<?php

$config['list']['toolbar'] = [
    'buttons' => [
        'browse' => [
            'label' => 'lang:igniter::system.themes.button_browse',
            'class' => 'btn btn-primary',
            'href' => 'https://tastyigniter.com/marketplace/themes',
            'target' => '_blank',
        ],
        'check' => [
            'label' => 'lang:igniter::system.updates.button_check',
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
            'class' => 'btn btn-light mr-2 shadow-none',
            'href' => 'themes/edit/{code}',
        ],
    ],
    'source' => [
        'type' => 'button',
        'iconCssClass' => 'fa fa-file',
        'attributes' => [
            'class' => 'btn btn-light mr-2 shadow-none',
            'href' => 'themes/source/{code}',
        ],
    ],
    'default' => [
        'type' => 'button',
        'iconCssClass' => 'fa fa-star-o',
        'attributes' => [
            'class' => 'btn btn-light text-warning mr-2 shadow-none',
            'title' => 'lang:igniter::system.themes.text_set_default',
            'data-request' => 'onSetDefault',
            'data-request-form' => '#lists-list-form',
            'data-request-data' => 'code:\'{code}\'',
        ],
    ],
    'delete' => [
        'type' => 'button',
        'iconCssClass' => 'fa fa-trash-o',
        'attributes' => [
            'class' => 'btn btn-light text-danger shadow-none',
            'href' => 'themes/delete/{code}',
        ],
    ],
    'name' => [
        'label' => 'lang:igniter::admin.label_name',
        'type' => 'text',
        'searchable' => true,
    ],
    'theme_id' => [
        'label' => 'lang:igniter::admin.column_id',
        'invisible' => true,
    ],
    'created_at' => [
        'label' => 'lang:igniter::admin.column_date_added',
        'invisible' => true,
        'type' => 'datetime',
    ],
    'updated_at' => [
        'label' => 'lang:igniter::admin.column_date_updated',
        'invisible' => true,
        'type' => 'datetime',
    ],
];

$config['form']['toolbar'] = [
    'buttons' => [
        'save' => [
            'label' => 'lang:igniter::admin.button_save',
            'class' => 'btn btn-primary',
            'data-request' => 'onSave',
            'data-progress-indicator' => 'igniter::admin.text_saving',
        ],
        'reset' => [
            'label' => 'lang:igniter::system.themes.button_reset_to_default',
            'class' => 'btn btn-default',
            'context' => 'edit',
            'data-request' => 'onReset',
            'data-request-confirm' => 'lang:igniter::admin.alert_warning_confirm',
            'data-progress-indicator' => 'igniter::admin.text_saving',
        ],
    ],
];

$config['form']['fields'] = [
    'name' => [
        'label' => 'lang:igniter::admin.label_name',
        'type' => 'text',
        'span' => 'left',
        'disabled' => true,
    ],
    'code' => [
        'label' => 'lang:igniter::system.themes.label_code',
        'type' => 'text',
        'span' => 'right',
        'cssClass' => 'flex-width',
        'disabled' => true,
    ],
    'is_default' => [
        'label' => 'lang:igniter::system.themes.label_is_active',
        'type' => 'switch',
        'span' => 'right',
        'cssClass' => 'flex-width',
        'disabled' => true,
    ],
    'template' => [
        'label' => 'lang:igniter::system.themes.label_template',
        'type' => 'templateeditor',
        'context' => ['source'],
    ],
];

$config['form']['tabs'] = [
    'cssClass' => 'theme-customizer',
    'fields' => [],
];

return $config;
