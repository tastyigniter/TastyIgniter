<?php

return [
    'form' => [
        'toolbar' => [
            'buttons' => [
                'back' => [
                    'label' => 'lang:admin::lang.button_icon_back',
                    'class' => 'btn btn-default',
                    'href' => 'settings',
                ],
                'save' => [
                    'label' => 'lang:admin::lang.button_save',
                    'class' => 'btn btn-primary',
                    'data-request' => 'onSave',
                    'data-progress-indicator' => 'admin::lang.text_saving',
                ],
            ],
        ],
        'fields' => [
            'tax_mode' => [
                'label' => 'lang:system::lang.settings.label_tax_mode',
                'type' => 'switch',
                'default' => false,
                'comment' => 'lang:system::lang.settings.help_tax_mode',
            ],
            'tax_percentage' => [
                'label' => 'lang:system::lang.settings.label_tax_percentage',
                'type' => 'number',
                'default' => 0,
                'comment' => 'lang:system::lang.settings.help_tax_percentage',
            ],
            'tax_menu_price' => [
                'label' => 'lang:system::lang.settings.label_tax_menu_price',
                'type' => 'select',
                'options' => [
                    'lang:system::lang.settings.text_menu_price_include_tax',
                    'lang:system::lang.settings.text_apply_tax_on_menu_price',
                ],
                'comment' => 'lang:system::lang.settings.help_tax_menu_price',
            ],
            'tax_delivery_charge' => [
                'label' => 'lang:system::lang.settings.label_tax_delivery_charge',
                'type' => 'switch',
                'on' => 'lang:admin::lang.text_yes',
                'off' => 'lang:admin::lang.text_no',
                'comment' => 'lang:system::lang.settings.help_tax_delivery_charge',
            ],
        ],
    ],
];
