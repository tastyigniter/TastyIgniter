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
        'upload' => ['label' => 'lang:system::lang.extensions.button_new', 'class' => 'btn btn-primary', 'href' => 'extensions/upload'],
        'browse' => ['label' => 'lang:system::lang.extensions.button_browse', 'class' => 'btn btn-default', 'href' => 'updates/browse/extensions'],
        'check' => ['label' => 'lang:system::lang.extensions.button_check', 'class' => 'btn btn-success', 'href' => 'updates'],
        'filter' => ['label' => 'lang:admin::lang.button_icon_filter', 'class' => 'btn btn-default btn-filter', 'data-toggle' => 'list-filter', 'data-target' => '.list-filter'],
        'setting' => ['label' => 'lang:system::lang.extensions.button_settings', 'class' => 'btn btn-default pull-right', 'href' => 'settings'],
        'payment' => ['label' => 'lang:system::lang.extensions.button_payments', 'class' => 'btn btn-default pull-right', 'href' => 'payments'],
    ],
];

$config['list']['columns'] = [
    'install' => [
        'type' => 'button',
        'iconCssClass' => 'fa fa-play',
        'attributes' => [
            'class' => 'btn btn-outline-success',
            'data-request' => 'onInstall',
            'data-request-form' => '#list-form',
            'data-request-data' => 'code:\'{name}\'',
        ],
    ],
    'uninstall' => [
        'type' => 'button',
        'iconCssClass' => 'fa fa-stop',
        'attributes' => [
            'class' => 'btn btn-outline-default',
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
    'icon' => [
        'label' => 'lang:system::lang.extensions.column_icon',
        'cssClass' => 'list-action text-center',
        'type' => 'partial',
        'path' => 'lists/extension_icon',
        'sortable' => FALSE,
    ],
    'title' => [
        'label' => 'lang:system::lang.extensions.column_name',
        'type' => 'partial',
        'path' => 'lists/extension_card',
        'searchable' => TRUE,
    ],
    'version' => [
        'label' => 'lang:system::lang.extensions.column_version',
        'cssClass' => 'text-right',
        'searchable' => TRUE,
    ],
];

$config['form']['toolbar'] = [
    'buttons' => [
        'back' => ['label' => 'lang:admin::lang.button_icon_back', 'class' => 'btn btn-default', 'href' => 'settings'],
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

return $config;