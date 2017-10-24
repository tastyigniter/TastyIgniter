<?php
$config['form']['toolbar'] = [
    'buttons' => [
        'save'      => ['label' => 'lang:admin::default.button_save', 'class' => 'btn btn-primary', 'data-request-form' => '#edit-form', 'data-request' => 'onSave'],
        'saveClose' => [
            'label'             => 'lang:admin::default.button_save_close',
            'class'             => 'btn btn-default',
            'data-request'      => 'onSave',
            'data-request-form' => '#edit-form',
            'data-request-data' => 'close:1',
        ],
        'back'      => ['label' => 'lang:admin::default.button_icon_back', 'class' => 'btn btn-default', 'href' => 'settings'],
    ],
];

$config['form']['general'] = [
    'label'    => 'lang:system::settings.text_tab_general',
    'icon'     => 'fa fa-sliders',
    'priority' => 0,
    'url'      => admin_url('settings/edit/general'),
    'form'     => [
        'tabs' => [
            'fields' => [
                'site_name'           => [
                    'label' => 'lang:system::settings.label_site_name',
                    'tab'   => 'lang:system::settings.text_tab_restaurant',
                    'type'  => 'text',
                    'span'  => 'left',
                ],
                'site_email'          => [
                    'label' => 'lang:system::settings.label_site_email',
                    'tab'   => 'lang:system::settings.text_tab_restaurant',
                    'type'  => 'text',
                    'span'  => 'right',
                ],
                'site_url'            => [
                    'label' => 'lang:system::settings.label_site_url',
                    'tab'   => 'lang:system::settings.text_tab_restaurant',
                    'type'  => 'text',
                    'span'  => 'left',
                ],
                'country_id'          => [
                    'label'   => 'lang:system::settings.label_country',
                    'tab'     => 'lang:system::settings.text_tab_restaurant',
                    'type'    => 'select',
                    'span'    => 'right',
                    'options' => ['System\Models\Countries_model', 'getDropdownOptions'],
                ],
                'site_location_mode'  => [
                    'label'   => 'lang:system::settings.label_site_location_mode',
                    'tab'     => 'lang:system::settings.text_tab_restaurant',
                    'type'    => 'radio',
                    'span'    => 'left',
                    'options' => [
                        'single'   => 'lang:system::settings.text_single',
                        'multiple' => 'lang:system::settings.text_multiple',
                    ],
                    'comment' => 'lang:system::settings.help_site_location_mode',
                ],
                'default_location_id' => [
                    'label'    => 'lang:system::settings.label_default_location',
                    'tab'      => 'lang:system::settings.text_tab_restaurant',
                    'type'     => 'select',
                    'span'     => 'right',
                    'disabled' => TRUE,
                    'options'  => ['Admin\Models\Locations_model', 'getDropdownOptions'],
                    'comment'  => 'lang:system::settings.help_default_location',
                    'trigger'  => [
                        'action'    => 'show',
                        'field'     => 'site_location_mode',
                        'condition' => 'value[multiple]',
                    ],
                ],
                'site_logo'           => [
                    'label' => 'lang:system::settings.label_site_logo',
                    'tab'   => 'lang:system::settings.text_tab_restaurant',
                    'type'  => 'mediafinder',
                ],
                'maps'                => [
                    'label' => 'lang:system::settings.text_tab_title_maps',
                    'tab'   => 'lang:system::settings.text_tab_restaurant',
                    'type'  => 'section',
                ],
                'maps_api_key'        => [
                    'label'   => 'lang:system::settings.label_maps_api_key',
                    'tab'     => 'lang:system::settings.text_tab_restaurant',
                    'type'    => 'text',
                    'comment' => 'lang:system::settings.help_maps_api_key',
                ],
                'distance_unit'       => [
                    'label'   => 'lang:system::settings.label_distance_unit',
                    'tab'     => 'lang:system::settings.text_tab_restaurant',
                    'type'    => 'radio',
                    'options' => [
                        'mi' => 'lang:system::settings.text_miles',
                        'km' => 'lang:system::settings.text_kilometers',
                    ],
                ],
                'meta_description'    => [
                    'label' => 'lang:system::settings.label_meta_description',
                    'tab'   => 'lang:system::settings.text_tab_restaurant',
                    'type'  => 'textarea',
                    'span'  => 'left',
                ],
                'meta_keywords'       => [
                    'label' => 'lang:system::settings.label_meta_keyword',
                    'tab'   => 'lang:system::settings.text_tab_restaurant',
                    'type'  => 'textarea',
                    'span'  => 'right',
                ],

                'page_limit'                 => [
                    'label'   => 'lang:system::settings.label_page_limit',
                    'tab'     => 'lang:system::settings.text_tab_site',
                    'span'    => 'left',
                    'type'    => 'radio',
                    'options' => 'getPageLimitOptions',
                    'comment' => 'lang:system::settings.help_page_limit',
                ],
                'menus_page_limit'           => [
                    'label'   => 'lang:system::settings.label_menu_page_limit',
                    'tab'     => 'lang:system::settings.text_tab_site',
                    'span'    => 'right',
                    'type'    => 'radio',
                    'options' => 'getPageLimitOptions',
                    'comment' => 'lang:system::settings.help_menu_page_limit',
                ],
                'special_category_id'        => [
                    'label'       => 'lang:system::settings.label_special_category',
                    'tab'         => 'lang:system::settings.text_tab_site',
                    'type'        => 'select',
                    'options'     => ['Admin\Models\Categories_model', 'getDropdownOptions'],
                    'comment'     => 'lang:system::settings.help_special_category',
                    'placeholder' => 'lang:admin::default.text_please_select',
                ],
                'show_menu_images'           => [
                    'label'   => 'lang:system::settings.label_show_menu_image',
                    'tab'     => 'lang:system::settings.text_tab_site',
                    'type'    => 'radio',
                    'options' => [
                        'lang:admin::default.text_hide',
                        'lang:admin::default.text_show',
                    ],
                    'comment' => 'lang:system::settings.help_show_menu_image',
                ],
                'menu_images_w'              => [
                    'label'   => 'lang:system::settings.label_menu_image_height',
                    'tab'     => 'lang:system::settings.text_tab_site',
                    'span'    => 'left',
                    'type'    => 'number',
                    'trigger' => [
                        'action'    => 'show',
                        'field'     => 'show_menu_images',
                        'condition' => 'value[1]',
                    ],
                ],
                'menu_images_h'              => [
                    'label'   => 'lang:system::settings.label_menu_image_width',
                    'tab'     => 'lang:system::settings.text_tab_site',
                    'span'    => 'right',
                    'type'    => 'number',
                    'trigger' => [
                        'action'    => 'show',
                        'field'     => 'show_menu_images',
                        'condition' => 'value[1]',
                    ],
                ],
                'language'                   => [
                    'label' => 'lang:system::settings.text_tab_title_language',
                    'tab'   => 'lang:system::settings.text_tab_site',
                    'type'  => 'section',
                ],
                'language_id'                => [
                    'label'       => 'lang:system::settings.label_site_language',
                    'tab'         => 'lang:system::settings.text_tab_site',
                    'type'        => 'select',
                    'span'        => 'left',
                    'options'     => ['System\Models\Languages_model', 'getDropdownOptions'],
                    'placeholder' => 'lang:admin::default.text_please_select',
                ],
                'admin_language_id'          => [
                    'label'       => 'lang:system::settings.label_admin_language',
                    'tab'         => 'lang:system::settings.text_tab_site',
                    'type'        => 'select',
                    'span'        => 'right',
                    'options'     => ['System\Models\Languages_model', 'getDropdownOptions'],
                    'placeholder' => 'lang:admin::default.text_please_select',
                ],
                'detect_language'            => [
                    'label'   => 'lang:system::settings.label_detect_language',
                    'tab'     => 'lang:system::settings.text_tab_site',
                    'type'    => 'switch',
                    'comment' => 'lang:system::settings.help_detect_language',
                ],
                'currency'                   => [
                    'label' => 'lang:system::settings.text_tab_title_currency',
                    'tab'   => 'lang:system::settings.text_tab_site',
                    'type'  => 'section',
                ],
                'accepted_currencies'        => [
                    'label'       => 'lang:system::settings.label_accepted_currency',
                    'tab'         => 'lang:system::settings.text_tab_site',
                    'span'        => 'left',
                    'type'        => 'select',
                    'multiOption' => TRUE,
                    'options'     => ['System\Models\Currencies_model', 'getDropdownOptions'],
                    'comment'     => 'lang:system::settings.help_accepted_currency',
                    'placeholder' => 'lang:admin::default.text_please_select',
                ],
                'currency_id'                => [
                    'label'       => 'lang:system::settings.label_site_currency',
                    'tab'         => 'lang:system::settings.text_tab_site',
                    'span'        => 'right',
                    'type'        => 'select',
                    'options'     => ['System\Models\Currencies_model', 'getDropdownOptions'],
                    'placeholder' => 'lang:admin::default.text_please_select',
                ],
                'auto_update_currency_rates' => [
                    'label'   => 'lang:system::settings.label_auto_update_rates',
                    'tab'     => 'lang:system::settings.text_tab_site',
                    'type'    => 'switch',
                    'comment' => 'lang:system::settings.help_auto_update_rates',
                ],
                'date'                       => [
                    'label' => 'lang:system::settings.text_tab_title_date_time',
                    'tab'   => 'lang:system::settings.text_tab_site',
                    'type'  => 'section',
                ],
                'timezone'                   => [
                    'label'       => 'lang:system::settings.label_timezone',
                    'tab'         => 'lang:system::settings.text_tab_site',
                    'type'        => 'select',
                    'options'     => 'listTimezones',
                    'comment'     => 'lang:system::settings.help_timezone',
                    'placeholder' => 'lang:admin::default.text_please_select',
                ],
                'date_format'                => [
                    'label' => 'lang:system::settings.label_date_format',
                    'tab'   => 'lang:system::settings.text_tab_site',
                    'span'  => 'left',
                    'type'  => 'radio',
                ],
                'time_format'                => [
                    'label' => 'lang:system::settings.label_time_format',
                    'tab'   => 'lang:system::settings.text_tab_site',
                    'span'  => 'right',
                    'type'  => 'radio',
                ],
            ],
        ],
        'rules'    => [
            ['site_name', 'lang:system::settings.label_site_name', 'required|min:2|max:128'],
            ['site_email', 'lang:system::settings.label_site_email', 'required|email'],
            ['site_logo', 'lang:system::settings.label_site_logo', 'required'],
            ['timezone', 'lang:system::settings.label_timezone', 'required'],
            ['date_format', 'lang:system::settings.label_date_format', 'required'],
            ['time_format', 'lang:system::settings.label_time_format', 'required'],
            ['currency_id', 'lang:system::settings.label_site_currency', 'required|integer'],
            ['auto_update_currency_rates', 'lang:system::settings.label_auto_update_rates', 'required|integer'],
            ['accepted_currencies[]', 'lang:system::settings.label_accepted_currency', 'required|integer'],
            ['detect_language', 'lang:system::settings.label_default_language', 'required|integer'],
            ['language_id', 'lang:system::settings.label_site_language', 'required'],
            ['admin_language_id', 'lang:system::settings.label_admin_language', 'required'],
            ['page_limit', 'lang:system::settings.label_page_limit', 'required|integer'],
            ['meta_description', 'lang:system::settings.label_meta_description'],
            ['meta_keywords', 'lang:system::settings.label_meta_keyword'],
            ['menus_page_limit', 'lang:system::settings.label_menu_page_limit', 'required|integer'],
            ['show_menu_images', 'lang:system::settings.label_show_menu_image', 'required|integer'],
            ['menu_images_h', 'lang:system::settings.label_menu_image_height', 'required_if:show_menu_images|numeric'],
            ['menu_images_w', 'lang:system::settings.label_menu_image_width', 'required_if:show_menu_images|numeric'],
            ['special_category_id', 'lang:system::settings.label_special_category', 'required|numeric'],
            ['country_id', 'lang:system::settings.label_country', 'required|integer'],
            ['maps_api_key', 'lang:system::settings.label_maps_api_key'],
            ['distance_unit', 'lang:system::settings.label_distance_unit'],
        ],
    ],
];

