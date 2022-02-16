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
        'tabs' => [
            'fields' => [
                'site_name' => [
                    'label' => 'lang:system::lang.settings.label_site_name',
                    'tab' => 'lang:system::lang.settings.text_tab_restaurant',
                    'type' => 'text',
                ],
                'site_email' => [
                    'label' => 'lang:system::lang.settings.label_site_email',
                    'tab' => 'lang:system::lang.settings.text_tab_restaurant',
                    'type' => 'text',
                ],
                'country_id' => [
                    'label' => 'lang:system::lang.settings.label_country',
                    'tab' => 'lang:system::lang.settings.text_tab_restaurant',
                    'type' => 'select',
                    'options' => ['System\Models\Country', 'getDropdownOptions'],
                ],
                'site_logo' => [
                    'label' => 'lang:system::lang.settings.label_site_logo',
                    'tab' => 'lang:system::lang.settings.text_tab_restaurant',
                    'type' => 'mediafinder',
                ],
                'maps' => [
                    'label' => 'lang:system::lang.settings.text_tab_title_maps',
                    'tab' => 'lang:system::lang.settings.text_tab_restaurant',
                    'type' => 'section',
                ],
                'distance_unit' => [
                    'label' => 'lang:system::lang.settings.label_distance_unit',
                    'tab' => 'lang:system::lang.settings.text_tab_restaurant',
                    'type' => 'radiotoggle',
                    'options' => [
                        'mi' => 'lang:system::lang.settings.text_miles',
                        'km' => 'lang:system::lang.settings.text_kilometers',
                    ],
                ],
                'default_geocoder' => [
                    'label' => 'lang:system::lang.settings.label_default_geocoder',
                    'tab' => 'lang:system::lang.settings.text_tab_restaurant',
                    'type' => 'radiotoggle',
                    'default' => 'chain',
                    'comment' => 'lang:system::lang.settings.help_default_geocoder',
                    'options' => [
                        'nominatim' => 'lang:system::lang.settings.text_nominatim',
                        'google' => 'lang:system::lang.settings.text_google_geocoder',
                        'chain' => 'lang:system::lang.settings.text_chain_geocoder',
                    ],
                ],
                'maps_api_key' => [
                    'label' => 'lang:system::lang.settings.label_maps_api_key',
                    'tab' => 'lang:system::lang.settings.text_tab_restaurant',
                    'type' => 'text',
                    'comment' => 'lang:system::lang.settings.help_maps_api_key',
                    'trigger' => [
                        'action' => 'disable',
                        'field' => 'default_geocoder',
                        'condition' => 'value[nominatim]',
                    ],
                ],

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
                    'options' => ['System\Models\Language', 'getDropdownOptions'],
                    'placeholder' => 'lang:admin::lang.text_please_select',
                ],
                'detect_language' => [
                    'label' => 'lang:system::lang.settings.label_detect_language',
                    'tab' => 'lang:system::lang.settings.text_tab_site',
                    'type' => 'switch',
                    'default' => FALSE,
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
                    'options' => ['System\Models\Currency', 'getDropdownOptions'],
                    'placeholder' => 'lang:admin::lang.text_please_select',
                    'comment' => 'lang:system::lang.settings.help_site_currency',
                ],
                'currency_converter[api]' => [
                    'label' => 'lang:system::lang.settings.label_currency_converter',
                    'tab' => 'lang:system::lang.settings.text_tab_site',
                    'span' => 'right',
                    'type' => 'select',
                    'default' => 'openexchangerates',
                    'options' => ['System\Models\Currency', 'getConverterDropdownOptions'],
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
    ],
];
