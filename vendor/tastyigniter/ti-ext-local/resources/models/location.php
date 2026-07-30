<?php

$config['list']['filter'] = [
    'search' => [
        'prompt' => 'lang:igniter.local::default.text_filter_search',
        'mode' => 'all',
    ],
    'scopes' => [
        'status' => [
            'label' => 'lang:igniter::admin.text_filter_status',
            'type' => 'switch',
            'conditions' => 'location_status = :filtered',
        ],
    ],
];

$config['list']['toolbar'] = [
    'buttons' => [
        'create' => [
            'label' => 'lang:igniter::admin.button_new',
            'class' => 'btn btn-primary',
            'href' => 'locations/create',
        ],
    ],
];

$config['list']['bulkActions'] = [
    'status' => [
        'label' => 'lang:igniter::admin.list.actions.label_status',
        'type' => 'dropdown',
        'class' => 'btn btn-light',
        'statusColumn' => 'location_status',
        'menuItems' => [
            'enable' => [
                'label' => 'lang:igniter::admin.list.actions.label_enable',
                'type' => 'button',
                'class' => 'dropdown-item',
            ],
            'disable' => [
                'label' => 'lang:igniter::admin.list.actions.label_disable',
                'type' => 'button',
                'class' => 'dropdown-item text-danger',
            ],
        ],
    ],
    'delete' => [
        'label' => 'lang:igniter::admin.button_delete',
        'class' => 'btn btn-light text-danger',
        'data-request-confirm' => 'lang:igniter::admin.alert_warning_confirm',
    ],
];

$config['list']['columns'] = [
    'edit' => [
        'type' => 'button',
        'iconCssClass' => 'fa fa-pencil',
        'attributes' => [
            'class' => 'btn btn-edit',
            'href' => 'locations/edit/{location_id}',
        ],
    ],
    'settings' => [
        'type' => 'button',
        'iconCssClass' => 'fa fa-cog',
        'attributes' => [
            'class' => 'btn btn-edit',
            'href' => 'locations/settings/{location_id}',
        ],
    ],
    'default' => [
        'type' => 'button',
        'iconCssClass' => 'fa fa-star-o',
        'attributes' => [
            'class' => 'btn btn-light text-warning',
            'data-request' => 'onSetDefault',
            'data-request-data' => 'default:{location_id}',
        ],
    ],
    'location_name' => [
        'label' => 'lang:igniter::admin.label_name',
        'type' => 'text',
        'searchable' => true,
    ],
    'location_city' => [
        'label' => 'lang:igniter.local::default.column_city',
        'type' => 'text',
        'searchable' => true,
    ],
    'location_state' => [
        'label' => 'lang:igniter.local::default.column_state',
        'type' => 'text',
        'searchable' => true,
    ],
    'location_postcode' => [
        'label' => 'lang:igniter.local::default.column_postcode',
        'type' => 'text',
        'searchable' => true,
    ],
    'location_telephone' => [
        'label' => 'lang:igniter.local::default.column_telephone',
        'type' => 'text',
        'searchable' => true,
    ],
    'location_status' => [
        'label' => 'lang:igniter::admin.label_status',
        'type' => 'switch',
    ],
    'location_id' => [
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
            'context' => ['create', 'edit', 'settings'],
            'partial' => 'form/toolbar_save_button',
            'saveActions' => ['continue', 'close'],
            'class' => 'btn btn-primary',
            'data-request' => 'onSave',
            'data-progress-indicator' => 'igniter::admin.text_saving',
        ],
        'delete' => [
            'label' => 'lang:igniter::admin.button_icon_delete',
            'class' => 'btn btn-danger',
            'data-request' => 'onDelete',
            'data-request-data' => "_method:'DELETE'",
            'data-request-confirm' => 'lang:igniter::admin.alert_warning_confirm',
            'data-progress-indicator' => 'igniter::admin.text_deleting',
            'context' => ['edit'],
        ],
    ],
];

$config['form']['tabs'] = [
    'defaultTab' => 'lang:igniter.local::default.text_tab_general',
    'fields' => [
        'location_name' => [
            'label' => 'lang:igniter::admin.label_name',
            'type' => 'text',
            'span' => 'left',
        ],
        'permalink_slug' => [
            'label' => 'lang:igniter.local::default.label_permalink_slug',
            'type' => 'permalink',
            'span' => 'right',
            'comment' => 'lang:igniter::admin.help_permalink',
            'preset' => [
                'field' => 'location_name',
                'type' => 'slug',
            ],
        ],
        'location_email' => [
            'label' => 'lang:igniter::admin.label_email',
            'type' => 'text',
            'span' => 'left',
        ],
        'location_telephone' => [
            'label' => 'lang:igniter.local::default.label_telephone',
            'type' => 'text',
            'span' => 'right',
        ],
        'location_address_1' => [
            'label' => 'lang:igniter.local::default.label_address_1',
            'type' => 'text',
            'span' => 'left',
        ],
        'location_address_2' => [
            'label' => 'lang:igniter.local::default.label_address_2',
            'type' => 'text',
            'span' => 'right',
        ],
        'location_city' => [
            'label' => 'lang:igniter.local::default.label_city',
            'type' => 'text',
            'span' => 'left',
        ],
        'location_state' => [
            'label' => 'lang:igniter.local::default.label_state',
            'type' => 'text',
            'span' => 'right',
        ],
        'location_postcode' => [
            'label' => 'lang:igniter.local::default.label_postcode',
            'type' => 'text',
            'span' => 'left',
        ],
        'thumb' => [
            'label' => 'lang:igniter.local::default.label_image',
            'type' => 'mediafinder',
            'span' => 'left',
            'mode' => 'inline',
            'useAttachment' => true,
            'comment' => 'lang:igniter.local::default.help_image',
        ],
        'is_auto_lat_lng' => [
            'label' => 'lang:igniter.local::default.label_auto_lat_lng',
            'type' => 'switch',
            'default' => true,
            'onText' => 'lang:igniter::admin.text_yes',
            'offText' => 'lang:igniter::admin.text_no',
            'span' => 'left',
        ],
        'location_status' => [
            'label' => 'lang:igniter::admin.label_status',
            'type' => 'switch',
            'default' => 1,
            'span' => 'right',
            'cssClass' => 'flex-width',
        ],
        'is_default' => [
            'label' => 'lang:igniter::admin.text_is_default',
            'type' => 'switch',
            'default' => 1,
            'span' => 'right',
            'cssClass' => 'flex-width',
        ],
        'location_lat' => [
            'label' => 'lang:igniter.local::default.label_latitude',
            'type' => 'text',
            'span' => 'left',
            'trigger' => [
                'action' => 'hide',
                'field' => 'is_auto_lat_lng',
                'condition' => 'checked',
            ],
        ],
        'location_lng' => [
            'label' => 'lang:igniter.local::default.label_longitude',
            'type' => 'text',
            'span' => 'right',
            'trigger' => [
                'action' => 'hide',
                'field' => 'is_auto_lat_lng',
                'condition' => 'checked',
            ],
        ],
        'description' => [
            'label' => 'lang:igniter::admin.label_description',
            'type' => 'richeditor',
            'size' => 'small',
        ],
    ],
];

return $config;
