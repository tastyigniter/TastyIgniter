<?php

use Igniter\Admin\Models\Status;
use Igniter\Cart\Http\Requests\OrderStatusRequest;
use Igniter\Local\Models\Location;
use Igniter\PayRegister\Models\Payment;

$config['list']['filter'] = [
    'search' => [
        'prompt' => 'lang:igniter.cart::default.orders.text_filter_search',
        'mode' => 'all',
    ],
    'scopes' => [
        'assignee' => [
            'label' => 'lang:igniter.cart::default.orders.text_filter_assignee',
            'type' => 'select',
            'scope' => 'filterAssignedTo',
            'options' => [
                1 => 'lang:igniter::admin.statuses.text_unassigned',
                2 => 'lang:igniter::admin.statuses.text_assigned_to_self',
                3 => 'lang:igniter::admin.statuses.text_assigned_to_others',
            ],
        ],
        'status' => [
            'label' => 'lang:igniter::admin.text_filter_status',
            'type' => 'selectlist',
            'mode' => 'radio',
            'conditions' => 'status_id IN(:filtered)',
            'modelClass' => Status::class,
            'options' => 'getDropdownOptionsForOrder',
        ],
        'type' => [
            'label' => 'lang:igniter.cart::default.orders.text_filter_order_type',
            'type' => 'select',
            'conditions' => 'order_type = :filtered',
            'modelClass' => Location::class,
            'options' => 'getOrderTypeOptions',
        ],
        'payment' => [
            'label' => 'lang:igniter.cart::default.orders.text_filter_payment',
            'type' => 'selectlist',
            'conditions' => 'payment IN(:filtered)',
            'modelClass' => Payment::class,
            'options' => 'getDropdownOptions',
        ],
        'date' => [
            'label' => 'lang:igniter::admin.text_filter_date',
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
        'label' => 'lang:igniter::admin.button_delete',
        'class' => 'btn btn-light text-danger',
        'data-request-confirm' => 'lang:igniter::admin.alert_warning_confirm',
        'permissions' => 'Admin.DeleteOrders',
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
        'label' => 'lang:igniter::admin.column_id',
        'searchable' => true,
    ],
    'location_name' => [
        'label' => 'lang:igniter.cart::default.orders.column_location',
        'relation' => 'location',
        'select' => 'location_name',
        'searchable' => true,
        'locationAware' => true,
    ],
    'full_name' => [
        'label' => 'lang:igniter.cart::default.orders.column_customer_name',
        'select' => "concat(first_name, ' ', last_name)",
        'searchable' => true,
    ],
    'order_type_name' => [
        'label' => 'lang:igniter::admin.label_type',
        'type' => 'text',
        'sortable' => false,
    ],
    'order_time_is_asap' => [
        'label' => 'lang:igniter.cart::default.orders.label_time_is_asap',
        'type' => 'switch',
        'cssClass' => 'text-center',
        'onText' => 'lang:igniter::admin.text_yes',
        'offText' => 'lang:igniter::admin.text_no',
    ],
    'order_time' => [
        'label' => 'lang:igniter.cart::default.orders.column_time',
        'type' => 'time',
    ],
    'order_date' => [
        'label' => 'lang:igniter.cart::default.orders.column_date',
        'type' => 'date',
        'searchable' => true,
    ],
    'status_name' => [
        'label' => 'lang:igniter::admin.label_status',
        'relation' => 'status',
        'select' => 'status_name',
        'type' => 'partial',
        'path' => 'statuses/status_column',
        'cssClass' => 'overflow-visible',
    ],
    'payment' => [
        'label' => 'lang:igniter.cart::default.orders.column_payment',
        'type' => 'text',
        'sortable' => false,
        'relation' => 'payment_method',
        'select' => 'name',
    ],
    'assignee_name' => [
        'label' => 'lang:igniter.cart::default.orders.column_assignee',
        'type' => 'text',
        'relation' => 'assignee',
        'select' => 'name',
        'searchable' => true,
        'invisible' => true,
    ],
    'assignee_group_name' => [
        'label' => 'lang:igniter.cart::default.orders.column_assignee_group',
        'type' => 'text',
        'relation' => 'assignee_group',
        'select' => 'user_group_name',
        'searchable' => true,
        'invisible' => true,
    ],
    'order_total' => [
        'label' => 'lang:igniter.cart::default.orders.column_total',
        'type' => 'currency',
    ],
    'telephone' => [
        'label' => 'lang:igniter.cart::default.orders.label_telephone',
        'invisible' => true,
        'searchable' => true,
    ],
    'email' => [
        'label' => 'lang:igniter::admin.label_email',
        'invisible' => true,
        'searchable' => true,
    ],
    'updated_at' => [
        'label' => 'lang:igniter::admin.column_date_updated',
        'type' => 'datesince',
        'invisible' => true,
    ],
    'created_at' => [
        'label' => 'lang:igniter::admin.column_date_added',
        'type' => 'timesince',
        'invisible' => true,
    ],
];

$config['form']['toolbar'] = [
    'buttons' => [
        'save' => [
            'label' => 'lang:igniter::admin.button_save',
            'context' => ['create'],
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

$config['form']['fields'] = [
    '_info' => [
        'type' => 'partial',
        'disabled' => true,
        'path' => 'orders/info',
        'span' => 'left',
        'cssClass' => 'left',
        'context' => ['edit', 'preview'],
    ],
    'status_id' => [
        'type' => 'statuseditor',
        'span' => 'right',
        'form' => 'orderstatus',
        'request' => OrderStatusRequest::class,
    ],
];

$config['form']['tabs'] = [
    'defaultTab' => 'lang:igniter.cart::default.orders.text_tab_general',
    'fields' => [
        'order_menus' => [
            'type' => 'partial',
            'path' => 'orders/order_menus',
        ],
        'customer' => [
            'label' => 'lang:igniter.cart::default.orders.text_customer',
            'type' => 'partial',
            'path' => 'orders/field_customer',
        ],
        'location' => [
            'label' => 'lang:igniter.cart::default.orders.text_restaurant',
            'type' => 'partial',
            'path' => 'orders/field_location',
        ],
        'order_details' => [
            'type' => 'partial',
            'path' => 'orders/order_details',
        ],

        'status_history' => [
            'tab' => 'lang:igniter.cart::default.orders.text_status_history',
            'type' => 'datatable',
            'useAjax' => true,
            'defaultSort' => ['status_history_id', 'desc'],
            'columns' => [
                'date_added_since' => [
                    'title' => 'lang:igniter.cart::default.orders.column_time_date',
                ],
                'status_name' => [
                    'title' => 'lang:igniter::admin.label_status',
                ],
                'comment' => [
                    'title' => 'lang:igniter.cart::default.orders.column_comment',
                ],
                'notified' => [
                    'title' => 'lang:igniter.cart::default.orders.column_notify',
                ],
                'staff_name' => [
                    'title' => 'lang:igniter.cart::default.orders.column_staff',
                ],
            ],
        ],
    ],
];

return $config;
