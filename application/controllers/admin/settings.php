<?php
class Settings extends CI_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
		$this->load->model('Locations_model'); // load the locations model
		$this->load->model('Settings_model');
		$this->load->model('Countries_model');
		$this->load->model('Currencies_model');
		$this->load->model('Statuses_model');
		$this->load->model('Menus_model');	    
	}

	public function index() {
			
		if (!file_exists(APPPATH .'views/admin/settings.php')) {
			show_404();
		}
			
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

		$data['heading'] 			= 'Settings';
		$data['sub_menu_save'] 		= 'Save';

		if (isset($this->input->post['site_name'])) {
			$data['site_name'] = $this->input->post['site_name'];
		} else {
			$data['site_name'] = $this->config->item('site_name');
		}
				
		if (isset($this->input->post['site_email'])) {
			$data['site_email'] = $this->input->post['site_email'];
		} else {
			$data['site_email'] = $this->config->item('site_email');
		}
				
		if (isset($this->input->post['site_desc'])) {
			$data['site_desc'] = $this->input->post['site_desc'];
		} else {
			$data['site_desc'] = $this->config->item('site_desc');
		}
				
		$this->load->model('Image_tool_model');
		if (isset($this->input->post['site_logo'])) {
			$data['site_logo'] = $this->Image_tool_model->resize($this->input->post['site_logo'], 120, 120);
			$data['logo_name'] = basename($this->input->post['site_logo']);
			$data['logo_val'] = $this->input->post['site_logo'];			
		} else if ($this->config->item('site_logo')) {
			$data['site_logo'] = $this->Image_tool_model->resize($this->config->item('site_logo'), 120, 120);
			$data['logo_name'] = basename($this->config->item('site_logo'));
			$data['logo_val'] = $this->config->item('site_logo');			
		} else {
			$data['site_logo'] = $this->Image_tool_model->resize('data/no_photo.png', 120, 120);
			$data['logo_name'] = 'no_photo.png';
			$data['logo_val'] = 'data/no_photo.png';			
		}
				
		$data['no_photo'] = $this->Image_tool_model->resize('data/no_photo.png', 120, 120);
		
		if (isset($this->input->post['country_id'])) {
			$data['country_id'] = $this->input->post['country_id'];
		} else {
			$data['country_id'] = $this->config->item('country_id');
		}
				
		if (isset($this->input->post['timezone'])) {
			$data['timezone'] = $this->input->post['timezone'];
		} else {
			$data['timezone'] = $this->config->item('timezone');
		}
				
		if (isset($this->input->post['currency_id'])) {
			$data['currency_id'] = $this->input->post['currency_id'];
		} else {
			$data['currency_id'] = $this->config->item('currency_id');
		}
				
		if (isset($this->input->post['default_location_id'])) {
			$data['default_location_id'] = $this->input->post['default_location_id'];
		} else {
			$data['default_location_id'] = $this->config->item('default_location_id');
		}
				
		if (isset($this->input->post['page_limit'])) {
			$data['page_limit'] = $this->input->post['page_limit'];
		} else {
			$data['page_limit'] = $this->config->item('page_limit');
		}
				
		if (isset($this->input->post['show_menu_images'])) {
			$data['show_menu_images'] = $this->input->post['show_menu_images'];
		} else {
			$data['show_menu_images'] = $this->config->item('show_menu_images');
		}
				
		if (isset($this->input->post['menu_images_h'])) {
			$data['menu_images_h'] = $this->input->post['menu_images_h'];
		} else {
			$data['menu_images_h'] = $this->config->item('menu_images_h');
		}
				
		if (isset($this->input->post['menu_images_w'])) {
			$data['menu_images_w'] = $this->input->post['menu_images_w'];
		} else {
			$data['menu_images_w'] = $this->config->item('menu_images_w');
		}
				
		if (isset($this->input->post['special_category_id'])) {
			$data['special_category_id'] = $this->input->post['special_category_id'];
		} else {
			$data['special_category_id'] = $this->config->item('special_category_id');
		}
				
		if (isset($this->input->post['maps_api_key'])) {
			$data['maps_api_key'] = $this->input->post['maps_api_key'];
		} else {
			$data['maps_api_key'] = $this->config->item('maps_api_key');
		}
				
		if (isset($this->input->post['search_by'])) {
			$data['search_by'] = $this->input->post['search_by'];
		} else {
			$data['search_by'] = $this->config->item('search_by');
		}
				
		if (isset($this->input->post['distance_unit'])) {
			$data['distance_unit'] = $this->input->post['distance_unit'];
		} else {
			$data['distance_unit'] = $this->config->item('distance_unit');
		}
				
		if (isset($this->input->post['search_radius'])) {
			$data['search_radius'] = $this->input->post['search_radius'];
		} else {
			$data['search_radius'] = $this->config->item('search_radius');
		}
				
		if (isset($this->input->post['send_order_email'])) {
			$data['send_order_email'] = $this->input->post['send_order_email'];
		} else {
			$data['send_order_email'] = $this->config->item('send_order_email');
		}
				
		if (isset($this->input->post['send_reserve_email'])) {
			$data['send_reserve_email'] = $this->input->post['send_reserve_email'];
		} else {
			$data['send_reserve_email'] = $this->config->item('send_reserve_email');
		}
				
		if (isset($this->input->post['location_order'])) {
			$data['location_order'] = $this->input->post['location_order'];
		} else {
			$data['location_order'] = $this->config->item('location_order');
		}
				
		if (isset($this->input->post['approve_reviews'])) {
			$data['approve_reviews'] = $this->input->post['approve_reviews'];
		} else {
			$data['approve_reviews'] = $this->config->item('approve_reviews');
		}
				
		if (isset($this->input->post['order_status_new'])) {
			$data['order_status_new'] = $this->input->post['order_status_new'];
		} else {
			$data['order_status_new'] = $this->config->item('order_status_new');
		}
				
		if (isset($this->input->post['order_status_complete'])) {
			$data['order_status_complete'] = $this->input->post['order_status_complete'];
		} else {
			$data['order_status_complete'] = $this->config->item('order_status_complete');
		}
				
		if (isset($this->input->post['guest_order'])) {
			$data['guest_order'] = $this->input->post['guest_order'];
		} else {
			$data['guest_order'] = $this->config->item('guest_order');
		}
				
		if (isset($this->input->post['ready_time'])) {
			$data['ready_time'] = $this->input->post['ready_time'];
		} else {
			$data['ready_time'] = $this->config->item('ready_time');
		}
				
		if (isset($this->input->post['reserve_prefix'])) {
			$data['reserve_prefix'] = $this->input->post['reserve_prefix'];
		} else {
			$data['reserve_prefix'] = $this->config->item('reserve_prefix');
		}
				
		if (isset($this->input->post['reserve_status'])) {
			$data['reserve_status'] = $this->input->post['reserve_status'];
		} else {
			$data['reserve_status'] = $this->config->item('reserve_status');
		}
				
		if (isset($this->input->post['reserve_interval'])) {
			$data['reserve_interval'] = $this->input->post['reserve_interval'];
		} else {
			$data['reserve_interval'] = $this->config->item('reserve_interval');
		}
				
		if (isset($this->input->post['reserve_turn'])) {
			$data['reserve_turn'] = $this->input->post['reserve_turn'];
		} else {
			$data['reserve_turn'] = $this->config->item('reserve_turn');
		}
				
		if (isset($this->input->post['protocol'])) {
			$data['protocol'] = strtolower($this->input->post['protocol']);
		} else {
			$data['protocol'] = strtolower($this->config->item('protocol'));
		}
				
		if (isset($this->input->post['mailtype'])) {
			$data['mailtype'] = strtolower($this->input->post['mailtype']);
		} else {
			$data['mailtype'] = strtolower($this->config->item('mailtype'));
		}
				
		if (isset($this->input->post['smtp_host'])) {
			$data['smtp_host'] = $this->input->post['smtp_host'];
		} else {
			$data['smtp_host'] = $this->config->item('smtp_host');
		}
				
		if (isset($this->input->post['smtp_port'])) {
			$data['smtp_port'] = $this->input->post['smtp_port'];
		} else {
			$data['smtp_port'] = $this->config->item('smtp_port');
		}
				
		if (isset($this->input->post['smtp_user'])) {
			$data['smtp_user'] = $this->input->post['smtp_user'];
		} else {
			$data['smtp_user'] = $this->config->item('smtp_user');
		}
				
		if (isset($this->input->post['smtp_pass'])) {
			$data['smtp_pass'] = $this->input->post['smtp_pass'];
		} else {
			$data['smtp_pass'] = $this->config->item('smtp_pass');
		}				

		if (isset($this->input->post['log_threshold'])) {
			$data['log_threshold'] = $this->input->post['log_threshold'];
		} else {
			$data['log_threshold'] = $this->config->item('log_threshold');
		}				

		if (isset($this->input->post['log_path'])) {
			$data['log_path'] = $this->input->post['log_path'];
		} else {
			$data['log_path'] = $this->config->item('log_path');
		}				

		if (isset($this->input->post['encryption_key'])) {
			$data['encryption_key'] = $this->input->post['encryption_key'];
		} else {
			$data['encryption_key'] = $this->config->item('encryption_key');
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
				'currency_title'	=>	$currency['currency_title'],
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

		// check if POST add_food, validate fields and add Food to model
		if ($this->input->post() && $this->_updateSettings() === TRUE) {
						
			redirect('admin/settings');
		}
						
		$regions = array(
			'admin/header',
			'admin/footer'
		);
		
		$this->template->regions($regions);
		$this->template->load('admin/settings', $data);
	}

	public function _updateSettings() {
    	if (!$this->user->hasPermissions('modify', 'admin/settings')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have the right permission to edit!</p>');
  			return TRUE;
    	
    	} else if ($this->validateForm() === TRUE) { 
			$update = array(
				'site_name' 			=> $this->input->post('site_name'),
				'site_email' 			=> $this->input->post('site_email'),
				'site_desc' 			=> $this->input->post('site_desc'),
				'site_logo' 			=> ($this->input->post('site_logo')) ? $this->input->post('site_logo') : $this->config->item('site_logo'),
				'country_id' 			=> $this->input->post('country_id'),
				'timezone' 				=> $this->input->post('timezone'),
				'currency_id' 			=> $this->input->post('currency_id'),
				'default_location_id' 	=> $this->input->post('default_location_id'),
				'page_limit' 			=> $this->input->post('page_limit'),
				'show_menu_images' 		=> $this->input->post('show_menu_images'),
				'menu_images_h' 		=> $this->input->post('menu_images_h'),
				'menu_images_w' 		=> $this->input->post('menu_images_w'),
				'special_category_id' 	=> $this->input->post('special_category_id'),
				'maps_api_key'			=> $this->input->post('maps_api_key'),
				'search_by'				=> $this->input->post('search_by'),
				'distance_unit'			=> $this->input->post('distance_unit'),
				'search_radius'			=> $this->input->post('search_radius'),
				'location_order'			=> $this->input->post('location_order'),
				'send_order_email'		=> $this->input->post('send_order_email'),
				'send_reserve_email'	=> $this->input->post('send_reserve_email'),
				'approve_reviews'		=> $this->input->post('approve_reviews'),
				'order_status_new'		=> $this->input->post('order_status_new'),
				'order_status_complete'	=> $this->input->post('order_status_complete'),
				'guest_order'			=> $this->input->post('guest_order'),
				'ready_time'			=> $this->input->post('ready_time'),
				'reserve_prefix'		=> $this->input->post('reserve_prefix'),
				'reserve_status'		=> $this->input->post('reserve_status'),
				'reserve_interval'		=> $this->input->post('reserve_interval'),
				'reserve_turn'			=> $this->input->post('reserve_turn'),
				'protocol' 				=> strtolower($this->input->post('protocol')),
				'mailtype' 				=> strtolower($this->input->post('mailtype')),
				'smtp_host' 			=> $this->input->post('smtp_host'),
				'smtp_port' 			=> $this->input->post('smtp_port'),
				'smtp_user' 			=> $this->input->post('smtp_user'),
				'smtp_pass' 			=> $this->input->post('smtp_pass'),
				'log_threshold' 		=> $this->input->post('log_threshold'),
				'log_path' 				=> $this->input->post('log_path'),
				'encryption_key' 		=> $this->input->post('encryption_key')
			);

			if ($this->Settings_model->updateSettings('config', $update)) {
				$this->session->set_flashdata('alert', '<p class="success">Settings Updated Sucessfully!</p>');
			} else {
				$this->session->set_flashdata('alert', '<p class="warning">Nothing Updated!</p>');
			}
			
			return TRUE;
		}
	}

	public function validateForm() {
		$this->form_validation->set_rules('site_name', 'Restaurant Name', 'trim|required|min_length[2]|max_length[128]');
		$this->form_validation->set_rules('site_email', 'Restaurant Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('site_desc', 'Site Description', 'trim');
		$this->form_validation->set_rules('site_logo', 'Site Logo', 'trim|required');
		$this->form_validation->set_rules('country_id', 'Restaurant Country', 'trim|required|integer');
		$this->form_validation->set_rules('timezone', 'Timezones', 'trim|required');
		$this->form_validation->set_rules('currency_id', 'Restaurant Currency', 'trim|required|integer');
		$this->form_validation->set_rules('default_location_id', 'Default Location', 'trim|required|integer');
		$this->form_validation->set_rules('page_limit', 'Default Page Limit', 'trim|required|integer');

		$this->form_validation->set_rules('show_menu_images', 'Show Menu Images', 'trim|required|integer');
		$this->form_validation->set_rules('menu_images_h', 'Menu Images Height', 'trim|required|numeric');
		$this->form_validation->set_rules('menu_images_w', 'Menu Images Width', 'trim|required|numeric');
		$this->form_validation->set_rules('special_category_id', 'Specials Category', 'trim|required|numeric');

		$this->form_validation->set_rules('maps_api_key', 'Google Maps API Key', 'trim');
		$this->form_validation->set_rules('search_by', 'Search By', 'trim|required|alpha');
		$this->form_validation->set_rules('distance_unit', 'Distance Unit', 'trim|required');
		$this->form_validation->set_rules('search_radius', 'Search Radius', 'trim|integer');
		$this->form_validation->set_rules('location_order', 'Allow Order', 'trim|required|integer');
		$this->form_validation->set_rules('send_order_email', 'Send Order Email', 'trim|required|integer');
		$this->form_validation->set_rules('send_reserve_email', 'Send Reservation Email', 'trim|required|integer');

		$this->form_validation->set_rules('approve_reviews', 'Approve Reviews', 'trim|required|integer');
		
		$this->form_validation->set_rules('order_status_new', 'New Order Status', 'trim|required|integer');
		$this->form_validation->set_rules('order_status_complete', 'Complete Order Status', 'trim|required|integer');
		$this->form_validation->set_rules('guest_order', 'Guest Order', 'trim|required|integer');
		$this->form_validation->set_rules('ready_time', 'Ready Time', 'trim|required|integer');
		
		$this->form_validation->set_rules('reserve_prefix', 'Reservation Prefix', 'trim|required|integer');
		$this->form_validation->set_rules('reserve_status', 'Reservation Status', 'trim|required|integer');
		$this->form_validation->set_rules('reserve_interval', 'Reservation Interval', 'trim|required|integer');
		$this->form_validation->set_rules('reserve_turn', 'Reservations Turn', 'trim|required|integer');

		$this->form_validation->set_rules('protocol', 'Mail Protocol', 'trim|required');
		$this->form_validation->set_rules('mailtype', 'Mail Type Format', 'trim|required');
		$this->form_validation->set_rules('smtp_host', 'SMTP Host', 'trim|');
		$this->form_validation->set_rules('smtp_port', 'SMTP Port', 'trim|');
		$this->form_validation->set_rules('smtp_user', 'SMTP Username', 'trim|');
		$this->form_validation->set_rules('smtp_pass', 'SMTP Password', 'trim|');
		
		$this->form_validation->set_rules('log_threshold', 'Threshold Options', 'trim|required|integer');
		$this->form_validation->set_rules('log_path', 'Log Path', 'trim|');

		$this->form_validation->set_rules('encryption_key', 'Encryption Key', 'trim|required');

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
			$timezone_list[$tz['identifier']] = '(UTC ' . $sign . $offset .') '. $tz['identifier'];
		}
 
		return $timezone_list;
	}
}
