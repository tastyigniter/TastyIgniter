<?php

use Igniter\Admin\Models\Status;

return [
    'form' => [
        'fields' => [
            'status_id' => [
                'context' => 'status',
                'label' => 'lang:igniter::admin.label_status',
                'type' => 'select',
                'options' => [Status::class, 'getDropdownOptionsForReservation'],
                'placeholder' => 'lang:igniter::admin.text_please_select',
                'attributes' => [
                    'data-status-value' => '',
                ],
            ],
            'comment' => [
                'context' => 'status',
                'label' => 'lang:igniter::admin.statuses.label_comment',
                'type' => 'textarea',
                'attributes' => [
                    'data-status-comment' => '',
                ],
            ],
            'notify' => [
                'context' => 'status',
                'label' => 'lang:igniter::admin.statuses.label_notify_customer',
                'type' => 'switch',
                'default' => true,
                'offText' => 'lang:igniter::admin.text_no',
                'onText' => 'lang:igniter::admin.text_yes',
                'comment' => 'lang:igniter::admin.statuses.help_notify_customer',
                'attributes' => [
                    'data-status-notify' => '',
                ],
            ],

            'assignee_group_id' => [
                'context' => 'assignee',
                'label' => 'lang:igniter::admin.statuses.label_assignee_group',
                'type' => 'select',
                'options' => [],
                'comment' => 'lang:igniter::admin.statuses.help_assignee_group',
                'placeholder' => 'lang:igniter::admin.text_please_select',
                'attributes' => [
                    'data-assign-group' => '',
                ],
            ],
            'assignee_id' => [
                'context' => 'assignee',
                'label' => 'lang:igniter::admin.statuses.label_assignee',
                'type' => 'select',
                'placeholder' => 'lang:igniter::admin.text_please_select',
                'options' => [],
                'attributes' => [
                    'data-assign-staff' => '',
                ],
            ],
        ],
    ],
];
