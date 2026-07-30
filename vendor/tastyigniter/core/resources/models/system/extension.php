<?php

$config['list']['filter'] = [
    'search' => [
        'prompt' => 'igniter::system.extensions.text_filter_search',
        'mode' => 'all',
    ],
];

$config['list']['toolbar'] = [
    'buttons' => [
        'browse' => [
            'label' => 'igniter::system.extensions.button_browse',
            'class' => 'btn btn-primary',
            'href' => 'https://tastyigniter.com/marketplace/extensions',
            'target' => '_blank',
        ],
        'check' => [
            'label' => 'igniter::system.updates.button_check',
            'class' => 'btn btn-success',
            'href' => 'updates',
        ],
    ],
];

$config['list']['columns'] = [
    'install' => [
        'type' => 'button',
        'iconCssClass' => 'fas fa-fw fa-check',
        'attributes' => [
            'class' => 'btn btn-light text-success mr-3 shadow-none',
            'data-request' => 'onInstall',
            'data-request-data' => 'code:\'{name}\'',
        ],
    ],
    'uninstall' => [
        'type' => 'button',
        'iconCssClass' => 'fas fa-fw fa-xmark',
        'attributes' => [
            'class' => 'btn btn-light text-danger mr-3 shadow-none',
            'data-request' => 'onUninstall',
            'data-request-data' => 'code:\'{name}\'',
        ],
    ],
    'delete' => [
        'type' => 'button',
        'iconCssClass' => 'fa fa-trash-o',
        'attributes' => [
            'class' => 'btn btn-light text-danger shadow-none',
            'href' => 'extensions/delete/{name}',
        ],
    ],
    'name' => [
        'label' => 'lang:igniter::admin.label_name',
        'type' => 'partial',
        'path' => 'extensions/extension_card',
        'searchable' => true,
    ],
];

$config['form']['toolbar'] = [
    'buttons' => [
        'save' => [
            'label' => 'lang:igniter::admin.button_save',
            'class' => 'btn btn-primary',
            'data-request-submit' => 'true',
            'data-request' => 'onSave',
            'data-progress-indicator' => 'igniter::admin.text_saving',
        ],
    ],
];

return $config;
