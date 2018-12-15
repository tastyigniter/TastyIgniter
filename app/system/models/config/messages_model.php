<?php

$config['list']['filter'] = [
    'search' => [
        'prompt' => 'lang:system::lang.messages.text_filter_search',
        'mode' => 'all',
    ],
];

$config['list']['toolbar'] = [
    'buttons' => [
        'compose' => ['label' => 'lang:system::lang.messages.button_compose', 'class' => 'btn btn-primary', 'href' => 'messages/compose'],
        'control' => ['label' => 'lang:admin::lang.button_delete', 'partial' => 'messages/message_controls', 'context' => 'index'],
        'filter' => ['label' => 'lang:admin::lang.button_icon_filter', 'class' => 'btn btn-default btn-filter', 'data-toggle' => 'list-filter', 'data-target' => '.list-filter'],
    ],
];

$config['list']['columns'] = [
    'sender[staff_name]' => [
        'label' => 'lang:system::lang.messages.label_from',
        'type' => 'text',
        'searchable' => TRUE,
    ],
    'subject' => [
        'label' => 'lang:system::lang.messages.label_subject',
        'type' => 'partial',
        'searchable' => TRUE,
        'path' => 'messages/message_card',
        'onClick' => 'messages/view/{message_id}',
    ],
    'date_updated' => [
        'label' => 'lang:system::lang.messages.label_date',
        'type' => 'timesince',
    ],
];

$config['form']['toolbar'] = [
    'buttons' => [
        'respond' => [
            'label' => 'lang:system::lang.messages.button_respond',
            'class' => 'btn btn-primary',
            'context' => ['view'],
            'data-request' => 'onSend',
            'data-request-submit' => 'true',
            'data-request-data' => 'close:1',
        ],
        'save' => [
            'label' => 'lang:system::lang.messages.button_save_draft',
            'class' => 'btn btn-default',
            'context' => ['draft'],
            'data-request' => 'onDraft',
            'data-request-submit' => 'true',
        ],
        'send' => [
            'label' => 'lang:system::lang.messages.button_send',
            'class' => 'btn btn-success',
            'context' => ['compose', 'draft'],
            'data-request-submit' => 'true',
            'data-request' => 'onSend',
            'data-request-data' => 'close:1',
        ],
        'draftCompose' => [
            'label' => 'lang:system::lang.messages.button_save_draft',
            'class' => 'btn btn-default',
            'context' => ['compose'],
            'data-request' => 'onDraft',
            'data-request-submit' => 'true',
        ],
    ],
];

$config['form']['fields'] = [
    'subject' => [
        'label' => 'lang:system::lang.messages.label_subject',
        'type' => 'text',
        'span' => 'left',
        'context' => ['compose', 'draft'],
    ],
    'layout_id' => [
        'label' => 'lang:system::lang.messages.label_layout',
        'type' => 'relation',
        'span' => 'right',
        'valueFrom' => 'layout',
        'context' => ['compose', 'draft'],
        'placeholder' => 'lang:admin::lang.text_none',
    ],
    'recipient' => [
        'label' => 'lang:system::lang.messages.label_to',
        'type' => 'radio',
        'span' => 'left',
        'options' => 'listReceivers',
        'cssClass' => 'recipient',
        'default' => 'customers',
        'context' => ['compose', 'draft'],
    ],
    'send_type' => [
        'label' => 'lang:system::lang.messages.label_send_type',
        'type' => 'radio',
        'span' => 'right',
        'default' => 'email',
        'context' => ['compose', 'draft'],
        'trigger' => [
            'action' => 'hide',
            'field' => 'recipient',
            'condition' => 'value[all_newsletters]',
        ],
    ],
    'customers' => [
        'label' => 'lang:system::lang.messages.label_customers',
        'type' => 'selectlist',
        'mode' => 'checkbox',
        'options' => ['Admin\Models\Customers_model', 'getDropdownOptions'],
        'context' => ['compose', 'draft'],
        'trigger' => [
            'action' => 'show',
            'field' => 'recipient',
            'condition' => 'value[customers]',
        ],
    ],
    'customer_group' => [
        'label' => 'lang:system::lang.messages.label_customer_group',
        'type' => 'selectlist',
        'mode' => 'checkbox',
        'options' => ['Admin\Models\Customer_groups_model', 'getDropdownOptions'],
        'context' => ['compose', 'draft'],
        'trigger' => [
            'action' => 'show',
            'field' => 'recipient',
            'condition' => 'value[customer_group]',
        ],
    ],
    'staff' => [
        'label' => 'lang:system::lang.messages.label_staff',
        'type' => 'selectlist',
        'mode' => 'checkbox',
        'options' => ['Admin\Models\Staffs_model', 'getDropdownOptions'],
        'context' => ['compose', 'draft'],
        'trigger' => [
            'action' => 'show',
            'field' => 'recipient',
            'condition' => 'value[staff]',
        ],
    ],
    'staff_group' => [
        'label' => 'lang:system::lang.messages.label_staff_group',
        'type' => 'selectlist',
        'mode' => 'checkbox',
        'options' => ['Admin\Models\Staff_groups_model', 'getDropdownOptions'],
        'context' => ['compose', 'draft'],
        'trigger' => [
            'action' => 'show',
            'field' => 'recipient',
            'condition' => 'value[staff_group]',
        ],
    ],
    'conversation' => [
        'type' => 'partial',
        'path' => 'messages/conversation',
        'cssClass' => 'conversation',
        'context' => ['view'],
    ],
    'body' => [
        'type' => 'richeditor',
        'cssClass' => 'message-respond richeditor-fluid',
        'context' => ['compose', 'draft'],
    ],
    'respond' => [
        'type' => 'richeditor',
        'cssClass' => 'message-respond richeditor-fluid',
        'context' => ['view'],
    ],
];

return $config;