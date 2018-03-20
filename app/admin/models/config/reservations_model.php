<?php
$config['list']['filter'] = [
    'search' => [
        'prompt' => 'lang:admin::reservations.text_filter_search',
        'mode'   => 'all',
    ],
    'scopes' => [
        'location' => [
            'label'      => 'lang:admin::reservations.text_filter_location',
            'type'       => 'select',
            'conditions' => 'location_id = :filtered',
            'modelClass' => 'Admin\Models\Locations_model',
            'nameFrom'   => 'location_name',
        ],
        'status'   => [
            'label'      => 'lang:admin::reservations.text_filter_status',
            'type'       => 'select',
            'conditions' => 'status_id = :filtered',
            'modelClass' => 'Admin\Models\Statuses_model',
            'nameFrom'   => 'status_name',
        ],
        'date'     => [
            'label'      => 'lang:admin::reservations.text_filter_date',
            'type'       => 'date',
            'conditions' => 'YEAR(date_added) = :year AND MONTH(date_added) = :month',
            'modelClass' => 'Admin\Models\Reservations_model',
            'options'    => 'getReservationDates',
        ],
    ],
];

$config['list']['toolbar'] = [
    'buttons' => [
        'delete' => ['label' => 'lang:admin::default.button_delete', 'class' => 'btn btn-danger', 'data-request-form' => '#list-form', 'data-request' => 'onDelete', 'data-request-data' => "_method:'DELETE'", 'data-request-confirm' => 'lang:admin::default.alert_warning_confirm'],
        'filter' => ['label' => 'lang:admin::default.button_icon_filter', 'class' => 'btn btn-default btn-filter', 'data-toggle' => 'list-filter', 'data-target' => '.panel-filter .panel-body'],
    ],
];

$config['list']['columns'] = [
    'edit'           => [
        'type'         => 'button',
        'iconCssClass' => 'fa fa-pencil',
        'attributes'   => [
            'class' => 'btn btn-edit',
            'href'  => 'reservations/edit/{reservation_id}',
        ],
    ],
    'location'       => [
        'label'      => 'lang:admin::reservations.column_location',
        'relation'   => 'location',
        'select'     => 'location_name',
        'searchable' => TRUE,
    ],
    'full_name'      => [
        'label'      => 'lang:admin::reservations.column_customer_name',
        'select'     => "concat(first_name, ' ', last_name)",
        'searchable' => TRUE,
    ],
    'guest_num'      => [
        'label'      => 'lang:admin::reservations.column_guest',
        'type'       => 'number',
        'searchable' => TRUE,
    ],
    'table_name'     => [
        'label'      => 'lang:admin::reservations.column_table',
        'type'       => 'text',
        'relation'   => 'reserved_table',
        'select'     => 'table_name',
        'searchable' => TRUE,
    ],
    'status'         => [
        'label'      => 'lang:admin::reservations.column_status',
        'relation'   => 'status',
        'select'     => 'status_name',
        'type'       => 'partial',
        'path'       => 'reservations/status_column',
        'searchable' => TRUE,
    ],
    'staff_name'     => [
        'label' => 'lang:admin::reservations.column_staff',
        'type'  => 'text',
    ],
    'reserve_time'   => [
        'label'     => 'lang:admin::reservations.column_time',
        'type'      => 'date',
        'invisible' => TRUE,
    ],
    'reserve_date'   => [
        'label'     => 'lang:admin::reservations.column_date',
        'type'      => 'time',
        'invisible' => TRUE,
    ],
    'reservation_id' => [
        'label'     => 'lang:admin::reservations.column_id',
        'invisible' => TRUE,
    ],

];

$config['form']['toolbar'] = [
    'buttons' => [
        'save'      => ['label' => 'lang:admin::default.button_save', 'class' => 'btn btn-primary', 'data-request-form' => '#edit-form', 'data-request' => 'onSave'],
        'saveClose' => [
            'label'             => 'lang:admin::default.button_save_close',
            'class'             => 'btn btn-default',
            'data-request'      => 'onSave',
            'data-request-form' => '#edit-form',
            'data-request-data' => 'close:1',
        ],
        'delete'    => [
            'label'                => 'lang:admin::default.button_icon_delete', 'class' => 'btn btn-danger',
            'data-request-form'    => '#edit-form', 'data-request' => 'onDelete', 'data-request-data' => "_method:'DELETE'",
            'data-request-confirm' => 'lang:admin::default.alert_warning_confirm', 'context' => ['edit'],
        ],
        'back'      => ['label' => 'lang:admin::default.button_icon_back', 'class' => 'btn btn-default', 'href' => 'reservations'],
    ],
];

$config['form']['fields'] = [
    'reservation_id' => [
        'label'    => 'lang:admin::reservations.label_reservation_id',
        'type'     => 'text',
        'disabled' => TRUE,
        'span'     => 'left',
        'context'  => ['edit', 'preview'],
    ],
    'table_name'     => [
        'label'    => 'lang:admin::reservations.label_table_name',
        'type'     => 'text',
        'disabled' => TRUE,
        'span'     => 'right',
        'context'  => ['edit', 'preview'],
    ],
];