$config['form']['order'] = [
    'label'    => 'lang:system::settings.text_tab_order',
    'icon'     => 'fa fa-shopping-cart',
    'priority' => 1,
    'url'      => admin_url('settings/edit/order'),
    'form'     => [
        'tabs' => [
            'fields' => [
                'default_order_status'    => [
                    'label'       => 'lang:system::settings.label_default_order_status',
                    'tab'         => 'lang:system::settings.text_tab_general',
                    'type'        => 'select',
                    'options'     => ['Admin\Models\Statuses_model', 'getDropdownOptionsForOrder'],
                    'comment'     => 'lang:system::settings.help_default_order_status',
                    'placeholder' => 'lang:admin::default.text_please_select',
                ],
                'processing_order_status' => [
                    'label'       => 'lang:system::settings.label_processing_order_status',
                    'tab'         => 'lang:system::settings.text_tab_general',
                    'type'        => 'select',
                    'multiOption' => TRUE,
                    'options'     => ['Admin\Models\Statuses_model', 'getDropdownOptionsForOrder'],
                    'comment'     => 'lang:system::settings.help_processing_order_status',
                ],
                'completed_order_status'  => [
                    'label'       => 'lang:system::settings.label_completed_order_status',
                    'tab'         => 'lang:system::settings.text_tab_general',
                    'type'        => 'select',
                    'multiOption' => TRUE,
                    'options'     => ['Admin\Models\Statuses_model', 'getDropdownOptionsForOrder'],
                    'comment'     => 'lang:system::settings.help_completed_order_status',
                ],
                'canceled_order_status'   => [
                    'label'       => 'lang:system::settings.label_canceled_order_status',
                    'tab'         => 'lang:system::settings.text_tab_general',
                    'type'        => 'select',
                    'options'     => ['Admin\Models\Statuses_model', 'getDropdownOptionsForOrder'],
                    'comment'     => 'lang:system::settings.help_canceled_order_status',
                    'placeholder' => 'lang:admin::default.text_please_select',
                ],
                'invoice'                 => [
                    'label' => 'lang:system::settings.text_tab_title_invoice',
                    'tab'   => 'lang:system::settings.text_tab_general',
                    'type'  => 'section',
                ],
                'invoice_prefix'          => [
                    'label'   => 'lang:system::settings.label_invoice_prefix',
                    'tab'     => 'lang:system::settings.text_tab_general',
                    'type'    => 'text',
                    'comment' => 'lang:system::settings.help_invoice_prefix',
                ],
                'auto_invoicing'          => [
                    'label'   => 'lang:system::settings.label_auto_invoicing',
                    'tab'     => 'lang:system::settings.text_tab_general',
                    'type'    => 'radio',
                    'options' => [
                        'lang:system::settings.text_manual',
                        'lang:system::settings.text_auto',
                    ],
                    'comment' => 'lang:system::settings.help_auto_invoicing',
                ],
                'reviews'                 => [
                    'label' => 'lang:system::settings.text_tab_title_reviews',
                    'tab'   => 'lang:system::settings.text_tab_general',
                    'type'  => 'section',
                ],
                'allow_reviews'           => [
                    'label'   => 'lang:system::settings.label_allow_reviews',
                    'tab'     => 'lang:system::settings.text_tab_general',
                    'type'    => 'switch',
                    'comment' => 'lang:system::settings.help_allow_reviews',
                ],
                'approve_reviews'         => [
                    'label'   => 'lang:system::settings.label_approve_reviews',
                    'tab'     => 'lang:system::settings.text_tab_general',
                    'type'    => 'radio',
                    'options' => [
                        'lang:system::settings.text_auto',
                        'lang:system::settings.text_manual',
                    ],
                    'comment' => 'lang:system::settings.help_approve_reviews',
                    'trigger' => [
                        'action'    => 'show',
                        'field'     => 'allow_reviews',
                        'condition' => 'value[1]',
                    ],
                ],

                'delivery_time'      => [
                    'label'   => 'lang:system::settings.label_delivery_time',
                    'tab'     => 'lang:system::settings.text_tab_title_checkout',
                    'span'    => 'left',
                    'type'    => 'number',
                    'comment' => 'lang:system::settings.help_delivery_time',
                ],
                'collection_time'    => [
                    'label'   => 'lang:system::settings.label_collection_time',
                    'tab'     => 'lang:system::settings.text_tab_title_checkout',
                    'span'    => 'right',
                    'type'    => 'number',
                    'comment' => 'lang:system::settings.help_collection_time',
                ],
                'order_email'        => [
                    'label'   => 'lang:system::settings.label_order_email',
                    'tab'     => 'lang:system::settings.text_tab_title_checkout',
                    'type'    => 'checkbox',
                    'options' => [
                        'customer' => 'lang:system::settings.text_to_customer',
                        'admin'    => 'lang:system::settings.text_to_admin',
                        'location' => 'lang:system::settings.text_to_location',
                    ],
                    'comment' => 'lang:system::settings.help_order_email',
                ],
                'guest_order'        => [
                    'label'   => 'lang:system::settings.label_guest_order',
                    'tab'     => 'lang:system::settings.text_tab_title_checkout',
                    'type'    => 'switch',
                    'comment' => 'lang:system::settings.help_guest_order',
                ],
                'future_orders'      => [
                    'label'   => 'lang:system::settings.label_future_order',
                    'tab'     => 'lang:system::settings.text_tab_title_checkout',
                    'type'    => 'switch',
                    'comment' => 'lang:system::settings.help_future_order',
                ],
                'location_order'     => [
                    'label'   => 'lang:system::settings.label_location_order',
                    'tab'     => 'lang:system::settings.text_tab_title_checkout',
                    'type'    => 'switch',
                    'comment' => 'lang:system::settings.help_location_order',
                ],
                'stock'              => [
                    'label' => 'lang:system::settings.text_tab_title_stock',
                    'tab'   => 'lang:system::settings.text_tab_title_checkout',
                    'type'  => 'section',
                ],
                'stock_checkout'     => [
                    'label'   => 'lang:system::settings.label_stock_checkout',
                    'tab'     => 'lang:system::settings.text_tab_title_checkout',
                    'type'    => 'switch',
                    'comment' => 'lang:system::settings.help_stock_checkout',
                ],
                'show_stock_warning' => [
                    'label'   => 'lang:system::settings.label_show_stock_warning',
                    'tab'     => 'lang:system::settings.text_tab_title_checkout',
                    'type'    => 'switch',
                    'comment' => 'lang:system::settings.help_show_stock_warning',
                ],
                'terms'              => [
                    'label' => 'lang:system::settings.text_tab_title_terms',
                    'tab'   => 'lang:system::settings.text_tab_title_checkout',
                    'type'  => 'section',
                ],
                'checkout_terms'     => [
                    'label'       => 'lang:system::settings.label_checkout_terms',
                    'tab'         => 'lang:system::settings.text_tab_title_checkout',
                    'type'        => 'select',
                    'options'     => ['Admin\Models\Pages_model', 'getDropdownOptions'],
                    'comment'     => 'lang:system::settings.help_checkout_terms',
                    'placeholder' => 'lang:admin::default.text_please_select',
                ],

                //

                'tax_mode'            => [
                    'label'   => 'lang:system::settings.label_tax_mode',
                    'tab'     => 'lang:system::settings.text_tab_title_taxation',
                    'type'    => 'switch',
                    'comment' => 'lang:system::settings.help_tax_mode',
                ],
                'tax_percentage'      => [
                    'label'   => 'lang:system::settings.label_tax_percentage',
                    'tab'     => 'lang:system::settings.text_tab_title_taxation',
                    'type'    => 'number',
                    'comment' => 'lang:system::settings.help_tax_percentage',
                ],
                'tax_menu_price'      => [
                    'label'   => 'lang:system::settings.label_tax_menu_price',
                    'tab'     => 'lang:system::settings.text_tab_title_taxation',
                    'type'    => 'select',
                    'options' => [
                        'lang:system::settings.text_menu_price_include_tax',
                        'lang:system::settings.text_apply_tax_on_menu_price',
                    ],
                    'comment' => 'lang:system::settings.help_tax_menu_price',
                ],
                'tax_delivery_charge' => [
                    'label'   => 'lang:system::settings.label_tax_delivery_charge',
                    'tab'     => 'lang:system::settings.text_tab_title_taxation',
                    'type'    => 'radio',
                    'options' => [
                        'lang:admin::default.text_no',
                        'lang:admin::default.text_yes',
                    ],
                    'comment' => 'lang:system::settings.help_tax_delivery_charge',
                ],
            ],
        ],
        'rules'    => [
            ['order_email[]', 'lang:system::settings.label_order_email', 'required|alpha'],
            ['tax_mode', 'lang:system::settings.label_tax_mode', 'required|integer'],
            ['tax_title', 'lang:system::settings.label_tax_title', 'max:32'],
            ['tax_percentage', 'lang:system::settings.label_tax_percentage', 'required_if:tax_mode,1|numeric'],
            ['tax_menu_price', 'lang:system::settings.label_tax_menu_price', 'numeric'],
            ['tax_delivery_charge', 'lang:system::settings.label_tax_delivery_charge', 'numeric'],
            ['allow_reviews', 'lang:system::settings.label_allow_reviews', 'required|integer'],
            ['approve_reviews', 'lang:system::settings.label_approve_reviews', 'required|integer'],
            ['stock_checkout', 'lang:system::settings.label_stock_checkout', 'required|integer'],
            ['show_stock_warning', 'lang:system::settings.label_show_stock_warning', 'required|integer'],
            ['checkout_terms', 'lang:system::settings.label_checkout_terms', 'required|numeric'],
            ['default_order_status', 'lang:system::settings.label_default_order_status', 'required|integer'],
            ['processing_order_status[]', 'lang:system::settings.label_processing_order_status', 'required|integer'],
            ['completed_order_status[]', 'lang:system::settings.label_completed_order_status', 'required|integer'],
            ['canceled_order_status', 'lang:system::settings.label_canceled_order_status', 'required|integer'],
            ['delivery_time', 'lang:system::settings.label_delivery_time', 'required|integer'],
            ['collection_time', 'lang:system::settings.label_collection_time', 'required|integer'],
            ['guest_order', 'lang:system::settings.label_guest_order', 'required|integer'],
            ['location_order', 'lang:system::settings.label_location_order', 'required|integer'],
            ['future_orders', 'lang:system::settings.label_future_order', 'required|numeric'],
            ['auto_invoicing', 'lang:system::settings.label_auto_invoicing', 'required|integer'],
            ['invoice_prefix', 'lang:system::settings.label_invoice_prefix'],
        ],
    ],
];

