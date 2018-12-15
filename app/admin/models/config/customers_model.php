<?php
$config['list']['filter'] = [
    'search' => [
        'prompt' => 'lang:admin::lang.customers.text_filter_search',
        'mode' => 'all' // or any, exact
    ],
    'scopes' => [
        'date' => [
            'label' => 'lang:admin::lang.customers.text_filter_date',
            'type' => 'date',
            'conditions' => 'YEAR(date_added) = :year AND MONTH(date_added) = :month',
            'modelClass' => 'Admin\Models\Customers_model',
            'options' => 'getCustomerDates',
        ],
        'status' => [
            'label' => 'lang:admin::lang.customers.text_filter_status',
            'type' => 'switch',
        ],
    ],
];

$config['list']['toolbar'] = [
    'buttons' => [
        'create' => ['label' => 'lang:admin::lang.button_new', 'class' => 'btn btn-primary', 'href' => 'customers/create'],
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
            'href' => 'customers/edit/{customer_id}',
        ],
    ],
    'info' => [
        'type' => 'button',
        'iconCssClass' => 'fa fa-user',
        'attributes' => [
            'class' => 'btn btn-outline-info',
            'target' => '_blank',
            'href' => 'customers/impersonate/{customer_id}',
        ],
    ],
    'full_name' => [
        'label' => 'lang:admin::lang.customers.column_full_name',
        'type' => 'text',
        'select' => 'concat(first_name, " ", last_name)',
        'searchable' => TRUE,
    ],
    'email' => [
        'label' => 'lang:admin::lang.customers.column_email',
        'type' => 'text',
        'searchable' => TRUE,
    ],
    'telephone' => [
        'label' => 'lang:admin::lang.customers.column_telephone',
        'type' => 'text',
    ],
    'date_added' => [
        'label' => 'lang:admin::lang.customers.column_date_added',
        'type' => 'datesince',
    ],
    'status' => [
        'label' => 'lang:admin::lang.customers.column_status',
        'type' => 'switch',
    ],
    'customer_id' => [
        'label' => 'lang:admin::lang.column_id',
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

$config['form']['tabs'] = [
    'defaultTab' => 'lang:admin::lang.customers.text_tab_general',
    'fields' => [
        'first_name' => [
            'label' => 'lang:admin::lang.customers.label_first_name',
            'type' => 'text',
            'span' => 'left',
        ],
        'last_name' => [
            'label' => 'lang:admin::lang.customers.label_last_name',
            'type' => 'text',
            'span' => 'right',
        ],
        'email' => [
            'label' => 'lang:admin::lang.customers.label_email',
            'type' => 'text',
            'span' => 'left',
        ],
        'telephone' => [
            'label' => 'lang:admin::lang.customers.label_telephone',
            'type' => 'text',
            'span' => 'right',
        ],
        'password' => [
            'label' => 'lang:admin::lang.customers.label_password',
            'type' => 'password',
            'span' => 'left',
            'comment' => 'lang:admin::lang.customers.help_password',
        ],
        '_confirm_password' => [
            'label' => 'lang:admin::lang.customers.label_confirm_password',
            'type' => 'password',
            'span' => 'right',
        ],
        'customer_group_id' => [
            'label' => 'lang:admin::lang.customers.label_customer_group',
            'type' => 'relation',
            'relationFrom' => 'group',
            'nameFrom' => 'group_name',
            'placeholder' => 'lang:admin::lang.text_please_select',
        ],
        'newsletter' => [
            'label' => 'lang:admin::lang.customers.label_newsletter',
            'type' => 'switch',
            'on' => 'lang:admin::lang.customers.text_subscribe',
            'off' => 'lang:admin::lang.customers.text_un_subscribe',
        ],
        'status' => [
            'label' => 'lang:admin::lang.label_status',
            'type' => 'switch',
        ],
        'addresses' => [
            'tab' => 'lang:admin::lang.customers.text_tab_address',
            'type' => 'partial',
            'path' => 'customers/address_tabs',
            'options' => 'listAddresses',
        ],
        'orders' => [
            'tab' => 'lang:admin::lang.customers.text_tab_orders',
            'type' => 'datatable',
            'columns' => [
                'order_id' => [
                    'title' => 'lang:admin::lang.column_id',
                ],
                'customer_name' => [
                    'title' => 'lang:admin::lang.orders.column_customer_name',
                ],
                'status_name' => [
                    'title' => 'lang:admin::lang.orders.column_status',
                ],
                'order_type_name' => [
                    'title' => 'lang:admin::lang.orders.column_type',
                ],
                'order_total' => [
                    'title' => 'lang:admin::lang.orders.column_total',
                ],
                'order_time' => [
                    'title' => 'lang:admin::lang.orders.column_time',
                ],
                'order_date' => [
                    'title' => 'lang:admin::lang.orders.column_date',
                ],
            ],
        ],
        'reservations' => [
            'tab' => 'lang:admin::lang.customers.text_tab_reservations',
            'type' => 'datatable',
            'columns' => [
                'reservation_id' => [
                    'title' => 'lang:admin::lang.column_id',
                ],
                'customer_name' => [
                    'title' => 'lang:admin::lang.reservations.column_customer_name',
                ],
                'status_name' => [
                    'title' => 'lang:admin::lang.reservations.column_status',
                ],
                'table_name' => [
                    'title' => 'lang:admin::lang.reservations.column_table',
                ],
                'table_name' => [
                    'title' => 'lang:admin::lang.reservations.column_table',
                ],
                'reserve_time' => [
                    'title' => 'lang:admin::lang.reservations.column_time',
                ],
                'reserve_date' => [
                    'title' => 'lang:admin::lang.reservations.column_date',
                ],
            ],
        ],
    ],
];

return $config;