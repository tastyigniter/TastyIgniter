<?php
$config['list']['filter'] = [
    'search' => [
        'prompt' => 'lang:admin::layouts.text_filter_search',
        'mode'   => 'all' // or any, exact
    ],
];

$config['list']['toolbar'] = [
    'buttons' => [
        'create' => ['label' => 'lang:admin::default.button_new', 'class' => 'btn btn-primary', 'href' => 'layouts/create'],
        'delete' => ['label' => 'lang:admin::default.button_delete', 'class' => 'btn btn-danger', 'data-request-form' => '#list-form', 'data-request' => 'onDelete', 'data-request-data' => "_method:'DELETE'", 'data-request-confirm' => 'lang:admin::default.alert_warning_confirm'],
        'filter' => ['label' => 'lang:admin::default.button_icon_filter', 'class' => 'btn btn-default btn-filter', 'data-toggle' => 'list-filter', 'data-target' => '.panel-filter .panel-body'],
    ],
];

$config['list']['columns'] = [
    'edit'              => [
        'type'         => 'button',
        'iconCssClass' => 'fa fa-pencil',
        'attributes'   => [
            'class' => 'btn btn-edit',
            'href'  => 'layouts/edit/{layout_id}',
        ],
    ],
    'name'              => [
        'label'      => 'lang:admin::layouts.column_name',
        'type'       => 'text',
        'searchable' => TRUE,
    ],
    'active_components' => [
        'label' => 'lang:admin::layouts.column_active_components',
        'type'  => 'partial',
        'path'  => 'layouts/active_components',
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
        'delete'    => [
            'label'                => 'lang:admin::default.button_icon_delete', 'class' => 'btn btn-danger',
            'data-request-form'    => '#edit-form', 'data-request' => 'onDelete', 'data-request-data' => "_method:'DELETE'",
            'data-request-confirm' => 'lang:admin::default.alert_warning_confirm',
        ],
        'back'      => ['label' => 'lang:admin::default.button_icon_back', 'class' => 'btn btn-default', 'href' => 'layouts'],
    ],
];

$config['form']['fields'] = [
    'name' => [
        'label' => 'lang:admin::layouts.label_name',
        'type'  => 'text',
    ],
];
$config['form']['tabs']['fields'] = [
    'components' => [
        'tab'  => 'lang:admin::layouts.text_tab_general',
        'type' => 'components',
        'form' => [
            'fields' => [
                'layout_module_id'             => ['type' => 'hidden',],
                'layout_id'                    => ['type' => 'hidden',],
                'module_code'                  => ['type' => 'hidden',],
                'partial'                      => ['type' => 'hidden',],
                'alias'                        => [
                    'label' => 'lang:admin::layouts.label_module_alias',
                    'type'  => 'text',
                    'attributes'  => [
                        'data-toggle' => 'disabled'
                    ],
                ],
                'options[title]'               => [
                    'label' => 'lang:admin::layouts.label_module_title',
                    'type'  => 'text',
                ],
                'options[fixed]'               => [
                    'label' => 'lang:admin::layouts.label_module_fixed',
                    'type'  => 'switch',
                    'span'  => 'left',
                ],
                'status'                       => [
                    'label' => 'lang:admin::layouts.label_module_status',
                    'type'  => 'switch',
                    'span'  => 'right',
                    'default'  => TRUE,
                ],
                'options[fixed_top_offset]'    => [
                    'label'   => 'lang:admin::layouts.label_fixed_top',
                    'type'    => 'number',
                    'span'    => 'left',
                    'trigger' => [
                        'action'    => 'show',
                        'field'     => 'options[fixed]',
                        'condition' => 'checked',
                    ],
                ],
                'options[fixed_bottom_offset]' => [
                    'label'   => 'lang:admin::layouts.label_fixed_bottom',
                    'type'    => 'number',
                    'span'    => 'right',
                    'trigger' => [
                        'action'    => 'show',
                        'field'     => 'options[fixed]',
                        'condition' => 'checked',
                    ],
                ],
            ],
        ],
    ],
    'routes'     => [
        'label' => 'lang:admin::layouts.label_route',
        'tab'   => 'lang:admin::layouts.text_tab_routes',
        'type'  => 'repeater',
        'form'  => [
            'fields' => [
                'layout_route_id' => [
                    'type' => 'hidden',
                ],
                'layout_id'       => [
                    'type' => 'hidden',
                ],
                'uri_route'       => [
                    'label' => 'lang:admin::layouts.column_uri_route',
                    'type'  => 'text',
                ],
            ],
        ],
    ],
];

return $config;