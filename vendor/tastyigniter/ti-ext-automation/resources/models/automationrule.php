<?php

declare(strict_types=1);

return [
    'list' => [
        'toolbar' => [
            'buttons' => [
                'create' => ['label' => 'lang:admin::lang.button_new', 'class' => 'btn btn-primary', 'href' => 'igniter/automation/automations/create'],
            ],
        ],
        'bulkActions' => [
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
        ],
        'columns' => [
            'edit' => [
                'type' => 'button',
                'iconCssClass' => 'fa fa-pencil',
                'attributes' => [
                    'class' => 'btn btn-edit',
                    'href' => 'igniter/automation/automations/edit/{id}',
                ],
            ],
            'name' => [
                'label' => 'lang:admin::lang.label_name',
                'type' => 'text',
                'searchable' => true,
            ],
            'code' => [
                'label' => 'lang:igniter.automation::default.column_code',
                'type' => 'text',
                'searchable' => true,
            ],
            'event_name' => [
                'label' => 'lang:igniter.automation::default.column_event',
                'type' => 'text',
                'sortable' => false,
            ],
            'status' => [
                'label' => 'lang:admin::lang.label_status',
                'type' => 'switch',
                'searchable' => true,
            ],
            'id' => [
                'label' => 'lang:admin::lang.column_id',
                'invisible' => true,
            ],
        ],
    ],

    'form' => [
        'toolbar' => [
            'buttons' => [
                'save' => [
                    'label' => 'lang:admin::lang.button_save',
                    'context' => ['create', 'edit'],
                    'partial' => 'form/toolbar_save_button',
                    'class' => 'btn btn-primary',
                    'data-request' => 'onSave',
                    'data-progress-indicator' => 'admin::lang.text_saving',
                ],
            ],
        ],
        'fields' => [
            'event_class' => [
                'label' => 'lang:igniter.automation::default.label_event',
                'type' => 'select',
                'comment' => 'lang:igniter.automation::default.help_event',
            ],
            'name' => [
                'label' => 'lang:admin::lang.label_name',
                'type' => 'text',
                'context' => ['edit', 'preview'],
                'span' => 'left',
            ],
            'code' => [
                'label' => 'lang:igniter.automation::default.label_code',
                'type' => 'text',
                'context' => ['edit', 'preview'],
                'span' => 'right',
                'cssClass' => 'flex-width',
            ],
            'status' => [
                'label' => 'lang:admin::lang.label_status',
                'type' => 'switch',
                'default' => true,
                'context' => ['edit', 'preview'],
                'span' => 'right',
                'cssClass' => 'flex-width',
            ],
            'description' => [
                'context' => ['edit', 'preview'],
                'type' => 'hidden',
            ],
        ],
        'tabs' => [
            'fields' => [
                'config_data[condition_match_type]' => [
                    'tab' => 'lang:igniter.automation::default.label_conditions',
                    'type' => 'radiolist',
                    'context' => ['edit', 'preview'],
                    'inlineMode' => true,
                    'default' => 'all',
                    'options' => [
                        'all' => 'lang:igniter.automation::default.text_condition_match_all',
                        'any' => 'lang:igniter.automation::default.text_condition_match_any',
                    ],
                ],
                '_condition' => [
                    'tab' => 'lang:igniter.automation::default.label_conditions',
                    'type' => 'select',
                    'context' => ['edit', 'preview'],
                    'placeholder' => 'lang:admin::lang.text_select',
                    'comment' => 'lang:igniter.automation::default.help_conditions',
                    'attributes' => [
                        'data-request' => 'onLoadCreateConditionForm',
                        'data-request-success' => '$(\'[data-control="connector"]\').connector();',
                    ],
                ],
                'conditions' => [
                    'tab' => 'lang:igniter.automation::default.label_conditions',
                    'type' => 'connector',
                    'context' => ['edit', 'preview'],
                    'formName' => 'lang:igniter.automation::default.text_condition_form_name',
                    'popupSize' => 'modal-lg',
                    'sortable' => true,
                    'form' => [
                        'fields' => [
                            'options' => [
                                'label' => 'lang:igniter.automation::default.label_conditions',
                                'type' => 'repeater',
                                'commentAbove' => 'lang:igniter.automation::default.help_conditions',
                                'sortable' => true,
                                'form' => [
                                    'fields' => [
                                        'priority' => [
                                            'label' => 'lang:igniter.automation::default.column_condition_priority',
                                            'type' => 'hidden',
                                        ],
                                        'attribute' => [
                                            'label' => 'lang:igniter.automation::default.column_condition_attribute',
                                            'type' => 'select',
                                            'options' => 'getAttributeOptions',
                                        ],
                                        'operator' => [
                                            'label' => 'lang:igniter.automation::default.column_condition_operator',
                                            'type' => 'select',
                                            'options' => 'getOperatorOptions',
                                        ],
                                        'value' => [
                                            'label' => 'lang:igniter.automation::default.column_condition_value',
                                            'type' => 'text',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],

                '_action' => [
                    'tab' => 'lang:igniter.automation::default.label_actions',
                    'type' => 'select',
                    'context' => ['edit', 'preview'],
                    'placeholder' => 'lang:admin::lang.text_select',
                    'comment' => 'lang:igniter.automation::default.help_actions',
                    'attributes' => [
                        'data-request' => 'onLoadCreateActionForm',
                        'data-request-success' => '$(\'[data-control="connector"]\').connector();',
                    ],
                ],
                'actions' => [
                    'tab' => 'lang:igniter.automation::default.label_actions',
                    'type' => 'connector',
                    'context' => ['edit', 'preview'],
                    'formName' => 'lang:igniter.automation::default.text_action_form_name',
                    'popupSize' => 'modal-lg',
                    'sortable' => true,
                    'form' => [],
                ],

                'logs' => [
                    'tab' => 'lang:igniter.automation::default.text_tab_logs',
                    'type' => 'datatable',
                    'context' => ['edit', 'preview'],
                    'defaultSort' => ['created_at', 'desc'],
                    'searchableFields' => ['message'],
                    'useAjax' => true,
                    'columns' => [
                        'created_since' => [
                            'title' => 'lang:igniter.automation::default.column_time_date',
                        ],
                        'status_name' => [
                            'title' => 'lang:igniter.automation::default.column_status',
                        ],
                        'action_name' => [
                            'title' => 'lang:igniter.automation::default.column_action_name',
                        ],
                        'message' => [
                            'title' => 'lang:igniter.automation::default.column_message',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
