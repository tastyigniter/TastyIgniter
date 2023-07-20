<?php

$config['list']['filter'] = [
    'search' => [
        'prompt' => 'lang:admin::lang.categories.text_filter_search',
        'mode' => 'all',
    ],
    'scopes' => [
        'location' => [
            'label' => 'lang:admin::lang.text_filter_location',
            'type' => 'selectlist',
            'scope' => 'whereHasLocation',
            'modelClass' => 'Admin\Models\Locations_model',
            'nameFrom' => 'location_name',
            'locationAware' => true,
        ],
        'status' => [
            'label' => 'lang:admin::lang.text_filter_status',
            'type' => 'switch', // checkbox, switch, date, daterange
            'conditions' => 'status = :filtered',
        ],
    ],
];

$config['list']['toolbar'] = [
    'buttons' => [
        'create' => [
            'label' => 'lang:admin::lang.button_new',
            'class' => 'btn btn-primary',
            'href' => 'categories/create',
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
            'href' => 'categories/edit/{category_id}',
        ],
    ],
    'name' => [
        'label' => 'lang:admin::lang.label_name',
        'type' => 'text',
    ],
    'parent' => [
        'label' => 'lang:admin::lang.categories.column_parent',
        'type' => 'text',
        'relation' => 'parent_cat',
        'select' => 'name',
    ],
    'location_name' => [
        'label' => 'lang:admin::lang.column_location',
        'type' => 'text',
        'relation' => 'locations',
        'select' => 'location_name',
        'locationAware' => true,
        'invisible' => true,
    ],
    'priority' => [
        'label' => 'lang:admin::lang.categories.column_priority',
        'type' => 'text',
    ],
    'status' => [
        'label' => 'lang:admin::lang.label_status',
        'type' => 'switch',
    ],
    'category_id' => [
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
            'href' => 'categories',
        ],
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
            'data-request-confirm' => 'lang:admin::lang.alert_warning_confirm',
            'data-progress-indicator' => 'admin::lang.text_deleting',
        ],
    ],
];

$config['form']['fields'] = [
    'name' => [
        'label' => 'lang:admin::lang.label_name',
        'type' => 'text',
        'span' => 'left',
    ],
    'permalink_slug' => [
        'label' => 'lang:admin::lang.categories.label_permalink_slug',
        'type' => 'permalink',
        'comment' => 'lang:admin::lang.help_permalink',
        'span' => 'right',
    ],
    'parent_id' => [
        'label' => 'lang:admin::lang.categories.label_parent',
        'type' => 'relation',
        'span' => 'left',
        'relationFrom' => 'parent_cat',
        'placeholder' => 'lang:admin::lang.text_please_select',
    ],
    'locations' => [
        'label' => 'lang:admin::lang.label_location',
        'type' => 'relation',
        'span' => 'right',
        'valueFrom' => 'locations',
        'nameFrom' => 'location_name',
    ],
    'priority' => [
        'label' => 'lang:admin::lang.categories.label_priority',
        'type' => 'number',
        'span' => 'left',
    ],
    'status' => [
        'label' => 'lang:admin::lang.label_status',
        'type' => 'switch',
        'span' => 'right',
        'default' => 1,
    ],
    'description' => [
        'label' => 'lang:admin::lang.label_description',
        'type' => 'textarea',
        'span' => 'left',
        'attributes' => [
            'rows' => 5,
        ],
    ],
    'thumb' => [
        'label' => 'lang:admin::lang.categories.label_image',
        'type' => 'mediafinder',
        'useAttachment' => true,
        'span' => 'right',
        'comment' => 'lang:admin::lang.categories.help_photo',
    ],
];

return $config;
