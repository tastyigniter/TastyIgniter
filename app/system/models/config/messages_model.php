<?php

$config['list']['filter'] = [
    'search' => [
        'prompt' => 'lang:system::messages.text_filter_search',
        'mode'   => 'all',
    ],
];

$config['list']['toolbar'] = [
    'buttons' => [
        'control' => ['label' => 'lang:admin::default.button_delete', 'partial' => 'messages/message_controls', 'context' => 'index'],
//        'delete' => ['label' => 'lang:admin::default.button_delete', 'class' => 'btn btn-danger', 'data-request-form' => '#list-form', 'data-request' => 'onDelete', 'data-request-data' => "_method:'DELETE'", 'data-request-confirm' => 'lang:alert_warning_confirm'],
        'filter'  => ['label' => 'lang:admin::default.button_icon_filter', 'class' => 'btn btn-default btn-filter', 'data-toggle' => 'list-filter', 'data-target' => '.panel-filter .panel-body'],
    ],
];

$config['list']['columns'] = [
    'sender[staff_name]' => [
        'label'      => 'lang:system::messages.label_from',
        'type'       => 'text',
        'searchable' => TRUE,
    ],
    'subject'            => [
        'label'      => 'lang:system::messages.label_subject',
        'type'       => 'partial',
        'searchable' => TRUE,
        'path'       => 'messages/message_card',
        'onClick'    => 'messages/view/{message_id}',
    ],
    'date_updated'       => [
        'label' => 'lang:system::messages.label_date',
        'type'  => 'timesince',
    ],
];

$config['form']['toolbar'] = [
    'buttons' => [
        'respond'       => [
            'label'             => 'lang:system::messages.button_respond',
            'class'             => 'btn btn-primary',
            'context'           => ['view'],
            'data-request'      => 'onSend',
            'data-request-form' => '#edit-form',
            'data-request-data' => 'close:1',
        ],
        'save'          => [
            'label'             => 'lang:system::messages.button_save_draft',
            'class'             => 'btn btn-default',
            'context'           => ['draft'],
            'data-request'      => 'onDraft',
            'data-request-form' => '#edit-form',
        ],
        'send'          => [
            'label'             => 'lang:system::messages.button_send',
            'class'             => 'btn btn-success',
            'context'           => ['compose', 'draft'],
            'data-request-form' => '#edit-form',
            'data-request'      => 'onSend',
            'data-request-data' => 'close:1',
        ],
        'draftCompose'  => [
            'label'             => 'lang:system::messages.button_save_draft',
            'class'             => 'btn btn-default',
            'context'           => ['compose'],
            'data-request'      => 'onDraft',
            'data-request-form' => '#edit-form',
        ],
        'back'          => ['label' => 'lang:admin::default.button_icon_back', 'class' => 'btn btn-default', 'href' => 'messages'],
    ],
];

$config['form']['fields'] = [
    'subject'        => [
        'label'   => 'lang:system::messages.label_subject',
        'type'    => 'text',
        'span'    => 'left',
        'context' => ['compose', 'draft'],
    ],
    'layout_id'      => [
        'label'       => 'lang:system::messages.label_layout',
        'type'        => 'relation',
        'span'        => 'right',
        'valueFrom'   => 'layout',
        'context' => ['compose', 'draft'],
        'placeholder' => 'lang:admin::default.text_none',
    ],
    'recipient'      => [
        'label'    => 'lang:system::messages.label_to',
        'type'     => 'radio',
        'span'     => 'left',
        'options'  => 'listReceivers',
        'cssClass' => 'recipient',
        'default'  => 'customers',
        'context'  => ['compose', 'draft'],
    ],
    'send_type'      => [
        'label'   => 'lang:system::messages.label_send_type',
        'type'    => 'radio',
        'span'    => 'right',
        'default' => 'email',
        'context' => ['compose', 'draft'],
        'trigger' => [
            'action'    => 'hide',
            'field'     => 'recipient',
            'condition' => 'value[all_newsletters]',
        ],
    ],
    'customers'      => [
        'label'   => 'lang:system::messages.label_customers',
        'type'    => 'selectlist',
        'mode'    => 'checkbox',
        'options' => ['Admin\Models\Customers_model', 'getDropdownOptions'],
        'context' => ['compose', 'draft'],
        'trigger' => [
            'action'    => 'show',
            'field'     => 'recipient',
            'condition' => 'value[customers]',
        ],
    ],
    'customer_group' => [
        'label'   => 'lang:system::messages.label_customer_group',
        'type'    => 'selectlist',
        'mode'    => 'checkbox',
        'options' => ['Admin\Models\Customer_groups_model', 'getDropdownOptions'],
        'context' => ['compose', 'draft'],
        'trigger' => [
            'action'    => 'show',
            'field'     => 'recipient',
            'condition' => 'value[customer_group]',
        ],
    ],
    'staff'          => [
        'label'   => 'lang:system::messages.label_staff',
        'type'    => 'selectlist',
        'mode'    => 'checkbox',
        'options' => ['Admin\Models\Staffs_model', 'getDropdownOptions'],
        'context' => ['compose', 'draft'],
        'trigger' => [
            'action'    => 'show',
            'field'     => 'recipient',
            'condition' => 'value[staff]',
        ],
    ],
    'staff_group'    => [
        'label'   => 'lang:system::messages.label_staff_group',
        'type'    => 'selectlist',
        'mode'    => 'checkbox',
        'options' => ['Admin\Models\Staff_groups_model', 'getDropdownOptions'],
        'context' => ['compose', 'draft'],
        'trigger' => [
            'action'    => 'show',
            'field'     => 'recipient',
            'condition' => 'value[staff_group]',
        ],
    ],
    'conversation'   => [
        'type'     => 'partial',
        'path'     => 'messages/conversation',
        'cssClass' => 'conversation',
        'context'  => ['view'],
    ],
    'body'           => [
        'type'     => 'richeditor',
        'cssClass' => 'message-respond richeditor-fluid',
        'context'  => ['compose', 'draft'],
    ],
    'respond'        => [
        'type'     => 'richeditor',
        'cssClass' => 'message-respond richeditor-fluid',
        'context'  => ['view'],
    ],
];

return $config;