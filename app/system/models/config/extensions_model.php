<?php
$config['list']['filter'] = [
    'search' => [
        'prompt' => 'lang:system::extensions.text_filter_search',
        'mode'   => 'all',
    ],
    'scopes' => [
        'status' => [
            'label'      => 'lang:system::extensions.text_filter_status',
            'type'       => 'switch',
            'conditions' => 'status = :filtered',
        ],
    ],
];

$config['list']['toolbar'] = [
    'buttons' => [
        'upload'  => ['label' => 'lang:admin::default.button_new', 'class' => 'btn btn-primary', 'href' => 'extensions/upload'],
        'setting' => ['label' => 'lang:system::extensions.button_settings', 'class' => 'btn btn-default', 'href' => 'settings'],
        'payment' => ['label' => 'lang:system::extensions.button_payments', 'class' => 'btn btn-default', 'href' => 'payments'],
        'filter'  => ['label' => 'lang:admin::default.button_icon_filter', 'class' => 'btn btn-default btn-filter', 'data-toggle' => 'list-filter', 'data-target' => '.panel-filter .panel-body'],
        'check'   => ['label' => 'lang:system::extensions.button_check', 'class' => 'btn btn-success pull-right', 'href' => 'updates'],
        'browse'  => ['label' => 'lang:system::extensions.button_browse', 'class' => 'btn btn-default pull-right', 'href' => 'updates/browse/extensions'],
    ],
];

$config['list']['columns'] = [
    'install'   => [
        'type'         => 'button',
        'iconCssClass' => 'fa fa-play',
        'attributes'   => [
            'class'             => 'btn btn-outline btn-success',
            'data-request'      => 'onInstall',
            'data-request-form' => '#list-form',
            'data-request-data' => 'code:\'{name}\'',
        ],
    ],
    'uninstall' => [
        'type'         => 'button',
        'iconCssClass' => 'fa fa-stop text-muted',
        'attributes'   => [
            'class'             => 'btn btn-default',
            'data-request'      => 'onUninstall',
            'data-request-form' => '#list-form',
            'data-request-data' => 'code:\'{name}\'',
        ],
    ],
    'delete'    => [
        'type'         => 'button',
        'iconCssClass' => 'fa fa-trash-o',
        'attributes'   => [
            'class' => 'btn btn-outline btn-danger',
            'href'  => 'extensions/delete/{name}',
        ],
    ],
    'icon'      => [
        'label'    => 'lang:system::extensions.column_icon',
        'cssClass' => 'list-action text-center',
        'type'     => 'partial',
        'path'     => 'extensions/extension_icon',
        'sortable' => FALSE,
    ],
    'title'     => [
        'label'      => 'lang:system::extensions.column_name',
        'type'       => 'partial',
        'path'       => 'extensions/extension_card',
        'searchable' => TRUE,
    ],
    'version'   => [
        'label'      => 'lang:system::extensions.column_version',
        'cssClass'   => 'text-right',
        'searchable' => TRUE,
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
        'back'      => ['label' => 'lang:admin::default.button_icon_back', 'class' => 'btn btn-default', 'href' => 'settings'],
    ],
];

return $config;