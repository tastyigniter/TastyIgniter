<?php

use Igniter\Admin\Models\Status;

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
        'fields' => [
            'reservation_email' => [
                'label' => 'lang:igniter.reservation::default.label_reservation_email',
                'tab' => 'lang:igniter.reservation::default.text_tab_title_reservation',
                'type' => 'checkboxtoggle',
                'options' => [
                    'customer' => 'lang:igniter::system.settings.text_to_customer',
                    'admin' => 'lang:igniter::system.settings.text_to_admin',
                    'location' => 'lang:igniter::system.settings.text_to_location',
                ],
                'comment' => 'lang:igniter.reservation::default.help_reservation_email',
            ],
            'default_reservation_status' => [
                'label' => 'lang:igniter.reservation::default.label_default_reservation_status',
                'tab' => 'lang:igniter.reservation::default.text_tab_title_reservation',
                'type' => 'selectlist',
                'mode' => 'radio',
                'options' => [Status::class, 'getDropdownOptionsForReservation'],
                'comment' => 'lang:igniter.reservation::default.help_default_reservation_status',
            ],
            'confirmed_reservation_status' => [
                'label' => 'lang:igniter.reservation::default.label_confirmed_reservation_status',
                'tab' => 'lang:igniter.reservation::default.text_tab_title_reservation',
                'type' => 'selectlist',
                'mode' => 'radio',
                'options' => [Status::class, 'getDropdownOptionsForReservation'],
                'comment' => 'lang:igniter.reservation::default.help_confirmed_reservation_status',
            ],
            'canceled_reservation_status' => [
                'label' => 'lang:igniter.reservation::default.label_canceled_reservation_status',
                'tab' => 'lang:igniter.reservation::default.text_tab_title_reservation',
                'type' => 'selectlist',
                'mode' => 'radio',
                'options' => [Status::class, 'getDropdownOptionsForReservation'],
                'comment' => 'lang:igniter.reservation::default.help_canceled_reservation_status',
            ],
        ],
    ],
];
