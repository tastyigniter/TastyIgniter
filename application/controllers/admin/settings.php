<?php

class Settings extends CI_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
		$this->load->model('Locations_model');
		$this->load->model('Settings_model');
		$this->load->model('Countries_model');
		$this->load->model('Currencies_model');
		$this->load->model('Statuses_model');
		$this->load->model('Menus_model');	    
	}

	public function index() {
			
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/settings')) {
  			redirect('admin/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		$this->template->setTitle('Settings');
		$this->template->setHeading('Settings');
		$this->template->setButton('Save', array('class' => 'save_button', 'onclick' => '$(\'form\').submit();'));

		if ($this->input->post('site_name')) {
			$data['site_name'] = $this->input->post('site_name');
		} else {
			$data['site_name'] = $this->config->item('site_name');
		}
				
		if ($this->input->post('site_email')) {
			$data['site_email'] = $this->input->post('site_email');
		} else {
			$data['site_email'] = $this->config->item('site_email');
		}
				
		if ($this->input->post('site_desc')) {
			$data['site_desc'] = $this->input->post('site_desc');
		} else {
			$data['site_desc'] = $this->config->item('site_desc');
		}
				
		$this->load->model('Image_tool_model');
		$data['no_photo'] = $this->Image_tool_model->resize('data/no_photo.png');
		
		if ($this->input->post('site_logo')) {
			$data['site_logo'] = $this->Image_tool_model->resize($this->input->post('site_logo'));
			$data['logo_name'] = basename($this->input->post('site_logo'));
			$data['logo_val'] = $this->input->post('site_logo');			
		} else if ($this->config->item('site_logo')) {
			$data['site_logo'] = $this->Image_tool_model->resize($this->config->item('site_logo'));
			$data['logo_name'] = basename($this->config->item('site_logo'));
			$data['logo_val'] = $this->config->item('site_logo');			
		} else {
			$data['site_logo'] = $this->Image_tool_model->resize('data/no_photo.png');
			$data['logo_name'] = 'no_photo.png';
			$data['logo_val'] = 'data/no_photo.png';			
		}
				
		if ($this->input->post('country_id')) {
			$data['country_id'] = $this->input->post('country_id');
		} else {
			$data['country_id'] = $this->config->item('country_id');
		}
				
		$data['current_time'] = mdate('%d-%m-%Y %H:%i:%s', time());
		if ($this->input->post('timezone')) {
			$data['timezone'] = $this->input->post('timezone');
		} else {
			$data['timezone'] = $this->config->item('timezone');
		}
				
		if ($this->input->post('currency_id')) {
			$data['currency_id'] = $this->input->post('currency_id');
		} else {
			$data['currency_id'] = $this->config->item('currency_id');
		}
				
		if ($this->input->post('default_location_id')) {
			$data['default_location_id'] = $this->input->post('default_location_id');
		} else {
			$data['default_location_id'] = $this->config->item('default_location_id');
		}
				
		if ($this->input->post('language_id')) {
			$data['language_id'] = $this->input->post('language_id');
		} else {
			$data['language_id'] = $this->config->item('language_id');
		}
				
		if ($this->input->post('customer_group_id')) {
			$data['customer_group_id'] = $this->input->post('customer_group_id');
		} else {
			$data['customer_group_id'] = $this->config->item('customer_group_id');
		}
				
		if ($this->input->post('page_limit')) {
			$data['page_limit'] = $this->input->post('page_limit');
		} else {
			$data['page_limit'] = $this->config->item('page_limit');
		}
				
		if ($this->input->post('show_menu_images')) {
			$data['show_menu_images'] = $this->input->post('show_menu_images');
		} else {
			$data['show_menu_images'] = $this->config->item('show_menu_images');
		}
				
		if ($this->input->post('menu_images_h')) {
			$data['menu_images_h'] = $this->input->post('menu_images_h');
		} else {
			$data['menu_images_h'] = $this->config->item('menu_images_h');
		}
				
		if ($this->input->post('menu_images_w')) {
			$data['menu_images_w'] = $this->input->post('menu_images_w');
		} else {
			$data['menu_images_w'] = $this->config->item('menu_images_w');
		}
				
		if ($this->input->post('special_category_id')) {
			$data['special_category_id'] = $this->input->post('special_category_id');
		} else {
			$data['special_category_id'] = $this->config->item('special_category_id');
		}
				
		if ($this->input->post('maps_api_key')) {
			$data['maps_api_key'] = $this->input->post('maps_api_key');
		} else {
			$data['maps_api_key'] = $this->config->item('maps_api_key');
		}
				
		if ($this->input->post('search_by')) {
			$data['search_by'] = $this->input->post('search_by');
		} else {
			$data['search_by'] = $this->config->item('search_by');
		}
				
		if ($this->input->post('distance_unit')) {
			$data['distance_unit'] = $this->input->post('distance_unit');
		} else {
			$data['distance_unit'] = $this->config->item('distance_unit');
		}
				
		if ($this->input->post('search_radius')) {
			$data['search_radius'] = $this->input->post('search_radius');
		} else {
			$data['search_radius'] = $this->config->item('search_radius');
		}
				
		if ($this->input->post('send_order_email')) {
			$data['send_order_email'] = $this->input->post('send_order_email');
		} else {
			$data['send_order_email'] = $this->config->item('send_order_email');
		}
				
		if ($this->input->post('send_reserve_email')) {
			$data['send_reserve_email'] = $this->input->post('send_reserve_email');
		} else {
			$data['send_reserve_email'] = $this->config->item('send_reserve_email');
		}
				
		if ($this->input->post('location_order')) {
			$data['location_order'] = $this->input->post('location_order');
		} else {
			$data['location_order'] = $this->config->item('location_order');
		}
				
		if ($this->input->post('approve_reviews')) {
			$data['approve_reviews'] = $this->input->post('approve_reviews');
		} else {
			$data['approve_reviews'] = $this->config->item('approve_reviews');
		}
				
		if ($this->input->post('order_status_new')) {
			$data['order_status_new'] = $this->input->post('order_status_new');
		} else {
			$data['order_status_new'] = $this->config->item('order_status_new');
		}
				
		if ($this->input->post('order_status_complete')) {
			$data['order_status_complete'] = $this->input->post('order_status_complete');
		} else {
			$data['order_status_complete'] = $this->config->item('order_status_complete');
		}
				
		if ($this->input->post('guest_order')) {
			$data['guest_order'] = $this->input->post('guest_order');
		} else {
			$data['guest_order'] = $this->config->item('guest_order');
		}
				
		if ($this->input->post('ready_time')) {
			$data['ready_time'] = $this->input->post('ready_time');
		} else {
			$data['ready_time'] = $this->config->item('ready_time');
		}
				
		if ($this->input->post('reserve_mode')) {
			$data['reserve_mode'] = $this->input->post('reserve_mode');
		} else {
			$data['reserve_mode'] = $this->config->item('reserve_mode');
		}
				
		if ($this->input->post('reserve_status')) {
			$data['reserve_status'] = $this->input->post('reserve_status');
		} else {
			$data['reserve_status'] = $this->config->item('reserve_status');
		}
				
		if ($this->input->post('reserve_interval')) {
			$data['reserve_interval'] = $this->input->post('reserve_interval');
		} else {
			$data['reserve_interval'] = $this->config->item('reserve_interval');
		}
				
		if ($this->input->post('reserve_turn')) {
			$data['reserve_turn'] = $this->input->post('reserve_turn');
		} else {
			$data['reserve_turn'] = $this->config->item('reserve_turn');
		}
				
		if ($this->input->post('themes_allowed_img')) {
			$data['themes_allowed_img'] = strtolower($this->input->post('themes_allowed_img'));
		} else {
			$data['themes_allowed_img'] = strtolower($this->config->item('themes_allowed_img'));
		}
				
		if ($this->input->post('themes_allowed_file')) {
			$data['themes_allowed_file'] = strtolower($this->input->post('themes_allowed_file'));
		} else {
			$data['themes_allowed_file'] = strtolower($this->config->item('themes_allowed_file'));
		}
				
		if ($this->input->post('themes_hidden_files')) {
			$data['themes_hidden_files'] = strtolower($this->input->post('themes_hidden_files'));
		} else {
			$data['themes_hidden_files'] = strtolower($this->config->item('themes_hidden_files'));
		}
				
		if ($this->input->post('themes_hidden_folders')) {
			$data['themes_hidden_folders'] = strtolower($this->input->post('themes_hidden_folders'));
		} else {
			$data['themes_hidden_folders'] = strtolower($this->config->item('themes_hidden_folders'));
		}
				
		if ($this->input->post('protocol')) {
			$data['protocol'] = strtolower($this->input->post('protocol'));
		} else {
			$data['protocol'] = strtolower($this->config->item('protocol'));
		}
				
		if ($this->input->post('mailtype')) {
			$data['mailtype'] = strtolower($this->input->post('mailtype'));
		} else {
			$data['mailtype'] = strtolower($this->config->item('mailtype'));
		}
				
		if ($this->input->post('smtp_host')) {
			$data['smtp_host'] = $this->input->post('smtp_host');
		} else {
			$data['smtp_host'] = $this->config->item('smtp_host');
		}
				
		if ($this->input->post('smtp_port')) {
			$data['smtp_port'] = $this->input->post('smtp_port');
		} else {
			$data['smtp_port'] = $this->config->item('smtp_port');
		}
				
		if ($this->input->post('smtp_user')) {
			$data['smtp_user'] = $this->input->post('smtp_user');
		} else {
			$data['smtp_user'] = $this->config->item('smtp_user');
		}
				
		if ($this->input->post('smtp_pass')) {
			$data['smtp_pass'] = $this->input->post('smtp_pass');
		} else {
			$data['smtp_pass'] = $this->config->item('smtp_pass');
		}				

		if ($this->input->post('log_threshold')) {
			$data['log_threshold'] = $this->input->post('log_threshold');
		} else {
			$data['log_threshold'] = $this->config->item('log_threshold');
		}				

		if ($this->input->post('log_path')) {
			$data['log_path'] = $this->input->post('log_path');
		} else {
			$data['log_path'] = $this->config->item('log_path');
		}			

		if ($this->input->post('encryption_key')) {
			$data['encryption_key'] = $this->input->post('encryption_key');
		} else {
			$data['encryption_key'] = $this->config->item('encryption_key');
		}				

		if ($this->input->post('activity_timeout')) {
			$data['activity_timeout'] = $this->input->post('activity_timeout');
		} else {
			$data['activity_timeout'] = $this->config->item('activity_timeout');
		}				

		if ($this->input->post('index_file_url')) {
			$data['index_file_url'] = $this->input->post('index_file_url');
		} else {
			$data['index_file_url'] = $this->config->item('index_file_url');
		}				

		if ($this->input->post('maintenance_mode')) {
			$data['maintenance_mode'] = $this->input->post('maintenance_mode');
		} else {
			$data['maintenance_mode'] = $this->config->item('maintenance_mode');
		}				

		if ($this->input->post('maintenance_page')) {
			$data['maintenance_page'] = $this->input->post('maintenance_page');
		} else {
			$data['maintenance_page'] = $this->config->item('maintenance_page');
		}				

		if ($this->input->post('cache_mode')) {
			$data['cache_mode'] = $this->input->post('cache_mode');
		} else {
			$data['cache_mode'] = $this->config->item('cache_mode');
		}				

		if ($this->input->post('cache_time')) {
			$data['cache_time'] = $this->input->post('cache_time');
		} else {
			$data['cache_time'] = $this->config->item('cache_time');
		}				

		$data['page_limits'] = array('10', '20', '50', '75', '100');
		
		$timezones = $this->getTimezones();
		foreach ($timezones as $key => $value) {					
			$data['timezones'][$key] = $value;
		}

		$data['countries'] = array();
		$results = $this->Countries_model->getCountries();
		foreach ($results as $result) {					
			$data['countries'][] = array(
				'country_id'	=>	$result['country_id'],
				'name'			=>	$result['country_name'],
			);
		}

		$data['currencies'] = array();
		$currencies = $this->Currencies_model->getCurrencies();
		foreach ($currencies as $currency) {					
			$data['currencies'][] = array(
				'currency_id'		=>	$currency['currency_id'],
				'currency_name'		=>	$currency['currency_name'],
				'currency_status'	=>	$currency['currency_status']
			);
		}

		$this->load->model('Locations_model');	    
		$data['locations'] = array();
		$results = $this->Locations_model->getLocations();
		foreach ($results as $result) {					
			$data['locations'][] = array(
				'location_id'	=>	$result['location_id'],
				'location_name'	=>	$result['location_name'],
			);
		}
	
		$this->load->model('Languages_model');	    
		$data['languages'] = array();
		$results = $this->Languages_model->getLanguages();
		foreach ($results as $result) {					
			$data['languages'][] = array(
				'language_id'	=>	$result['language_id'],
				'name'			=>	$result['name'],
			);
		}
	
		$this->load->model('Customer_groups_model');
		$data['customer_groups'] = array();
		$results = $this->Customer_groups_model->getCustomerGroups();
		foreach ($results as $result) {					
			$data['customer_groups'][] = array(
				'customer_group_id'	=>	$result['customer_group_id'],
				'group_name'		=>	$result['group_name']
			);
		}

		$data['categories'] = array();
		$categories = $this->Menus_model->getCategories();
		foreach ($categories as $category) {					
			$data['categories'][] = array(
				'category_id'	=>	$category['category_id'],
				'category_name'	=>	$category['category_name']
			);
		}
		
		$data['search_by_array'] = array('postcode' => 'Postcode Only', 'address' => 'Postcode & Address');

		$data['statuses'] = array();
		$results = $this->Statuses_model->getStatuses();
		foreach ($results as $result) {					
			$data['statuses'][] = array(
				'status_id'		=> $result['status_id'],
				'status_name'		=> $result['status_name']
			);
		}

		$data['protocals'] 	= array('mail', 'sendmail', 'smtp');
		$data['mailtypes'] 	= array('text', 'html');
		$data['thresholds'] = array('Disable', 'Error Only', 'Debug Only', 'Info Only', 'All');

		$this->load->model('Pages_model');	    
		$data['pages'] = array();
		$results = $this->Pages_model->getPages();
		foreach ($results as $result) {					
			$data['pages'][] = array(
				'page_id'		=>	$result['page_id'],
				'name'			=>	$result['name'],
			);
		}
	
		if ($this->input->post() AND $this->_updateSettings() === TRUE) {
			redirect('admin/settings');
		}
						
		$this->template->regions(array('header', 'footer'));
		if (file_exists(APPPATH .'views/themes/admin/'.$this->config->item('admin_theme').'settings.php')) {
			$this->template->render('themes/admin/'.$this->config->item('admin_theme'), 'settings', $data);
		} else {
			$this->template->render('themes/admin/default/', 'settings', $data);
		}
	}

	public function _updateSettings() {
    	if (!$this->user->hasPermissions('modify', 'admin/settings')) {
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to update!</p>');
  			return TRUE;
    	} else if ($this->validateForm() === TRUE) { 
			$update = array(
				'site_name' 			=> $this->input->post('site_name'),
				'site_email' 			=> $this->input->post('site_email'),
				'site_desc' 			=> $this->input->post('site_desc'),
				'site_logo' 			=> $this->input->post('site_logo'),
				'country_id' 			=> $this->input->post('country_id'),
				'timezone' 				=> $this->input->post('timezone'),
				'currency_id' 			=> $this->input->post('currency_id'),
				'default_location_id' 	=> $this->input->post('default_location_id'),
				'language_id' 			=> $this->input->post('language_id'),
				'customer_group_id' 	=> $this->input->post('customer_group_id'),
				'page_limit' 			=> $this->input->post('page_limit'),
				'show_menu_images' 		=> $this->input->post('show_menu_images'),
				'menu_images_h' 		=> $this->input->post('menu_images_h'),
				'menu_images_w' 		=> $this->input->post('menu_images_w'),
				'special_category_id' 	=> $this->input->post('special_category_id'),
				'maps_api_key'			=> $this->input->post('maps_api_key'),
				'search_by'				=> $this->input->post('search_by'),
				'distance_unit'			=> $this->input->post('distance_unit'),
				'search_radius'			=> $this->input->post('search_radius'),
				'location_order'		=> $this->input->post('location_order'),
				'send_order_email'		=> $this->input->post('send_order_email'),
				'send_reserve_email'	=> $this->input->post('send_reserve_email'),
				'approve_reviews'		=> $this->input->post('approve_reviews'),
				'order_status_new'		=> $this->input->post('order_status_new'),
				'order_status_complete'	=> $this->input->post('order_status_complete'),
				'guest_order'			=> $this->input->post('guest_order'),
				'ready_time'			=> $this->input->post('ready_time'),
				'reserve_mode'			=> $this->input->post('reserve_mode'),
				'reserve_status'		=> $this->input->post('reserve_status'),
				'reserve_interval'		=> $this->input->post('reserve_interval'),
				'reserve_turn'			=> $this->input->post('reserve_turn'),
				'themes_allowed_img'	=> $this->input->post('themes_allowed_img'),
				'themes_allowed_file'	=> $this->input->post('themes_allowed_file'),
				'themes_hidden_files'	=> $this->input->post('themes_hidden_files'),
				'themes_hidden_folders'	=> $this->input->post('themes_hidden_folders'),
				'protocol' 				=> strtolower($this->input->post('protocol')),
				'mailtype' 				=> strtolower($this->input->post('mailtype')),
				'smtp_host' 			=> $this->input->post('smtp_host'),
				'smtp_port' 			=> $this->input->post('smtp_port'),
				'smtp_user' 			=> $this->input->post('smtp_user'),
				'smtp_pass' 			=> $this->input->post('smtp_pass'),
				'log_threshold' 		=> $this->input->post('log_threshold'),
				'log_path' 				=> $this->input->post('log_path'),
				'activity_timeout' 		=> $this->input->post('activity_timeout'),
				'encryption_key' 		=> $this->input->post('encryption_key'),
				'index_file_url' 		=> $this->input->post('index_file_url'),
				'maintenance_mode' 		=> $this->input->post('maintenance_mode'),
				'maintenance_page' 		=> $this->input->post('maintenance_page'),
				'cache_mode' 			=> $this->input->post('cache_mode'),
				'cache_time' 			=> $this->input->post('cache_time')
			);

			if ($this->Settings_model->updateSettings('config', $update)) {
				$this->session->set_flashdata('alert', '<p class="success">Settings updated sucessfully.</p>');
			} else {
				$this->session->set_flashdata('alert', '<p class="warning">An error occured, nothing updated.</p>');
			}
			
			return TRUE;
		}
	}

	public function validateForm() {
		$this->form_validation->set_rules('site_name', 'Restaurant Name', 'xss_clean|trim|required|min_length[2]|max_length[128]');
		$this->form_validation->set_rules('site_email', 'Restaurant Email', 'xss_clean|trim|required|valid_email');
		$this->form_validation->set_rules('site_desc', 'Site Description', 'xss_clean|trim');
		$this->form_validation->set_rules('site_logo', 'Site Logo', 'xss_clean|trim|required');
		$this->form_validation->set_rules('country_id', 'Restaurant Country', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('timezone', 'Timezones', 'xss_clean|trim|required');
		$this->form_validation->set_rules('currency_id', 'Restaurant Currency', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('default_location_id', 'Default Location', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('language_id', 'Default Language', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('customer_group_id', 'Customer Group', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('page_limit', 'Default Page Limit', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('show_menu_images', 'Show Menu Images', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('menu_images_h', 'Menu Images Height', 'xss_clean|trim|required|numeric');
		$this->form_validation->set_rules('menu_images_w', 'Menu Images Width', 'xss_clean|trim|required|numeric');
		$this->form_validation->set_rules('special_category_id', 'Specials Category', 'xss_clean|trim|required|numeric');
		$this->form_validation->set_rules('maps_api_key', 'Google Maps API Key', 'xss_clean|trim');
		$this->form_validation->set_rules('search_by', 'Search By', 'xss_clean|trim|required|alpha');
		$this->form_validation->set_rules('distance_unit', 'Distance Unit', 'xss_clean|trim|required');
		$this->form_validation->set_rules('search_radius', 'Search Radius', 'xss_clean|trim|integer');
		$this->form_validation->set_rules('location_order', 'Allow Order', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('send_order_email', 'Send Order Email', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('send_reserve_email', 'Send Reservation Email', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('approve_reviews', 'Approve Reviews', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('order_status_new', 'New Order Status', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('order_status_complete', 'Complete Order Status', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('guest_order', 'Guest Order', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('ready_time', 'Ready Time', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('reserve_mode', 'Reservation Mode', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('reserve_status', 'Reservation Status', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('reserve_interval', 'Reservation Interval', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('reserve_turn', 'Reservations Turn', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('themes_allowed_img', 'Themes Allowed Images', 'xss_clean|trim');
		$this->form_validation->set_rules('themes_allowed_file', 'Themes Allowed Files', 'xss_clean|trim');
		$this->form_validation->set_rules('themes_hidden_files', 'Themes Hidden Files', 'xss_clean|trim');
		$this->form_validation->set_rules('themes_hidden_folders', 'Themes Hidden Folders', 'xss_clean|trim');
		$this->form_validation->set_rules('protocol', 'Mail Protocol', 'xss_clean|trim|required');
		$this->form_validation->set_rules('mailtype', 'Mail Type Format', 'xss_clean|trim|required');
		$this->form_validation->set_rules('smtp_host', 'SMTP Host', 'xss_clean|trim|');
		$this->form_validation->set_rules('smtp_port', 'SMTP Port', 'xss_clean|trim|');
		$this->form_validation->set_rules('smtp_user', 'SMTP Username', 'xss_clean|trim|');
		$this->form_validation->set_rules('smtp_pass', 'SMTP Password', 'xss_clean|trim|');
		$this->form_validation->set_rules('log_threshold', 'Threshold Options', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('log_path', 'Log Path', 'xss_clean|trim|');
		$this->form_validation->set_rules('encryption_key', 'Encryption Key', 'xss_clean|trim|required');
		$this->form_validation->set_rules('activity_timeout', 'Activity Timeout', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('index_file_url', 'Index File', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('maintenance_mode', 'Maintenance Mode', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('maintenance_page', 'Maintenance Page', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('cache_mode', 'Cache Mode', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('cache_time', 'Cache Time', 'xss_clean|trim|integer');

		if ($this->form_validation->run() == TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}

	}

	public function getTimezones() {
		$timezone_identifiers = DateTimeZone::listIdentifiers();
		$utc_time = new DateTime('now', new DateTimeZone('UTC'));
 
		$temp_timezones = array();
		foreach ($timezone_identifiers as $timezone_identifier) {
			$current_timezone = new DateTimeZone($timezone_identifier);
 
			$temp_timezones[] = array(
				'offset' => (int)$current_timezone->getOffset($utc_time),
				'identifier' => $timezone_identifier
			);
		}
 
		usort($temp_timezones, function($a, $b) {
			return ($a['offset'] == $b['offset']) ? strcmp($a['identifier'], $b['identifier']) : $a['offset'] - $b['offset'];
		});
 
		$timezoneList = array();
		foreach ($temp_timezones as $tz) {
			$sign = ($tz['offset'] > 0) ? '+' : '-';
			$offset = gmdate('H:i', abs($tz['offset']));
			$timezone_list[$tz['identifier']] = $tz['identifier'] .' (UTC ' . $sign . $offset .')';
		}
 
		return $timezone_list;
	}
}

/* End of file settings.php */
/* Location: ./application/controllers/admin/settings.php */