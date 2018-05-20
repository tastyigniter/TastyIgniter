<?php
$config['list']['filter'] = [
    'search' => [
        'prompt' => 'lang:admin::banners.text_filter_search',
        'mode'   => 'all' // or any, exact
    ],
    'scopes' => [
        'status' => [
            'label'      => 'lang:admin::banners.text_filter_status',
            'type'       => 'switch',
            'conditions' => 'status = :filtered',
        ],
    ],
];

$config['list']['toolbar'] = [
    'buttons' => [
        'create' => [
            'label' => 'lang:admin::default.button_new',
            'class' => 'btn btn-primary',
            'href'  => 'banners/create',
        ],
        'delete' => [
            'label'                => 'lang:admin::default.button_delete',
            'class'                => 'btn btn-danger',
            'data-request-form'    => '#list-form',
            'data-request-handler' => 'onDelete',
            'data-request-confirm' => 'lang:admin::default.alert_warning_confirm',
        ],
        'filter' => [
            'label'       => 'lang:admin::default.button_icon_filter',
            'class'       => 'btn btn-default btn-filter',
            'data-toggle' => 'list-filter',
            'data-target' => '.list-filter',
        ],
    ],
];

$config['list']['columns'] = [
    'edit'       => [
        'type'         => 'button',
        'iconCssClass' => 'fa fa-pencil',
        'attributes'   => [
            'class' => 'btn btn-edit',
            'href'  => 'banners/edit/{banner_id}',
        ],
    ],
    'name'       => [
        'label'      => 'lang:admin::banners.column_name',
        'type'       => 'text',
        'searchable' => TRUE,
    ],
    'type_label' => [
        'label' => 'lang:admin::banners.column_type',
        'type'  => 'text',
    ],
    'status'     => [
        'label'      => 'lang:admin::banners.column_status',
        'type'       => 'switch',
        'searchable' => TRUE,
    ],
    'banner_id'  => [
        'label'     => 'lang:admin::default.column_id',
        'invisible' => TRUE,
    ],

];

$config['form']['toolbar'] = [
    'buttons' => [
        'save'      => [
            'label'        => 'lang:admin::default.button_save',
            'context'      => ['create', 'edit'],
            'class'        => 'btn btn-primary',
            'data-request' => 'onSave',
        ],
        'saveClose' => [
            'label'             => 'lang:admin::default.button_save_close',
            'context'           => ['create', 'edit'],
            'class'             => 'btn btn-default',
            'data-request'      => 'onSave',
            'data-request-data' => 'close:1',
        ],
        'delete'    => [
            'label'                => 'lang:admin::default.button_icon_delete',
            'context'              => ['edit'],
            'class'                => 'btn btn-danger',
            'data-request'         => 'onDelete',
            'data-request-confirm' => 'lang:admin::default.alert_warning_confirm',
        ],
        'back'      => [
            'label' => 'lang:admin::default.button_icon_back',
            'class' => 'btn btn-default',
            'href'  => 'banners',
        ],
    ],
];

$config['form']['fields'] = [
    'name'        => [
        'label' => 'lang:admin::banners.label_name',
        'type'  => 'text',
    ],
    'type'        => [
        'label'   => 'lang:admin::banners.label_type',
        'type'    => 'radio',
        'default' => 'image',
        'options' => [
            'image'  => 'lang:admin::banners.text_image',
            'custom' => 'lang:admin::banners.text_custom',
        ],
    ],
    'image_code'  => [
        'label'        => 'lang:admin::banners.label_image',
        'type'         => 'mediafinder',
        'mode'         => 'grid',
        'commentAbove' => 'lang:admin::banners.help_image',
        'isMulti'      => TRUE,
        'trigger'      => [
            'action'    => 'hide',
            'field'     => 'type',
            'condition' => 'value[custom]',
        ],
    ],
    'custom_code' => [
        'label'   => 'lang:admin::banners.label_custom_code',
        'type'    => 'textarea',
        'trigger' => [
            'action'    => 'show',
            'field'     => 'type',
            'condition' => 'value[custom]',
        ],
    ],
    'alt_text'    => [
        'label' => 'lang:admin::banners.label_alt_text',
        'type'  => 'text',
    ],
    'click_url'   => [
        'label'   => 'lang:admin::banners.label_click_url',
        'type'    => 'text',
        'comment' => 'lang:admin::banners.help_click_url',
    ],
    'language_id' => [
        'label'        => 'lang:admin::banners.label_language',
        'type'         => 'relation',
        'relationFrom' => 'language',
        'placeholder'  => 'lang:admin::default.text_please_select',
    ],
    'status'      => [
        'label'   => 'lang:admin::default.label_status',
        'type'    => 'switch',
        'default' => TRUE,
    ],
];

return $config;