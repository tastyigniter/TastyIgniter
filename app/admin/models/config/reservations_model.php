<?php

$config['list']['filter'] = [
    'search' => [
        'prompt' => 'lang:admin::lang.reservations.text_filter_search',
        'mode' => 'all',
    ],
    'scopes' => [
        'assignee' => [
            'label' => 'lang:admin::lang.reservations.text_filter_assignee',
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
            'type' => 'selectlist',
            'scope' => 'whereHasLocation',
            'modelClass' => 'Admin\Models\Locations_model',
            'nameFrom' => 'location_name',
            'locationAware' => true,
        ],
        'status' => [
            'label' => 'lang:admin::lang.text_filter_status',
            'type' => 'selectlist',
            'conditions' => 'status_id IN(:filtered)',
            'modelClass' => 'Admin\Models\Statuses_model',
            'options' => 'getDropdownOptionsForReservation',
        ],
        'date' => [
            'label' => 'lang:admin::lang.text_filter_date',
            'type' => 'daterange',
            'conditions' => 'reserve_date >= CAST(:filtered_start AS DATE) AND reserve_date <= CAST(:filtered_end AS DATE)',
        ],
    ],
];

$config['list']['toolbar'] = [
    'buttons' => [
        'create' => [
            'label' => 'lang:admin::lang.button_new',
            'class' => 'btn btn-primary',
            'href' => 'reservations/create',
        ],
        'calendar' => [
            'label' => 'lang:admin::lang.reservations.text_switch_to_calendar',
            'class' => 'btn btn-default',
            'href' => 'reservations/calendar',
            'context' => 'index',
        ],
    ],
];

$config['list']['bulkActions'] = [
    'delete' => [
        'label' => 'lang:admin::lang.button_delete',
        'class' => 'btn btn-light text-danger',
        'data-request-confirm' => 'lang:admin::lang.alert_warning_confirm',
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
        'label' => 'lang:admin::lang.column_id',
    ],
    'location_name' => [
        'label' => 'lang:admin::lang.reservations.column_location',
        'relation' => 'location',
        'select' => 'location_name',
        'searchable' => true,
        'locationAware' => true,
    ],
    'full_name' => [
        'label' => 'lang:admin::lang.label_name',
        'select' => "concat(first_name, ' ', last_name)",
        'searchable' => true,
    ],
    'guest_num' => [
        'label' => 'lang:admin::lang.reservations.column_guest',
        'type' => 'number',
        'searchable' => true,
    ],
    'table_name' => [
        'label' => 'lang:admin::lang.reservations.column_table',
        'type' => 'text',
        'relation' => 'tables',
        'select' => 'table_name',
        'searchable' => true,
    ],
    'status_name' => [
        'label' => 'lang:admin::lang.label_status',
        'relation' => 'status',
        'select' => 'status_name',
        'type' => 'partial',
        'path' => 'statuses/form/status_column',
        'searchable' => true,
    ],
    'assignee_name' => [
        'label' => 'lang:admin::lang.reservations.column_staff',
        'type' => 'text',
        'relation' => 'assignee',
        'select' => 'staff_name',
    ],
    'reserve_time' => [
        'label' => 'lang:admin::lang.reservations.column_time',
        'type' => 'time',
    ],
    'reserve_date' => [
        'label' => 'lang:admin::lang.reservations.column_date',
        'type' => 'date',
    ],
    'comment' => [
        'label' => 'lang:admin::lang.statuses.label_comment',
        'invisible' => true,
    ],
    'telephone' => [
        'label' => 'lang:admin::lang.customers.label_telephone',
        'searchable' => true,
        'invisible' => true,
    ],
    'email' => [
        'label' => 'lang:admin::lang.label_email',
        'searchable' => true,
        'invisible' => true,
    ],
];

$config['calendar']['toolbar'] = [
    'buttons' => [
        'create' => [
            'label' => 'lang:admin::lang.button_new',
            'class' => 'btn btn-primary',
            'href' => 'reservations/create',
        ],
        'list' => [
            'label' => 'lang:admin::lang.text_switch_to_list',
            'class' => 'btn btn-default',
            'href' => 'reservations',
            'context' => 'calendar',
        ],
    ],
];

