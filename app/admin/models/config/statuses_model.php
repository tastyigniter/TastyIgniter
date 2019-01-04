<?php
$config['list']['filter'] = [
    'search' => [
        'prompt' => 'lang:admin::lang.statuses.text_filter_search',
        'mode' => 'all' // or any, exact
    ],
    'scopes' => [
        'type' => [
            'label' => 'lang:admin::lang.statuses.text_filter_status',
            'type' => 'select', // checkbox, switch, date, daterange
            'conditions' => 'status_for = :filtered',
            'options' => [
                'order' => 'lang:admin::lang.statuses.text_order',
                'reserve' => 'lang:admin::lang.statuses.text_reservation',
            ],
        ],
    ],
];

$config['list']['toolbar'] = [
    'buttons' => [
        'create' => ['label' => 'lang:admin::lang.button_new', 'class' => 'btn btn-primary', 'href' => 'statuses/create'],
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
            'href' => 'statuses/edit/{status_id}',
        ],
    ],
    'status_name' => [
        'label' => 'lang:admin::lang.statuses.column_name',
        'type' => 'text', // number, switch, date_time, time, date, timesince, select, relation, partial
        'searchable' => TRUE,
    ],
    'status_comment' => [
        'label' => 'lang:admin::lang.statuses.column_comment',
        'type' => 'text',
        'searchable' => TRUE,
    ],
    'status_for_name' => [
        'label' => 'lang:admin::lang.statuses.column_type',
        'type' => 'text',
    ],
    'notify_customer' => [
        'label' => 'lang:admin::lang.statuses.column_notify',
        'type' => 'switch',
    ],
    'status_id' => [
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

$config['form']['fields'] = [
    'status_name' => [
        'label' => 'lang:admin::lang.statuses.label_name',
        'type' => 'text',
        'span' => 'left',
    ],
    'status_for' => [
        'label' => 'lang:admin::lang.statuses.label_for',
        'type' => 'radio',
        'span' => 'right',
        'placeholder' => 'lang:admin::lang.text_please_select',
        'options' => 'getStatusForDropdownOptions',
    ],
    'status_color' => [
        'label' => 'lang:admin::lang.statuses.label_color',
        'type' => 'colorpicker',
    ],
    'status_comment' => [
        'label' => 'lang:admin::lang.statuses.label_comment',
        'type' => 'textarea',
    ],
    'notify_customer' => [
        'label' => 'lang:admin::lang.statuses.label_notify',
        'type' => 'radio',
        'default' => 1,
        'options' => [
            'lang:admin::lang.text_no',
            'lang:admin::lang.text_yes',
        ],
        'comment' => 'lang:admin::lang.statuses.help_notify',
    ],
];

return $config;