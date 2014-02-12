<?php
class Locations extends CI_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
		$this->load->library('location'); // load the location library
		$this->load->library('pagination');
		$this->load->model('Locations_model'); // load the locations model
		$this->load->model('Tables_model');
		$this->load->model('Countries_model');
	}

	public function index() {
		
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/locations')) {
  			redirect('admin/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}
															
		$filter = array();
		if ($this->input->get('page')) {
			$filter['page'] = (int) $this->input->get('page');
		} else {
			$filter['page'] = 1;
		}
		
		if ($this->config->item('page_limit')) {
			$filter['limit'] = $this->config->item('page_limit');
		}
				
		$data['heading'] 			= 'Locations';
		$data['sub_menu_add'] 		= 'Add new location';
		$data['sub_menu_delete'] 	= 'Delete';
		$data['text_empty'] 		= 'There are no locations available.';

		$data['country_id'] = $this->config->item('country_id');
		
		//load category data into array
		$data['locations'] = array();
		$results = $this->Locations_model->getList($filter);
		foreach ($results as $result) {					
			$data['locations'][] = array(
				'location_id'			=> $result['location_id'],
				'location_name'			=> $result['location_name'],
				'location_address_1'	=> $result['location_address_1'],
				'location_city'			=> $result['location_city'],
				'location_postcode'		=> $result['location_postcode'],
				'location_telephone'	=> $result['location_telephone'],
				'location_lat'			=> $result['location_lat'],
				'location_lng'			=> $result['location_lng'],
				'location_status'		=> $result['location_status'],
				'edit' 					=> $this->config->site_url('admin/locations/edit?id=' . $result['location_id'])
			);
		}

		$data['tables'] = array();
		$tables = $this->Tables_model->getTables();
		if ($tables) {
			foreach ($tables as $table) {
			$data['tables'][] = array(
				'table_id'			=> $table['table_id'],
				'table_name'		=> $table['table_name'],
				'min_capacity'		=> $table['min_capacity'],
				'max_capacity'	=> $table['max_capacity']
			);
			}
		}

		$data['countries'] = array();
		$results = $this->Countries_model->getCountries();
		foreach ($results as $result) {					
			$data['countries'][] = array(
				'country_id'	=>	$result['country_id'],
				'name'			=>	$result['country_name'],
			);
		}
				
		$data['hours'] = $this->Locations_model->getOpeningHours();

		$config['base_url'] 		= $this->config->site_url('admin/locations');
		$config['total_rows'] 		= $this->Locations_model->record_count();
		$config['per_page'] 		= $filter['limit'];
		$config['num_links'] 		= round($config['total_rows'] / $config['per_page']);
		
		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		if ($this->input->post('delete') && $this->_deleteLocation() === TRUE) {
			
			redirect('admin/locations');  			
		}	

		$regions = array(
			'admin/header',
			'admin/footer'
		);
		
		$this->template->regions($regions);
		$this->template->load('admin/locations', $data);
	}

	public function edit() {
		
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/locations')) {
  			redirect('admin/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else { 
			$data['alert'] = '';
		}		

		//check if /location_id is set in uri string
		if (is_numeric($this->input->get('id'))) {
			$location_id = (int)$this->input->get('id');
			$data['action']	= $this->config->site_url('admin/locations/edit?id='. $location_id);
		} else {
		    $location_id = 0;
			$data['action']	= $this->config->site_url('admin/locations/edit');
		}
		
		$result = $this->Locations_model->getLocation($location_id);
		
		$data['heading'] 				= 'Location - '. $result['location_name'];
		$data['sub_menu_save'] 			= 'Save';
		$data['sub_menu_back'] 			= $this->config->site_url('admin/locations');

		$data['location_id'] 			= $result['location_id'];
		$data['location_name'] 			= $result['location_name'];
		$data['location_address_1'] 	= $result['location_address_1'];
		$data['location_address_2'] 	= $result['location_address_2'];
		$data['location_city'] 			= $result['location_city'];
		$data['location_postcode'] 		= $result['location_postcode'];
		$data['location_email'] 		= $result['location_email'];
		$data['location_telephone'] 	= $result['location_telephone'];
		$data['location_lat'] 			= $result['location_lat'];
		$data['location_lng'] 			= $result['location_lng'];
		$data['location_radius'] 		= $result['location_radius'];
		$data['location_status'] 		= $result['location_status'];
		$data['offer_delivery'] 		= $result['offer_delivery'];
		$data['offer_collection'] 		= $result['offer_collection'];
		$data['ready_time'] 			= $result['ready_time'];
		$data['delivery_charge'] 		= $result['delivery_charge'];
		$data['min_delivery_total'] 	= $result['min_delivery_total'];
		
		if ($result['location_country_id']) {
			$data['country_id'] = $result['location_country_id'];
		} else if ($this->config->item('country_id')) {
			$data['country_id'] = $this->config->item('country_id');
		}

		$weekdays = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');

		if ($this->input->post('hours')) {
			$data['hours'] = $this->input->post('hours');
			$data['hours']['day'] = $weekdays;
		} else {
			$data['hours'] = $this->Locations_model->getOpeningHours($location_id);
		}
					
		if ($this->input->post('tables')) {
			$data['location_tables'] = $this->input->post('tables');
		} else {
			$data['location_tables'] = $this->Tables_model->getTablesByLocation($location_id);
		}
		
		$data['tables'] = array();
		$tables = $this->Tables_model->getTables();
		if ($tables) {
			foreach ($tables as $table) {
			$data['tables'][] = array(
				'table_id'			=> $table['table_id'],
				'table_name'		=> $table['table_name'],
				'min_capacity'		=> $table['min_capacity'],
				'max_capacity'	=> $table['max_capacity']
			);
			}
		}

		$data['countries'] = array();
		$results = $this->Countries_model->getCountries();
		foreach ($results as $result) {					
			$data['countries'][] = array(
				'country_id'	=>	$result['country_id'],
				'name'			=>	$result['country_name'],
			);
		}

		if ($this->input->post() && $this->_addLocation() === TRUE) {
		
			redirect('/admin/locations');
		}

		if ($this->input->post() && $this->_updateLocation() === TRUE) {
					
			redirect('admin/locations');
		}
		
		$regions = array(
			'admin/header',
			'admin/footer'
		);
		
		$this->template->regions($regions);
		$this->template->load('admin/location_edit', $data);
	}

	public function _addLocation() {
									
    	if (!$this->user->hasPermissions('modify', 'admin/locations')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
			return TRUE;
    	
    	} else if (	! $this->input->get('id')) { 
			
			//form validation
			$this->form_validation->set_rules('location_name', 'Location Name', 'trim|required|min_length[2]|max_length[45]');
			$this->form_validation->set_rules('address[address_1]', 'Location Address 1', 'trim|required|min_length[2]|max_length[45]');
			$this->form_validation->set_rules('address[address_2]', 'Location Address 2', 'trim|max_length[45]');
			$this->form_validation->set_rules('address[city]', 'Location City', 'trim|required|min_length[2]|max_length[45]');
			$this->form_validation->set_rules('address[postcode]', 'Location Postcode', 'trim|required|min_length[2]|max_length[45]|callback_get_lat_lag');
			$this->form_validation->set_rules('address[country]', 'Location Country', 'trim|required|integer');
			$this->form_validation->set_rules('address[radius]', 'Location Radius', 'trim|required|integer|max_length[5]');
			$this->form_validation->set_rules('email', 'Location Email', 'trim|required|valid_email');
			$this->form_validation->set_rules('telephone', 'Location Telephone', 'trim|required|min_length[2]|max_length[15]');
			$this->form_validation->set_rules('hours[open]', 'Opening Hours', 'trim|required|callback_validate_time|callback_less_time[hours[close]]');
			$this->form_validation->set_rules('hours[close]', 'Closing Hours', 'trim|required|callback_validate_time');
			$this->form_validation->set_rules('tables[]', 'Tables', 'trim|integer');
			$this->form_validation->set_rules('offer_delivery', 'Offer Delivery', 'trim|required|integer');
			$this->form_validation->set_rules('offer_collection', 'Offer Collection', 'trim|required|integer');
			$this->form_validation->set_rules('ready_time', 'Ready Time', 'trim|integer');
			$this->form_validation->set_rules('delivery_charge', 'Delivery Charge', 'trim|numeric');
			$this->form_validation->set_rules('min_delivery_total', 'Min Delivery Total', 'trim|numeric');
			$this->form_validation->set_rules('location_status', 'Location Status', 'trim|required|integer');
			
			//if validation is true
			if ($this->form_validation->run() === TRUE) {
				$add = array();
				
				//Sanitizing the POST values
				$add['location_name'] 		= $this->input->post('location_name');
				$add['address'] 			= $this->input->post('address');
				$add['email'] 				= $this->input->post('email');			
				$add['telephone'] 			= $this->input->post('telephone');			
				$add['hours'] 				= $this->input->post('hours');
				$add['tables'] 				= $this->input->post('tables');
				$add['offer_delivery'] 		= $this->input->post('offer_delivery');
				$add['offer_collection'] 	= $this->input->post('offer_collection');
				$add['ready_time'] 			= $this->input->post('ready_time');
				$add['delivery_charge'] 	= $this->input->post('delivery_charge');
				$add['min_delivery_total'] = $this->input->post('min_delivery_total');
				$add['location_status'] 	= $this->input->post('location_status');			
				
				if ($this->Locations_model->addLocation($add)) {
			
					$this->session->set_flashdata('alert', '<p class="success">Location Added Sucessfully!</p>');
			
				} else {
			
					$this->session->set_flashdata('alert', '<p class="warning">Nothing Added!</p>');				
			
				}
								
				return TRUE;
			}	
		}
	}

	public function _updateLocation() {
									
    	if (!$this->user->hasPermissions('modify', 'admin/locations')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
			return TRUE;
    	
    	} else if ($this->input->get('id')) { 
			
			//form validation
			$this->form_validation->set_rules('location_name', 'Location Name', 'trim|required|min_length[2]|max_length[45]');
			$this->form_validation->set_rules('address[address_1]', 'Location Address 1', 'trim|required|min_length[2]|max_length[45]');
			$this->form_validation->set_rules('address[address_2]', 'Location Address 2', 'trim|max_length[45]');
			$this->form_validation->set_rules('address[city]', 'Location City', 'trim|required|min_length[2]|max_length[45]');
			$this->form_validation->set_rules('address[postcode]', 'Location Postcode', 'trim|required|min_length[2]|max_length[45]|callback_get_lat_lag');
			$this->form_validation->set_rules('address[country]', 'Location Country', 'trim|required|integer');
			$this->form_validation->set_rules('address[radius]', 'Location Radius', 'trim|required|integer|max_length[5]');
			$this->form_validation->set_rules('email', 'Location Email', 'trim|required|valid_email');
			$this->form_validation->set_rules('telephone', 'Location Telephone', 'trim|required|min_length[2]|max_length[15]');
			$this->form_validation->set_rules('hours[open]', 'Open Hour', 'trim|required|callback_validate_time|callback_less_time[hours[close]]');
			$this->form_validation->set_rules('hours[close]', 'Close Hour', 'trim|required|callback_validate_time');
			$this->form_validation->set_rules('tables[]', 'Tables', 'trim|integer');
			$this->form_validation->set_rules('offer_delivery', 'Offer Delivery', 'trim|required|integer');
			$this->form_validation->set_rules('offer_collection', 'Offer Collection', 'trim|required|integer');
			$this->form_validation->set_rules('ready_time', 'Ready Time', 'trim|integer');
			$this->form_validation->set_rules('delivery_charge', 'Delivery Charge', 'trim|numeric');
			$this->form_validation->set_rules('min_delivery_total', 'Min Delivery Total', 'trim|numeric');
			$this->form_validation->set_rules('location_status', 'Location Status', 'trim|required|integer');
		
			//if validation is true
			if ($this->form_validation->run() === TRUE) {
				$update = array();
				
				//Sanitizing the POST values
				$update['location_id'] 			= $this->input->get('id');
				$update['location_name'] 		= $this->input->post('location_name');
				$update['address'] 				= $this->input->post('address');
				$update['email'] 				= $this->input->post('email');			
				$update['telephone'] 			= $this->input->post('telephone');			
				$update['hours'] 				= $this->input->post('hours');
				$update['tables'] 				= $this->input->post('tables');
				$update['offer_delivery'] 		= $this->input->post('offer_delivery');
				$update['offer_collection'] 	= $this->input->post('offer_collection');
				$update['ready_time'] 			= $this->input->post('ready_time');
				$update['delivery_charge'] 		= $this->input->post('delivery_charge');
				$update['min_delivery_total'] 	= $this->input->post('min_delivery_total');
				$update['location_status'] 		= $this->input->post('location_status');			
			
				if ($this->Locations_model->updateLocation($update)) {

					$this->session->set_flashdata('alert', '<p class="success">Location Updated Sucessfully!</p>');

				} else {

					$this->session->set_flashdata('alert', '<p class="warning">Nothing Updated!</p>');				

				}
					
				return TRUE;
			}	
		}
	}

	public function _deleteLocation($location_id = FALSE) {
    	if (!$this->user->hasPermissions('modify', 'admin/menus')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
    	
    	} else { 
		
			if (is_array($this->input->post('delete'))) {

				//sorting the post[quantity] array to rowid and qty.
				foreach ($this->input->post('delete') as $key => $value) {
					$location_id = $value;
				
					$this->Locations_model->deleteLocation($location_id);
			
				}			
			
				$this->session->set_flashdata('alert', '<p class="success">Location Deleted Sucessfully!</p>');

			}
		}
				
		return TRUE;
	}
	
	public function get_lat_lag() {
		if (isset($_POST['address']) && is_array($_POST['address']) && !empty($_POST['address']['postcode'])) {			 

			$address_string =  implode(", ", $_POST['address']);
			
			$address = urlencode($address_string);
        	        
			$geocode = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='. $address .'&sensor=false&region=GB');
        	
    		$output = json_decode($geocode);
    		
    		$status = $output->status;
    		
    		if ($status === 'OK') {
				$_POST['address']['location_lat'] = $output->results[0]->geometry->location->lat;
				$_POST['address']['location_lng'] = $output->results[0]->geometry->location->lng;
			    return TRUE;
    		} else {
        		$this->form_validation->set_message('get_lat_lag', 'The Address you entered failed Geocoding, please enter a different address!');
        		return FALSE;
    		}
        }
	}

	public function validate_time($str) {
		if ( ! preg_match('/^(\d+):(\d+)$/', $str)) {
        	$this->form_validation->set_message('validate_time', 'The %s field must be in this format 00:00.');
			return FALSE;
		} else if ( ! strtotime($str)) {
        	$this->form_validation->set_message('validate_time', 'The %s field must be between 00:00 and 23:59.');
			return FALSE;
		} else {
			return TRUE;
		}
	}
	
	public function less_time($str) {
	
		foreach ($_POST['hours']['open'] as $day => $human_open) {

			foreach ($_POST['hours']['close'] as $day => $human_close) {
				if ($day === $day) {
					$unix_open = strtotime($human_open);
					$unix_close = strtotime($human_close);
					
					if ($unix_open >= $unix_close && ($human_open !== "00:00" && $human_close !== "00:00")) {
						$this->form_validation->set_message('less_time', 'The %s field must contain a number less than %s.');
						return FALSE;
					}
				}
			}
		}
		
		return TRUE;
	}
}