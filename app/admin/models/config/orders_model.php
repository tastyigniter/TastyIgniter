<?php
$config['list']['filter'] = [
    'search' => [
        'prompt' => 'lang:admin::lang.orders.text_filter_search',
        'mode' => 'all',
    ],
    'scopes' => [
        'assignee' => [
            'label' => 'lang:admin::lang.orders.text_filter_assignee',
            'type' => 'select',
            'scope' => 'filterAssignedTo',
            'options' => [
                1 => 'lang:admin::lang.statuses.text_unassigned',
                2 => 'lang:admin::lang.statuses.text_assigned_to_self',
                3 => 'lang:admin::lang.statuses.text_assigned_to_others',
            ],
        ],
        'location' => [
            'label' => 'lang:admin::lang.text_filter_location',
            'type' => 'select',
            'conditions' => 'location_id = :filtered',
            'modelClass' => 'Admin\Models\Locations_model',
            'nameFrom' => 'location_name',
            'locationAware' => TRUE,
        ],
        'status' => [
            'label' => 'lang:admin::lang.text_filter_status',
            'type' => 'selectlist',
            'conditions' => 'status_id IN(:filtered)',
            'modelClass' => 'Admin\Models\Statuses_model',
            'options' => 'getDropdownOptionsForOrder',
        ],
        'type' => [
            'label' => 'lang:admin::lang.orders.text_filter_order_type',
            'type' => 'select',
            'conditions' => 'order_type = :filtered',
            'modelClass' => 'Admin\Models\Locations_model',
            'options' => 'getOrderTypeOptions',
        ],
        'payment' => [
            'label' => 'lang:admin::lang.orders.text_filter_payment',
            'type' => 'select',
            'conditions' => 'payment = :filtered',
            'modelClass' => 'Admin\Models\Payments_model',
            'options' => 'getDropdownOptions',
        ],
        'date' => [
            'label' => 'lang:admin::lang.text_filter_date',
            'type' => 'daterange',
            'conditions' => 'order_date >= CAST(:filtered_start AS DATE) AND order_date <= CAST(:filtered_end AS DATE)',
        ],
    ],
];

$config['list']['toolbar'] = [
    'buttons' => [
    ],
];

$config['list']['bulkActions'] = [
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
            'href' => 'orders/edit/{order_id}',
        ],
    ],
    'order_id' => [
        'label' => 'lang:admin::lang.column_id',
        'searchable' => TRUE,
    ],
    'location_name' => [
        'label' => 'lang:admin::lang.orders.column_location',
        'relation' => 'location',
        'searchable' => TRUE,
        'locationAware' => TRUE,
    ],
    'full_name' => [
        'label' => 'lang:admin::lang.orders.column_customer_name',
        'select' => "concat(first_name, ' ', last_name)",
        'searchable' => TRUE,
    ],
    'order_type_name' => [
        'label' => 'lang:admin::lang.label_type',
        'type' => 'text',
        'sortable' => FALSE,
    ],
    'order_time_is_asap' => [
        'label' => 'lang:admin::lang.orders.label_time_is_asap',
        'type' => 'switch',
        'cssClass' => 'text-center',
        'onText' => 'lang:admin::lang.text_yes',
        'offText' => 'lang:admin::lang.text_no',
    ],
    'order_time' => [
        'label' => 'lang:admin::lang.orders.column_time',
        'type' => 'time',
    ],
    'order_date' => [
        'label' => 'lang:admin::lang.orders.column_date',
        'type' => 'date',
        'searchable' => TRUE,
    ],
    'status_name' => [
        'label' => 'lang:admin::lang.label_status',
        'relation' => 'status',
        'select' => 'status_name',
        'type' => 'partial',
        'path' => 'statuses/form/status_column',
    ],
    'payment' => [
        'label' => 'lang:admin::lang.orders.column_payment',
        'type' => 'text',
        'sortable' => FALSE,
        'relation' => 'payment_method',
        'select' => 'name',
    ],
    'assignee_name' => [
        'label' => 'lang:admin::lang.orders.column_assignee',
        'type' => 'text',
        'relation' => 'assignee',
        'select' => 'staff_name',
        'searchable' => TRUE,
        'invisible' => TRUE,
    ],
    'assignee_group_name' => [
        'label' => 'lang:admin::lang.orders.column_assignee_group',
        'type' => 'text',
        'relation' => 'assignee_group',
        'select' => 'staff_group_name',
        'searchable' => TRUE,
        'invisible' => TRUE,
    ],
    'order_total' => [
        'label' => 'lang:admin::lang.orders.column_total',
        'type' => 'currency',
    ],
    'updated_at' => [
        'label' => 'lang:admin::lang.column_date_updated',
        'type' => 'datesince',
        'invisible' => TRUE,
    ],
    'created_at' => [
        'label' => 'lang:admin::lang.column_date_added',
        'type' => 'timesince',
        'invisible' => TRUE,
    ],
];

$config['form']['toolbar'] = [
    'buttons' => [
        'back' => [
            'label' => 'lang:admin::lang.button_icon_back',
            'class' => 'btn btn-default',
            'href' => 'orders',
        ],
        'save' => [
            'label' => 'lang:admin::lang.button_save',
            'context' => ['create'],
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

$config['form']['fields'] = [
    '_info' => [
        'type' => 'partial',
        'disabled' => TRUE,
        'path' => 'orders/form/info',
        'span' => 'left',
        'cssClass' => 'left',
        'context' => ['edit', 'preview'],
    ],
    'status_id' => [
        'type' => 'statuseditor',
        'span' => 'right',
        'form' => 'order_status_model',
    ],
];

$config['form']['tabs'] = [
    'defaultTab' => 'lang:admin::lang.orders.text_tab_general',
    'fields' => [
        'order_menus' => [
            'type' => 'partial',
            'path' => 'orders/form/order_menus',
        ],
        'customer' => [
            'label' => 'lang:admin::lang.orders.text_customer',
            'type' => 'partial',
            'path' => 'orders/form/field_customer',
        ],
        'location' => [
            'label' => 'lang:admin::lang.orders.text_restaurant',
            'type' => 'partial',
            'path' => 'orders/form/field_location',
        ],
        'order_details' => [
            'type' => 'partial',
            'path' => 'orders/form/order_details',
        ],

        'status_history' => [
            'tab' => 'lang:admin::lang.orders.text_status_history',
            'type' => 'datatable',
            'useAjax' => TRUE,
            'defaultSort' => ['status_history_id', 'desc'],
            'columns' => [
                'date_added_since' => [
                    'title' => 'lang:admin::lang.orders.column_time_date',
                ],
                'status_name' => [
                    'title' => 'lang:admin::lang.label_status',
                ],
                'comment' => [
                    'title' => 'lang:admin::lang.orders.column_comment',
                ],
                'notified' => [
                    'title' => 'lang:admin::lang.orders.column_notify',
                ],
                'staff_name' => [
                    'title' => 'lang:admin::lang.orders.column_staff',
                ],
            ],
        ],
        'payment_logs' => [
            'tab' => 'lang:admin::lang.orders.text_payment_logs',
            'type' => 'datatable',
            'useAjax' => TRUE,
            'defaultSort' => ['payment_log_id', 'desc'],
            'columns' => [
                'date_added_since' => [
                    'title' => 'lang:admin::lang.orders.column_time_date',
                ],
                'payment_name' => [
                    'title' => 'lang:admin::lang.orders.label_payment_method',
                ],
                'message' => [
                    'title' => 'lang:admin::lang.orders.column_comment',
                ],
            ],
        ],
    ],
];

return $config;
