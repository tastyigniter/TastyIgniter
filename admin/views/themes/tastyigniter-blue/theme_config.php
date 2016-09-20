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
$theme['version']       = '1.1';
$theme['description']   = 'Responsive theme for admin panel';

$theme['nav_menu'] = array(
	'dashboard' => array(
		'priority' => '0',
		'class' => 'dashboard admin',
		'href' => site_url('dashboard'),
		'icon' => 'fa-dashboard',
		'title' => lang('menu_dashboard'),
		'permission' => 'Admin.Dashboard',
	),
	'kitchen' => array(
		'priority' => '1',
		'class' => 'kitchen',
		'icon' => 'fa-cutlery',
		'title' => lang('menu_kitchen'),
		'permission' => 'Admin.Menus|Admin.MenuOptions|Admin.Categories',
		'child' => array(
			'menus' => array('priority' => '1', 'class' => 'menus', 'href' => site_url('menus'), 'title' => lang('menu_menu'), 'permission' => 'Admin.Menus'),
			'menu_options' => array('priority' => '2', 'class' => 'menu_options', 'href' => site_url('menu_options'), 'title' => lang('menu_option'), 'permission' => 'Admin.MenuOptions'),
			'categories' => array('priority' => '3', 'class' => 'categories', 'href' => site_url('categories'), 'title' => lang('menu_category'), 'permission' => 'Admin.Categories'),
		)
	),
	'sales' => array(
		'priority' => '2',
		'class' => 'sales',
		'icon' => 'fa-bar-chart-o',
		'title' => lang('menu_sale'),
		'permission' => 'Admin.Orders|Admin.Reservations|Admin.Coupons',
		'child' => array(
			'orders' => array('priority' => '1', 'class' => 'orders', 'href' => site_url('orders'), 'title' => lang('menu_order'), 'permission' => 'Admin.Orders'),
			'reservations' => array('priority' => '2', 'class' => 'reservations', 'href' => site_url('reservations'), 'title' => lang('menu_reservation'), 'permission' => 'Admin.Reservations'),
			'coupons' => array('priority' => '3', 'class' => 'coupons', 'href' => site_url('coupons'), 'title' => lang('menu_coupon'), 'permission' => 'Admin.Coupons'),
		)
	),
	'marketing' => array(
		'priority' => '3',
		'class' => 'marketing',
		'icon' => 'fa-line-chart',
		'title' => lang('menu_marketing'),
		'permission' => 'Admin.Banners|Admin.Reviews|Admin.Messages',
		'child' => array(
			'reviews' => array('priority' => '1', 'class' => 'reviews', 'href' => site_url('reviews'), 'title' => lang('menu_review'), 'permission' => 'Admin.Reviews'),
			'messages' => array('priority' => '2', 'class' => 'messages', 'href' => site_url('messages'), 'title' => lang('menu_messages'), 'permission' => 'Admin.Messages'),
			'banners' => array('priority' => '3', 'class' => 'banners', 'href' => site_url('banners'), 'title' => lang('menu_banner'), 'permission' => 'Admin.Banners'),
		)
	),
	'restaurant' => array(
		'priority' => '4',
		'class' => 'restaurant',
		'icon' => 'fa-map-marker',
		'title' => lang('menu_restaurant'),
		'permission' => 'Admin.Locations|Admin.Tables',
		'child' => array(
			'locations' => array('priority' => '1', 'class' => 'locations', 'href' => site_url('locations'), 'title' => lang('menu_location'), 'permission' => 'Admin.Locations'),
			'tables' => array('priority' => '2', 'class' => 'tables', 'href' => site_url('tables'), 'title' => lang('menu_table'), 'permission' => 'Admin.Tables'),
		)
	),
	'users' => array(
		'priority' => '10',
		'class' => 'users',
		'icon' => 'fa-user',
		'title' => lang('menu_user'),
		'permission' => 'Admin.Customers|Admin.CustomerGroups|Admin.CustomersOnline|Admin.Staffs|Admin.StaffGroups',
		'child' => array(
			'customers' => array('priority' => '1', 'class' => 'customers', 'href' => site_url('customers'), 'title' => lang('menu_customer'), 'permission' => 'Admin.Customers'),
			'customer_groups' => array('priority' => '2', 'class' => 'customer_groups', 'href' => site_url('customer_groups'), 'title' => lang('menu_customer_group'), 'permission' => 'Admin.CustomerGroups'),
			'customers_online' => array('priority' => '3', 'class' => 'customers_online', 'href' => site_url('customers_online'), 'title' => lang('menu_customer_online'), 'permission' => 'Admin.CustomersOnline'),
			'staffs' => array('priority' => '4', 'class' => 'staffs', 'href' => site_url('staffs'), 'title' => lang('menu_staff'), 'permission' => 'Admin.Staffs'),
			'staff_groups' => array('priority' => '5', 'class' => 'staff_groups', 'href' => site_url('staff_groups'), 'title' => lang('menu_staff_group'), 'permission' => 'Admin.StaffGroups'),
			'activities' => array('priority' => '6', 'class' => 'activities', 'href' => site_url('activities'), 'title' => lang('menu_activities'), 'permission' => 'Admin.Activities'),
		)
	),
	'extensions' => array(
		'priority' => '20',
		'class' => 'extensions',
		'href' => site_url('extensions'),
		'icon' => 'fa-puzzle-piece',
		'title' => lang('menu_extension'),
		'permission' => 'Admin.Extensions'
	),
	'design' => array(
		'priority' => '30',
		'class' => 'design',
		'icon' => 'fa-paint-brush',
		'title' => lang('menu_design'),
		'permission' => 'Site.Pages|Site.Layouts|Site.Themes|Admin.MailTemplates',
		'child' => array(
			'pages' => array('priority' => '1', 'class' => 'pages', 'href' => site_url('pages'), 'title' => lang('menu_page'), 'permission' => 'Site.Pages'),
			'layouts' => array('priority' => '2', 'class' => 'layouts', 'href' => site_url('layouts'), 'title' => lang('menu_layout'), 'permission' => 'Site.Layouts'),
			'themes' => array('priority' => '3', 'class' => 'themes', 'href' => site_url('themes'), 'title' => lang('menu_theme'), 'permission' => 'Site.Themes'),
			'mail_templates' => array('priority' => '4', 'class' => 'mail_templates', 'href' => site_url('mail_templates'), 'title' => lang('menu_mail_template'), 'permission' => 'Admin.MailTemplates'),
		)
	),
	'localisation' => array(
		'priority' => '40',
		'class' => 'localisation',
		'icon' => 'fa-globe',
		'title' => lang('menu_localisation'),
		'permission' => 'Site.Languages|Site.Currencies|Site.Countries|Admin.SecurityQuestions|Admin.Ratings|Admin.Statuses',
        'child' => array(
	        'languages' => array('priority' => '1', 'class' => 'languages', 'href' => site_url('languages'), 'title' => lang('menu_language'), 'permission' => 'Site.Languages'),
	        'currencies' => array('priority' => '2', 'class' => 'currencies', 'href' => site_url('currencies'), 'title' => lang('menu_currency'), 'permission' => 'Site.Currencies'),
	        'countries' => array('priority' => '3', 'class' => 'countries', 'href' => site_url('countries'), 'title' => lang('menu_country'), 'permission' => 'Site.Countries'),
	        'mealtimes' => array('priority' => '4', 'class' => 'mealtimes', 'href' => site_url('mealtimes'), 'title' => lang('menu_mealtimes'), 'permission' => 'Admin.Mealtimes'),
	        'security_questions' => array('priority' => '5', 'class' => 'security_questions', 'href' => site_url('security_questions'), 'title' => lang('menu_security_question'), 'permission' => 'Admin.SecurityQuestions'),
	        'ratings' => array('priority' => '6', 'class' => 'ratings', 'href' => site_url('ratings'), 'title' => lang('menu_rating'), 'permission' => 'Admin.Ratings'),
	        'statuses' => array('priority' => '7', 'class' => 'statuses', 'href' => site_url('statuses'), 'title' => lang('menu_status'), 'permission' => 'Admin.Statuses'),
        )
	),
	'system' => array(
		'priority' => '999',
		'class' => 'system',
		'icon' => 'fa-cog',
		'title' => lang('menu_system'),
		'permission' => 'Admin.Permissions|Admin.ErrorLogs|Site.Settings',
		'child' => array(
			'settings' => array('priority' => '1', 'class' => 'settings', 'href' => site_url('settings'), 'title' => lang('menu_setting'), 'permission' => 'Site.Settings'),
			'updates' => array('priority' => '2', 'class' => 'updates', 'href' => site_url('updates'), 'title' => lang('menu_updates'), 'permission' => 'Site.Updates'),
			'permissions' => array('priority' => '2', 'class' => 'permissions', 'href' => site_url('permissions'), 'title' => lang('menu_permission'), 'permission' => 'Admin.Permissions'),
//			'uri_routes' => array('priority' => '3', 'class' => 'uri_routes', 'href' => site_url('uri_routes'), 'title' => lang('menu_uri_route')),
			'error_logs' => array('priority' => '4', 'class' => 'error_logs', 'href' => site_url('error_logs'), 'title' => lang('menu_error_log'), 'permission' => 'Admin.ErrorLogs'),
			'tools' => array(
				'priority' => '5',
				'class' => 'tools',
				'title' => lang('menu_tool'),
				'permission' => 'Admin.MediaManager|Admin.Maintenance',
				'child' => array(
					'image_manager' => array('priority' => '1', 'class' => 'image_manager', 'href' => site_url('image_manager'), 'title' => lang('menu_media_manager'), 'permission' => 'Admin.MediaManager'),
					'maintenance' => array('priority' => '2', 'class' => 'maintenance', 'href' => site_url('maintenance'), 'title' => lang('menu_maintenance'), 'permission' => 'Admin.Maintenance'),
				)
			),

		)
	),
	'collapse' => array(
		'priority' => '9999',
		'class' => 'hidden-xs sidebar-toggle',
		'icon' => 'fa-chevron-circle-left',
		'title' => lang('menu_collapse')
	),
);


/* End of file theme_config.php */
/* Location: ./admin/views/themes/tastyigniter-blue/theme_config.php */