$config['form']['reservation'] = [
    'label'    => 'lang:system::settings.text_tab_reservation',
    'icon'     => 'fa fa-book',
    'priority' => 2,
    'url'      => admin_url('settings/edit/reservation'),
    'form'     => [
        'fields' => [
            'reservation_mode'             => [
                'label'   => 'lang:system::settings.label_reservation_mode',
                'type'    => 'switch',
                'comment' => 'lang:system::settings.help_reservation_mode',
            ],
            'reservation_email'            => [
                'label'   => 'lang:system::settings.label_reservation_email',
                'type'    => 'checkbox',
                'options' => [
                    'customer' => 'lang:system::settings.text_to_customer',
                    'admin'    => 'lang:system::settings.text_to_admin',
                    'location' => 'lang:system::settings.text_to_location',
                ],
                'comment' => 'lang:system::settings.help_reservation_email',
            ],
            'default_reservation_status'   => [
                'label'       => 'lang:system::settings.label_default_reservation_status',
                'type'        => 'select',
                'options'     => ['Admin\Models\Statuses_model', 'getDropdownOptionsForReservation'],
                'comment'     => 'lang:system::settings.help_default_reservation_status',
                'placeholder' => 'lang:admin::default.text_please_select',
            ],
            'confirmed_reservation_status' => [
                'label'       => 'lang:system::settings.label_confirmed_reservation_status',
                'type'        => 'select',
                'options'     => ['Admin\Models\Statuses_model', 'getDropdownOptionsForReservation'],
                'comment'     => 'lang:system::settings.help_confirmed_reservation_status',
                'placeholder' => 'lang:admin::default.text_please_select',
            ],
            'canceled_reservation_status'  => [
                'label'       => 'lang:system::settings.label_canceled_reservation_status',
                'type'        => 'select',
                'options'     => ['Admin\Models\Statuses_model', 'getDropdownOptionsForReservation'],
                'comment'     => 'lang:system::settings.help_canceled_reservation_status',
                'placeholder' => 'lang:admin::default.text_please_select',
            ],
            'reservation_time_interval'    => [
                'label'   => 'lang:system::settings.label_reservation_time_interval',
                'type'    => 'number',
                'comment' => 'lang:system::settings.help_reservation_time_interval',
            ],
            'reservation_stay_time'        => [
                'label'   => 'lang:system::settings.label_reservation_stay_time',
                'type'    => 'number',
                'comment' => 'lang:system::settings.help_reservation_stay_time',
            ],
        ],
        'rules'    => [
            ['reservation_email[]', 'lang:system::settings.label_reservation_email', 'required|alpha'],
            ['reservation_mode', 'lang:system::settings.label_reservation_mode', 'required|integer'],
            ['default_reservation_status', 'lang:system::settings.label_default_reservation_status', 'required|integer'],
            ['confirmed_reservation_status', 'lang:system::settings.label_confirmed_reservation_status', 'required|integer'],
            ['canceled_reservation_status', 'lang:system::settings.label_canceled_reservation_status', 'required|integer'],
            ['reservation_time_interval', 'lang:system::settings.label_reservation_time_interval', 'required|integer'],
            ['reservation_stay_time', 'lang:system::settings.label_reservation_stay_time', 'required|integer'],

        ],
    ],
];

