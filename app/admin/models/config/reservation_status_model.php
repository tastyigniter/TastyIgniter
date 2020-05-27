<?php

return [
    'form' => [
        'fields' => [
            'status_id' => [
                'context' => 'status',
                'label' => 'lang:admin::lang.label_status',
                'type' => 'select',
                'options' => ['Admin\Models\Statuses_model', 'getDropdownOptionsForReservation'],
                'placeholder' => 'lang:admin::lang.text_please_select',
                'attributes' => [
                    'data-status-value' => '',
                ],
            ],
            'comment' => [
                'context' => 'status',
                'label' => 'lang:admin::lang.statuses.label_comment',
                'type' => 'textarea',
                'attributes' => [
                    'data-status-comment' => '',
                ],
            ],
            'notify' => [
                'context' => 'status',
                'label' => 'lang:admin::lang.statuses.label_notify_customer',
                'type' => 'switch',
                'default' => TRUE,
                'offText' => 'lang:admin::lang.text_no',
                'onText' => 'lang:admin::lang.text_yes',
                'comment' => 'lang:admin::lang.statuses.help_notify_customer',
                'attributes' => [
                    'data-status-notify' => '',
                ],
            ],

            'assignee_group_id' => [
                'context' => 'assignee',
                'label' => 'lang:admin::lang.statuses.label_assignee_group',
                'type' => 'select',
                'options' => [],
                'comment' => 'lang:admin::lang.statuses.help_assignee_group',
                'placeholder' => 'lang:admin::lang.text_please_select',
                'attributes' => [
                    'data-assign-group' => '',
                ],
            ],
            'assignee_id' => [
                'context' => 'assignee',
                'label' => 'lang:admin::lang.statuses.label_assignee',
                'type' => 'select',
                'placeholder' => 'lang:admin::lang.text_please_select',
                'options' => [],
                'attributes' => [
                    'data-assign-staff' => '',
                ],
            ],
        ],
        'rules' => [
            ['status_id', 'admin::lang.label_status', 'sometimes|required|integer|exists:statuses'],
            ['comment', 'admin::lang.statuses.label_comment', 'max:1500'],
            ['notify', 'admin::lang.statuses.label_notify', 'sometimes|required|boolean'],

            ['assignee_group_id', 'admin::lang.statuses.label_assignee_group', 'sometimes|required|integer|exists:staff_groups,staff_group_id'],
            ['assignee_id', 'admin::lang.statuses.label_assignee', 'sometimes|required|integer|exists:staffs,staff_id'],
        ],
    ],
];