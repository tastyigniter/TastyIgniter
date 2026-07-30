<?php

return [
    'text_title' => 'Payments',
    'text_side_menu' => 'Payment Gateways',
    'text_form_name' => 'Payment',
    'text_tab_config' => 'Config',
    'text_filter_search' => 'Search by name or description.',
    'text_empty' => 'There are no payments available.',
    'text_this_payment' => 'this payment method',
    'text_save_card_profile' => 'Save card details for later.',
    'text_refund_title' => 'Refund: %s',
    'text_refund_full' => 'Full Refund',
    'text_refund_partial' => 'Partial Refund',
    'text_payment_logs' => 'Payment Attempts',
    'text_permission_group' => 'Payment',

    'label_payments' => 'Payment Gateways',
    'label_code' => 'Unique Code',
    'label_default' => 'Is Default',
    'label_priority' => 'Priority',
    'label_order_fee_type' => 'Additional Fee Type',
    'label_order_fee' => 'Additional Fee',
    'label_order_total' => 'Minimum Order Total Amount',
    'label_order_status' => 'Order Status',
    'label_capture_status' => 'Capture Payment Order Status',
    'label_refund_type' => 'Refund Type',
    'label_refund_amount' => 'Refund Partial Amount',
    'label_refund_reason' => 'Refund Reason',

    'onboarding_payments' => 'Set up how you get paid',
    'help_onboarding_payments' => 'Enable and configure at least one payment method so you can start accepting orders right away — online or offline.',

    'button_delete_card' => 'Delete and use a different card.',
    'button_refund' => 'Refund',

    'alert_min_total' => 'Order total is below the minimum order total for %s.',
    'alert_min_order_total' => 'You need to spend %s or more to pay with %s.',
    'alert_order_fee' => 'There\'s an additional fee of %s when you pay with %s.',
    'alert_missing_applicable_fee' => 'Missing additional fee for %s payment.',
    'alert_set_default' => 'Payment set as default',
    'alert_setting_missing_id' => 'Extension setting code has not been specified.',
    'alert_invalid_code' => 'Invalid payment gateway code selected.',
    'alert_code_not_found' => 'Unable to find payment gateway with code %s',
    'alert_refund_success' => 'Payment refunded successfully',

    'help_order_total' => 'The total amount the order must reach before this payment gateway becomes active',
    'help_order_fee' => 'Extra charge to the order total when this payment gateway becomes active',
    'help_order_status' => 'Default order status when this payment method is used. Leave blank to use the default order status set in the order settings (Manage > Settings > Order).',
    'help_capture_status' => 'The order status that captures an authorized payment.',

    'help_permission' => 'Manage payment gateways',
    'help_payments' => 'Select the payment(s) available at this location. Leave blank to use all enabled payments',
    'help_no_payments' => 'No enabled payment was found.',

    'cod' => [
        'text_tab_general' => 'General',
        'text_payment_title' => 'Cash On Delivery',
        'text_payment_desc' => 'Pay with cash when you pick up your order or when is delivered',

        'label_title' => 'Title',
        'label_status' => 'Status',
        'label_priority' => 'Priority',
    ],

    'paypal' => [
        'text_tab_general' => 'General',
        'text_payment_title' => 'PayPal Express',
        'text_payment_desc' => 'Securely pay using your PayPal account',

        'text_sandbox' => 'Sandbox',
        'text_go_live' => 'Go Live',
        'text_sale' => 'SALE',
        'text_authorization' => 'AUTHORIZATION',

        'label_title' => 'Title',
        'label_api_user' => 'Client ID',
        'label_api_pass' => 'Client Secret',
        'label_api_sandbox_user' => 'Sandbox Client ID',
        'label_api_sandbox_pass' => 'Sandbox Client Secret',
        'label_api_mode' => 'Mode',
        'label_api_action' => 'Payment Action',
        'label_priority' => 'Priority',
        'label_status' => 'Status',

        'alert_error_server' => '<p class="alert-danger">Sorry an error occurred, please try again</p>',
    ],

    'authorize_net_aim' => [
        'text_payment_title' => 'Authorize.Net (AIM)',
        'text_payment_desc' => 'Pay with your credit card via Authorize.Net',
        'text_go_live' => 'Go Live',
        'text_test' => 'Test',
        'text_test_live' => 'Test Live',
        'text_sale' => 'SALE',
        'text_auth_only' => 'Authorization Only',
        'text_auth_capture' => 'Authorization & Capture',
        'text_visa' => 'Visa',
        'text_mastercard' => 'MasterCard',
        'text_american_express' => 'American Express',
        'text_jcb' => 'JCB',
        'text_diners_club' => 'Diners Club',

        'label_title' => 'Title',
        'label_api_login_id' => 'API Login ID',
        'label_client_key' => 'Client Key',
        'label_transaction_key' => 'Transaction Key',
        'label_transaction_mode' => 'Transaction Mode',
        'label_transaction_type' => 'Transaction Type',
        'label_priority' => 'Priority',
        'label_status' => 'Status',

        'alert_acceptable_cards' => 'We only accept %s',
    ],

    'stripe' => [
        'text_tab_general' => 'General',
        'text_payment_title' => 'Stripe Payment',
        'text_payment_desc' => 'Pay with your credit card using Stripe',
        'text_credit_or_debit' => 'Credit or debit card',

        'text_auth_only' => 'Authorization Only',
        'text_auth_capture' => 'Authorization & Capture',
        'text_description' => 'Pay by Credit Card using Stripe',
        'text_live' => 'Live',
        'text_test' => 'Test',
        'text_stripe_charge_description' => '%s Charge for %s',
        'text_payment_status' => 'Payment %s (%s)',

        'label_title' => 'Title',
        'label_description' => 'Description',
        'label_transaction_mode' => 'Transaction Mode',
        'label_transaction_type' => 'Transaction Type',
        'label_test_secret_key' => 'Test Secret Key',
        'label_test_publishable_key' => 'Test Publishable Key',
        'label_live_secret_key' => 'Live Secret Key',
        'label_live_publishable_key' => 'Live Publishable Key',
        'label_test_webhook_secret' => 'Test Webhook Secret',
        'label_live_webhook_secret' => 'Live Webhook Secret',
        'label_locale_code' => 'Locale Code',
        'label_priority' => 'Priority',
        'label_status' => 'Status',
        'label_offsite_enabled' => 'Offsite Mode (Stripe Checkout)',
        'help_offsite_enabled' => 'Enabling offsite mode will redirect customers to a Stripe hosted payment page to complete the payment.',

        'help_locale_code' => 'See <a href="https://stripe.com/docs/js/appendix/supported_locales">Stripe.js supported locales</a',
    ],

    'mollie' => [
        'text_payment_title' => 'Mollie Payment',
        'text_payment_desc' => 'Pay with your credit card through Mollie',

        'text_live' => 'Live',
        'text_test' => 'Test',
        'text_description' => 'Pay by Credit Card using Mollie',
        'text_payment_status' => 'Payment %s (%s)',

        'label_transaction_mode' => 'Transaction Mode',
        'label_test_api_key' => 'Test API Key',
        'label_live_api_key' => 'Live API Key',
    ],

    'square' => [
        'text_payment_title' => 'Square Payment',
        'text_payment_desc' => 'Pay with your credit card using Square',

        'text_description' => 'Pay by Credit Card using Square',
        'text_live' => 'Live',
        'text_test' => 'Test',
        'text_payment_status' => 'Payment %s (%s)',

        'label_title' => 'Title',
        'label_description' => 'Description',
        'label_transaction_mode' => 'Transaction Mode',
        'label_test_app_id' => 'Test Application ID',
        'label_test_access_token' => 'Test Access Token',
        'label_test_location_id' => 'Test Location ID',
        'label_live_app_id' => 'Live Application ID',
        'label_live_access_token' => 'Live Access Token',
        'label_live_location_id' => 'Live Location ID',

        'help_square' => 'Get Square API Keys from <a href="https://developer.squareup.com">here</a>',
    ],
];