$config['form']['user'] = [
    'label'    => 'lang:system::settings.text_tab_user',
    'icon'     => 'fa fa-user',
    'priority' => 3,
    'url'      => admin_url('settings/edit/user'),
    'form'     => [
        'fields' => [
            'registration_email' => [
                'label'   => 'lang:system::settings.label_registration_email',
                'type'    => 'checkbox',
                'options' => [
                    'customer' => 'lang:system::settings.text_to_customer',
                    'admin'    => 'lang:system::settings.text_to_admin',
                ],
                'comment' => 'lang:system::settings.help_registration_email',
            ],
            'registration_terms' => [
                'label'       => 'lang:system::settings.label_registration_terms',
                'type'        => 'select',
                'options'     => ['Admin\Models\Pages_model', 'getDropdownOptions'],
                'comment'     => 'lang:system::settings.help_registration_terms',
                'placeholder' => 'lang:admin::default.text_please_select',
            ],
            'customer_group_id'  => [
                'label'   => 'lang:system::settings.label_customer_group',
                'type'    => 'select',
                'options' => ['Admin\Models\Customer_groups_model', 'getDropdownOptions'],
            ],
            'disable_security_questions'  => [
                'label'   => 'lang:system::settings.label_security_questions',
                'type'    => 'radio',
                'comment' => 'lang:system::settings.help_security_questions',
                'options' => ['lang:admin::default.text_no', 'lang:admin::default.text_yes']
            ],
        ],
        'rules'    => [
            ['registration_email[]', 'lang:system::settings.label_registration_email', 'required|alpha'],
            ['registration_terms', 'lang:system::settings.label_registration_terms', 'required|numeric'],
            ['customer_group_id', 'lang:system::settings.label_customer_group', 'required|integer'],
            ['disable_security_questions', 'lang:system::settings.label_security_questions', 'required|integer'],
        ],
    ],
];

