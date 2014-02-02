<?php
class Pages extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('Locations_model');
	}

	public function home() {
			
		$this->output->enable_profiler(TRUE); // for debugging profiler... remove later
		//check if file exists in views
		if ( !file_exists('application/views/main/home.php')) {
			// Whoops, we don't have a page for that!
			show_404();
		}
			
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');
		} else {
			$data['alert'] = '';
		}

		$data['heading'] = 'Welcome To FoodIgniter!';		
		
		$data['locations'] = array();
		$results = $this->Locations_model->getLocations();
		foreach ($results as $result) {					
			$data['locations'][] = array(
				'location_id'	=>	$result['location_id'],
				'location_name'	=>	$result['location_name'],
				'location_address'	=>	$result['location_address'],
				'location_region'	=>	$result['location_region'],
				'location_postcode'	=>	$result['location_postcode'],
				'location_phone_number'	=>	$result['location_phone_number']
			);
		}
					
		//validate location drop-down
		$this->form_validation->set_rules('locations', 'Locations', 'Required');

		//if validation is FALSE
		if ($this->form_validation->run() === TRUE)	{
			$nearest_location = $this->input->post('nearest_location');
		//} else {
			//set location data to session
			//$this->session->set_userdata('nearest_location', $this->input->post('locations'));
			$this->session->set_userdata('location_id', $location_id);
		}	
		

		//load home page content
		$this->load->view('main/header', $data);
		$this->load->view('main/home', $data);
		$this->load->view('main/footer', $data);
	}
	
	public function aboutus() {
		//check if file exists in views
		if ( !file_exists('application/views/main/aboutus.php')) {
			// Whoops, we don't have a page for that!
			show_404();
		}
			
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');
		} else {
			$data['alert'] = '';
		}

		$data['heading'] = 'About FoodIgniter!';

		//load aboutus page content
		$this->load->view('main/header', $data);
		$this->load->view('main/aboutus', $data);
		$this->load->view('main/footer', $data);
	}

	public function distance() {

		if ($this->input->get('lat')) {
			$lat = (int)$this->input->get('lat');
		} else {
		    $lat = 0;
		}

		if ($this->input->get('lng')) {
			$lng = (int)$this->input->get('lng');
		} else {
		    $lng = 0;
		}
				
		if ($this->input->get('radius')) {
			$radius = (int)$this->input->get('radius');
		} else {
		    $radius = 50;
		}

		$this->Locations_model->getLocationDistance($lat, $lng, $radius);
	}

	public function nearest() {
		$json = array();
		
		if ($this->input->get('id')) {
			$location_id = $this->input->get('id');
		} else {
			$location_id = FALSE;
		}
		
		if (!$json) {
								
			if ($location_id !== $this->session->userdata('location_id')) {
				$this->session->set_userdata('location_id', $location_id);
			}
		redirect('foods');		
		}
	}
}

/* End of file myfile.php */