$config['form']['toolbar'] = [
    'buttons' => [
        'back' => [
            'label' => 'lang:admin::lang.button_icon_back',
            'class' => 'btn btn-outline-secondary',
            'href' => 'reservations',
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
        'disabled' => true,
        'path' => 'reservations/form/info',
        'span' => 'left',
        'context' => ['edit', 'preview'],
    ],
    'status_id' => [
        'type' => 'statuseditor',
        'span' => 'right',
        'context' => ['edit', 'preview'],
        'form' => 'reservation_status_model',
        'request' => 'Admin\Requests\ReservationStatus',
    ],
];

$config['form']['tabs'] = [
    'defaultTab' => 'lang:admin::lang.reservations.text_tab_general',
    'fields' => [
        'tables' => [
            'label' => 'lang:admin::lang.reservations.label_table_name',
            'type' => 'relation',
            'nameFrom' => 'table_name',
        ],
        'guest_num' => [
            'label' => 'lang:admin::lang.reservations.label_guest',
            'type' => 'number',
            'span' => 'left',
            'cssClass' => 'flex-width',
        ],
        'duration' => [
            'label' => 'lang:admin::lang.reservations.label_reservation_duration',
            'type' => 'number',
            'span' => 'left',
            'cssClass' => 'flex-width',
            'comment' => 'lang:admin::lang.reservations.help_reservation_duration',
        ],
        'reserve_date' => [
            'label' => 'lang:admin::lang.reservations.label_reservation_date',
            'type' => 'datepicker',
            'mode' => 'date',
            'span' => 'right',
            'cssClass' => 'flex-width',
        ],
        'reserve_time' => [
            'label' => 'lang:admin::lang.reservations.label_reservation_time',
            'type' => 'datepicker',
            'mode' => 'time',
            'span' => 'right',
            'cssClass' => 'flex-width',
        ],
        'first_name' => [
            'label' => 'lang:admin::lang.reservations.label_first_name',
            'type' => 'text',
            'span' => 'left',
        ],
        'last_name' => [
            'label' => 'lang:admin::lang.reservations.label_last_name',
            'type' => 'text',
            'span' => 'right',
        ],
        'email' => [
            'label' => 'lang:admin::lang.label_email',
            'type' => 'text',
            'span' => 'left',
        ],
        'telephone' => [
            'label' => 'lang:admin::lang.reservations.label_customer_telephone',
            'type' => 'text',
            'span' => 'right',
        ],
        'location_id' => [
            'label' => 'lang:admin::lang.reservations.text_tab_restaurant',
            'type' => 'relation',
            'relationFrom' => 'location',
            'nameFrom' => 'location_name',
            'span' => 'left',
            'placeholder' => 'lang:admin::lang.text_please_select',
        ],
        'notify' => [
            'label' => 'lang:admin::lang.reservations.label_send_confirmation',
            'type' => 'switch',
            'span' => 'right',
            'default' => 1,
        ],
        'comment' => [
            'label' => 'lang:admin::lang.statuses.label_comment',
            'type' => 'textarea',
        ],
        'created_at' => [
            'label' => 'lang:admin::lang.reservations.label_date_added',
            'type' => 'datepicker',
            'mode' => 'date',
            'disabled' => true,
            'span' => 'left',
            'context' => ['edit', 'preview'],
        ],
        'ip_address' => [
            'label' => 'lang:admin::lang.reservations.label_ip_address',
            'type' => 'text',
            'span' => 'right',
            'disabled' => true,
            'context' => ['edit', 'preview'],
        ],
        'updated_at' => [
            'label' => 'lang:admin::lang.reservations.label_date_modified',
            'type' => 'datepicker',
            'mode' => 'date',
            'disabled' => true,
            'span' => 'left',
            'context' => ['edit', 'preview'],
        ],
        'user_agent' => [
            'label' => 'lang:admin::lang.reservations.label_user_agent',
            'type' => 'text',
            'span' => 'right',
            'disabled' => true,
            'context' => ['edit', 'preview'],
        ],
        'status_history' => [
            'tab' => 'lang:admin::lang.reservations.text_status_history',
            'type' => 'datatable',
            'context' => ['edit', 'preview'],
            'useAjax' => true,
            'defaultSort' => ['status_history_id', 'desc'],
            'columns' => [
                'date_added_since' => [
                    'title' => 'lang:admin::lang.reservations.column_date_time',
                ],
                'status_name' => [
                    'title' => 'lang:admin::lang.label_status',
                ],
                'comment' => [
                    'title' => 'lang:admin::lang.reservations.column_comment',
                ],
                'notified' => [
                    'title' => 'lang:admin::lang.reservations.column_notify',
                ],
                'staff_name' => [
                    'title' => 'lang:admin::lang.reservations.column_staff',
                ],
            ],
        ],
    ],
];

return $config;
