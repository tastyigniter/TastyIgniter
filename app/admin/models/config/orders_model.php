<?php
$config['list']['filter'] = [
    'search' => [
        'prompt' => 'lang:admin::lang.orders.text_filter_search',
        'mode' => 'all',
    ],
    'scopes' => [
        'location' => [
            'label' => 'lang:admin::lang.orders.text_filter_location',
            'type' => 'select',
            'conditions' => 'location_id = :filtered',
            'modelClass' => 'Admin\Models\Locations_model',
            'nameFrom' => 'location_name',
        ],
        'status' => [
            'label' => 'lang:admin::lang.orders.text_filter_status',
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
            'label' => 'lang:admin::lang.orders.text_filter_date',
            'type' => 'date',
            'conditions' => 'YEAR(date_added) = :year AND MONTH(date_added) = :month',
            'modelClass' => 'Admin\Models\Orders_model',
            'options' => 'getOrderDates',
        ],
    ],
];

$config['list']['toolbar'] = [
    'buttons' => [
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
            'href' => 'orders/edit/{order_id}',
        ],
    ],
    'order_id' => [
        'label' => 'lang:admin::lang.column_id',
    ],
    'location' => [
        'label' => 'lang:admin::lang.orders.column_location',
        'relation' => 'location',
        'select' => 'location_name',
        'searchable' => TRUE,
    ],
    'full_name' => [
        'label' => 'lang:admin::lang.orders.column_customer_name',
        'select' => "concat(first_name, ' ', last_name)",
        'searchable' => TRUE,
    ],
    'status_name' => [
        'label' => 'lang:admin::lang.orders.column_status',
        'relation' => 'status',
        'select' => 'status_name',
        'type' => 'partial',
        'path' => 'orders/status_column',
    ],
    'order_type_name' => [
        'label' => 'lang:admin::lang.orders.column_type',
        'type' => 'text',
        'sortable' => FALSE,
    ],
    'payment' => [
        'label' => 'lang:admin::lang.orders.column_payment',
        'type' => 'text',
        'sortable' => FALSE,
        'relation' => 'payment_method',
        'select' => 'name',
    ],
    'assignee_id' => [
        'label' => 'lang:admin::lang.orders.column_staff',
        'type' => 'text',
        'relation' => 'assignee',
        'select' => 'staff_name',
    ],
    'order_total' => [
        'label' => 'lang:admin::lang.orders.column_total',
        'type' => 'money',
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
    'date_added' => [
        'label' => 'lang:admin::lang.orders.column_date_added',
        'type' => 'datesince',
        'invisible' => TRUE,
    ],
];

$config['form']['toolbar'] = [
    'buttons' => [
        'save' => ['label' => 'lang:admin::lang.button_save', 'class' => 'btn btn-primary', 'data-request-submit' => 'true', 'data-request' => 'onSave'],
        'saveClose' => [
            'label' => 'lang:admin::lang.button_save_close',
            'class' => 'btn btn-default',
            'data-request' => 'onSave',
            'data-request-submit' => 'true',
            'data-request-data' => 'close:1',
        ],
        'delete' => [
            'label' => 'lang:admin::lang.button_icon_delete', 'class' => 'btn btn-danger',
            'data-request-submit' => 'true', 'data-request' => 'onDelete', 'data-request-data' => "_method:'DELETE'",
            'data-request-confirm' => 'lang:admin::lang.alert_warning_confirm', 'context' => ['edit'],
        ],
    ],
];

