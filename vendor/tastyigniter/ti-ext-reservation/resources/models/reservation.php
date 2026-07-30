<?php

use Igniter\Admin\Models\Status;
use Igniter\Reservation\Http\Requests\ReservationStatusRequest;
use Igniter\User\Models\Customer;

$listButtonItems = [
    'index' => [
        'label' => 'igniter.reservation::default.text_view_list',
        'class' => 'dropdown-item',
        'href' => 'reservations',
    ],
    'calendar' => [
        'label' => 'igniter.reservation::default.text_view_calendar',
        'class' => 'dropdown-item',
        'href' => 'reservations/calendar',
    ],
    'floor_plan' => [
        'label' => 'igniter.reservation::default.text_view_floor_plan',
        'class' => 'dropdown-item',
        'href' => 'reservations/floor_plan',
    ],
];

$config['list']['filter'] = [
    'search' => [
        'prompt' => 'lang:igniter.reservation::default.text_filter_search',
        'mode' => 'all',
    ],
    'scopes' => [
        'assignee' => [
            'label' => 'lang:igniter.reservation::default.text_filter_assignee',
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
            'conditions' => 'status_id IN(:filtered)',
            'modelClass' => Status::class,
            'options' => 'getDropdownOptionsForReservation',
        ],
        'date' => [
            'label' => 'lang:igniter::admin.text_filter_date',
            'type' => 'daterange',
            'conditions' => 'reserve_date >= CAST(:filtered_start AS DATE) AND reserve_date <= CAST(:filtered_end AS DATE)',
        ],
    ],
];

$config['list']['toolbar'] = [
    'buttons' => [
        'create' => [
            'label' => 'lang:igniter::admin.button_new',
            'class' => 'btn btn-primary',
            'href' => 'reservations/create',
        ],
        'calendar' => [
            'label' => 'lang:igniter.reservation::default.text_view_list',
            'class' => 'btn btn-default',
            'type' => 'dropdown',
            'menuItems' => $listButtonItems,
            'context' => 'index',
        ],
    ],
];

$config['list']['bulkActions'] = [
    'assign_table' => [
        'label' => 'lang:igniter.reservation::default.button_assign_table',
        'class' => 'btn btn-light',
        'permissions' => 'Admin.AssignTables',
    ],
    'delete' => [
        'label' => 'lang:igniter::admin.button_delete',
        'class' => 'btn btn-light text-danger',
        'data-request-confirm' => 'lang:igniter::admin.alert_warning_confirm',
        'permissions' => 'Admin.DeleteReservations',
    ],
];

