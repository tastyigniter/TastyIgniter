<?php
$config['list']['filter'] = [
    'search' => [
        'prompt' => 'lang:admin::lang.categories.text_filter_search',
        'mode' => 'all' // or any, exact
    ],
    'scopes' => [
        'location' => [
            'label' => 'lang:admin::lang.text_filter_location',
            'type' => 'select',
            'scope' => 'whereHasLocation',
            'modelClass' => 'Admin\Models\Locations_model',
            'nameFrom' => 'location_name',
        ],
        'status' => [
            'label' => 'lang:admin::lang.categories.text_filter_status',
            'type' => 'switch', // checkbox, switch, date, daterange
            'conditions' => 'status = :filtered',
        ],
    ],
];

$config['list']['toolbar'] = [
    'buttons' => [
        'create' => ['label' => 'lang:admin::lang.button_new', 'class' => 'btn btn-primary', 'href' => 'categories/create'],
        'delete' => ['label' => 'lang:admin::lang.button_delete', 'class' => 'btn btn-danger', 'data-request-form' => '#list-form', 'data-request' => 'onDelete', 'data-request-data' => "_method:'DELETE'", 'data-request-confirm' => 'lang:admin::lang.alert_warning_confirm'],
        'filter' => ['label' => 'lang:admin::lang.button_icon_filter', 'class' => 'btn btn-default btn-filter', 'data-toggle' => 'list-filter', 'data-target' => '.list-filter'],
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
        'label' => 'lang:admin::lang.categories.column_name',
        'type' => 'text',
        'searchable' => TRUE,
    ],
    'parent_cat' => [
        'label' => 'lang:admin::lang.categories.column_parent',
        'type' => 'text',
        'relation' => 'parent_cat',
        'select' => 'name',
        'searchable' => TRUE,
    ],
    'locations' => [
        'label' => 'lang:admin::lang.column_location',
        'type' => 'text',
        'relation' => 'locations',
        'select' => 'location_name',
        'invisible' => TRUE,
    ],
    'priority' => [
        'label' => 'lang:admin::lang.categories.column_priority',
        'type' => 'text',
        'searchable' => TRUE,
    ],
    'status' => [
        'label' => 'lang:admin::lang.categories.column_status',
        'type' => 'switch',
    ],
    'category_id' => [
        'label' => 'lang:admin::lang.column_id',
        'invisible' => TRUE,
    ],

];

$config['form']['toolbar'] = [
    'buttons' => [
        'save' => [
            'label' => 'lang:admin::lang.button_save',
            'context' => ['create', 'edit'],
            'class' => 'btn btn-primary',
            'data-request-submit' => 'true',
            'data-request' => 'onSave',
        ],
        'saveClose' => [
            'label' => 'lang:admin::lang.button_save_close',
            'context' => ['create', 'edit'],
            'class' => 'btn btn-default',
            'data-request' => 'onSave',
            'data-request-submit' => 'true',
            'data-request-data' => 'close:1',
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
        'label' => 'lang:admin::lang.categories.label_name',
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
        'label' => 'lang:admin::lang.categories.label_description',
        'type' => 'textarea',
        'span' => 'left',
        'attributes' => [
            'rows' => 5,
        ],
    ],
    'thumb' => [
        'label' => 'lang:admin::lang.categories.label_image',
        'type' => 'mediafinder',
        'useAttachment' => TRUE,
        'span' => 'right',
        'comment' => 'lang:admin::lang.categories.help_photo',
    ],
];

return $config;