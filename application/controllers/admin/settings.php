<?php
class Settings extends CI_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
		$this->load->model('Locations_model'); // load the locations model
		$this->load->model('Countries_model');
		$this->load->model('Currencies_model');
		$this->load->model('Statuses_model');	    
	}

	public function index() {
			
		if ( !file_exists(APPPATH .'/views/admin/settings.php')) { //check if file exists in views folder
			show_404(); // Whoops, show 404 error page!
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
		$data['sub_menu_update'] 	= 'Update';

		if (isset($this->input->post['config_site_name'])) {
			$data['config_site_name'] = $this->input->post['config_site_name'];
		} else {
			$data['config_site_name'] = $this->config->item('config_site_name');
		}
				
		if (isset($this->input->post['config_site_email'])) {
			$data['config_site_email'] = $this->input->post['config_site_email'];
		} else {
			$data['config_site_email'] = $this->config->item('config_site_email');
		}
				
		if (isset($this->input->post['config_site_desc'])) {
			$data['config_site_desc'] = $this->input->post['config_site_desc'];
		} else {
			$data['config_site_desc'] = $this->config->item('config_site_desc');
		}
				
		if (isset($this->input->post['config_page_limit'])) {
			$data['config_page_limit'] = $this->input->post['config_page_limit'];
		} else {
			$data['config_page_limit'] = $this->config->item('config_page_limit');
		}
				
		if (isset($this->input->post['config_site_logo'])) {
			$data['config_site_logo'] = $this->input->post['config_site_logo'];
		} else {
			$data['config_site_logo'] = $this->config->base_url('assets/img/' . $this->config->item('config_site_logo'));
		}
				
		if (isset($this->input->post['config_country'])) {
			$data['config_country'] = $this->input->post['config_country'];
		} else {
			$data['config_country'] = $this->config->item('config_country');
		}
				
		if (isset($this->input->post['config_timezone'])) {
			$data['config_timezone'] = $this->input->post['config_timezone'];
		} else {
			$data['config_timezone'] = $this->config->item('config_timezone');
		}
				
		if (isset($this->input->post['config_currency'])) {
			$data['config_currency'] = $this->input->post['config_currency'];
		} else {
			$data['config_currency'] = $this->config->item('config_currency');
		}
				
		if (isset($this->input->post['config_approve_reviews'])) {
			$data['config_approve_reviews'] = $this->input->post['config_approve_reviews'];
		} else {
			$data['config_approve_reviews'] = $this->config->item('config_approve_reviews');
		}
				
		if (isset($this->input->post['config_search_by'])) {
			$data['config_search_by'] = $this->input->post['config_search_by'];
		} else {
			$data['config_search_by'] = $this->config->item('config_search_by');
		}
				
		if (isset($this->input->post['config_distance_unit'])) {
			$data['config_distance_unit'] = $this->input->post['config_distance_unit'];
		} else {
			$data['config_distance_unit'] = $this->config->item('config_distance_unit');
		}
				
		if (isset($this->input->post['config_allow_order'])) {
			$data['config_allow_order'] = $this->input->post['config_allow_order'];
		} else {
			$data['config_allow_order'] = $this->config->item('config_allow_order');
		}
				
		if (isset($this->input->post['config_order_received'])) {
			$data['config_order_received'] = $this->input->post['config_order_received'];
		} else {
			$data['config_order_received'] = $this->config->item('config_order_received');
		}
				
		if (isset($this->input->post['config_order_completed'])) {
			$data['config_order_completed'] = $this->input->post['config_order_completed'];
		} else {
			$data['config_order_completed'] = $this->config->item('config_order_completed');
		}
				
		if (isset($this->input->post['config_ready_time'])) {
			$data['config_ready_time'] = $this->input->post['config_ready_time'];
		} else {
			$data['config_ready_time'] = $this->config->item('config_ready_time');
		}
				
		if (isset($this->input->post['config_reserve_status'])) {
			$data['config_reserve_status'] = $this->input->post['config_reserve_status'];
		} else {
			$data['config_reserve_status'] = $this->config->item('config_reserve_status');
		}
				
		if (isset($this->input->post['config_reserve_prefix'])) {
			$data['config_reserve_prefix'] = $this->input->post['config_reserve_prefix'];
		} else {
			$data['config_reserve_prefix'] = $this->config->item('config_reserve_prefix');
		}
				
		if (isset($this->input->post['config_upload_path'])) {
			$data['config_upload_path'] = $this->input->post['config_upload_path'];
		} else {
			$data['config_upload_path'] = $this->config->item('config_upload_path');
		}
				
		if (isset($this->input->post['config_allowed_types'])) {
			$data['config_allowed_types'] = $this->input->post['config_allowed_types'];
		} else {
			$data['config_allowed_types'] = $this->config->item('config_allowed_types');
		}
				
		if (isset($this->input->post['config_max_size'])) {
			$data['config_max_size'] = $this->input->post['config_max_size'];
		} else {
			$data['config_max_size'] = $this->config->item('config_max_size');
		}
				
		if (isset($this->input->post['config_max_height'])) {
			$data['config_max_height'] = $this->input->post['config_max_height'];
		} else {
			$data['config_max_height'] = $this->config->item('config_max_height');
		}
				
		if (isset($this->input->post['config_max_width'])) {
			$data['config_max_width'] = $this->input->post['config_max_width'];
		} else {
			$data['config_max_width'] = $this->config->item('config_max_width');
		}
				
		if (isset($this->input->post['config_menus_height'])) {
			$data['config_menus_height'] = $this->input->post['config_menus_height'];
		} else {
			$data['config_menus_height'] = $this->config->item('config_menus_height');
		}
				
		if (isset($this->input->post['config_menus_width'])) {
			$data['config_menus_width'] = $this->input->post['config_menus_width'];
		} else {
			$data['config_menus_width'] = $this->config->item('config_menus_width');
		}
				
		if (isset($this->input->post['config_protocol'])) {
			$data['config_protocol'] = strtolower($this->input->post['config_protocol']);
		} else {
			$data['config_protocol'] = strtolower($this->config->item('config_protocol'));
		}
				
		if (isset($this->input->post['config_mailtype'])) {
			$data['config_mailtype'] = strtolower($this->input->post['config_mailtype']);
		} else {
			$data['config_mailtype'] = strtolower($this->config->item('config_mailtype'));
		}
				
		if (isset($this->input->post['config_smtp_host'])) {
			$data['config_smtp_host'] = $this->input->post['config_smtp_host'];
		} else {
			$data['config_smtp_host'] = $this->config->item('config_smtp_host');
		}
				
		if (isset($this->input->post['config_smtp_port'])) {
			$data['config_smtp_port'] = $this->input->post['config_smtp_port'];
		} else {
			$data['config_smtp_port'] = $this->config->item('config_smtp_port');
		}
				
		if (isset($this->input->post['config_smtp_user'])) {
			$data['config_smtp_user'] = $this->input->post['config_smtp_user'];
		} else {
			$data['config_smtp_user'] = $this->config->item('config_smtp_user');
		}
				
		if (isset($this->input->post['config_smtp_pass'])) {
			$data['config_smtp_pass'] = $this->input->post['config_smtp_pass'];
		} else {
			$data['config_smtp_pass'] = $this->config->item('config_smtp_pass');
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
						
		//load home page content
		$this->load->view('admin/header', $data);
		$this->load->view('admin/settings', $data);
		$this->load->view('admin/footer');
	}

	public function _updateSettings() {
    	if (!$this->user->hasPermissions('modify', 'admin/settings')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
  			return TRUE;
    	
    	} else { 

			// form validation
			$this->form_validation->set_rules('config_site_name', 'Restaurant Name', 'trim|required|min_length[2]|max_length[128]');
			$this->form_validation->set_rules('config_site_email', 'Restaurant Email', 'trim|required|valid_email');
			$this->form_validation->set_rules('config_site_desc', 'Site Description', 'trim');
			$this->form_validation->set_rules('config_page_limit', 'Default Page Limit', 'trim|required|integer');
			$this->form_validation->set_rules('config_site_logo', 'Site Logo', 'trim|callback_handle_upload');
			$this->form_validation->set_rules('config_country', 'Restaurant Country', 'trim|required|integer');
			$this->form_validation->set_rules('config_timezone', 'Timezones', 'trim|required');
			$this->form_validation->set_rules('config_currency', 'Default Currency', 'trim|required|integer');

			$this->form_validation->set_rules('config_approve_reviews', 'Approve Reviews', 'trim|required|integer');
			
			$this->form_validation->set_rules('config_search_by', 'Search By', 'trim|required|alpha');
			$this->form_validation->set_rules('config_distance_unit', 'Distance Unit', 'trim|required');
			$this->form_validation->set_rules('config_allow_order', 'Allow Order', 'trim|required|integer');

			$this->form_validation->set_rules('config_order_received', 'Received Status', 'trim|required|integer');
			$this->form_validation->set_rules('config_order_completed', 'Completed Status', 'trim|required|integer');
			$this->form_validation->set_rules('config_ready_time', 'Default Ready Time', 'trim|required|integer');
			
			$this->form_validation->set_rules('config_reserve_status', 'Reservation Status', 'trim|required|integer');
			$this->form_validation->set_rules('config_reserve_prefix', 'Reservation Prefix', 'trim|required|integer');

			$this->form_validation->set_rules('config_upload_path', 'Upload Path', 'trim|required|');
			$this->form_validation->set_rules('config_allowed_types', 'Allowed Types', 'trim|required|');
			$this->form_validation->set_rules('config_max_size', 'Max Size', 'trim|required|integer');
			$this->form_validation->set_rules('config_max_height', 'Max Height', 'trim|required|integer');
			$this->form_validation->set_rules('config_max_width', 'Max Width', 'trim|required|integer');
			$this->form_validation->set_rules('config_menus_height', 'Menus Height', 'trim|required|integer');
			$this->form_validation->set_rules('config_menus_width', 'Menus Width', 'trim|required|integer');
			
			$this->form_validation->set_rules('config_protocol', 'Mail Protocol', 'trim|required');
			$this->form_validation->set_rules('config_mailtype', 'Mail Type Format', 'trim|required');
			$this->form_validation->set_rules('config_smtp_host', 'SMTP Host', 'trim|required');
			$this->form_validation->set_rules('config_smtp_port', 'SMTP Port', 'trim|required');
			$this->form_validation->set_rules('config_smtp_user', 'SMTP Username', 'trim|required');
			$this->form_validation->set_rules('config_smtp_pass', 'SMTP Password', 'trim|required');
			
			$this->form_validation->set_rules('log_threshold', 'Threshold Options', 'trim|required|integer');
			$this->form_validation->set_rules('log_path', 'Log Path', '');

			if ($this->form_validation->run() == TRUE){

				$update = array(
					'config_site_name' 			=> $this->input->post('config_site_name'),
					'config_site_email' 		=> $this->input->post('config_site_email'),
					'config_site_desc' 			=> $this->input->post('config_site_desc'),
					'config_page_limit' 		=> $this->input->post('config_page_limit'),
					'config_site_logo' 			=> $this->input->post('config_site_logo'),
					'config_country' 			=> $this->input->post('config_country'),
					'config_timezone' 			=> $this->input->post('config_timezone'),
					'config_currency' 			=> $this->input->post('config_currency'),
					'config_approve_reviews'	=> $this->input->post('config_approve_reviews'),
					'config_search_by'			=> $this->input->post('config_search_by'),
					'config_distance_unit'		=> $this->input->post('config_distance_unit'),
					'config_allow_order'		=> $this->input->post('config_allow_order'),
					'config_order_received'		=> $this->input->post('config_order_received'),
					'config_order_completed'	=> $this->input->post('config_order_completed'),
					'config_ready_time'			=> $this->input->post('config_ready_time'),
					'config_reserve_status'		=> $this->input->post('config_reserve_status'),
					'config_reserve_prefix'		=> $this->input->post('config_reserve_prefix'),
					'config_upload_path' 		=> $this->input->post('config_upload_path'),
					'config_allowed_types' 		=> $this->input->post('config_allowed_types'),
					'config_max_size' 			=> $this->input->post('config_max_size'),
					'config_max_height' 		=> $this->input->post('config_max_height'),
					'config_max_width' 			=> $this->input->post('config_max_width'),
					'config_menus_height' 		=> $this->input->post('config_menus_height'),
					'config_menus_width' 		=> $this->input->post('config_menus_width'),
					'config_protocol' 			=> $this->input->post('config_protocol'),
					'config_mailtype' 			=> $this->input->post('config_mailtype'),
					'config_smtp_host' 			=> $this->input->post('config_smtp_host'),
					'config_smtp_port' 			=> $this->input->post('config_smtp_port'),
					'config_smtp_user' 			=> $this->input->post('config_smtp_user'),
					'config_smtp_pass' 			=> $this->input->post('config_smtp_pass'),
					'log_threshold' 			=> $this->input->post('log_threshold'),
					'log_path' 					=> $this->input->post('log_path')
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
		$this->upload->set_upload_path($this->config->item('config_upload_path'));
		$this->upload->set_allowed_types($this->config->item('config_allowed_types'));
		$this->upload->set_max_filesize($this->config->item('config_max_size'));
		$this->upload->set_max_width($this->config->item('config_max_width'));
		$this->upload->set_max_height($this->config->item('config_max_height'));

		if (isset($_FILES['config_site_logo']) && !empty($_FILES['config_site_logo']['name'])) {
      		
      		if ($this->upload->do_upload('config_site_logo')) {

        		// set a $_POST value for 'menu_photo' that we can use later
        		$upload_data    = $this->upload->data();
        		if ($upload_data) {
        			$_POST['config_site_logo'] = $this->security->sanitize_filename($upload_data['file_name']);
        		}
        		return TRUE;        
      		} else {
        		
        		// possibly do some clean up ... then throw an error
        		$this->form_validation->set_message('handle_upload', $this->upload->display_errors());
        		return FALSE;
     		}
    	} else {
      	
        	// set an empty $_POST value for 'menu_photo' to be used on database queries
        	$_POST['config_site_logo'] = '';
      		//return TRUE;
      	}
    }
}