$config['form']['media'] = [
    'label'    => 'lang:system::settings.text_tab_media_manager',
    'icon'     => 'fa fa-image',
    'priority' => 4,
    'url'      => admin_url('settings/edit/media'),
    'form'     => [
        'fields' => [
            'image_manager[max_size]'      => [
                'label'   => 'lang:system::settings.label_media_max_size',
                'type'    => 'number',
                'span'    => 'left',
                'comment' => 'lang:system::settings.help_media_max_size',
            ],
            'image_manager[remember_days]' => [
                'label'   => 'lang:system::settings.label_media_remember_days',
                'type'    => 'select',
                'span'    => 'right',
                'options' => [
                    1 => 'lang:system::settings.text_24_hour',
                    3 => 'lang:system::settings.text_3_days',
                    5 => 'lang:system::settings.text_5_days',
                    7 => 'lang:system::settings.text_1_week',
                ],
                'comment' => 'lang:system::settings.help_media_remember_days',
            ],
            'image_manager[thumb_width]'   => [
                'label' => 'lang:system::settings.label_media_thumb_width',
                'type'  => 'number',
                'span'  => 'left',
            ],
            'image_manager[thumb_height]'  => [
                'label' => 'lang:system::settings.label_media_thumb_height',
                'type'  => 'number',
                'span'  => 'right',
            ],
            'image_manager[uploads]'       => [
                'label'   => 'lang:system::settings.label_media_uploads',
                'type'    => 'switch',
                'span'    => 'left',
                'comment' => 'lang:system::settings.help_media_upload',
            ],
            'image_manager[new_folder]'    => [
                'label'   => 'lang:system::settings.label_media_new_folder',
                'type'    => 'switch',
                'span'    => 'right',
                'comment' => 'lang:system::settings.help_media_new_folder',
            ],
            'image_manager[copy]'          => [
                'label'   => 'lang:system::settings.label_media_copy',
                'type'    => 'switch',
                'span'    => 'left',
                'comment' => 'lang:system::settings.help_media_copy',
            ],
            'image_manager[move]'          => [
                'label'   => 'lang:system::settings.label_media_move',
                'type'    => 'switch',
                'span'    => 'right',
                'comment' => 'lang:system::settings.help_media_move',
            ],
            'image_manager[rename]'        => [
                'label'   => 'lang:system::settings.label_media_rename',
                'type'    => 'switch',
                'span'    => 'left',
                'comment' => 'lang:system::settings.help_media_rename',
            ],
            'image_manager[delete]'        => [
                'label'   => 'lang:system::settings.label_media_delete',
                'type'    => 'switch',
                'span'    => 'right',
                'comment' => 'lang:system::settings.help_media_delete',
            ],
        ],
        'rules'    => [
            ['image_manager[max_size]', 'lang:system::settings.label_media_max_size', 'required|numeric'],
            ['image_manager[thumb_height]', 'lang:system::settings.label_media_thumb_height', 'required|numeric'],
            ['image_manager[thumb_width]', 'lang:system::settings.label_media_thumb_width', 'required|numeric'],
            ['image_manager[uploads]', 'lang:system::settings.label_media_uploads', 'integer'],
            ['image_manager[new_folder]', 'lang:system::settings.label_media_new_folder', 'integer'],
            ['image_manager[copy]', 'lang:system::settings.label_media_copy', 'integer'],
            ['image_manager[move]', 'lang:system::settings.label_media_move', 'integer'],
            ['image_manager[rename]', 'lang:system::settings.label_media_rename', 'integer'],
            ['image_manager[delete]', 'lang:system::settings.label_media_delete', 'integer'],
            ['image_manager[transliteration]', 'lang:system::settings.label_media_transliteration', 'integer'],
            ['image_manager[remember_days]', 'lang:system::settings.label_media_remember_days', 'integer'],
        ],
    ],
];