$config['list']['columns'] = [
    'edit' => [
        'type' => 'button',
        'iconCssClass' => 'fa fa-pencil',
        'attributes' => [
            'class' => 'btn btn-edit',
            'href' => 'reservations/edit/{reservation_id}',
        ],
    ],
    'reservation_id' => [
        'label' => 'lang:igniter::admin.column_id',
    ],
    'location_name' => [
        'label' => 'lang:igniter.reservation::default.column_location',
        'relation' => 'location',
        'select' => 'location_name',
        'searchable' => true,
        'locationAware' => true,
    ],
    'full_name' => [
        'label' => 'lang:igniter::admin.label_name',
        'select' => "concat(first_name, ' ', last_name)",
        'searchable' => true,
    ],
    'guest_num' => [
        'label' => 'lang:igniter.reservation::default.column_guest',
        'type' => 'number',
        'searchable' => true,
    ],
    'table_name' => [
        'label' => 'lang:igniter.reservation::default.column_table',
        'type' => 'partial',
        'path' => 'reservations/lists/column_table_name',
        'searchable' => false,
        'sortable' => false,
    ],
    'status_name' => [
        'label' => 'lang:igniter::admin.label_status',
        'relation' => 'status',
        'select' => 'status_name',
        'type' => 'partial',
        'path' => 'statuses/status_column',
        'searchable' => true,
    ],
    'assignee_name' => [
        'label' => 'lang:igniter.reservation::default.column_staff',
        'type' => 'text',
        'relation' => 'assignee',
        'select' => 'name',
    ],
    'reserve_time' => [
        'label' => 'lang:igniter.reservation::default.column_time',
        'type' => 'time',
    ],
    'reserve_date' => [
        'label' => 'lang:igniter.reservation::default.column_date',
        'type' => 'date',
    ],
    'comment' => [
        'label' => 'lang:admin::lang.statuses.label_comment',
        'invisible' => true,
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
];

$config['calendar']['toolbar'] = [
    'buttons' => [
        'create' => [
            'label' => 'lang:igniter::admin.button_new',
            'class' => 'btn btn-primary',
            'href' => 'reservations/create',
        ],
        'list' => [
            'label' => 'lang:igniter.reservation::default.text_view_calendar',
            'class' => 'btn btn-default',
            'type' => 'dropdown',
            'context' => 'calendar',
            'menuItems' => $listButtonItems,
        ],
    ],
];

$config['form']['toolbar'] = [
    'buttons' => [
        'save' => [
            'label' => 'lang:igniter::admin.button_save',
            'context' => ['create', 'edit'],
            'partial' => 'form/toolbar_save_button',
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
        'path' => 'reservations/form/info',
        'span' => 'left',
        'context' => ['edit', 'preview'],
    ],
    'status_id' => [
        'type' => 'statuseditor',
        'span' => 'right',
        'context' => ['edit', 'preview'],
        'form' => 'reservationstatus',
        'request' => ReservationStatusRequest::class,
    ],
];

$config['form']['tabs'] = [
    'defaultTab' => 'lang:igniter.reservation::default.text_tab_general',
    'fields' => [
        'tables' => [
            'label' => 'lang:igniter.reservation::default.label_table_name',
            'type' => 'relation',
            'relationFrom' => 'tables',
            'nameFrom' => 'summary',
            'span' => 'left',
        ],
        'guest_num' => [
            'label' => 'lang:igniter.reservation::default.label_guest',
            'type' => 'number',
            'span' => 'right',
        ],
        'reserve_date' => [
            'label' => 'lang:igniter.reservation::default.label_reservation_date',
            'type' => 'datepicker',
            'mode' => 'date',
            'span' => 'left',
        ],
        'reserve_time' => [
            'label' => 'lang:igniter.reservation::default.label_reservation_time',
            'type' => 'datepicker',
            'mode' => 'time',
            'span' => 'right',
        ],
        'customer_id' => [
            'label' => 'lang:igniter.reservation::default.text_customer',
            'type' => 'select',
            'options' => [Customer::class, 'getDropdownOptions'],
            'placeholder' => 'lang:igniter.reservation::default.text_guest',
        ],
        'first_name' => [
            'label' => 'lang:igniter.reservation::default.label_first_name',
            'type' => 'text',
            'span' => 'left',
            'trigger' => [
                'action' => 'show',
                'field' => 'customer_id',
                'condition' => 'value[]',
            ],
        ],
        'last_name' => [
            'label' => 'lang:igniter.reservation::default.label_last_name',
            'type' => 'text',
            'span' => 'right',
            'trigger' => [
                'action' => 'show',
                'field' => 'customer_id',
                'condition' => 'value[]',
            ],
        ],
        'email' => [
            'label' => 'lang:igniter::admin.label_email',
            'type' => 'text',
            'span' => 'left',
            'trigger' => [
                'action' => 'show',
                'field' => 'customer_id',
                'condition' => 'value[]',
            ],
        ],
        'telephone' => [
            'label' => 'lang:igniter.reservation::default.label_customer_telephone',
            'type' => 'text',
            'span' => 'right',
            'trigger' => [
                'action' => 'show',
                'field' => 'customer_id',
                'condition' => 'value[]',
            ],
        ],
        'location_id' => [
            'label' => 'lang:igniter.reservation::default.text_tab_restaurant',
            'type' => 'relation',
            'relationFrom' => 'location',
            'nameFrom' => 'location_name',
            'span' => 'right',
            'placeholder' => 'lang:igniter::admin.text_please_select',
        ],
        'duration' => [
            'label' => 'lang:igniter.reservation::default.label_reservation_duration',
            'type' => 'number',
            'span' => 'left',
            'comment' => 'lang:igniter.reservation::default.help_reservation_duration',
        ],
        'comment' => [
            'label' => 'lang:igniter::admin.statuses.label_comment',
            'type' => 'textarea',
        ],
        'notify' => [
            'label' => 'lang:igniter.reservation::default.label_send_confirmation',
            'type' => 'switch',
            'span' => 'left',
            'default' => 1,
        ],
        'created_at' => [
            'label' => 'lang:igniter.reservation::default.label_date_added',
            'type' => 'datepicker',
            'mode' => 'date',
            'disabled' => true,
            'span' => 'left',
            'context' => ['edit', 'preview'],
        ],
        'ip_address' => [
            'label' => 'lang:igniter.reservation::default.label_ip_address',
            'type' => 'text',
            'span' => 'right',
            'disabled' => true,
            'context' => ['edit', 'preview'],
        ],
        'updated_at' => [
            'label' => 'lang:igniter.reservation::default.label_date_modified',
            'type' => 'datepicker',
            'mode' => 'date',
            'disabled' => true,
            'span' => 'left',
            'context' => ['edit', 'preview'],
        ],
        'user_agent' => [
            'label' => 'lang:igniter.reservation::default.label_user_agent',
            'type' => 'text',
            'span' => 'right',
            'disabled' => true,
            'context' => ['edit', 'preview'],
        ],
        'status_history' => [
            'tab' => 'lang:igniter.reservation::default.text_status_history',
            'type' => 'datatable',
            'context' => ['edit', 'preview'],
            'useAjax' => true,
            'defaultSort' => ['status_history_id', 'desc'],
            'columns' => [
                'date_added_since' => [
                    'title' => 'lang:igniter.reservation::default.column_date_time',
                ],
                'status_name' => [
                    'title' => 'lang:igniter::admin.label_status',
                ],
                'comment' => [
                    'title' => 'lang:igniter.reservation::default.column_comment',
                ],
                'notified' => [
                    'title' => 'lang:igniter.reservation::default.column_notify',
                ],
                'staff_name' => [
                    'title' => 'lang:igniter.reservation::default.column_staff',
                ],
            ],
        ],
    ],
];

return $config;