$config['form']['fields'] = [
    'order_id' => [
        'label' => 'lang:admin::lang.orders.label_order_id',
        'type' => 'text',
        'disabled' => TRUE,
        'span' => 'left',
        'cssClass' => 'flex-width',
        'context' => ['edit', 'preview'],
    ],
    'invoice_id' => [
        'label' => 'lang:admin::lang.orders.label_invoice',
        'type' => 'addon',
        'disabled' => TRUE,
        'span' => 'left',
        'cssClass' => 'flex-width',
        'context' => ['edit', 'preview'],
        'addonCssClass' => ['input-addon-btn'],
        'addonRight' => [
            'tag' => 'button',
            'label' => 'admin::lang.orders.button_create_invoice',
            'attributes' => [
                'type' => 'button',
                'class' => 'btn btn-outline-default',
                'data-request' => 'onGenerateInvoice',
            ],
        ],
    ],
    'order_total' => [
        'label' => 'lang:admin::lang.orders.label_order_total',
        'type' => 'money',
        'disabled' => TRUE,
        'span' => 'right',
        'context' => ['edit', 'preview'],
    ],
    'status_id' => [
        'label' => 'lang:admin::lang.label_status',
        'type' => 'statuseditor',
        'span' => 'left',
        'options' => ['Admin\Models\Statuses_model', 'listStatuses'],
        'form' => [
            'fields' => [
                'status_id' => [
                    'label' => 'lang:admin::lang.label_status',
                    'type' => 'select',
                    'options' => ['Admin\Models\Statuses_model', 'getDropdownOptionsForOrder'],
                    'placeholder' => 'lang:admin::lang.text_please_select',
                    'attributes' => [
                        'data-status-value' => '',
                    ],
                ],
                'comment' => [
                    'label' => 'lang:admin::lang.orders.label_comment',
                    'type' => 'textarea',
                    'attributes' => [
                        'data-status-comment' => '',
                    ],
                ],
                'notify' => [
                    'label' => 'lang:admin::lang.orders.label_notify',
                    'type' => 'radio',
                    'default' => 1,
                    'options' => [
                        'lang:admin::lang.text_no',
                        'lang:admin::lang.text_yes',
                    ],
                    'comment' => 'lang:admin::lang.orders.help_notify_customer',
                    'attributes' => [
                        'data-status-notify' => '',
                    ],
                ],
            ],
        ],
    ],
    'assignee_id' => [
        'label' => 'lang:admin::lang.orders.label_assign_staff',
        'type' => 'relation',
        'relationFrom' => 'assignee',
        'nameFrom' => 'staff_name',
        'span' => 'right',
        'placeholder' => 'lang:admin::lang.text_please_select',
    ],
];

$config['form']['tabs'] = [
    'defaultTab' => 'lang:admin::lang.orders.text_tab_general',
    'fields' => [
        'location[location_name]' => [
            'label' => 'lang:admin::lang.orders.text_restaurant',
            'type' => 'text',
            'disabled' => TRUE,
            'span' => 'left',
            'placeholder' => 'lang:admin::lang.text_please_select',
        ],
        'customer_name' => [
            'label' => 'lang:admin::lang.orders.label_customer_name',
            'type' => 'text',
            'disabled' => TRUE,
            'span' => 'right',
        ],
        'order_type_name' => [
            'label' => 'lang:admin::lang.orders.label_order_type',
            'type' => 'text',
            'span' => 'left',
            'disabled' => TRUE,
        ],
        'email' => [
            'label' => 'lang:admin::lang.orders.label_email',
            'type' => 'text',
            'disabled' => TRUE,
            'span' => 'right',
            'context' => ['edit', 'preview'],
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
        'telephone' => [
            'label' => 'lang:admin::lang.orders.label_telephone',
            'type' => 'text',
            'disabled' => TRUE,
            'span' => 'right',
            'context' => ['edit', 'preview'],
        ],
        'delivery_address' => [
            'label' => 'lang:admin::lang.orders.label_delivery_address',
            'span' => 'left',
            'valueFrom' => 'formatted_address',
            'disabled' => TRUE,
        ],
        'total_items' => [
            'label' => 'lang:admin::lang.orders.label_total_items',
            'type' => 'number',
            'span' => 'right',
            'disabled' => TRUE,
            'context' => ['edit', 'preview'],
        ],
        'payment_method[name]' => [
            'label' => 'lang:admin::lang.orders.label_payment_method',
            'span' => 'left',
            'type' => 'text',
            'disabled' => TRUE,
        ],
        'invoice' => [
            'label' => 'lang:admin::lang.orders.label_invoice',
            'type' => 'text',
            'disabled' => TRUE,
            'span' => 'right',
            'context' => ['edit', 'preview'],
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
            'path' => 'orders/order_menus',
        ],
        'status_history' => [
            'tab' => 'lang:admin::lang.orders.text_status_history',
            'type' => 'datatable',
            'columns' => [
                'date_added' => [
                    'title' => 'lang:admin::lang.orders.column_time_date',
                ],
                'staff_name' => [
                    'title' => 'lang:admin::lang.orders.column_staff',
                ],
                'assignee_name' => [
                    'title' => 'lang:admin::lang.orders.column_assignee',
                ],
                'status_name' => [
                    'title' => 'lang:admin::lang.orders.column_status',
                ],
                'comment' => [
                    'title' => 'lang:admin::lang.orders.column_comment',
                ],
                'notified' => [
                    'title' => 'lang:admin::lang.orders.column_notify',
                ],
            ],
        ],
    ],
];

return $config;