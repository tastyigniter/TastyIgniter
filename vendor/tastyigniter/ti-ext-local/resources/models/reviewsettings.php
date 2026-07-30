<?php

/**
 * Model configuration options for settings model.
 */

use Igniter\Local\Models\ReviewSettings;

return [
    'form' => [
        'toolbar' => [
            'buttons' => [
                'save' => ['label' => 'lang:admin::lang.button_save', 'class' => 'btn btn-primary', 'data-request' => 'onSave'],
                'saveClose' => [
                    'label' => 'lang:admin::lang.button_save_close',
                    'class' => 'btn btn-default',
                    'data-request' => 'onSave',
                    'data-request-data' => 'close:1',
                ],
            ],
        ],
        'fields' => [
            'allow_reviews' => [
                'label' => 'lang:igniter.local::default.reviews.label_allow_reviews',
                'tab' => 'lang:igniter.local::default.reviews.text_tab_title_reviews',
                'type' => 'switch',
                'default' => true,
                'on' => 'lang:admin::lang.text_yes',
                'off' => 'lang:admin::lang.text_no',
                'comment' => 'lang:igniter.local::default.reviews.help_allow_reviews',
            ],
            'approve_reviews' => [
                'label' => 'lang:igniter.local::default.reviews.label_approve_reviews',
                'tab' => 'lang:igniter.local::default.reviews.text_tab_title_reviews',
                'type' => 'switch',
                'on' => 'lang:system::lang.settings.text_auto',
                'off' => 'lang:system::lang.settings.text_manual',
                'comment' => 'lang:igniter.local::default.reviews.help_approve_reviews',
                'trigger' => [
                    'action' => 'show',
                    'field' => 'allow_reviews',
                    'condition' => 'checked',
                ],
            ],
            'hints' => [
                'label' => 'lang:igniter.local::default.reviews.label_hints',
                'tab' => 'lang:igniter.local::default.reviews.text_tab_title_reviews',
                'type' => 'repeater',
                'sortable' => true,
                'showAddButton' => false,
                'showRemoveButton' => false,
                'default' => ReviewSettings::$defaultHints,
                'form' => [
                    'fields' => [
                        'value' => [
                            'type' => 'text',
                        ],
                    ],
                ],
                'commentAbove' => 'lang:igniter.local::default.reviews.help_hints',
            ],
        ],
        'rules' => [
            ['allow_reviews', 'lang:igniter.local::default.reviews.label_allow_reviews', 'required|integer'],
            ['approve_reviews', 'lang:igniter.local::default.reviews.label_approve_reviews', 'required|integer'],
            ['ratings.*', 'lang:admin::lang.label_name', 'required|min:2|max:32'],
        ],
    ],
];
