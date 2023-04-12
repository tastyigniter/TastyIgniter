<?php

$config['list']['filter'] = [
    'search' => [
        'prompt' => 'lang:admin::lang.locations.text_filter_search',
        'mode' => 'all',
    ],
    'scopes' => [
        'status' => [
            'label' => 'lang:admin::lang.text_filter_status',
            'type' => 'switch',
            'conditions' => 'location_status = :filtered',
        ],
    ],
];

$config['list']['toolbar'] = [
    'buttons' => [
        'create' => [
            'label' => 'lang:admin::lang.button_new',
            'class' => 'btn btn-primary',
            'href' => 'locations/create',
        ],
    ],
];

$config['list']['bulkActions'] = [
    'status' => [
        'label' => 'lang:admin::lang.list.actions.label_status',
        'type' => 'dropdown',
        'class' => 'btn btn-light',
        'statusColumn' => 'location_status',
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
            'href' => 'locations/edit/{location_id}',
        ],
    ],
    'default' => [
        'type' => 'button',
        'iconCssClass' => 'fa fa-star-o',
        'attributes' => [
            'class' => 'btn btn-outline-warning bg-transparent',
            'data-request' => 'onSetDefault',
            'data-request-data' => 'default:{location_id}',
        ],
    ],
    'location_name' => [
        'label' => 'lang:admin::lang.label_name',
        'type' => 'text',
        'searchable' => true,
    ],
    'location_city' => [
        'label' => 'lang:admin::lang.locations.column_city',
        'type' => 'text',
        'searchable' => true,
    ],
    'location_state' => [
        'label' => 'lang:admin::lang.locations.column_state',
        'type' => 'text',
        'searchable' => true,
    ],
    'location_postcode' => [
        'label' => 'lang:admin::lang.locations.column_postcode',
        'type' => 'text',
        'searchable' => true,
    ],
    'location_telephone' => [
        'label' => 'lang:admin::lang.locations.column_telephone',
        'type' => 'text',
        'searchable' => true,
    ],
    'location_status' => [
        'label' => 'lang:admin::lang.label_status',
        'type' => 'switch',
    ],
    'location_id' => [
        'label' => 'lang:admin::lang.column_id',
        'invisible' => true,
    ],
    'created_at' => [
        'label' => 'lang:admin::lang.column_date_added',
        'invisible' => true,
        'type' => 'datetime',
    ],
    'updated_at' => [
        'label' => 'lang:admin::lang.column_date_updated',
        'invisible' => true,
        'type' => 'datetime',
    ],
];

$config['form']['toolbar'] = [
    'buttons' => [
        'back' => [
            'label' => 'lang:admin::lang.button_icon_back',
            'class' => 'btn btn-outline-secondary',
            'href' => 'locations',
        ],
        'save' => [
            'label' => 'lang:admin::lang.button_save',
            'context' => ['create', 'edit', 'settings'],
            'partial' => 'form/toolbar_save_button',
            'saveActions' => ['continue', 'close'],
            'class' => 'btn btn-primary',
            'data-request' => 'onSave',
            'data-progress-indicator' => 'admin::lang.text_saving',
        ],
        'delete' => [
            'label' => 'lang:admin::lang.button_icon_delete',
            'class' => 'btn btn-danger',
            'data-request' => 'onDelete',
            'data-request-data' => "_method:'DELETE'",
            'data-request-confirm' => 'lang:admin::lang.alert_warning_confirm',
            'data-progress-indicator' => 'admin::lang.text_deleting',
            'context' => ['edit'],
        ],
    ],
];

