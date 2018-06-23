<?php
return [
    'site_title'     => '%s - %s',
    'site_copyright' => '&copy; %s %s - ',

    'text_free'        => 'Free',
    'text_equals'      => ' = ',
    'text_plus'        => '+ ',
    'text_minutes'     => 'minutes',
    'text_min'         => 'min',
    'text_my_account'  => 'My Account',
    'text_information' => 'Information',
    'text_follow_us'   => 'Follow us on:',

    'text_maintenance_enabled' => 'Maintenance Enabled',

    'menu_home'               => 'Home',
    'menu_menu'               => 'View Menu',
    'menu_reservation'        => 'Reservation',
    'menu_login'              => 'Login',
    'menu_logout'             => 'Logout',
    'menu_register'           => 'Register',
    'menu_my_account'         => 'My Account',
    'menu_account'            => 'Main',
    'menu_detail'             => 'Edit Details',
    'menu_address'            => 'Address Book',
    'menu_recent_order'       => 'Recent Orders',
    'menu_recent_reservation' => 'Recent Reservations',
    'menu_locations'          => 'Our Locations',
    'menu_contact'            => 'Contact Us',
    'menu_admin'              => 'Administrator',

    'alert_success'         => '%s successfully.',
    'alert_error'           => 'An error occurred, %s.',
    'alert_error_nothing'   => 'An error occurred, nothing %s.',
    'alert_error_try_again' => 'An error occurred, please try again.',
    'alert_warning_confirm' => 'This cannot be undone! Are you sure you want to do this?',
    'alert_custom_error'    => 'Something went wrong and the page cannot be displayed',

    'alert_no_search_query'       => 'Please type in a postcode/address to check if we can deliver to you.',
    'alert_info_outdated_browser' => 'You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.',

    'home' => [
        'title'            => 'Welcome To TastyIgniter!',
        'text_step_one'    => 'Search',
        'text_step_two'    => 'Choose',
        'text_step_three'  => 'Pay by cash or card',
        'text_step_four'   => 'Enjoy',
        'text_step_search' => 'Find and select restaurant that deliver to you by entering your postcode or address.',
        'text_step_choose' => 'Browse hundreds of menus to find the food you like.',
        'text_step_pay'    => 'It\'s quick, easy and secure. Pay by Cash on Delivery or PayPal.',
        'text_step_enjoy'  => 'Food is prepared & delivered to your door step or ready for pick-up at the restaurant.',
    ],

    'local' => [
        'text_tab_menu'    => 'Menu',
        'text_tab_review'  => 'Reviews',
        'text_tab_info'    => 'Info',
        'text_tab_gallery' => 'Gallery',

        'menus'   => [
            'title' => 'Menu',
        ],
        'info'    => [
            'title' => 'Info',
        ],
        'gallery' => [
            'title' => 'Gallery',
        ],
        'reviews' => [
            'title' => 'Reviews',
        ],
    ],

    'checkout' => [
        'title'   => 'Checkout',
        'success' => [
            'title' => 'Checkout Confirmation',
        ],
    ],

    'reservation' => [
        'title'   => 'Reservation',
        'success' => [
            'title' => 'Reservation Confirmation',
        ],
    ],

    'cart' => [
        'title' => 'Cart',
    ],

    'locations' => [
        'title' => 'Locations',
    ],

    'contact' => [
        'title' => 'Contact',
    ],

    'pages' => [
        'title' => 'Pages',
    ],

    'account' => [
        'title' => 'Account',

        'login' => [
            'title'               => 'Login',
            'text_login'          => 'Log In',
            'text_register'       => 'Register <small>It\'s easy and always will be.</small>',
            'text_forgot'         => 'Forgot password?',
            'text_login_register' => 'Already registered? <a href="%s">Login</a>',

            'button_login'    => 'Login',
            'button_register' => 'Register',

            'activity_logged_in'          => ' <b>logged</b> in.',
            'activity_registered_account' => ' <b>created</b> an account.',
        ],

        'register' => [
            'title' => 'Register',
        ],

        'address' => [
            'title' => 'Account',
        ],

        'settings' => [
            'title' => 'Settings',
        ],

        'orders' => [
            'title' => 'Orders',
        ],

        'reservations' => [
            'title' => 'Reservations',
        ],

        'reviews' => [
            'title' => 'Reviews',
        ],

        'inbox' => [
            'title' => 'Inbox',
        ],

        'reset' => [
            'title'        => 'Account Password Reset',
            'text_heading' => 'Account Password Reset',
        ],
    ],

    'not_found' => [
        'layout_name'       => 'Layout [%s] not found',
        'page_label'        => 'Page not found',
        'page_message'      => 'The requested page cannot be found',
        'active_theme'      => 'Unable to load the active theme',
        'controller_action' => 'Action [%s] is not found in the controller [%s]',
        'layout'            => 'The layout [%s] is not found.',
        'component'         => 'The component [%s] is not found.',
        'partial'           => 'The partial [%s] is not found.',
        'content'           => 'The content [%s] is not found.',
        'method'            => 'The method [:method] is not found in [:name].',
        'ajax_handler'      => 'Ajax handler [%s] is not found.',
    ],
];