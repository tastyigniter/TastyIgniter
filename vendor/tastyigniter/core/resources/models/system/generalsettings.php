<?php

use Igniter\System\Models\Currency;

return [
    'form' => [
        'toolbar' => [
            'buttons' => [
                'save' => [
                    'label' => 'lang:igniter::admin.button_save',
                    'class' => 'btn btn-primary',
                    'data-request' => 'onSave',
                    'data-progress-indicator' => 'igniter::admin.text_saving',
                ],
            ],
        ],
        'tabs' => [
            'fields' => [
                'site_name' => [
                    'label' => 'igniter::system.settings.label_site_name',
                    'tab' => 'igniter::system.settings.text_tab_general',
                    'type' => 'text',
                    'span' => 'left',
                ],
                'site_email' => [
                    'label' => 'igniter::system.settings.label_site_email',
                    'tab' => 'igniter::system.settings.text_tab_general',
                    'type' => 'text',
                    'span' => 'right',
                ],
                'site_logo' => [
                    'label' => 'igniter::system.settings.label_site_logo',
                    'tab' => 'igniter::system.settings.text_tab_general',
                    'type' => 'mediafinder',
                ],
                'maps' => [
                    'label' => 'igniter::system.settings.text_tab_title_maps',
                    'tab' => 'igniter::system.settings.text_tab_general',
                    'type' => 'section',
                ],
                'default_geocoder' => [
                    'label' => 'igniter::system.settings.label_default_geocoder',
                    'tab' => 'igniter::system.settings.text_tab_general',
                    'type' => 'radiotoggle',
                    'span' => 'left',
                    'default' => 'nominatim',
                    'comment' => 'igniter::system.settings.help_default_geocoder',
                    'options' => [
                        'nominatim' => 'igniter::system.settings.text_nominatim',
                        'google' => 'igniter::system.settings.text_google_geocoder',
                        'chain' => 'igniter::system.settings.text_chain_geocoder',
                    ],
                ],
                'distance_unit' => [
                    'label' => 'igniter::system.settings.label_distance_unit',
                    'tab' => 'igniter::system.settings.text_tab_general',
                    'type' => 'radiotoggle',
                    'span' => 'right',
                    'options' => [
                        'mi' => 'igniter::system.settings.text_miles',
                        'km' => 'igniter::system.settings.text_kilometers',
                    ],
                ],
                'maps_api_key' => [
                    'label' => 'igniter::system.settings.label_maps_api_key',
                    'tab' => 'igniter::system.settings.text_tab_general',
                    'type' => 'text',
                    'span' => 'left',
                    'comment' => 'igniter::system.settings.help_maps_api_key',
                    'trigger' => [
                        'action' => 'disable',
                        'field' => 'default_geocoder',
                        'condition' => 'value[nominatim]',
                    ],
                ],

                'language' => [
                    'label' => 'lang:igniter::system.settings.text_tab_title_language',
                    'tab' => 'lang:igniter::system.settings.text_tab_site',
                    'comment' => 'lang:igniter::system.settings.help_language',
                    'type' => 'section',
                ],
                'detect_language' => [
                    'label' => 'lang:igniter::system.settings.label_detect_language',
                    'tab' => 'lang:igniter::system.settings.text_tab_site',
                    'type' => 'switch',
                    'default' => false,
                    'comment' => 'lang:igniter::system.settings.help_detect_language',
                ],
                'currency' => [
                    'label' => 'lang:igniter::system.settings.text_tab_title_currency',
                    'tab' => 'lang:igniter::system.settings.text_tab_site',
                    'type' => 'section',
                    'comment' => 'lang:igniter::system.settings.help_site_currency',
                ],
                'currency_converter[api]' => [
                    'label' => 'lang:igniter::system.settings.label_currency_converter',
                    'tab' => 'lang:igniter::system.settings.text_tab_site',
                    'type' => 'radiotoggle',
                    'default' => 'openexchangerates',
                    'options' => [Currency::class, 'getConverterDropdownOptions'],
                ],
                'currency_converter[oer][apiKey]' => [
                    'label' => 'lang:igniter::system.settings.label_currency_converter_oer_api_key',
                    'tab' => 'lang:igniter::system.settings.text_tab_site',
                    'type' => 'text',
                    'span' => 'left',
                    'comment' => 'lang:igniter::system.settings.help_currency_converter_oer_api',
                    'trigger' => [
                        'action' => 'show',
                        'field' => 'currency_converter[api]',
                        'condition' => 'value[openexchangerates]',
                    ],
                ],
                'currency_converter[fixerio][apiKey]' => [
                    'label' => 'lang:igniter::system.settings.label_currency_converter_fixer_api_key',
                    'tab' => 'lang:igniter::system.settings.text_tab_site',
                    'type' => 'text',
                    'span' => 'left',
                    'comment' => 'lang:igniter::system.settings.help_currency_converter_fixer_api',
                    'trigger' => [
                        'action' => 'show',
                        'field' => 'currency_converter[api]',
                        'condition' => 'value[fixerio]',
                    ],
                ],
                'currency_converter[refreshInterval]' => [
                    'label' => 'lang:igniter::system.settings.label_currency_refresh_interval',
                    'tab' => 'lang:igniter::system.settings.text_tab_site',
                    'span' => 'right',
                    'type' => 'select',
                    'default' => '24',
                    'options' => [
                        '1' => 'lang:igniter::system.settings.text_1_hour',
                        '3' => 'lang:igniter::system.settings.text_3_hours',
                        '6' => 'lang:igniter::system.settings.text_6_hours',
                        '12' => 'lang:igniter::system.settings.text_12_hours',
                        '24' => 'lang:igniter::system.settings.text_24_hours',
                    ],
                ],
                'date' => [
                    'label' => 'lang:igniter::system.settings.text_tab_title_date_time',
                    'tab' => 'lang:igniter::system.settings.text_tab_site',
                    'type' => 'section',
                ],
                'timezone' => [
                    'label' => 'lang:igniter::system.settings.label_timezone',
                    'tab' => 'lang:igniter::system.settings.text_tab_site',
                    'type' => 'select',
                    'options' => 'listTimezones',
                    'comment' => 'lang:igniter::system.settings.help_timezone',
                    'placeholder' => 'lang:igniter::admin.text_please_select',
                ],
            ],
        ],
    ],
];
