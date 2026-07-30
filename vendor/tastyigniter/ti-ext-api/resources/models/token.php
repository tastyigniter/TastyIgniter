<?php

return [
    'list' => [
        'filter' => [
            'search' => [
                'prompt' => 'lang:igniter.api::default.search_tokens_prompt',
                'mode' => 'all',
            ],
        ],
        'bulkActions' => [
            'delete' => [
                'label' => 'lang:admin::lang.button_delete',
                'class' => 'btn btn-light text-danger',
                'data-request-confirm' => 'lang:admin::lang.alert_warning_confirm',
            ],
        ],
        'columns' => [
            'name' => [
                'label' => 'lang:igniter.api::default.column_device_name',
                'searchable' => true,
            ],
            'tokenable_type' => [
                'label' => 'lang:igniter.api::default.column_token_type',
                'searchable' => true,
                'formatter' => function($record, $column, $value) {
                    return $value == 'users' ? lang('igniter.api::default.text_token_type_staff') : lang('igniter.api::default.text_token_type_customer');
                },
            ],
            'tokenable_id' => [
                'label' => 'lang:igniter.api::default.column_issued_to',
                'searchable' => true,
                'formatter' => function($record, $column, $value) {
                    return $record->tokenable->email;
                },
            ],
            '_abilities' => [
                'label' => 'lang:igniter.api::default.column_abilities',
                'sortable' => true,
                'formatter' => function($record, $column, $value) {
                    return implode(', ', $record->abilities);
                },
            ],
            'created_at' => [
                'label' => 'lang:igniter.api::default.column_created',
                'type' => 'datetime',
            ],
            'last_used_at' => [
                'label' => 'lang:igniter.api::default.column_lastused',
                'type' => 'datetime',
            ],
        ],
    ],
];