$config['form']['tabs'] = [
    'defaultTab' => 'lang:admin::lang.locations.text_tab_general',
    'fields' => [
        'location_name' => [
            'label' => 'lang:admin::lang.label_name',
            'type' => 'text',
            'span' => 'left',
        ],
        'permalink_slug' => [
            'label' => 'lang:admin::lang.locations.label_permalink_slug',
            'type' => 'permalink',
            'span' => 'right',
            'comment' => 'lang:admin::lang.help_permalink',
        ],
        'location_email' => [
            'label' => 'lang:admin::lang.label_email',
            'type' => 'text',
            'span' => 'left',
        ],
        'location_telephone' => [
            'label' => 'lang:admin::lang.locations.label_telephone',
            'type' => 'text',
            'span' => 'right',
        ],
        'location_address_1' => [
            'label' => 'lang:admin::lang.locations.label_address_1',
            'type' => 'text',
            'span' => 'left',
        ],
        'location_address_2' => [
            'label' => 'lang:admin::lang.locations.label_address_2',
            'type' => 'text',
            'span' => 'right',
        ],
        'location_city' => [
            'label' => 'lang:admin::lang.locations.label_city',
            'type' => 'text',
            'span' => 'left',
        ],
        'location_state' => [
            'label' => 'lang:admin::lang.locations.label_state',
            'type' => 'text',
            'span' => 'right',
        ],
        'location_postcode' => [
            'label' => 'lang:admin::lang.locations.label_postcode',
            'type' => 'text',
            'span' => 'left',
        ],
        'location_country_id' => [
            'label' => 'lang:admin::lang.locations.label_country',
            'type' => 'relation',
            'relationFrom' => 'country',
            'nameFrom' => 'country_name',
            'default' => setting('country_id'),
            'span' => 'right',
        ],
        'thumb' => [
            'label' => 'lang:admin::lang.locations.label_image',
            'type' => 'mediafinder',
            'span' => 'left',
            'mode' => 'inline',
            'useAttachment' => true,
            'comment' => 'lang:admin::lang.locations.help_image',
        ],
        'options[auto_lat_lng]' => [
            'label' => 'lang:admin::lang.locations.label_auto_lat_lng',
            'type' => 'switch',
            'default' => true,
            'onText' => 'lang:admin::lang.text_yes',
            'offText' => 'lang:admin::lang.text_no',
            'span' => 'right',
            'cssClass' => 'flex-width',
        ],
        'location_status' => [
            'label' => 'lang:admin::lang.label_status',
            'type' => 'switch',
            'default' => 1,
            'span' => 'right',
            'cssClass' => 'flex-width',
        ],
        'location_lat' => [
            'label' => 'lang:admin::lang.locations.label_latitude',
            'type' => 'text',
            'span' => 'left',
            'trigger' => [
                'action' => 'hide',
                'field' => 'options[auto_lat_lng]',
                'condition' => 'checked',
            ],
        ],
        'location_lng' => [
            'label' => 'lang:admin::lang.locations.label_longitude',
            'type' => 'text',
            'span' => 'right',
            'trigger' => [
                'action' => 'hide',
                'field' => 'options[auto_lat_lng]',
                'condition' => 'checked',
            ],
        ],
        'description' => [
            'label' => 'lang:admin::lang.label_description',
            'type' => 'richeditor',
            'size' => 'small',
        ],

        '_working_hours' => [
            'tab' => 'lang:admin::lang.locations.text_tab_schedules',
            'type' => 'scheduleeditor',
            'context' => ['edit'],
            'form' => 'working_hours_model',
            'request' => 'Admin\Requests\WorkingHour',
        ],

        'delivery_areas' => [
            'tab' => 'lang:admin::lang.locations.text_tab_delivery',
            'label' => 'lang:admin::lang.locations.text_delivery_area',
            'type' => 'maparea',
            'context' => ['edit'],
            'form' => 'location_areas_model',
            'request' => 'Admin\Requests\LocationArea',
            'commentAbove' => 'lang:admin::lang.locations.help_delivery_areas',
        ],

        'options[gallery][title]' => [
            'label' => 'lang:admin::lang.locations.label_gallery_title',
            'tab' => 'lang:admin::lang.locations.text_tab_gallery',
            'type' => 'text',
        ],
        'options[gallery][description]' => [
            'label' => 'lang:admin::lang.label_description',
            'tab' => 'lang:admin::lang.locations.text_tab_gallery',
            'type' => 'textarea',
        ],
        'gallery' => [
            'label' => 'lang:admin::lang.locations.label_gallery_add_image',
            'tab' => 'lang:admin::lang.locations.text_tab_gallery',
            'type' => 'mediafinder',
            'isMulti' => true,
            'useAttachment' => true,
        ],
    ],
];

return $config;
