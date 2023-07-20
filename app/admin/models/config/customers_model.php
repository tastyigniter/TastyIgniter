<?php
$config['list']['filter'] = [
    'search' => [
        'prompt' => 'lang:admin::lang.customers.text_filter_search',
        'mode' => 'all', // or any, exact
    ],
    'scopes' => [
        'date' => [
            'label' => 'lang:admin::lang.text_filter_date',
            'type' => 'date',
            'conditions' => 'YEAR(created_at) = :year AND MONTH(created_at) = :month AND DAY(created_at) = :day',
        ],
        'status' => [
            'label' => 'lang:admin::lang.text_filter_status',
            'type' => 'switch',
        ],
    ],
];

$config['list']['toolbar'] = [
    'buttons' => [
        'create' => [
            'label' => 'lang:admin::lang.button_new',
            'class' => 'btn btn-primary',
            'href' => 'customers/create',
        ],
        'groups' => [
            'label' => 'lang:admin::lang.side_menu.customer_group',
            'class' => 'btn btn-default',
            'href' => 'customer_groups',
            'permission' => 'Admin.CustomerGroups',
        ],
    ],
];

$config['list']['bulkActions'] = [
    'status' => [
        'label' => 'lang:admin::lang.list.actions.label_status',
        'type' => 'dropdown',
        'class' => 'btn btn-light',
        'statusColumn' => 'status',
        'menuItems' => [
            'enable' => [
                'label' => 'lang:admin::lang.list.actions.label_enable',
                'type' => 'button',
                'class' => 'dropdown-item',
            ],
            'disable' => [
                'label' => 'lang:admin::lang.list.actions.label_disable',
                'type' => 'button',
                'class' => 'dropdown-item text-danger',
            ],
        ],
    ],
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
            'href' => 'customers/edit/{customer_id}',
        ],
    ],
    'impersonate' => [
        'type' => 'button',
        'iconCssClass' => 'fa fa-user',
        'permissions' => 'Admin.ImpersonateCustomers',
        'attributes' => [
            'class' => 'btn btn-outline-secondary',
            'data-request' => 'onImpersonate',
            'data-request-data' => 'recordId: \'{customer_id}\'',
            'data-request-confirm' => 'admin::lang.customers.alert_impersonate_confirm',
        ],
    ],
    'full_name' => [
        'label' => 'lang:admin::lang.customers.column_full_name',
        'type' => 'text',
        'select' => 'concat(first_name, " ", last_name)',
        'searchable' => true,
    ],
    'email' => [
        'label' => 'lang:admin::lang.label_email',
        'type' => 'text',
        'searchable' => true,
    ],
    'telephone' => [
        'label' => 'lang:admin::lang.customers.column_telephone',
        'type' => 'text',
    ],
    'status' => [
        'label' => 'lang:admin::lang.label_status',
        'type' => 'switch',
    ],
    'customer_id' => [
        'label' => 'lang:admin::lang.column_id',
        'invisible' => true,
    ],
    'created_at' => [
        'label' => 'lang:admin::lang.column_date_added',
        'invisible' => true,
        'type' => 'datetime',
    ],
    'updated_at' => [
        'label' => 'lang:admin::lang.column_date_updated',
        'invisible' => true,
        'type' => 'datetime',
    ],
];

$config['form']['toolbar'] = [
    'buttons' => [
        'back' => [
            'label' => 'lang:admin::lang.button_icon_back',
            'class' => 'btn btn-outline-secondary',
            'href' => 'customers',
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
        'impersonate' => [
            'label' => 'lang:admin::lang.customers.text_impersonate',
            'class' => 'btn btn-default',
            'data-request' => 'onImpersonate',
            'data-request-confirm' => 'admin::lang.customers.alert_impersonate_confirm',
            'context' => ['edit'],
            'permission' => 'Admin.ImpersonateCustomers',
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
            'label' => 'lang:admin::lang.label_email',
            'type' => 'text',
            'span' => 'left',
        ],
        'telephone' => [
            'label' => 'lang:admin::lang.customers.label_telephone',
            'type' => 'text',
            'span' => 'right',
        ],
        'send_invite' => [
            'label' => 'lang:admin::lang.customers.label_send_invite',
            'type' => 'checkbox',
            'context' => 'create',
            'default' => true,
            'options' => [],
            'placeholder' => 'lang:admin::lang.customers.help_send_invite',
        ],
        'password' => [
            'label' => 'lang:admin::lang.customers.label_password',
            'type' => 'password',
            'span' => 'left',
            'comment' => 'lang:admin::lang.customers.help_password',
            'trigger' => [
                'action' => 'show',
                'field' => 'send_invite',
                'condition' => 'unchecked',
            ],
        ],
        '_confirm_password' => [
            'label' => 'lang:admin::lang.customers.label_confirm_password',
            'type' => 'password',
            'span' => 'right',
            'trigger' => [
                'action' => 'show',
                'field' => 'send_invite',
                'condition' => 'unchecked',
            ],
        ],
        'customer_group_id' => [
            'label' => 'lang:admin::lang.customers.label_customer_group',
            'type' => 'relation',
            'span' => 'left',
            'relationFrom' => 'group',
            'nameFrom' => 'group_name',
            'placeholder' => 'lang:admin::lang.text_please_select',
        ],
        'newsletter' => [
            'label' => 'lang:admin::lang.customers.label_newsletter',
            'type' => 'switch',
            'on' => 'lang:admin::lang.customers.text_subscribe',
            'off' => 'lang:admin::lang.customers.text_un_subscribe',
            'span' => 'left',
            'cssClass' => 'flex-width',
        ],
        'status' => [
            'label' => 'lang:admin::lang.label_status',
            'type' => 'switch',
            'span' => 'left',
            'cssClass' => 'flex-width',
        ],
        'addresses' => [
            'tab' => 'lang:admin::lang.customers.text_tab_address',
            'type' => 'repeater',
            'form' => 'addresses_model',
        ],
        'orders' => [
            'tab' => 'lang:admin::lang.customers.text_tab_orders',
            'type' => 'datatable',
            'context' => ['edit', 'preview'],
            'useAjax' => true,
            'defaultSort' => ['order_id', 'desc'],
            'columns' => [
                'order_id' => [
                    'title' => 'lang:admin::lang.column_id',
                ],
                'customer_name' => [
                    'title' => 'lang:admin::lang.orders.column_customer_name',
                ],
                'status_name' => [
                    'title' => 'lang:admin::lang.label_status',
                ],
                'order_type_name' => [
                    'title' => 'lang:admin::lang.label_type',
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
            'context' => ['edit', 'preview'],
            'useAjax' => true,
            'defaultSort' => ['reservation_id', 'desc'],
            'columns' => [
                'reservation_id' => [
                    'title' => 'lang:admin::lang.column_id',
                ],
                'customer_name' => [
                    'title' => 'lang:admin::lang.label_name',
                ],
                'status_name' => [
                    'title' => 'lang:admin::lang.label_status',
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
