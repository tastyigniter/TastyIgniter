<?php
$config['list']['filter'] = [
    'search' => [
        'prompt' => 'lang:admin::lang.reviews.text_filter_search',
        'mode' => 'all',
    ],
    'scopes' => [
        'location' => [
            'label' => 'lang:admin::lang.text_filter_location',
            'type' => 'select',
            'scope' => 'whereHasLocation',
            'modelClass' => 'Admin\Models\Locations_model',
            'nameFrom' => 'location_name',
            'locationAware' => 'hide',
        ],
        'status' => [
            'label' => 'lang:admin::lang.text_filter_status',
            'type' => 'select',
            'conditions' => 'review_status = :filtered',
            'options' => [
                'lang:admin::lang.reviews.text_pending_review',
                'lang:admin::lang.reviews.text_approved',
            ],
        ],
        'date' => [
            'label' => 'lang:admin::lang.text_filter_date',
            'type' => 'date',
            'conditions' => 'YEAR(date_added) = :year AND MONTH(date_added) = :month',
            'modelClass' => 'Admin\Models\Reviews_model',
            'options' => 'getReviewDates',
        ],
    ],
];

$config['list']['toolbar'] = [
    'buttons' => [
        'create' => [
            'label' => 'lang:admin::lang.button_new',
            'class' => 'btn btn-primary',
            'href' => 'reviews/create',
        ],
        'delete' => [
            'label' => 'lang:admin::lang.button_delete',
            'class' => 'btn btn-danger',
            'data-attach-loading' => '',
            'data-request' => 'onDelete',
            'data-request-form' => '#list-form',
            'data-request-data' => "_method:'DELETE'",
            'data-request-confirm' => 'lang:admin::lang.alert_warning_confirm',
        ],
        'filter' => [
            'label' => 'lang:admin::lang.button_icon_filter',
            'class' => 'btn btn-default btn-filter',
            'data-toggle' => 'list-filter',
            'data-target' => '.list-filter',
        ],
    ],
];

$config['list']['columns'] = [
    'edit' => [
        'type' => 'button',
        'iconCssClass' => 'fa fa-pencil',
        'attributes' => [
            'class' => 'btn btn-edit',
            'href' => 'reviews/edit/{review_id}',
        ],
    ],
    'location' => [
        'label' => 'lang:admin::lang.reviews.column_location',
        'relation' => 'location',
        'select' => 'location_name',
        'searchable' => TRUE,
        'locationAware' => 'hide',
    ],
    'author' => [
        'label' => 'lang:admin::lang.reviews.column_author',
        'relation' => 'customer',
        'select' => "concat(first_name, ' ', last_name)",
        'searchable' => TRUE,
    ],
    'sale_id' => [
        'label' => 'lang:admin::lang.reviews.column_sale_id',
        'type' => 'number',
        'searchable' => TRUE,
    ],
    'sale_type' => [
        'label' => 'lang:admin::lang.reviews.column_sale_type',
        'type' => 'select',
        'searchable' => TRUE,
        'formatter' => function ($record, $column, $value) {
            return ucwords($value);
        },
    ],
    'review_status' => [
        'label' => 'lang:admin::lang.label_status',
        'type' => 'switch',
        'onText' => 'lang:admin::lang.reviews.text_pending_review',
        'offText' => 'lang:admin::lang.reviews.text_approved',
    ],
    'date_added' => [
        'label' => 'lang:admin::lang.reviews.column_date_added',
        'type' => 'timetense',
    ],
    'review_id' => [
        'label' => 'lang:admin::lang.column_id',
        'invisible' => TRUE,
    ],

];

$config['form']['toolbar'] = [
    'buttons' => [
        'save' => [
            'label' => 'lang:admin::lang.button_save',
            'class' => 'btn btn-primary',
            'data-request' => 'onSave',
            'data-progress-indicator' => 'admin::lang.text_saving',
        ],
        'saveClose' => [
            'label' => 'lang:admin::lang.button_save_close',
            'class' => 'btn btn-default',
            'data-request' => 'onSave',
            'data-request-data' => 'close:1',
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

$config['form']['fields'] = [
    'location_id' => [
        'label' => 'lang:admin::lang.reviews.label_location',
        'type' => 'relation',
        'relationFrom' => 'location',
        'nameFrom' => 'location_name',
        'span' => 'left',
        'locationAware' => 'hide',
        'placeholder' => 'lang:admin::lang.text_please_select',
    ],
    'customer_id' => [
        'label' => 'lang:admin::lang.reviews.label_author',
        'type' => 'relation',
        'relationFrom' => 'customer',
        'nameFrom' => 'full_name',
        'span' => 'right',
        'placeholder' => 'lang:admin::lang.text_please_select',
    ],
    'sale_type' => [
        'label' => 'lang:admin::lang.reviews.label_sale_type',
        'type' => 'radiotoggle',
        'span' => 'left',
        'default' => 'orders',
    ],
    'sale_id' => [
        'label' => 'lang:admin::lang.reviews.label_sale_id',
        'type' => 'number',
        'span' => 'right',
    ],
    'quality' => [
        'label' => 'lang:admin::lang.reviews.label_quality',
        'type' => 'starrating',
        'span' => 'left',
        'cssClass' => 'flex-width',
    ],
    'delivery' => [
        'label' => 'lang:admin::lang.reviews.label_delivery',
        'type' => 'starrating',
        'span' => 'left',
        'cssClass' => 'flex-width',
    ],
    'service' => [
        'label' => 'lang:admin::lang.reviews.label_service',
        'type' => 'starrating',
        'span' => 'left',
        'cssClass' => 'flex-width',
    ],
    'review_text' => [
        'label' => 'lang:admin::lang.reviews.label_text',
        'type' => 'textarea',
    ],
    'review_status' => [
        'label' => 'lang:admin::lang.label_status',
        'type' => 'switch',
        'default' => TRUE,
    ],
];

return $config;