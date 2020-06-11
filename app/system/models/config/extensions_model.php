<?php
$config['list']['filter'] = [
    'search' => [
        'prompt' => 'lang:system::lang.extensions.text_filter_search',
        'mode' => 'all',
    ],
    'scopes' => [
        'status' => [
            'label' => 'lang:system::lang.extensions.text_filter_status',
            'type' => 'switch',
            'conditions' => 'status = :filtered',
        ],
    ],
];

$config['list']['toolbar'] = [
    'buttons' => [
        'browse' => [
            'label' => 'lang:system::lang.extensions.button_browse',
            'class' => 'btn btn-primary',
            'href' => 'updates/browse/extensions',
        ],
        'check' => [
            'label' => 'lang:system::lang.extensions.button_check',
            'class' => 'btn btn-success',
            'href' => 'updates',
        ],
        'filter' => [
            'label' => 'lang:admin::lang.button_icon_filter',
            'class' => 'btn btn-default btn-filter',
            'data-toggle' => 'list-filter',
            'data-target' => '.list-filter',
        ],
        'setting' => [
            'label' => 'lang:system::lang.extensions.button_settings',
            'class' => 'btn btn-default pull-right',
            'href' => 'settings',
        ],
        'payment' => [
            'label' => 'lang:system::lang.extensions.button_payments',
            'class' => 'btn btn-default pull-right',
            'href' => 'payments',
        ],
    ],
];

$config['list']['columns'] = [
    'install' => [
        'type' => 'button',
        'iconCssClass' => 'fa fa-play',
        'attributes' => [
            'class' => 'btn btn-outline-success mr-3',
            'data-request' => 'onInstall',
            'data-request-form' => '#list-form',
            'data-request-data' => 'code:\'{name}\'',
        ],
    ],
    'uninstall' => [
        'type' => 'button',
        'iconCssClass' => 'fa fa-stop',
        'attributes' => [
            'class' => 'btn btn-outline-default mr-3',
            'data-request' => 'onUninstall',
            'data-request-form' => '#list-form',
            'data-request-data' => 'code:\'{name}\'',
        ],
    ],
    'delete' => [
        'type' => 'button',
        'iconCssClass' => 'fa fa-trash-o',
        'attributes' => [
            'class' => 'btn btn-outline-danger',
            'href' => 'extensions/delete/{name}',
        ],
    ],
    'name' => [
        'label' => 'lang:admin::lang.label_name',
        'type' => 'partial',
        'path' => 'lists/extension_card',
        'searchable' => TRUE,
    ],
];

$config['form']['toolbar'] = [
    'buttons' => [
        'back' => [
            'label' => 'lang:admin::lang.button_icon_back',
            'class' => 'btn btn-default',
            'href' => 'settings',
        ],
        'save' => [
            'label' => 'lang:admin::lang.button_save',
            'class' => 'btn btn-primary',
            'data-request' => 'onSave',
            'data-request-submit' => 'true',
            'data-progress-indicator' => 'admin::lang.text_saving',
        ],
        'saveClose' => [
            'label' => 'lang:admin::lang.button_save_close',
            'class' => 'btn btn-default',
            'data-request' => 'onSave',
            'data-request-submit' => 'true',
            'data-request-data' => 'close:1',
            'data-progress-indicator' => 'admin::lang.text_saving',
        ],
    ],
];

return $config;