$config['form']['tabs'] = [
    'defaultTab' => 'lang:admin::reservations.text_tab_general',
    'fields'     => [
        'customer_name' => [
            'label' => 'lang:admin::reservations.label_customer_name',
            'type'  => 'text',
            'span'  => 'left',
        ],
        'status_id'     => [
            'label'   => 'lang:admin::default.label_status',
            'type'    => 'statuseditor',
            'span'    => 'right',
            'options' => ['Admin\Models\Statuses_model', 'listStatuses'],
            'list'    => 'status_history_model',
            'form'    => [
                'fields' => [
                    'assignee_id'    => [
                        'label'       => 'lang:admin::reservations.label_assign_staff',
                        'type'        => 'select',
                        'options'     => ['Admin\Models\Staffs_model', 'getDropdownOptions'],
                        'placeholder' => 'lang:admin::default.text_please_select',
                    ],
                    'order_status'   => [
                        'label'       => 'lang:admin::default.label_status',
                        'type'        => 'select',
                        'options'     => ['Admin\Models\Statuses_model', 'getDropdownOptionsForReservation'],
                        'placeholder' => 'lang:admin::default.text_please_select',
                        'attributes'  => [
                            'data-status-value' => '',
                        ],
                    ],
                    'status_comment' => [
                        'label'      => 'lang:admin::reservations.label_comment',
                        'type'       => 'textarea',
                        'attributes' => [
                            'data-status-comment' => '',
                        ],
                    ],
                    'status_notify'  => [
                        'label'      => 'lang:admin::reservations.label_notify',
                        'type'       => 'radio',
                        'default'    => 1,
                        'options'    => [
                            'lang:admin::default.text_no',
                            'lang:admin::default.text_yes',
                        ],
                        'comment'    => 'lang:admin::reservations.help_notify_customer',
                        'attributes' => [
                            'data-status-notify' => '',
                        ],
                    ],
                ],
            ],
        ],
        'guest_num'     => [
            'label' => 'lang:admin::reservations.label_guest',
            'type'  => 'number',
            'span'  => 'left',
        ],
        'occasion'      => [
            'label'   => 'lang:admin::reservations.label_occasion',
            'type'    => 'select',
            'span'    => 'right',
            'options' => 'getOccasionOptions',
        ],
        'min_capacity'  => [
            'label'     => 'lang:admin::reservations.label_table_min_capacity',
            'type'      => 'number',
            'valueFrom' => 'reserved_table',
            'span'      => 'left',
            'disabled'  => TRUE,
            'context'   => ['edit', 'preview'],
        ],
        'max_capacity'  => [
            'label'     => 'lang:admin::reservations.label_table_capacity',
            'type'      => 'number',
            'valueFrom' => 'reserved_table',
            'span'      => 'right',
            'disabled'  => TRUE,
            'context'   => ['edit', 'preview'],
        ],
        'reserve_date'  => [
            'label'    => 'lang:admin::reservations.label_reservation_date',
            'type'     => 'datepicker',
            'mode'     => 'date',
            'span'     => 'left',
            'cssClass' => 'flex-width',
        ],
        'reserve_time'  => [
            'label'    => 'lang:admin::reservations.label_reservation_time',
            'type'     => 'datepicker',
            'mode'     => 'time',
            'span'     => 'left',
            'cssClass' => 'flex-width',
        ],
        'location_id'   => [
            'label'        => 'lang:admin::reservations.text_tab_restaurant',
            'type'         => 'relation',
            'relationFrom' => 'location',
            'nameFrom'     => 'location_name',
            'span'         => 'right',
            'placeholder'  => 'lang:admin::default.text_please_select',
        ],
        'notify'        => [
            'label'   => 'lang:admin::reservations.label_send_confirmation',
            'type'    => 'switch',
            'span'    => 'left',
            'default' => 1,
        ],
        'comment'       => [
            'label' => 'lang:admin::reservations.label_comment',
            'type'  => 'textarea',
        ],
        'date_added'    => [
            'label'    => 'lang:admin::reservations.label_date_added',
            'type'     => 'datepicker',
            'mode'     => 'date',
            'disabled' => TRUE,
            'span'     => 'left',
            'context'  => ['edit', 'preview'],
        ],
        'date_modified' => [
            'label'    => 'lang:admin::reservations.label_date_modified',
            'type'     => 'datepicker',
            'mode'     => 'date',
            'disabled' => TRUE,
            'span'     => 'right',
            'context'  => ['edit', 'preview'],
        ],
        'ip_address'    => [
            'label'    => 'lang:admin::reservations.label_ip_address',
            'type'     => 'text',
            'span'     => 'left',
            'disabled' => TRUE,
            'context'  => ['edit', 'preview'],
        ],
        'user_agent'    => [
            'label'    => 'lang:admin::reservations.label_user_agent',
            'type'     => 'text',
            'span'     => 'right',
            'disabled' => TRUE,
            'context'  => ['edit', 'preview'],
        ],
    ],
];

return $config;