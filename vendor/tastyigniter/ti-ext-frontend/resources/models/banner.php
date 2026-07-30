<?php

$config['list']['filter'] = [
    'search' => [
        'prompt' => 'lang:igniter.frontend::default.banners.text_filter_search',
        'mode' => 'all', // or any, exact
    ],
    'scopes' => [
        'status' => [
            'label' => 'lang:admin::lang.text_filter_status',
            'type' => 'switch',
            'conditions' => 'status = :filtered',
        ],
    ],
];

$config['list']['toolbar'] = [
    'buttons' => [
        'create' => [
            'label' => 'lang:admin::lang.button_new',
            'class' => 'btn btn-primary',
            'href' => 'igniter/frontend/banners/create',
        ],
        'sliders' => [
            'label' => lang('igniter.frontend::default.slider.text_title'),
            'class' => 'btn btn-default',
            'href' => 'igniter/frontend/sliders',
            'permission' => 'Igniter.FrontEnd.ManageSlideshow',
        ],
    ],
];

$config['list']['bulkActions'] = [
    'status' => [
        'label' => 'lang:admin::lang.list.actions.label_status',
        'type' => 'dropdown',
        'class' => 'btn btn-light',
        'statusColumn' => 'status',
        'menuItems' => [
            'enable' => [
                'label' => 'lang:admin::lang.list.actions.label_enable',
                'type' => 'button',
                'class' => 'dropdown-item',
            ],
            'disable' => [
                'label' => 'lang:admin::lang.list.actions.label_disable',
                'type' => 'button',
                'class' => 'dropdown-item text-danger',
            ],
        ],
    ],
    'delete' => [
        'label' => 'lang:admin::lang.button_delete',
        'class' => 'btn btn-light text-danger',
        'data-request-confirm' => 'lang:admin::lang.alert_warning_confirm',
    ],
];

$config['list']['columns'] = [
    'edit' => [
        'type' => 'button',
        'iconCssClass' => 'fa fa-pencil',
        'attributes' => [
            'class' => 'btn btn-edit',
            'href' => 'igniter/frontend/banners/edit/{banner_id}',
        ],
    ],
    'name' => [
        'label' => 'lang:admin::lang.label_name',
        'type' => 'text',
        'searchable' => true,
    ],
    'code' => [
        'label' => 'lang:admin::lang.label_code',
        'type' => 'text',
        'searchable' => true,
    ],
    'type_label' => [
        'label' => 'lang:admin::lang.label_type',
        'type' => 'text',
    ],
    'status' => [
        'label' => 'lang:igniter.frontend::default.banners.column_status',
        'type' => 'switch',
        'searchable' => true,
    ],
    'banner_id' => [
        'label' => 'lang:admin::lang.column_id',
        'invisible' => true,
    ],

];

$config['form']['toolbar'] = [
    'buttons' => [
        'save' => [
            'label' => 'lang:admin::lang.button_save',
            'context' => ['create', 'edit'],
            'partial' => 'form/toolbar_save_button',
            'class' => 'btn btn-primary',
            'data-request' => 'onSave',
            'data-progress-indicator' => 'admin::lang.text_saving',
        ],
        'delete' => [
            'label' => 'lang:admin::lang.button_icon_delete',
            'context' => ['edit'],
            'class' => 'btn btn-danger',
            'data-request' => 'onDelete',
            'data-request-submit' => 'true',
            'data-request-confirm' => 'lang:admin::lang.alert_warning_confirm',
        ],
    ],
];

$config['form']['fields'] = [
    'name' => [
        'label' => 'lang:admin::lang.label_name',
        'type' => 'text',
        'span' => 'left',
    ],
    'code' => [
        'label' => 'lang:admin::lang.label_code',
        'type' => 'text',
        'span' => 'right',
        'cssClass' => 'flex-width',
    ],
    'status' => [
        'label' => 'lang:admin::lang.label_status',
        'type' => 'switch',
        'span' => 'right',
        'cssClass' => 'flex-width',
        'default' => true,
    ],
    'language_id' => [
        'label' => 'lang:igniter.frontend::default.banners.label_language',
        'type' => 'relation',
        'span' => 'left',
        'relationFrom' => 'language',
        'placeholder' => 'lang:admin::lang.text_please_select',
    ],
    'type' => [
        'label' => 'lang:igniter.frontend::default.banners.label_type',
        'type' => 'radiotoggle',
        'span' => 'right',
        'default' => 'image',
        'context' => ['edit', 'preview'],
        'options' => [
            'image' => 'lang:igniter.frontend::default.banners.text_image',
            'custom' => 'lang:igniter.frontend::default.banners.text_custom',
        ],
    ],
    'image_code' => [
        'label' => 'lang:igniter.frontend::default.banners.label_image',
        'type' => 'mediafinder',
        'mode' => 'grid',
        'commentAbove' => 'lang:igniter.frontend::default.banners.help_image',
        'isMulti' => true,
        'context' => ['edit', 'preview'],
        'trigger' => [
            'action' => 'hide',
            'field' => 'type',
            'condition' => 'value[custom]',
        ],
    ],
    'custom_code' => [
        'label' => 'lang:igniter.frontend::default.banners.label_custom_code',
        'type' => 'codeeditor',
        'context' => ['edit', 'preview'],
        'trigger' => [
            'action' => 'show',
            'field' => 'type',
            'condition' => 'value[custom]',
        ],
    ],
    'alt_text' => [
        'label' => 'lang:igniter.frontend::default.banners.label_alt_text',
        'type' => 'text',
        'context' => ['edit', 'preview'],
        'trigger' => [
            'action' => 'hide',
            'field' => 'type',
            'condition' => 'value[custom]',
        ],
    ],
    'click_url' => [
        'label' => 'lang:igniter.frontend::default.banners.label_click_url',
        'type' => 'url',
        'comment' => 'lang:igniter.frontend::default.banners.help_click_url',
        'context' => ['edit', 'preview'],
        'trigger' => [
            'action' => 'hide',
            'field' => 'type',
            'condition' => 'value[custom]',
        ],
    ],
];

return $config;
