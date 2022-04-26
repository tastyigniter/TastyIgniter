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
                'options' => ['System\Models\Countries_model', 'getDropdownOptions'],
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
        ],
    ],
];
