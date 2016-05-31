<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
* Theme configuration options for admin panel customization.
* This file contains an array of options for use with the theme customizer.
* ONLY $theme = array() allowed
*
*/

// Set a custom theme title.
$theme['title']         = 'TastyIgniter Admin Blue';
$theme['author']        = 'SamPoyigi';
$theme['version']       = '1.0';
$theme['description']   = 'Responsive theme for admin panel';

$theme['nav_menu'] = array(
	'dashboard' => array(
		'class' => 'dashboard admin',
		'href' => site_url('dashboard'),
		'icon' => 'fa-dashboard',
		'title' => lang('menu_dashboard')
	),
	'kitchen' => array(
		'class' => 'kitchen',
		'icon' => 'fa-cutlery',
		'title' => lang('menu_kitchen'),
		'permission' => 'Admin.Menus|Admin.MenuOptions|Admin.Categories',
		'child' => array(
			'menus' => array('class' => 'menus', 'href' => site_url('menus'), 'title' => lang('menu_menu'), 'permission' => 'Admin.Menus'),
			'menu_options' => array('class' => 'menu_options', 'href' => site_url('menu_options'), 'title' => lang('menu_option'), 'permission' => 'Admin.MenuOptions'),
			'categories' => array('class' => 'categories', 'href' => site_url('categories'), 'title' => lang('menu_category'), 'permission' => 'Admin.Categories'),
		)
	),
	'sales' => array(
		'class' => 'sales',
		'icon' => 'fa-bar-chart-o',
		'title' => lang('menu_sale'),
		'permission' => 'Admin.Orders|Admin.Reservations|Admin.Coupons',
		'child' => array(
			'orders' => array('class' => 'orders', 'href' => site_url('orders'), 'title' => lang('menu_order'), 'permission' => 'Admin.Orders'),
			'reservations' => array('class' => 'reservations', 'href' => site_url('reservations'), 'title' => lang('menu_reservation'), 'permission' => 'Admin.Reservations'),
			'coupons' => array('class' => 'coupons', 'href' => site_url('coupons'), 'title' => lang('menu_coupon'), 'permission' => 'Admin.Coupons'),
		)
	),
	'marketing' => array(
		'class' => 'marketing',
		'icon' => 'fa-line-chart',
		'title' => lang('menu_marketing'),
		'permission' => 'Admin.Banners|Admin.Reviews|Admin.Messages',
		'child' => array(
			'reviews' => array('class' => 'reviews', 'href' => site_url('reviews'), 'title' => lang('menu_review'), 'permission' => 'Admin.Reviews'),
			'messages' => array('class' => 'messages', 'href' => site_url('messages'), 'title' => lang('menu_messages'), 'permission' => 'Admin.Messages'),
			'banners' => array('class' => 'banners', 'href' => site_url('banners'), 'title' => lang('menu_banner'), 'permission' => 'Admin.Banners'),
		)
	),
	'restaurant' => array(
		'class' => 'restaurant',
		'icon' => 'fa-map-marker',
		'title' => lang('menu_restaurant'),
		'permission' => 'Admin.Locations|Admin.Tables',
		'child' => array(
			'locations' => array('class' => 'locations', 'href' => site_url('locations'), 'title' => lang('menu_location'), 'permission' => 'Admin.Locations'),
			'tables' => array('class' => 'tables', 'href' => site_url('tables'), 'title' => lang('menu_table'), 'permission' => 'Admin.Tables'),
		)
	),
	'users' => array(
		'class' => 'users',
		'icon' => 'fa-user',
		'title' => lang('menu_user'),
		'permission' => 'Admin.Customers|Admin.CustomerGroups|Admin.CustomersOnline|Admin.Staffs|Admin.StaffGroups',
		'child' => array(
			'customers' => array('class' => 'customers', 'href' => site_url('customers'), 'title' => lang('menu_customer'), 'permission' => 'Admin.Customers'),
			'customer_groups' => array('class' => 'customer_groups', 'href' => site_url('customer_groups'), 'title' => lang('menu_customer_group'), 'permission' => 'Admin.CustomerGroups'),
			'customers_online' => array('class' => 'customers_online', 'href' => site_url('customers_online'), 'title' => lang('menu_customer_online'), 'permission' => 'Admin.CustomersOnline'),
			'staffs' => array('class' => 'staffs', 'href' => site_url('staffs'), 'title' => lang('menu_staff'), 'permission' => 'Admin.Staffs'),
			'staff_groups' => array('class' => 'staff_groups', 'href' => site_url('staff_groups'), 'title' => lang('menu_staff_group'), 'permission' => 'Admin.StaffGroups'),
			'activities' => array('class' => 'activities', 'href' => site_url('activities'), 'title' => lang('menu_activities'), 'permission' => 'Admin.Activities'),
		)
	),
	'extensions' => array(
		'class' => 'extensions',
		'href' => site_url('extensions'),
		'icon' => 'fa-puzzle-piece',
		'title' => lang('menu_extension'),
		'permission' => 'Admin.Extensions'
	),
	'design' => array(
		'class' => 'design',
		'icon' => 'fa-paint-brush',
		'title' => lang('menu_design'),
		'permission' => 'Site.Pages|Site.Layouts|Site.Themes|Admin.MailTemplates',
		'child' => array(
			'pages' => array('class' => 'pages', 'href' => site_url('pages'), 'title' => lang('menu_page'), 'permission' => 'Site.Pages'),
			'layouts' => array('class' => 'layouts', 'href' => site_url('layouts'), 'title' => lang('menu_layout'), 'permission' => 'Site.Layouts'),
			'themes' => array('class' => 'themes', 'href' => site_url('themes'), 'title' => lang('menu_theme'), 'permission' => 'Site.Themes'),
			'mail_templates' => array('class' => 'mail_templates', 'href' => site_url('mail_templates'), 'title' => lang('menu_mail_template'), 'permission' => 'Admin.MailTemplates'),
		)
	),
	'localisation' => array(
		'class' => 'localisation',
		'icon' => 'fa-globe',
		'title' => lang('menu_localisation'),
		'permission' => 'Site.Languages|Site.Currencies|Site.Countries|Admin.SecurityQuestions|Admin.Ratings|Admin.Statuses',
        'child' => array(
	        'languages' => array('class' => 'languages', 'href' => site_url('languages'), 'title' => lang('menu_language'), 'permission' => 'Site.Languages'),
	        'currencies' => array('class' => 'currencies', 'href' => site_url('currencies'), 'title' => lang('menu_currency'), 'permission' => 'Site.Currencies'),
	        'countries' => array('class' => 'countries', 'href' => site_url('countries'), 'title' => lang('menu_country'), 'permission' => 'Site.Countries'),
	        'mealtimes' => array('class' => 'mealtimes', 'href' => site_url('mealtimes'), 'title' => lang('menu_mealtimes'), 'permission' => 'Admin.Mealtimes'),
	        'security_questions' => array('class' => 'security_questions', 'href' => site_url('security_questions'), 'title' => lang('menu_security_question'), 'permission' => 'Admin.SecurityQuestions'),
	        'ratings' => array('class' => 'ratings', 'href' => site_url('ratings'), 'title' => lang('menu_rating'), 'permission' => 'Admin.Ratings'),
	        'statuses' => array('class' => 'statuses', 'href' => site_url('statuses'), 'title' => lang('menu_status'), 'permission' => 'Admin.Statuses'),
        )
	),
	'system' => array(
		'class' => 'system',
		'icon' => 'fa-cog',
		'title' => lang('menu_system'),
		'permission' => 'Admin.Permissions|Admin.ErrorLogs|Site.Settings',
		'child' => array(
			'settings' => array('class' => 'settings', 'href' => site_url('settings'), 'title' => lang('menu_setting'), 'permission' => 'Site.Settings'),
			'permissions' => array('class' => 'permissions', 'href' => site_url('permissions'), 'title' => lang('menu_permission'), 'permission' => 'Admin.Permissions'),
//			'uri_routes' => array('class' => 'uri_routes', 'href' => site_url('uri_routes'), 'title' => lang('menu_uri_route')),
			'error_logs' => array('class' => 'error_logs', 'href' => site_url('error_logs'), 'title' => lang('menu_error_log'), 'permission' => 'Admin.ErrorLogs'),
			'tools' => array(
				'class' => 'tools',
				'title' => lang('menu_tool'),
				'permission' => 'Admin.MediaManager|Admin.Maintenance',
				'child' => array(
					'image_manager' => array('class' => 'image_manager', 'href' => site_url('image_manager'), 'title' => lang('menu_media_manager'), 'permission' => 'Admin.MediaManager'),
					'maintenance' => array('class' => 'maintenance', 'href' => site_url('maintenance'), 'title' => lang('menu_maintenance'), 'permission' => 'Admin.Maintenance'),
				)
			),

		)
	),
	'collapse' => array(
		'class' => 'hidden-xs sidebar-toggle',
		'icon' => 'fa-chevron-circle-left',
		'title' => lang('menu_collapse')
	),
);


/* End of file theme_config.php */
/* Location: ./admin/views/themes/tastyigniter-blue/theme_config.php */