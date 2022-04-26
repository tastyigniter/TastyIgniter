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
            'language' => [
                'label' => 'lang:system::lang.settings.text_tab_title_language',
                'tab' => 'lang:system::lang.settings.text_tab_site',
                'type' => 'section',
            ],
            'default_language' => [
                'label' => 'lang:system::lang.settings.label_site_language',
                'tab' => 'lang:system::lang.settings.text_tab_site',
                'type' => 'select',
                'default' => 'en',
                'span' => 'left',
                'options' => ['System\Models\Languages_model', 'getDropdownOptions'],
                'placeholder' => 'lang:admin::lang.text_please_select',
            ],
            'detect_language' => [
                'label' => 'lang:system::lang.settings.label_detect_language',
                'tab' => 'lang:system::lang.settings.text_tab_site',
                'type' => 'switch',
                'default' => false,
                'comment' => 'lang:system::lang.settings.help_detect_language',
            ],
            'currency' => [
                'label' => 'lang:system::lang.settings.text_tab_title_currency',
                'tab' => 'lang:system::lang.settings.text_tab_site',
                'type' => 'section',
            ],
            'default_currency_code' => [
                'label' => 'lang:system::lang.settings.label_site_currency',
                'tab' => 'lang:system::lang.settings.text_tab_site',
                'span' => 'left',
                'type' => 'select',
                'default' => 'GBP',
                'options' => ['System\Models\Currencies_model', 'getDropdownOptions'],
                'placeholder' => 'lang:admin::lang.text_please_select',
                'comment' => 'lang:system::lang.settings.help_site_currency',
            ],
            'currency_converter[api]' => [
                'label' => 'lang:system::lang.settings.label_currency_converter',
                'tab' => 'lang:system::lang.settings.text_tab_site',
                'span' => 'right',
                'type' => 'select',
                'default' => 'openexchangerates',
                'options' => ['System\Models\Currencies_model', 'getConverterDropdownOptions'],
            ],
            'currency_converter[oer][apiKey]' => [
                'label' => 'lang:system::lang.settings.label_currency_converter_oer_api_key',
                'tab' => 'lang:system::lang.settings.text_tab_site',
                'type' => 'text',
                'span' => 'left',
                'comment' => 'lang:system::lang.settings.help_currency_converter_oer_api',
                'trigger' => [
                    'action' => 'show',
                    'field' => 'currency_converter[api]',
                    'condition' => 'value[openexchangerates]',
                ],
            ],
            'currency_converter[fixerio][apiKey]' => [
                'label' => 'lang:system::lang.settings.label_currency_converter_fixer_api_key',
                'tab' => 'lang:system::lang.settings.text_tab_site',
                'type' => 'text',
                'span' => 'left',
                'comment' => 'lang:system::lang.settings.help_currency_converter_fixer_api',
                'trigger' => [
                    'action' => 'show',
                    'field' => 'currency_converter[api]',
                    'condition' => 'value[fixerio]',
                ],
            ],
            'currency_converter[refreshInterval]' => [
                'label' => 'lang:system::lang.settings.label_currency_refresh_interval',
                'tab' => 'lang:system::lang.settings.text_tab_site',
                'span' => 'right',
                'type' => 'select',
                'default' => '24',
                'options' => [
                    '1' => 'lang:system::lang.settings.text_1_hour',
                    '3' => 'lang:system::lang.settings.text_3_hours',
                    '6' => 'lang:system::lang.settings.text_6_hours',
                    '12' => 'lang:system::lang.settings.text_12_hours',
                    '24' => 'lang:system::lang.settings.text_24_hours',
                ],
            ],
            'date' => [
                'label' => 'lang:system::lang.settings.text_tab_title_date_time',
                'tab' => 'lang:system::lang.settings.text_tab_site',
                'type' => 'section',
            ],
            'timezone' => [
                'label' => 'lang:system::lang.settings.label_timezone',
                'tab' => 'lang:system::lang.settings.text_tab_site',
                'type' => 'select',
                'options' => 'listTimezones',
                'comment' => 'lang:system::lang.settings.help_timezone',
                'placeholder' => 'lang:admin::lang.text_please_select',
            ],
        ],
    ],
];
