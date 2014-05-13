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
															
		$url = '?';
		$filter = array();
		if ($this->input->get('page')) {
			$filter['page'] = (int) $this->input->get('page');
		} else {
			$filter['page'] = '';
		}
		
		if ($this->config->item('page_limit')) {
			$filter['limit'] = $this->config->item('page_limit');
		}
				
		if ($this->input->get('filter_search')) {
			$filter['filter_search'] = $this->input->get('filter_search');
			$data['filter_search'] = $filter['filter_search'];
			$url .= 'filter_search='.$filter['filter_search'].'&';
		} else {
			$data['filter_search'] = '';
		}
		
		if (is_numeric($this->input->get('filter_status'))) {
			$filter['filter_status'] = $this->input->get('filter_status');
			$data['filter_status'] = $filter['filter_status'];
			$url .= 'filter_status='.$filter['filter_status'].'&';
		} else {
			$filter['filter_status'] = '';
			$data['filter_status'] = '';
		}
		
		if ($this->input->get('sort_by')) {
			$filter['sort_by'] = $this->input->get('sort_by');
			$data['sort_by'] = $filter['sort_by'];
		} else {
			$filter['sort_by'] = '';
			$data['sort_by'] = '';
		}
		
		if ($this->input->get('order_by')) {
			$filter['order_by'] = $this->input->get('order_by');
			$data['order_by_active'] = strtolower($this->input->get('order_by')) .' active';
			$data['order_by'] = strtolower($this->input->get('order_by'));
		} else {
			$filter['order_by'] = '';
			$data['order_by_active'] = '';
			$data['order_by'] = 'desc';
		}
		
		$data['heading'] 			= 'Locations';
		$data['button_add'] 		= 'New';
		$data['button_delete'] 		= 'Delete';
		$data['text_empty'] 		= 'There are no locations available.';

		$order_by = (isset($filter['order_by']) AND $filter['order_by'] == 'DESC') ? 'ASC' : 'DESC';
		$data['sort_name'] 			= site_url('admin/locations'.$url.'sort_by=location_name&order_by='.$order_by);
		$data['sort_city'] 			= site_url('admin/locations'.$url.'sort_by=location_city&order_by='.$order_by);
		$data['sort_postcode'] 		= site_url('admin/locations'.$url.'sort_by=location_postcode&order_by='.$order_by);
		$data['sort_id'] 			= site_url('admin/locations'.$url.'sort_by=menu_id&location_id='.$order_by);

		$data['country_id'] = $this->config->item('country_id');
		$data['default_location_id'] = $this->config->item('default_location_id');
		
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
				'edit' 					=> site_url('admin/locations/edit?id=' . $result['location_id'])
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

		if (!empty($filter['sort_by']) AND !empty($filter['order_by'])) {
			$url .= 'sort_by='.$filter['sort_by'].'&';
			$url .= 'order_by='.$filter['order_by'].'&';
		}
		
		$config['base_url'] 		= site_url('admin/locations').$url;
		$config['total_rows'] 		= $this->Locations_model->record_count($filter);
		$config['per_page'] 		= $filter['limit'];
		
		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		if ($this->input->post('delete') AND $this->_deleteLocation() === TRUE) {
			
			redirect('admin/locations');  			
		}	

		$regions = array('header', 'footer');
		if (file_exists(APPPATH .'views/themes/admin/'.$this->config->item('admin_theme').'locations.php')) {
			$this->template->render('themes/admin/'.$this->config->item('admin_theme'), 'locations', $regions, $data);
		} else {
			$this->template->render('themes/admin/default/', 'locations', $regions, $data);
		}
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
			$data['action']	= site_url('admin/locations/edit?id='. $location_id);
		} else {
		    $location_id = 0;
			$data['action']	= site_url('admin/locations/edit');
		}
		
		$result = $this->Locations_model->getLocation($location_id);
		
		$data['heading'] 				= 'Location - '. $result['location_name'];
		$data['button_save'] 			= 'Save';
		$data['button_save_close'] 		= 'Save & Close';
		$data['sub_menu_back'] 			= site_url('admin/locations');

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
		$data['location_status'] 		= $result['location_status'];
		$data['last_order_time'] 		= $result['last_order_time'];
		$data['offer_delivery'] 		= $result['offer_delivery'];
		$data['offer_collection'] 		= $result['offer_collection'];
		$data['ready_time'] 			= $result['ready_time'];
		$data['delivery_charge'] 		= $result['delivery_charge'];
		$data['min_delivery_total'] 	= $result['min_delivery_total'];
		$data['reserve_interval'] 		= $result['reserve_interval'];
		$data['reserve_turn'] 			= $result['reserve_turn'];
		$data['location_radius'] 		= $result['location_radius'];
		
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
		
		if ($this->config->item('maps_api_key')) {
			$data['map_key'] = '&key='. $this->config->item('maps_api_key');
		} else {
			$data['map_key'] = '';
		}

		if ($result['location_lat'] AND $result['location_lng']) {
			$data['is_covered_area'] = TRUE;
		} else {
			$data['is_covered_area'] = FALSE;
		}
				
		$covered_area = unserialize($result['covered_area']);
		$data['covered_area'] = array();
		
		if (!empty($covered_area['path'])) {
			$data['covered_area']['path'] = $covered_area['path'];
		} else {
			$data['covered_area']['path'] = '';
		}

		if (!empty($covered_area['pathArray'])) {
			$data['covered_area']['pathArray'] = $covered_area['pathArray'];
		} else {
			$data['covered_area']['pathArray'] = '';
		}

		$data['tables'] = array();
		$tables = $this->Tables_model->getTables();
		if ($tables) {
			foreach ($tables as $table) {
			$data['tables'][] = array(
				'table_id'			=> $table['table_id'],
				'table_name'		=> $table['table_name'],
				'min_capacity'		=> $table['min_capacity'],
				'max_capacity'		=> $table['max_capacity']
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

		if ($this->input->post() AND $this->_addLocation() === TRUE) {
		
			redirect('/admin/locations');
		}

		if ($this->input->post() AND $this->_updateLocation() === TRUE) {
			if ($this->input->post('save_close') === '1') {
				redirect('admin/locations');
			}
			
			redirect('admin/locations/edit?id='. $location_id);
		}
		
		$regions = array('header', 'footer');
		if (file_exists(APPPATH .'views/themes/admin/'.$this->config->item('admin_theme').'locations_edit.php')) {
			$this->template->render('themes/admin/'.$this->config->item('admin_theme'), 'locations_edit', $regions, $data);
		} else {
			$this->template->render('themes/admin/default/', 'locations_edit', $regions, $data);
		}
	}

	public function _addLocation() {
									
    	if (!$this->user->hasPermissions('modify', 'admin/locations')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to add!</p>');
			return TRUE;
    	
    	} else if (	! $this->input->get('id') AND $this->validateForm() === TRUE) { 
			$add = array();
			
			//Sanitizing the POST values
			$add['location_name'] 		= $this->input->post('location_name');
			$add['address'] 			= $this->input->post('address');
			$add['email'] 				= $this->input->post('email');			
			$add['telephone'] 			= $this->input->post('telephone');			
			$add['hours'] 				= $this->input->post('hours');
			$add['last_order_time'] 	= $this->input->post('last_order_time');
			$add['offer_delivery'] 		= $this->input->post('offer_delivery');
			$add['offer_collection'] 	= $this->input->post('offer_collection');
			$add['ready_time'] 			= $this->input->post('ready_time');
			$add['delivery_charge'] 	= $this->input->post('delivery_charge');
			$add['min_delivery_total'] 	= $this->input->post('min_delivery_total');
			$add['tables'] 				= $this->input->post('tables');
			$add['location_status'] 	= $this->input->post('location_status');			
			$add['location_radius'] 	= $this->input->post('location_radius');			
			
			if ($this->Locations_model->addLocation($add)) {
				$this->session->set_flashdata('alert', '<p class="success">Location Added Sucessfully!</p>');
			} else {
				$this->session->set_flashdata('alert', '<p class="warning">Nothing Added!</p>');				
			}
							
			return TRUE;
		}
	}

	public function _updateLocation() {
									
    	if (!$this->user->hasPermissions('modify', 'admin/locations')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to update!</p>');
			return TRUE;
    	
    	} else if ($this->input->get('id') AND $this->validateForm() === TRUE) { 
			$update = array();
			
			//Sanitizing the POST values
			$update['location_id'] 			= $this->input->get('id');
			$update['location_name'] 		= $this->input->post('location_name');
			$update['address'] 				= $this->input->post('address');
			$update['email'] 				= $this->input->post('email');			
			$update['telephone'] 			= $this->input->post('telephone');			
			$update['hours'] 				= $this->input->post('hours');
			$update['offer_delivery'] 		= $this->input->post('offer_delivery');
			$update['offer_collection'] 	= $this->input->post('offer_collection');
			$update['ready_time'] 			= $this->input->post('ready_time');
			$update['last_order_time'] 		= $this->input->post('last_order_time');
			$update['delivery_charge'] 		= $this->input->post('delivery_charge');
			$update['min_delivery_total'] 	= $this->input->post('min_delivery_total');
			$update['tables'] 				= $this->input->post('tables');
			$update['reserve_interval'] 	= $this->input->post('reserve_interval');
			$update['reserve_turn'] 		= $this->input->post('reserve_turn');
			$update['location_status'] 		= $this->input->post('location_status');			
			$update['location_radius'] 		= $this->input->post('location_radius');			
			$update['covered_area'] 		= serialize($this->input->post('covered_area'));			
		
			if ($this->Locations_model->updateLocation($update)) {
				$this->session->set_flashdata('alert', '<p class="success">Location Updated Sucessfully!</p>');
			} else {
				$this->session->set_flashdata('alert', '<p class="warning">Nothing Updated!</p>');				
			}
				
			return TRUE;
		}
	}

	public function validateForm() {
		$this->form_validation->set_rules('location_name', 'Location Name', 'xss_clean|trim|required|min_length[2]|max_length[32]');
		$this->form_validation->set_rules('address[address_1]', 'Location Address 1', 'xss_clean|trim|required|min_length[2]|max_length[128]');
		$this->form_validation->set_rules('address[address_2]', 'Location Address 2', 'xss_clean|trim|max_length[128]');
		$this->form_validation->set_rules('address[city]', 'Location City', 'xss_clean|trim|required|min_length[2]|max_length[128]');
		$this->form_validation->set_rules('address[postcode]', 'Location Postcode', 'xss_clean|trim|required|min_length[2]|max_length[10]|callback_get_lat_lag');
		$this->form_validation->set_rules('address[country]', 'Location Country', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('email', 'Location Email', 'xss_clean|trim|required|valid_email');
		$this->form_validation->set_rules('telephone', 'Location Telephone', 'xss_clean|trim|required|min_length[2]|max_length[15]');
		$this->form_validation->set_rules('hours[open]', 'Open Hour', 'xss_clean|trim|required|valid_time|callback_less_time[hours[close]]');
		$this->form_validation->set_rules('hours[close]', 'Close Hour', 'xss_clean|trim|required|valid_time');
		$this->form_validation->set_rules('offer_delivery', 'Offer Delivery', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('offer_collection', 'Offer Collection', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('ready_time', 'Ready Time', 'xss_clean|trim|integer');
		$this->form_validation->set_rules('last_order_time', 'Last Order Time', 'xss_clean|trim|integer');
		$this->form_validation->set_rules('delivery_charge', 'Delivery Charge', 'xss_clean|trim|numeric');
		$this->form_validation->set_rules('min_delivery_total', 'Min Delivery Total', 'xss_clean|trim|numeric');
		$this->form_validation->set_rules('tables[]', 'Tables', 'xss_clean|trim|integer');
		$this->form_validation->set_rules('reserve_interval', 'Time Interval', 'xss_clean|trim|integer');
		$this->form_validation->set_rules('reserve_turn', 'Turn Time', 'xss_clean|trim|integer');
		$this->form_validation->set_rules('location_status', 'Location Status', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('location_radius', 'Location Radius', 'xss_clean|trim|integer');
		$this->form_validation->set_rules('covered_area', 'Covered Area', 'xss_clean');
	
		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function _deleteLocation() {
    	if (!$this->user->hasPermissions('modify', 'admin/menus')) {
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to delete!</p>');
    	} else { 
			if (is_array($this->input->post('delete'))) {
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
		if (isset($_POST['address']) AND is_array($_POST['address']) AND !empty($_POST['address']['postcode'])) {			 
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

	public function less_time($str) {
		foreach ($_POST['hours']['open'] as $day => $human_open) {
			foreach ($_POST['hours']['close'] as $day => $human_close) {
				if ($day === $day) {
					$unix_open = strtotime($human_open);
					$unix_close = strtotime($human_close);
					
					if ($unix_open >= $unix_close AND ($human_open !== "00:00" AND $human_close !== "00:00")) {
						$this->form_validation->set_message('less_time', 'The %s field must contain a number less than %s.');
						return FALSE;
					}
				}
			}
		}
		
		return TRUE;
	}
}

/* End of file locations.php */
/* Location: ./application/controllers/admin/locations.php */