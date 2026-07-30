<?php

return [
    'list' => [
        'filter' => [
            'search' => [
                'prompt' => 'lang:igniter.api::default.search_prompt',
                'mode' => 'all',
            ],
        ],
        'toolbar' => [
            'buttons' => [
                'tokens' => ['label' => 'lang:igniter.api::default.button_tokens', 'class' => 'btn btn-primary', 'href' => 'igniter/api/tokens'],
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
            'edit' => [
                'type' => 'button',
                'iconCssClass' => 'fa fa-pencil',
                'attributes' => [
                    'class' => 'btn btn-edit',
                    'href' => 'igniter/api/resources/edit/{id}',
                ],
            ],
            'name' => [
                'name' => 'lang:igniter.api::default.column_api_name',
                'searchable' => true,
            ],
            'base_endpoint' => [
                'label' => 'lang:igniter.api::default.column_base_endpoint',
                'sortable' => false,
            ],
            'description' => [
                'label' => 'lang:igniter.api::default.column_description',
            ],
        ],
    ],
    'form' => [
        'toolbar' => [
            'buttons' => [
                'save' => [
                    'label' => 'lang:igniter::admin.button_save',
                    'context' => ['create', 'edit'],
                    'partial' => 'form/toolbar_save_button',
                    'class' => 'btn btn-primary',
                    'data-request' => 'onSave',
                    'data-progress-indicator' => 'igniter::admin.text_saving',
                ],
                'delete' => [
                    'label' => 'lang:admin::lang.button_icon_delete', 'class' => 'btn btn-danger',
                    'data-request' => 'onDelete', 'data-request-data' => "_method:'DELETE'",
                    'data-request-confirm' => 'lang:admin::lang.alert_warning_confirm', 'context' => ['edit'],
                ],
            ],
        ],
        'tabs' => [
            'defaultTab' => 'lang:igniter.api::default.text_tab_general',
            'fields' => [
                'name' => [
                    'label' => 'lang:igniter.api::default.label_api_name',
                    'type' => 'text',
                    'span' => 'left',
                    'comment' => 'lang:igniter.api::default.label_api_name_comment',
                ],
                'endpoint' => [
                    'label' => 'lang:igniter.api::default.label_base_endpoint',
                    'type' => 'text',
                    'span' => 'right',
                    'comment' => 'lang:igniter.api::default.label_base_endpoint_comment',
                    'disabled' => true,
                ],
                'description' => [
                    'label' => 'lang:igniter.api::default.label_description',
                    'type' => 'text',
                    'comment' => 'lang:igniter.api::default.label_description_comment',
                    'commentHtml' => true,
                ],
                'meta' => [
                    'label' => 'lang:igniter.api::default.label_actions',
                    'type' => 'partial',
                    'path' => 'form/field_actions',
                    'span' => 'left',
                    'authOptions' => [
                        'admin' => 'lang:igniter.api::default.text_admin',
                        'customer' => 'lang:igniter.api::default.text_customer',
                        'users' => 'lang:igniter.api::default.text_admin_customer',
                        'guest' => 'lang:igniter.api::default.text_guest',
                        'all' => 'lang:igniter.api::default.text_all',
                    ],
                ],
                '_setup' => [
                    'tab' => 'lang:igniter.api::default.label_setup',
                    'type' => 'setup',
                ],
            ],
        ],
    ],
];
