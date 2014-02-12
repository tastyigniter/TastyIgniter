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
				
		if (isset($this->input->post['page_limit'])) {
			$data['page_limit'] = $this->input->post['page_limit'];
		} else {
			$data['page_limit'] = $this->config->item('page_limit');
		}
				
		if (isset($this->input->post['site_logo'])) {
			$data['site_logo'] = $this->input->post['site_logo'];
		} else {
			$data['site_logo'] = $this->config->base_url('assets/img/' . $this->config->item('site_logo'));
		}
				
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
				
		if (isset($this->input->post['approve_reviews'])) {
			$data['approve_reviews'] = $this->input->post['approve_reviews'];
		} else {
			$data['approve_reviews'] = $this->config->item('approve_reviews');
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
				
		if (isset($this->input->post['allow_order'])) {
			$data['allow_order'] = $this->input->post['allow_order'];
		} else {
			$data['allow_order'] = $this->config->item('allow_order');
		}
				
		if (isset($this->input->post['order_received'])) {
			$data['order_received'] = $this->input->post['order_received'];
		} else {
			$data['order_received'] = $this->config->item('order_received');
		}
				
		if (isset($this->input->post['order_completed'])) {
			$data['order_completed'] = $this->input->post['order_completed'];
		} else {
			$data['order_completed'] = $this->config->item('order_completed');
		}
				
		if (isset($this->input->post['ready_time'])) {
			$data['ready_time'] = $this->input->post['ready_time'];
		} else {
			$data['ready_time'] = $this->config->item('ready_time');
		}
				
		if (isset($this->input->post['reserve_status'])) {
			$data['reserve_status'] = $this->input->post['reserve_status'];
		} else {
			$data['reserve_status'] = $this->config->item('reserve_status');
		}
				
		if (isset($this->input->post['reserve_prefix'])) {
			$data['reserve_prefix'] = $this->input->post['reserve_prefix'];
		} else {
			$data['reserve_prefix'] = $this->config->item('reserve_prefix');
		}
				
		if (isset($this->input->post['upload_path'])) {
			$data['upload_path'] = $this->input->post['upload_path'];
		} else {
			$data['upload_path'] = $this->config->item('upload_path');
		}
				
		if (isset($this->input->post['allowed_types'])) {
			$data['allowed_types'] = $this->input->post['allowed_types'];
		} else {
			$data['allowed_types'] = $this->config->item('allowed_types');
		}
				
		if (isset($this->input->post['max_size'])) {
			$data['max_size'] = $this->input->post['max_size'];
		} else {
			$data['max_size'] = $this->config->item('max_size');
		}
				
		if (isset($this->input->post['max_height'])) {
			$data['max_height'] = $this->input->post['max_height'];
		} else {
			$data['max_height'] = $this->config->item('max_height');
		}
				
		if (isset($this->input->post['max_width'])) {
			$data['max_width'] = $this->input->post['max_width'];
		} else {
			$data['max_width'] = $this->config->item('max_width');
		}
				
		if (isset($this->input->post['menus_height'])) {
			$data['menus_height'] = $this->input->post['menus_height'];
		} else {
			$data['menus_height'] = $this->config->item('menus_height');
		}
				
		if (isset($this->input->post['menus_width'])) {
			$data['menus_width'] = $this->input->post['menus_width'];
		} else {
			$data['menus_width'] = $this->config->item('menus_width');
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
		
		$data['timezones'] = $this->Settings_model->getTimezones();

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

		$data['search_by'] = array('postcode' => 'Postcode Only', 'address' => 'Postcode & Address');

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
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
  			return TRUE;
    	
    	} else { 

			// form validation
			$this->form_validation->set_rules('site_name', 'Restaurant Name', 'trim|required|min_length[2]|max_length[128]');
			$this->form_validation->set_rules('site_email', 'Restaurant Email', 'trim|required|valid_email');
			$this->form_validation->set_rules('site_desc', 'Site Description', 'trim');
			$this->form_validation->set_rules('page_limit', 'Default Page Limit', 'trim|required|integer');
			$this->form_validation->set_rules('site_logo', 'Site Logo', 'trim|callback_handle_upload');
			$this->form_validation->set_rules('country_id', 'Restaurant Country', 'trim|required|integer');
			$this->form_validation->set_rules('timezone', 'Timezones', 'trim|required');
			$this->form_validation->set_rules('currency_id', 'Default Currency', 'trim|required|integer');

			$this->form_validation->set_rules('approve_reviews', 'Approve Reviews', 'trim|required|integer');
			
			$this->form_validation->set_rules('search_by', 'Search By', 'trim|required|alpha');
			$this->form_validation->set_rules('distance_unit', 'Distance Unit', 'trim|required');
			$this->form_validation->set_rules('allow_order', 'Allow Order', 'trim|required|integer');

			$this->form_validation->set_rules('order_received', 'Received Status', 'trim|required|integer');
			$this->form_validation->set_rules('order_completed', 'Completed Status', 'trim|required|integer');
			$this->form_validation->set_rules('ready_time', 'Default Ready Time', 'trim|required|integer');
			
			$this->form_validation->set_rules('reserve_status', 'Reservation Status', 'trim|required|integer');
			$this->form_validation->set_rules('reserve_prefix', 'Reservation Prefix', 'trim|required|integer');

			$this->form_validation->set_rules('upload_path', 'Upload Path', 'trim|required|');
			$this->form_validation->set_rules('allowed_types', 'Allowed Types', 'trim|required|');
			$this->form_validation->set_rules('max_size', 'Max Size', 'trim|required|integer');
			$this->form_validation->set_rules('max_height', 'Max Height', 'trim|required|integer');
			$this->form_validation->set_rules('max_width', 'Max Width', 'trim|required|integer');
			$this->form_validation->set_rules('menus_height', 'Menus Height', 'trim|required|integer');
			$this->form_validation->set_rules('menus_width', 'Menus Width', 'trim|required|integer');
			
			$this->form_validation->set_rules('protocol', 'Mail Protocol', 'trim|required');
			$this->form_validation->set_rules('mailtype', 'Mail Type Format', 'trim|required');
			$this->form_validation->set_rules('smtp_host', 'SMTP Host', 'trim|required');
			$this->form_validation->set_rules('smtp_port', 'SMTP Port', 'trim|required');
			$this->form_validation->set_rules('smtp_user', 'SMTP Username', 'trim|required');
			$this->form_validation->set_rules('smtp_pass', 'SMTP Password', 'trim|required');
			
			$this->form_validation->set_rules('log_threshold', 'Threshold Options', 'trim|required|integer');
			$this->form_validation->set_rules('log_path', 'Log Path', '');

			$this->form_validation->set_rules('encryption_key', 'Encryption Key', 'trim|required');

			if ($this->form_validation->run() == TRUE){

				$update = array(
					'site_name' 			=> $this->input->post('site_name'),
					'site_email' 			=> $this->input->post('site_email'),
					'site_desc' 			=> $this->input->post('site_desc'),
					'page_limit' 			=> $this->input->post('page_limit'),
					'site_logo' 			=> $this->input->post('site_logo'),
					'country_id' 			=> $this->input->post('country_id'),
					'timezone' 				=> $this->input->post('timezone'),
					'currency_id' 			=> $this->input->post('currency_id'),
					'approve_reviews'		=> $this->input->post('approve_reviews'),
					'search_by'				=> $this->input->post('search_by'),
					'distance_unit'			=> $this->input->post('distance_unit'),
					'allow_order'			=> $this->input->post('allow_order'),
					'order_received'		=> $this->input->post('order_received'),
					'order_completed'		=> $this->input->post('order_completed'),
					'ready_time'			=> $this->input->post('ready_time'),
					'reserve_status'		=> $this->input->post('reserve_status'),
					'reserve_prefix'		=> $this->input->post('reserve_prefix'),
					'upload_path' 			=> $this->input->post('upload_path'),
					'allowed_types' 		=> $this->input->post('allowed_types'),
					'max_size' 				=> $this->input->post('max_size'),
					'max_height' 			=> $this->input->post('max_height'),
					'max_width' 			=> $this->input->post('max_width'),
					'menus_height' 			=> $this->input->post('menus_height'),
					'menus_width' 			=> $this->input->post('menus_width'),
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
	}

 	public function handle_upload() {
		//loading upload library
		$this->load->library('upload');

		//setting upload preference
		$this->upload->set_upload_path($this->config->item('upload_path'));
		$this->upload->set_allowed_types($this->config->item('allowed_types'));
		$this->upload->set_max_filesize($this->config->item('max_size'));
		$this->upload->set_max_width($this->config->item('max_width'));
		$this->upload->set_max_height($this->config->item('max_height'));

		if (isset($_FILES['site_logo']) && !empty($_FILES['site_logo']['name'])) {
      		
      		if ($this->upload->do_upload('site_logo')) {

        		// set a $_POST value for 'menu_photo' that we can use later
        		if ($upload_data = $this->upload->data()) {
        			$_POST['site_logo'] = $this->security->sanitize_filename($upload_data['file_name']);
        		}
        		return TRUE;        
      		} else {
        		
        		// possibly do some clean up ... then throw an error
        		$this->form_validation->set_message('handle_upload', $this->upload->display_errors());
        		return FALSE;
     		}
    	} else {
      	
        	// set an empty $_POST value for 'menu_photo' to be used on database queries
        	$_POST['site_logo'] = '';
      		//return TRUE;
      	}
    }
}
