<?php

return [
    'form' => [
        'toolbar' => [
            'buttons' => [
                'back' => [
                    'label' => 'lang:admin::lang.button_icon_back',
                    'class' => 'btn btn-outline-secondary',
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
                'guest_order' => [
                    'label' => 'lang:system::lang.settings.label_guest_order',
                    'tab' => 'lang:system::lang.settings.text_tab_title_order',
                    'type' => 'switch',
                    'on' => 'lang:admin::lang.text_yes',
                    'off' => 'lang:admin::lang.text_no',
                    'comment' => 'lang:system::lang.settings.help_guest_order',
                ],
                'location_order' => [
                    'label' => 'lang:system::lang.settings.label_location_order',
                    'tab' => 'lang:system::lang.settings.text_tab_title_order',
                    'type' => 'switch',
                    'default' => false,
                    'on' => 'lang:admin::lang.text_yes',
                    'off' => 'lang:admin::lang.text_no',
                    'comment' => 'lang:system::lang.settings.help_location_order',
                ],
                'order_email' => [
                    'label' => 'lang:system::lang.settings.label_order_email',
                    'tab' => 'lang:system::lang.settings.text_tab_title_order',
                    'type' => 'checkboxtoggle',
                    'options' => [
                        'customer' => 'lang:system::lang.settings.text_to_customer',
                        'admin' => 'lang:system::lang.settings.text_to_admin',
                        'location' => 'lang:system::lang.settings.text_to_location',
                    ],
                    'comment' => 'lang:system::lang.settings.help_order_email',
                ],
                'default_order_status' => [
                    'label' => 'lang:system::lang.settings.label_default_order_status',
                    'tab' => 'lang:system::lang.settings.text_tab_title_order',
                    'type' => 'selectlist',
                    'mode' => 'radio',
                    'options' => ['Admin\Models\Statuses_model', 'getDropdownOptionsForOrder'],
                    'comment' => 'lang:system::lang.settings.help_default_order_status',
                ],
                'processing_order_status' => [
                    'label' => 'lang:system::lang.settings.label_processing_order_status',
                    'tab' => 'lang:system::lang.settings.text_tab_title_order',
                    'type' => 'selectlist',
                    'options' => ['Admin\Models\Statuses_model', 'getDropdownOptionsForOrder'],
                    'comment' => 'lang:system::lang.settings.help_processing_order_status',
                ],
                'completed_order_status' => [
                    'label' => 'lang:system::lang.settings.label_completed_order_status',
                    'tab' => 'lang:system::lang.settings.text_tab_title_order',
                    'type' => 'selectlist',
                    'options' => ['Admin\Models\Statuses_model', 'getDropdownOptionsForOrder'],
                    'comment' => 'lang:system::lang.settings.help_completed_order_status',
                ],
                'canceled_order_status' => [
                    'label' => 'lang:system::lang.settings.label_canceled_order_status',
                    'tab' => 'lang:system::lang.settings.text_tab_title_order',
                    'type' => 'selectlist',
                    'mode' => 'radio',
                    'options' => ['Admin\Models\Statuses_model', 'getDropdownOptionsForOrder'],
                    'comment' => 'lang:system::lang.settings.help_canceled_order_status',
                ],

                'reservation_email' => [
                    'label' => 'lang:system::lang.settings.label_reservation_email',
                    'tab' => 'lang:system::lang.settings.text_tab_title_reservation',
                    'type' => 'checkboxtoggle',
                    'options' => [
                        'customer' => 'lang:system::lang.settings.text_to_customer',
                        'admin' => 'lang:system::lang.settings.text_to_admin',
                        'location' => 'lang:system::lang.settings.text_to_location',
                    ],
                    'comment' => 'lang:system::lang.settings.help_reservation_email',
                ],
                'default_reservation_status' => [
                    'label' => 'lang:system::lang.settings.label_default_reservation_status',
                    'tab' => 'lang:system::lang.settings.text_tab_title_reservation',
                    'type' => 'selectlist',
                    'mode' => 'radio',
                    'options' => ['Admin\Models\Statuses_model', 'getDropdownOptionsForReservation'],
                    'comment' => 'lang:system::lang.settings.help_default_reservation_status',
                ],
                'confirmed_reservation_status' => [
                    'label' => 'lang:system::lang.settings.label_confirmed_reservation_status',
                    'tab' => 'lang:system::lang.settings.text_tab_title_reservation',
                    'type' => 'selectlist',
                    'mode' => 'radio',
                    'options' => ['Admin\Models\Statuses_model', 'getDropdownOptionsForReservation'],
                    'comment' => 'lang:system::lang.settings.help_confirmed_reservation_status',
                ],
                'canceled_reservation_status' => [
                    'label' => 'lang:system::lang.settings.label_canceled_reservation_status',
                    'tab' => 'lang:system::lang.settings.text_tab_title_reservation',
                    'type' => 'selectlist',
                    'mode' => 'radio',
                    'options' => ['Admin\Models\Statuses_model', 'getDropdownOptionsForReservation'],
                    'comment' => 'lang:system::lang.settings.help_canceled_reservation_status',
                ],

                'invoice_prefix' => [
                    'label' => 'lang:system::lang.settings.label_invoice_prefix',
                    'tab' => 'lang:system::lang.settings.text_tab_title_invoice',
                    'type' => 'text',
                    'span' => 'left',
                    'comment' => 'lang:system::lang.settings.help_invoice_prefix',
                ],
                'invoice_logo' => [
                    'label' => 'lang:system::lang.settings.label_invoice_logo',
                    'tab' => 'lang:system::lang.settings.text_tab_title_invoice',
                    'type' => 'mediafinder',
                    'span' => 'right',
                    'mode' => 'inline',
                    'comment' => 'lang:system::lang.settings.help_invoice_logo',
                ],
            ],
        ],
    ],
];