$config['form']['mail'] = [
    'label'    => 'lang:system::settings.text_tab_mail',
    'icon'     => 'fa fa-envelope',
    'priority' => 5,
    'url'      => admin_url('settings/edit/mail'),
    'form'     => [
        'fields' => [
            'sender_name'  => [
                'label' => 'lang:system::settings.label_sender_name',
                'type'  => 'text',
                'span'  => 'left',
            ],
            'sender_email' => [
                'label' => 'lang:system::settings.label_sender_email',
                'type'  => 'text',
                'span'  => 'right',
            ],
            'protocol'     => [
                'label'   => 'lang:system::settings.label_protocol',
                'type'    => 'radio',
                'default'    => 'sendmail',
                'options' => [
                    'sendmail' => 'lang:system::settings.text_sendmail',
                    'smtp'     => 'lang:system::settings.text_smtp',
                ],
                'span'    => 'left',
            ],
            'smtp_host'    => [
                'label' => 'lang:system::settings.label_smtp_host',
                'type'  => 'text',
                'span'  => 'right',
                'trigger' => [
                    'action' => 'show',
                    'field'     => 'protocol',
                    'condition' => 'value[smtp]',
                ]
            ],
            'smtp_port'    => [
                'label' => 'lang:system::settings.label_smtp_port',
                'type'  => 'text',
                'span'  => 'left',
                'trigger' => [
                    'action' => 'show',
                    'field'     => 'protocol',
                    'condition' => 'value[smtp]',
                ]
            ],
            'smtp_user'    => [
                'label' => 'lang:system::settings.label_smtp_user',
                'type'  => 'text',
                'span'  => 'right',
                'trigger' => [
                    'action' => 'show',
                    'field'     => 'protocol',
                    'condition' => 'value[smtp]',
                ]
            ],
            'smtp_pass'    => [
                'label' => 'lang:system::settings.label_smtp_pass',
                'type'  => 'text',
                'span'  => 'left',
                'trigger' => [
                    'action' => 'show',
                    'field'     => 'protocol',
                    'condition' => 'value[smtp]',
                ]
            ],
            'mailtype' => [
                'label'   => 'lang:system::settings.label_mailtype',
                'type'    => 'radio',
                'default'    => 'plain',
                'options' => [
                    'plain' => 'lang:system::settings.text_plain',
                    'html' => 'lang:system::settings.text_html',
                ],
                'span'  => 'right',
            ],
            'test_email'   => [
                'label' => 'lang:system::settings.label_test_email',
                'type'  => 'partial',
                'span'  => 'left',
                'path'  => 'settings/test_email_button',
            ],
        ],
        'rules'    => [
            ['sender_name', 'lang:system::settings.label_sender_name', 'required'],
            ['sender_email', 'lang:system::settings.label_sender_email', 'required'],
            ['protocol', 'lang:system::settings.label_protocol', 'required'],
            ['smtp_host', 'lang:system::settings.label_smtp_host', 'required_if:protocol,smtp'],
            ['smtp_port', 'lang:system::settings.label_smtp_port', 'required_if:protocol,smtp'],
            ['smtp_user', 'lang:system::settings.label_smtp_user', 'required_if:protocol,smtp'],
            ['smtp_pass', 'lang:system::settings.label_smtp_pass', 'required_if:protocol,smtp'],
        ],
    ],
];

