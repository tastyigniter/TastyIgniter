<?php

$config['list']['filter'] = [
    'search' => [
        'prompt' => 'lang:igniter.local::default.reviews.text_filter_search',
        'mode' => 'all',
    ],
    'scopes' => [
        'status' => [
            'label' => 'lang:admin::lang.text_filter_status',
            'type' => 'select',
            'conditions' => 'review_status = :filtered',
            'options' => [
                'lang:igniter.local::default.reviews.text_pending_review',
                'lang:igniter.local::default.reviews.text_approved',
            ],
        ],
        'date' => [
            'label' => 'lang:admin::lang.text_filter_date',
            'type' => 'daterange',
            'conditions' => 'created_at >= CAST(:filtered_start AS DATE) AND created_at <= CAST(:filtered_end AS DATE)',
        ],
    ],
];

$config['list']['toolbar'] = [
    'buttons' => [
        'create' => [
            'label' => 'lang:admin::lang.button_new',
            'class' => 'btn btn-primary',
            'href' => 'igniter/local/reviews/create',
        ],
    ],
];

$config['list']['bulkActions'] = [
    'status' => [
        'label' => 'lang:admin::lang.label_status',
        'type' => 'dropdown',
        'class' => 'btn btn-light',
        'statusColumn' => 'review_status',
        'menuItems' => [
            'enable' => [
                'label' => 'lang:igniter.local::default.reviews.text_approved',
                'type' => 'button',
                'class' => 'dropdown-item',
            ],
            'disable' => [
                'label' => 'lang:igniter.local::default.reviews.text_pending_review',
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
            'href' => 'igniter/local/reviews/edit/{review_id}',
        ],
    ],
    'location_name' => [
        'label' => 'lang:igniter.local::default.reviews.column_location',
        'relation' => 'location',
        'select' => 'location_name',
        'searchable' => true,
        'locationAware' => true,
    ],
    'author' => [
        'label' => 'lang:igniter.local::default.reviews.column_author',
        'type' => 'text',
        'searchable' => true,
    ],
    'reviewable_id' => [
        'label' => 'lang:igniter.local::default.reviews.column_reviewable_id',
        'type' => 'number',
        'searchable' => true,
    ],
    'reviewable_type' => [
        'label' => 'lang:igniter.local::default.reviews.column_reviewable_type',
        'type' => 'select',
        'searchable' => true,
        'formatter' => function($record, $column, $value) {
            return ucwords($value);
        },
    ],
    'review_status' => [
        'label' => 'lang:admin::lang.label_status',
        'type' => 'switch',
        'onText' => 'lang:igniter.local::default.reviews.text_approved',
        'offText' => 'lang:igniter.local::default.reviews.text_pending_review',
    ],
    'created_at' => [
        'label' => 'lang:admin::lang.column_date_added',
        'type' => 'timetense',
    ],
    'review_id' => [
        'label' => 'lang:admin::lang.column_id',
        'invisible' => true,
    ],
    'review_text' => [
        'label' => 'lang:igniter.local::default.reviews.column_text',
        'invisible' => true,
    ],
];

$config['form']['toolbar'] = [
    'buttons' => [
        'save' => [
            'label' => 'lang:admin::lang.button_save',
            'partial' => 'form/toolbar_save_button',
            'class' => 'btn btn-primary',
            'data-request' => 'onSave',
            'data-progress-indicator' => 'admin::lang.text_saving',
            'context' => ['create', 'edit'],
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

$config['form']['fields'] = [
    'location_id' => [
        'label' => 'lang:igniter.local::default.reviews.label_location',
        'type' => 'relation',
        'relationFrom' => 'location',
        'nameFrom' => 'location_name',
        'span' => 'left',
        'placeholder' => 'lang:admin::lang.text_please_select',
    ],
    'author@edit' => [
        'label' => 'lang:igniter.local::default.reviews.label_author',
        'type' => 'text',
        'span' => 'right',
        'disabled' => true,
    ],
    'author@create' => [
        'label' => 'lang:igniter.local::default.reviews.label_author',
        'type' => 'text',
        'span' => 'right',
    ],
    'reviewable_type' => [
        'label' => 'lang:igniter.local::default.reviews.label_reviewable_type',
        'type' => 'radiotoggle',
        'span' => 'left',
        'default' => 'orders',
    ],
    'reviewable_id' => [
        'label' => 'lang:igniter.local::default.reviews.label_reviewable_id',
        'type' => 'number',
        'span' => 'right',
    ],
    'quality' => [
        'label' => 'lang:igniter.local::default.reviews.label_quality',
        'type' => 'starrating',
        'span' => 'left',
        'cssClass' => 'flex-width',
    ],
    'delivery' => [
        'label' => 'lang:igniter.local::default.reviews.label_delivery',
        'type' => 'starrating',
        'span' => 'left',
        'cssClass' => 'flex-width',
    ],
    'service' => [
        'label' => 'lang:igniter.local::default.reviews.label_service',
        'type' => 'starrating',
        'span' => 'left',
        'cssClass' => 'flex-width',
    ],
    'review_text' => [
        'label' => 'lang:igniter.local::default.reviews.label_text',
        'type' => 'textarea',
    ],
    'review_status' => [
        'label' => 'lang:admin::lang.label_status',
        'type' => 'switch',
        'default' => true,
        'on' => 'lang:igniter.local::default.reviews.text_approved',
        'off' => 'lang:igniter.local::default.reviews.text_pending_review',
    ],
];

return $config;
