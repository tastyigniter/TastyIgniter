<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

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
  			redirect(ADMIN_URI.'/login');
		}

    	if (!$this->user->hasPermissions('access', ADMIN_URI.'/locations')) {
  			redirect(ADMIN_URI.'/permission');
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
			$filter['filter_search'] = $data['filter_search'] = $this->input->get('filter_search');
			$url .= 'filter_search='.$filter['filter_search'].'&';
		} else {
			$data['filter_search'] = '';
		}
		
		if (is_numeric($this->input->get('filter_status'))) {
			$filter['filter_status'] = $data['filter_status'] = $this->input->get('filter_status');
			$url .= 'filter_status='.$filter['filter_status'].'&';
		} else {
			$filter['filter_status'] = $data['filter_status'] = '';
		}
		
		if ($this->input->get('sort_by')) {
			$filter['sort_by'] = $data['sort_by'] = $this->input->get('sort_by');
		} else {
			$filter['sort_by'] = $data['sort_by'] = 'location_id';
		}
		
		if ($this->input->get('order_by')) {
			$filter['order_by'] = $data['order_by'] = $this->input->get('order_by');
			$data['order_by_active'] = $this->input->get('order_by') .' active';
		} else {
			$filter['order_by'] = $data['order_by'] = 'DESC';
			$data['order_by_active'] = 'DESC';
		}
		
		$this->template->setTitle('Locations');
		$this->template->setHeading('Locations');
		$this->template->setButton('+ New', array('class' => 'btn btn-success', 'href' => page_url() .'/edit'));
		$this->template->setButton('Delete', array('class' => 'btn btn-default', 'onclick' => '$(\'#list-form\').submit();'));

		$data['text_empty'] 		= 'There are no locations available.';

		$order_by = (isset($filter['order_by']) AND $filter['order_by'] == 'ASC') ? 'DESC' : 'ASC';
		$data['sort_name'] 			= site_url(ADMIN_URI.'/locations'.$url.'sort_by=location_name&order_by='.$order_by);
		$data['sort_city'] 			= site_url(ADMIN_URI.'/locations'.$url.'sort_by=location_city&order_by='.$order_by);
		$data['sort_postcode'] 		= site_url(ADMIN_URI.'/locations'.$url.'sort_by=location_postcode&order_by='.$order_by);
		$data['sort_id'] 			= site_url(ADMIN_URI.'/locations'.$url.'sort_by=location_id&order_by='.$order_by);

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
				'location_status'		=> ($result['location_status'] === '1') ? 'Enabled' : 'Disabled',
				'edit' 					=> site_url(ADMIN_URI.'/locations/edit?id=' . $result['location_id'])
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

		if ($this->input->get('sort_by') AND $this->input->get('order_by')) {
			$url .= 'sort_by='.$filter['sort_by'].'&';
			$url .= 'order_by='.$filter['order_by'].'&';
		}
		
		$config['base_url'] 		= site_url(ADMIN_URI.'/locations').$url;
		$config['total_rows'] 		= $this->Locations_model->getAdminListCount($filter);
		$config['per_page'] 		= $filter['limit'];
		
		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		if ($this->input->post('delete') AND $this->_deleteLocation() === TRUE) {
			
			redirect(ADMIN_URI.'/locations');  			
		}	

		$this->template->regions(array('header', 'footer'));
		if (file_exists(APPPATH .'views/themes/'.ADMIN_URI.'/'.$this->config->item('admin_theme').'locations.php')) {
			$this->template->render('themes/'.ADMIN_URI.'/'.$this->config->item('admin_theme'), 'locations', $data);
		} else {
			$this->template->render('themes/'.ADMIN_URI.'/default/', 'locations', $data);
		}
	}

	public function edit() {
		if (!$this->user->islogged()) {  
  			redirect(ADMIN_URI.'/login');
		}

    	if (!$this->user->hasPermissions('access', ADMIN_URI.'/locations')) {
  			redirect(ADMIN_URI.'/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else { 
			$data['alert'] = '';
		}		

		$location_info = $this->Locations_model->getLocation((int) $this->input->get('id'));
		
		if ($location_info) {
			$location_id = $location_info['location_id'];
			$data['action']	= site_url(ADMIN_URI.'/locations/edit?id='. $location_id);
		} else {
		    $location_id = 0;
			$data['action']	= site_url(ADMIN_URI.'/locations/edit');
		}
		
		$title = (isset($location_info['location_name'])) ? $location_info['location_name'] : 'New';	
		$this->template->setTitle('Location: '. $title);
		$this->template->setHeading('Location: '. $title);
		$this->template->setButton('Save', array('class' => 'btn btn-success', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton('Save & Close', array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		$this->template->setBackButton('btn-back', site_url(ADMIN_URI.'/locations'));

		$data['location_id'] 			= $location_info['location_id'];
		$data['location_name'] 			= $location_info['location_name'];
		$data['location_address_1'] 	= $location_info['location_address_1'];
		$data['location_address_2'] 	= $location_info['location_address_2'];
		$data['location_city'] 			= $location_info['location_city'];
		$data['location_postcode'] 		= $location_info['location_postcode'];
		$data['location_email'] 		= $location_info['location_email'];
		$data['location_telephone'] 	= $location_info['location_telephone'];
		$data['description'] 			= $location_info['description'];
		$data['location_lat'] 			= $location_info['location_lat'];
		$data['location_lng'] 			= $location_info['location_lng'];
		$data['location_status'] 		= $location_info['location_status'];
		$data['last_order_time'] 		= $location_info['last_order_time'];
		$data['offer_delivery'] 		= $location_info['offer_delivery'];
		$data['offer_collection'] 		= $location_info['offer_collection'];
		$data['ready_time'] 			= $location_info['ready_time'];
		$data['delivery_charge'] 		= $location_info['delivery_charge'];
		$data['min_delivery_total'] 	= $location_info['min_delivery_total'];
		$data['reservation_interval'] 	= $location_info['reservation_interval'];
		$data['reservation_turn'] 		= $location_info['reservation_turn'];
		$data['location_radius'] 		= $location_info['location_radius'];
		
		if ($location_info['location_country_id']) {
			$data['country_id'] = $location_info['location_country_id'];
		} else if ($this->config->item('country_id')) {
			$data['country_id'] = $this->config->item('country_id');
		}

		$weekdays = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');

		if ($this->input->post('hours')) {
			$data['hours'] = array();
			foreach ($this->input->post('hours') as $key => $value) {
				$data['hours'][] = array(
					'day'	=> $key,
					'open'	=> $value['open'],
					'close'	=> $value['close']
				);
			}
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

		if ($location_info['location_lat'] AND $location_info['location_lng']) {
			$data['is_covered_area'] = TRUE;
		} else {
			$data['is_covered_area'] = FALSE;
		}
				
		$covered_area = unserialize($location_info['covered_area']);
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
			if ($this->input->post('save_close') !== '1' AND is_numeric($this->input->post('insert_id'))) {	
				redirect(ADMIN_URI.'/locations/edit?id='. $this->input->post('insert_id'));
			} else {
				redirect(ADMIN_URI.'/locations');
			}
		}

		if ($this->input->post() AND $this->_updateLocation() === TRUE) {
			if ($this->input->post('save_close') === '1') {
				redirect(ADMIN_URI.'/locations');
			}
			
			redirect(ADMIN_URI.'/locations/edit?id='. $location_id);
		}
		
		$this->template->regions(array('header', 'footer'));
		if (file_exists(APPPATH .'views/themes/'.ADMIN_URI.'/'.$this->config->item('admin_theme').'locations_edit.php')) {
			$this->template->render('themes/'.ADMIN_URI.'/'.$this->config->item('admin_theme'), 'locations_edit', $data);
		} else {
			$this->template->render('themes/'.ADMIN_URI.'/default/', 'locations_edit', $data);
		}
	}

	public function _addLocation() {
    	if (!$this->user->hasPermissions('modify', ADMIN_URI.'/locations')) {
			$this->session->set_flashdata('alert', '<p class="alert-warning">Warning: You do not have permission to add!</p>');
			return TRUE;
    	} else if (	! is_numeric($this->input->get('id')) AND $this->validateForm() === TRUE) { 
			$add = array();
			
			$add['location_name'] 		= $this->input->post('location_name');
			$add['address'] 			= $this->input->post('address');
			$add['email'] 				= $this->input->post('email');			
			$add['telephone'] 			= $this->input->post('telephone');			
			$add['description'] 		= $this->input->post('description');			
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
			
			if ($_POST['insert_id'] = $this->Locations_model->addLocation($add)) {
				$this->session->set_flashdata('alert', '<p class="alert-success">Location added sucessfully.</p>');
			} else {
				$this->session->set_flashdata('alert', '<p class="alert-warning">An error occured, nothing added.</p>');				
			}
							
			return TRUE;
		}
	}

	public function _updateLocation() {
    	if (!$this->user->hasPermissions('modify', ADMIN_URI.'/locations')) {
			$this->session->set_flashdata('alert', '<p class="alert-warning">Warning: You do not have permission to update!</p>');
			return TRUE;
    	} else if (is_numeric($this->input->get('id')) AND $this->validateForm() === TRUE) { 
			$update = array();
			
			$update['location_id'] 			= $this->input->get('id');
			$update['location_name'] 		= $this->input->post('location_name');
			$update['address'] 				= $this->input->post('address');
			$update['email'] 				= $this->input->post('email');			
			$update['telephone'] 			= $this->input->post('telephone');			
			$update['description'] 			= $this->input->post('description');			
			$update['hours'] 				= $this->input->post('hours');
			$update['offer_delivery'] 		= $this->input->post('offer_delivery');
			$update['offer_collection'] 	= $this->input->post('offer_collection');
			$update['ready_time'] 			= $this->input->post('ready_time');
			$update['last_order_time'] 		= $this->input->post('last_order_time');
			$update['delivery_charge'] 		= $this->input->post('delivery_charge');
			$update['min_delivery_total'] 	= $this->input->post('min_delivery_total');
			$update['tables'] 				= $this->input->post('tables');
			$update['reservation_interval'] 	= $this->input->post('reservation_interval');
			$update['reservation_turn'] 		= $this->input->post('reservation_turn');
			$update['location_status'] 		= $this->input->post('location_status');			
			$update['location_radius'] 		= $this->input->post('location_radius');			
			$update['covered_area'] 		= serialize($this->input->post('covered_area'));			
		
			if ($this->Locations_model->updateLocation($update)) {
				$this->session->set_flashdata('alert', '<p class="alert-success">Location updated sucessfully.</p>');
			} else {
				$this->session->set_flashdata('alert', '<p class="alert-warning">An error occured, nothing updated.</p>');				
			}
				
			return TRUE;
		}
	}

	public function validateForm() {
		$this->form_validation->set_rules('location_name', 'Name', 'xss_clean|trim|required|min_length[2]|max_length[32]');
		$this->form_validation->set_rules('address[address_1]', 'Address 1', 'xss_clean|trim|required|min_length[2]|max_length[128]');
		$this->form_validation->set_rules('address[address_2]', 'Address 2', 'xss_clean|trim|max_length[128]');
		$this->form_validation->set_rules('address[city]', 'City', 'xss_clean|trim|required|min_length[2]|max_length[128]');
		$this->form_validation->set_rules('address[postcode]', 'Postcode', 'xss_clean|trim|required|min_length[2]|max_length[10]|callback_get_lat_lag');
		$this->form_validation->set_rules('address[country]', 'Country', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('email', 'Email', 'xss_clean|trim|required|valid_email');
		$this->form_validation->set_rules('telephone', 'Telephone', 'xss_clean|trim|required|min_length[2]|max_length[15]');
		$this->form_validation->set_rules('description', 'Description', 'xss_clean|trim|min_length[2]|max_length[1028]');
		$this->form_validation->set_rules('offer_delivery', 'Offer Delivery', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('offer_collection', 'Offer Collection', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('ready_time', 'Ready Time', 'xss_clean|trim|integer');
		$this->form_validation->set_rules('last_order_time', 'Last Order Time', 'xss_clean|trim|integer');
		$this->form_validation->set_rules('delivery_charge', 'Delivery Charge', 'xss_clean|trim|numeric');
		$this->form_validation->set_rules('min_delivery_total', 'Min Delivery Total', 'xss_clean|trim|numeric');
		$this->form_validation->set_rules('tables[]', 'Tables', 'xss_clean|trim|integer');
		$this->form_validation->set_rules('reservation_interval', 'Time Interval', 'xss_clean|trim|integer');
		$this->form_validation->set_rules('reservation_turn', 'Turn Time', 'xss_clean|trim|integer');
		$this->form_validation->set_rules('location_status', 'Status', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('location_radius', 'Radius', 'xss_clean|trim|integer');
		$this->form_validation->set_rules('covered_area', 'Covered Area', 'xss_clean');
	
		if ($this->input->post('hours')) {
			foreach ($this->input->post('hours') as $key => $value) {
				$this->form_validation->set_rules('hours['.$key.'][open]', 'Open Hour', 'xss_clean|trim|required|valid_time|callback_less_time[hours['.$key.'][close]]');
				$this->form_validation->set_rules('hours['.$key.'][close]', 'Close Hour', 'xss_clean|trim|required|valid_time');
			}
		}

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function _deleteLocation() {
    	if (!$this->user->hasPermissions('modify', ADMIN_URI.'/menus')) {
			$this->session->set_flashdata('alert', '<p class="alert-warning">Warning: You do not have permission to delete!</p>');
    	} else if (is_array($this->input->post('delete'))) {
			foreach ($this->input->post('delete') as $key => $value) {
				$this->Locations_model->deleteLocation($value);
			}			
		
			$this->session->set_flashdata('alert', '<p class="alert-success">Location deleted sucessfully!</p>');
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
		if ($this->input->post('hours')) {
			foreach ($this->input->post('hours') as $key => $value) {
				$unix_open = strtotime($value['open']);
				$unix_close = strtotime($value['close']);
				
				if ($unix_open >= $unix_close AND ($value['open'] !== "00:00" AND $value['close'] !== "00:00")) {
					$this->form_validation->set_message('less_time', 'The %s field must contain a number less than %s.');
					return FALSE;
				}
			}
		}
		
		return TRUE;
	}
}

/* End of file locations.php */
/* Location: ./application/controllers/admin/locations.php */