$config['form']['advanced'] = [
    'label'    => 'lang:system::settings.text_tab_server',
    'icon'     => 'fa fa-cog',
    'priority' => 6,
    'url'      => admin_url('settings/edit/advanced'),
    'form'     => [
        'fields' => [
            'captcha'      => [
                'label' => 'lang:system::settings.text_tab_title_captcha',
                'type'  => 'section',
            ],
            'captcha_mode' => [
                'label'   => 'lang:system::settings.label_captcha_mode',
                'type'    => 'radio',
                'comment' => 'lang:system::settings.help_captcha_mode',
                'default'    => 'default',
                'options' => [
                    'default' => 'lang:admin::default.text_default',
                    'recaptcha' => 'lang:system::settings.text_recaptcha',
                    'invisible-recaptcha' => 'lang:system::settings.text_invisible_recaptcha',
                ]
            ],
            'recaptcha_site_key' => [
                'label'   => 'lang:system::settings.label_recaptcha_site_key',
                'type'    => 'text',
                'span'    => 'left',
                'comment' => 'lang:system::settings.help_recaptcha_site_key',
                'trigger'  => [
                    'action'    => 'show',
                    'field'     => 'captcha_mode',
                    'condition' => 'value[recaptcha]',
                ],
            ],
            'recaptcha_secret_key' => [
                'label'   => 'lang:system::settings.label_recaptcha_secret_key',
                'type'    => 'text',
                'span'    => 'right',
                'comment' => 'lang:system::settings.help_recaptcha_secret_key',
                'trigger'  => [
                    'action'    => 'show',
                    'field'     => 'captcha_mode',
                    'condition' => 'value[recaptcha]',
                ],
            ],

            'maintenance'      => [
                'label' => 'lang:system::settings.text_tab_title_maintenance',
                'type'  => 'section',
            ],
            'maintenance_mode' => [
                'label'   => 'lang:system::settings.label_maintenance_mode',
                'type'    => 'switch',
                'comment' => 'lang:system::settings.help_maintenance',
            ],
            'custom_code'      => [
                'label' => 'lang:system::settings.label_maintenance_message',
                'type'  => 'textarea',
            ],

            'slug'      => [
                'label' => 'lang:system::settings.text_tab_title_permalink',
                'type'  => 'section',
            ],
            'permalink' => [
                'label'   => 'lang:system::settings.label_permalink',
                'type'    => 'switch',
                'comment' => 'lang:system::settings.help_permalink',
            ],

            'customer_online'                  => [
                'label' => 'lang:system::settings.text_tab_title_customer_online',
                'type'  => 'section',
            ],
            'customer_online_time_out'         => [
                'label'   => 'lang:system::settings.label_customer_online_time_out',
                'type'    => 'number',
                'span'    => 'left',
                'comment' => 'lang:system::settings.help_customer_online',
            ],
            'customer_online_archive_time_out' => [
                'label'   => 'lang:system::settings.label_customer_online_archive_time_out',
                'type'    => 'select',
                'span'    => 'right',
                'options' => [
                    '0'  => 'lang:system::settings.text_never_delete',
                    '1'  => 'lang:system::settings.text_1_month',
                    '3'  => 'lang:system::settings.text_3_months',
                    '6'  => 'lang:system::settings.text_6_months',
                    '12' => 'lang:system::settings.text_12_months',
                ],
                'comment' => 'lang:system::settings.help_customer_online_archive',
            ],

            'caching'    => [
                'label' => 'lang:system::settings.text_tab_title_caching',
                'type'  => 'section',
            ],
            'cache_mode' => [
                'label'   => 'lang:system::settings.label_cache_mode',
                'type'    => 'switch',
                'span'    => 'left',
                'comment' => 'lang:system::settings.help_cache_mode',
            ],
            'cache_time' => [
                'label'   => 'lang:system::settings.label_cache_time',
                'type'    => 'number',
                'span'    => 'right',
                'comment' => 'lang:system::settings.help_cache_time',
            ],
        ],
        'rules'    => [
            ['captcha_mode', 'lang:system::settings.label_recaptcha_site_key', 'required'],
            ['recaptcha_site_key', 'lang:system::settings.label_recaptcha_site_key', 'required_if:captcha_mode,recaptcha'],
            ['recaptcha_secret_key', 'lang:system::settings.label_recaptcha_secret_key', 'required_if:captcha_mode,recaptcha'],
            ['customer_online_time_out', 'lang:system::settings.label_customer_online_time_out', 'required|integer'],
            ['customer_online_time_out', 'lang:system::settings.label_customer_online_time_out', 'required|integer'],
            ['customer_online_archive_time_out', 'lang:system::settings.label_customer_online_archive_time_out', 'required|integer'],
            ['permalink', 'lang:system::settings.label_permalink', 'required|integer'],
            ['maintenance_mode', 'lang:system::settings.label_maintenance_mode', 'required|integer'],
            ['maintenance_message', 'lang:system::settings.label_maintenance_message', 'required'],
            ['cache_mode', 'lang:system::settings.label_cache_mode', 'required|integer'],
            ['cache_time', 'lang:system::settings.label_cache_time', 'integer'],
        ],
    ],
];

return $config;