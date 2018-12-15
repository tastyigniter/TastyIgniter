<?php
$config['list']['filter'] = [
    'search' => [
        'prompt' => 'lang:admin::lang.reservations.text_filter_search',
        'mode' => 'all',
    ],
    'scopes' => [
        'location' => [
            'label' => 'lang:admin::lang.reservations.text_filter_location',
            'type' => 'select',
            'conditions' => 'location_id = :filtered',
            'modelClass' => 'Admin\Models\Locations_model',
            'nameFrom' => 'location_name',
        ],
        'status' => [
            'label' => 'lang:admin::lang.reservations.text_filter_status',
            'type' => 'select',
            'conditions' => 'status_id = :filtered',
            'modelClass' => 'Admin\Models\Statuses_model',
            'options' => 'getDropdownOptionsForReservation',
        ],
        'date' => [
            'label' => 'lang:admin::lang.reservations.text_filter_date',
            'type' => 'date',
            'conditions' => 'YEAR(date_added) = :year AND MONTH(date_added) = :month',
            'modelClass' => 'Admin\Models\Reservations_model',
            'options' => 'getReservationDates',
        ],
    ],
];

$config['list']['toolbar'] = [
    'buttons' => [
        'create' => ['label' => 'lang:admin::lang.button_new', 'class' => 'btn btn-primary', 'href' => 'reservations/create'],
        'delete' => ['label' => 'lang:admin::lang.button_delete', 'class' => 'btn btn-danger', 'data-request-form' => '#list-form', 'data-request' => 'onDelete', 'data-request-data' => "_method:'DELETE'", 'data-request-confirm' => 'lang:admin::lang.alert_warning_confirm'],
        'calendar' => [
            'label' => 'lang:admin::lang.reservations.text_switch_to_calendar',
            'class' => 'btn btn-default',
            'href' => 'reservations/calendar',
            'context' => 'index',
        ],
        'filter' => ['label' => 'lang:admin::lang.button_icon_filter', 'class' => 'btn btn-default btn-filter', 'data-toggle' => 'list-filter', 'data-target' => '.list-filter'],
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
    'location' => [
        'label' => 'lang:admin::lang.reservations.column_location',
        'relation' => 'location',
        'select' => 'location_name',
        'searchable' => TRUE,
    ],
    'full_name' => [
        'label' => 'lang:admin::lang.reservations.column_customer_name',
        'select' => "concat(first_name, ' ', last_name)",
        'searchable' => TRUE,
    ],
    'guest_num' => [
        'label' => 'lang:admin::lang.reservations.column_guest',
        'type' => 'number',
        'searchable' => TRUE,
    ],
    'table_name' => [
        'label' => 'lang:admin::lang.reservations.column_table',
        'type' => 'text',
        'relation' => 'related_table',
        'select' => 'table_name',
        'searchable' => TRUE,
    ],
    'status_name' => [
        'label' => 'lang:admin::lang.reservations.column_status',
        'relation' => 'status',
        'select' => 'status_name',
        'type' => 'partial',
        'path' => 'reservations/status_column',
        'searchable' => TRUE,
    ],
    'assignee_id' => [
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
    'reservation_id' => [
        'label' => 'lang:admin::lang.column_id',
        'invisible' => TRUE,
    ],

];

$config['calendar']['toolbar'] = [
    'buttons' => [
        'create' => ['label' => 'lang:admin::lang.button_new', 'class' => 'btn btn-primary', 'href' => 'reservations/create'],
        'list' => [
            'label' => 'lang:admin::lang.reservations.text_switch_to_list',
            'class' => 'btn btn-default',
            'href' => 'reservations',
            'context' => 'calendar',
        ],
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
    'reservation_id' => [
        'label' => 'lang:admin::lang.reservations.label_reservation_id',
        'type' => 'text',
        'span' => 'left',
        'disabled' => TRUE,
        'context' => ['edit', 'preview'],
    ],
    'table_name' => [
        'label' => 'lang:admin::lang.reservations.label_table_name',
        'type' => 'text',
        'span' => 'right',
        'disabled' => TRUE,
        'context' => ['edit', 'preview'],
    ],
    'status_id' => [
        'label' => 'lang:admin::lang.label_status',
        'type' => 'statuseditor',
        'span' => 'left',
        'relationFrom' => 'status',
        'options' => ['Admin\Models\Statuses_model', 'listStatuses'],
        'list' => 'status_history_model',
        'form' => [
            'fields' => [
                'status_id' => [
                    'label' => 'lang:admin::lang.label_status',
                    'type' => 'select',
                    'options' => ['Admin\Models\Statuses_model', 'getDropdownOptionsForReservation'],
                    'placeholder' => 'lang:admin::lang.text_please_select',
                    'attributes' => [
                        'data-status-value' => '',
                    ],
                ],
                'comment' => [
                    'label' => 'lang:admin::lang.reservations.label_comment',
                    'type' => 'textarea',
                    'attributes' => [
                        'data-status-comment' => '',
                    ],
                ],
                'notify' => [
                    'label' => 'lang:admin::lang.reservations.label_notify',
                    'type' => 'radio',
                    'default' => 1,
                    'options' => [
                        'lang:admin::lang.text_no',
                        'lang:admin::lang.text_yes',
                    ],
                    'comment' => 'lang:admin::lang.reservations.help_notify_customer',
                    'attributes' => [
                        'data-status-notify' => '',
                    ],
                ],
            ],
        ],
    ],
    'assignee_id' => [
        'label' => 'lang:admin::lang.reservations.label_assign_staff',
        'type' => 'relation',
        'relationFrom' => 'assignee',
        'nameFrom' => 'staff_name',
        'span' => 'right',
        'placeholder' => 'lang:admin::lang.text_please_select',
    ],
];

$config['form']['tabs'] = [
    'defaultTab' => 'lang:admin::lang.reservations.text_tab_general',
    'fields' => [
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
            'label' => 'lang:admin::lang.reservations.label_customer_email',
            'type' => 'text',
            'span' => 'left',
        ],
        'telephone' => [
            'label' => 'lang:admin::lang.reservations.label_customer_telephone',
            'type' => 'text',
            'span' => 'right',
        ],
        'reserve_date' => [
            'label' => 'lang:admin::lang.reservations.label_reservation_date',
            'type' => 'datepicker',
            'mode' => 'date',
            'span' => 'left',
            'cssClass' => 'flex-width',
        ],
        'reserve_time' => [
            'label' => 'lang:admin::lang.reservations.label_reservation_time',
            'type' => 'datepicker',
            'mode' => 'time',
            'span' => 'left',
            'cssClass' => 'flex-width',
        ],
        'location_id' => [
            'label' => 'lang:admin::lang.reservations.text_tab_restaurant',
            'type' => 'relation',
            'relationFrom' => 'location',
            'nameFrom' => 'location_name',
            'span' => 'right',
            'placeholder' => 'lang:admin::lang.text_please_select',
        ],
        'guest_num' => [
            'label' => 'lang:admin::lang.reservations.label_guest',
            'type' => 'number',
            'span' => 'left',
            'cssClass' => 'flex-width',
        ],
        'table_id' => [
            'label' => 'lang:admin::lang.reservations.label_table_name',
            'type' => 'relation',
            'relationFrom' => 'related_table',
            'nameFrom' => 'table_name',
            'span' => 'left',
            'cssClass' => 'flex-width',
        ],
        'duration' => [
            'label' => 'lang:admin::lang.reservations.label_reservation_duration',
            'type' => 'number',
            'span' => 'right',
            'comment' => 'lang:admin::lang.reservations.help_reservation_duration',
        ],
        'notify' => [
            'label' => 'lang:admin::lang.reservations.label_send_confirmation',
            'type' => 'switch',
            'span' => 'left',
            'default' => 1,
        ],
        'comment' => [
            'label' => 'lang:admin::lang.reservations.label_comment',
            'type' => 'textarea',
        ],
        'date_added' => [
            'label' => 'lang:admin::lang.reservations.label_date_added',
            'type' => 'datepicker',
            'mode' => 'date',
            'disabled' => TRUE,
            'span' => 'left',
            'context' => ['edit', 'preview'],
        ],
        'ip_address' => [
            'label' => 'lang:admin::lang.reservations.label_ip_address',
            'type' => 'text',
            'span' => 'right',
            'disabled' => TRUE,
            'context' => ['edit', 'preview'],
        ],
        'date_modified' => [
            'label' => 'lang:admin::lang.reservations.label_date_modified',
            'type' => 'datepicker',
            'mode' => 'date',
            'disabled' => TRUE,
            'span' => 'left',
            'context' => ['edit', 'preview'],
        ],
        'user_agent' => [
            'label' => 'lang:admin::lang.reservations.label_user_agent',
            'type' => 'text',
            'span' => 'right',
            'disabled' => TRUE,
            'context' => ['edit', 'preview'],
        ],
        'status_history' => [
            'tab' => 'lang:admin::lang.reservations.text_status_history',
            'type' => 'datatable',
            'columns' => [
                'date_added' => [
                    'title' => 'lang:admin::lang.reservations.column_date_time',
                ],
                'staff_name' => [
                    'title' => 'lang:admin::lang.reservations.column_staff',
                ],
                'assignee_name' => [
                    'title' => 'lang:admin::lang.reservations.column_assignee',
                ],
                'status_name' => [
                    'title' => 'lang:admin::lang.reservations.column_status',
                ],
                'comment' => [
                    'title' => 'lang:admin::lang.reservations.column_comment',
                ],
                'notified' => [
                    'title' => 'lang:admin::lang.reservations.column_notify',
                ],
            ],
        ],
    ],
];

return $config;