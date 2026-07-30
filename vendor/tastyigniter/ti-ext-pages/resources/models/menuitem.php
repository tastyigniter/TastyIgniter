<?php

declare(strict_types=1);

return [
    'form' => [
        'fields' => [
            'title' => [
                'label' => 'igniter.pages::default.menu.label_title',
                'type' => 'text',
                'span' => 'left',
            ],
            'type' => [
                'label' => 'igniter.pages::default.menu.label_type',
                'type' => 'select',
                'span' => 'right',
                'attributes' => [
                    'data-toggle' => 'menu-item-type',
                    'data-handler' => 'onGetMenuItemTypeInfo',
                ],
            ],
            'url' => [
                'label' => 'igniter.pages::default.menu.label_url',
                'type' => 'text',
                'cssClass' => 'form-group-hide',
                'trigger' => [
                    'action' => 'show',
                    'field' => 'type',
                    'condition' => 'value[url]',
                ],
            ],
            'reference' => [
                'label' => 'igniter.pages::default.menu.label_reference',
                'type' => 'select',
                'options' => [],
                'cssClass' => 'form-group-hide',
                'comment' => 'igniter.pages::default.menu.help_reference',
            ],
            'parent_id' => [
                'label' => 'igniter.pages::default.menu.label_parent_id',
                'type' => 'select',
                'placeholder' => 'admin::lang.text_select',
            ],
            'description' => [
                'label' => 'admin::lang.label_description',
                'type' => 'textarea',
            ],
            'code' => [
                'label' => 'igniter.pages::default.menu.label_code',
                'type' => 'text',
            ],
            'config[extraAttributes]' => [
                'label' => 'igniter.pages::default.menu.label_attributes',
                'type' => 'text',
            ],
        ],
    ],
];
