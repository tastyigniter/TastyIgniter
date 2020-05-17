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
            'locationAware' => 'hide',
        ],
        'status' => [
            'label' => 'lang:admin::lang.text_filter_status',
            'type' => 'select',
            'conditions' => 'status_id = :filtered',
            'modelClass' => 'Admin\Models\Statuses_model',
            'options' => 'getDropdownOptionsForOrder',
        ],
        'type' => [
            'label' => 'lang:admin::lang.orders.text_filter_order_type',
            'type' => 'select',
            'conditions' => 'order_type = :filtered',
            'options' => [
                '1' => 'lang:admin::lang.orders.text_delivery',
                '2' => 'lang:admin::lang.orders.text_collection',
            ],
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
            'type' => 'date',
            'conditions' => 'YEAR(date_added) = :year AND MONTH(date_added) = :month',
            'modelClass' => 'Admin\Models\Orders_model',
            'options' => 'getOrderDates',
        ],
    ],
];

$config['list']['toolbar'] = [
    'buttons' => [
        'delete' => [
            'label' => 'lang:admin::lang.button_delete',
            'class' => 'btn btn-danger',
            'context' => 'index',
            'data-attach-loading' => '',
            'data-request' => 'onDelete',
            'data-request-form' => '#list-form',
            'data-request-data' => "_method:'DELETE'",
            'data-request-confirm' => 'lang:admin::lang.alert_warning_confirm',
        ],
        'assigned' => [
            'label' => 'lang:admin::lang.text_switch_to_assigned',
            'class' => 'btn btn-default',
            'href' => 'orders/assigned',
            'context' => 'index',
        ],
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
    'location' => [
        'label' => 'lang:admin::lang.orders.column_location',
        'relation' => 'location',
        'select' => 'location_name',
        'searchable' => TRUE,
        'locationAware' => 'hide',
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
        'path' => 'orders/status_column',
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
    'date_added' => [
        'label' => 'lang:admin::lang.orders.column_date_added',
        'type' => 'timesince',
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
            'context' => ['create'],
        ],
        'saveClose' => [
            'label' => 'lang:admin::lang.button_save_close',
            'class' => 'btn btn-default',
            'data-request' => 'onSave',
            'data-request-data' => 'close:1',
            'data-progress-indicator' => 'admin::lang.text_saving',
            'context' => ['create'],
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
        'order_type_name' => [
            'label' => 'lang:admin::lang.orders.label_order_type',
            'type' => 'text',
            'span' => 'left',
            'disabled' => TRUE,
            'context' => ['edit', 'preview'],
        ],
        'location[location_name]' => [
            'label' => 'lang:admin::lang.orders.text_restaurant',
            'type' => 'location',
            'disabled' => TRUE,
            'span' => 'right',
            'placeholder' => 'lang:admin::lang.text_please_select',
        ],
        'order_date' => [
            'label' => 'lang:admin::lang.orders.label_order_date',
            'type' => 'datepicker',
            'disabled' => TRUE,
            'mode' => 'date',
            'span' => 'left',
            'cssClass' => 'flex-width',
        ],
        'order_time' => [
            'label' => 'lang:admin::lang.orders.label_order_time',
            'type' => 'datepicker',
            'disabled' => TRUE,
            'mode' => 'time',
            'span' => 'left',
            'cssClass' => 'flex-width',
        ],
        'customer[full_name]' => [
            'label' => 'lang:admin::lang.orders.text_customer',
            'type' => 'customer',
            'disabled' => TRUE,
            'span' => 'right',
        ],
        'delivery_address' => [
            'label' => 'lang:admin::lang.orders.label_delivery_address',
            'span' => 'left',
            'valueFrom' => 'formatted_address',
            'disabled' => TRUE,
        ],
        'telephone' => [
            'label' => 'lang:admin::lang.orders.label_telephone',
            'type' => 'text',
            'disabled' => TRUE,
            'span' => 'right',
            'context' => ['edit', 'preview'],
        ],
        'payment_method[name]' => [
            'label' => 'lang:admin::lang.orders.label_payment_method',
            'span' => 'left',
            'type' => 'text',
            'disabled' => TRUE,
        ],
        'invoice_number' => [
            'label' => 'lang:admin::lang.orders.label_invoice',
            'type' => 'addon',
            'disabled' => TRUE,
            'span' => 'right',
            'context' => ['edit', 'preview'],
            'addonCssClass' => ['input-addon-btn'],
            'addonRight' => [
                'tag' => 'a',
                'label' => 'admin::lang.orders.button_print_invoice',
                'attributes' => [
                    'class' => 'btn btn-outline-default',
                    'target' => '_blank',
                ],
            ],
        ],
        'comment' => [
            'label' => 'lang:admin::lang.orders.label_comment',
            'type' => 'textarea',
            'disabled' => TRUE,
        ],
        'date_added' => [
            'label' => 'lang:admin::lang.orders.label_date_added',
            'type' => 'datepicker',
            'mode' => 'date',
            'disabled' => TRUE,
            'span' => 'left',
            'context' => ['edit', 'preview'],
        ],
        'ip_address' => [
            'label' => 'lang:admin::lang.orders.label_ip_address',
            'type' => 'text',
            'disabled' => TRUE,
            'span' => 'right',
            'context' => ['edit', 'preview'],
        ],
        'date_modified' => [
            'label' => 'lang:admin::lang.orders.label_date_modified',
            'type' => 'datepicker',
            'mode' => 'date',
            'span' => 'left',
            'disabled' => TRUE,
            'context' => ['edit', 'preview'],
        ],
        'user_agent' => [
            'label' => 'lang:admin::lang.orders.label_user_agent',
            'disabled' => TRUE,
            'type' => 'text',
            'span' => 'right',
            'context' => ['edit', 'preview'],
        ],
        'order_menus' => [
            'tab' => 'lang:admin::lang.orders.text_tab_menu',
            'type' => 'partial',
            'path' => 'orders/form/order_menus',
        ],
        'status_history' => [
            'tab' => 'lang:admin::lang.orders.text_status_history',
            'type' => 'datatable',
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