<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Find_table extends MX_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('location'); // load the location library
		$this->load->model('Reservations_model');
		$this->load->model('Customers_model');
		$this->load->model('Security_questions_model');
	}

	public function index() {
		$this->lang->load('main/reserve_table');  // loads language file

		if (!file_exists(APPPATH .'views/main/find_table.php')) {
			show_404();
		}
			
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		$data['text_heading'] 				= $this->lang->line('text_heading_find');
		$data['text_local'] 				= $this->lang->line('text_local');
		$data['text_postcode_warning'] 		= $this->lang->line('text_postcode_warning');
		$data['text_delivery_charge'] 		= $this->lang->line('text_delivery_charge');
		$data['text_postcode'] 				= $this->lang->line('text_postcode');
		$data['text_find'] 					= $this->lang->line('text_find');
		$data['text_no_table'] 				= $this->lang->line('text_no_table');
		$data['text_no_opening'] 			= $this->lang->line('text_no_opening');
		$data['text_find_msg'] 				= $this->lang->line('text_find_msg');
		$data['text_reservation_msg'] 		= $this->lang->line('text_reservation_msg');
		$data['entry_postcode'] 			= $this->lang->line('entry_postcode');
		$data['entry_no_guest'] 			= $this->lang->line('entry_no_guest');
		$data['entry_date'] 				= $this->lang->line('entry_date');
		$data['entry_time'] 				= $this->lang->line('entry_time');
		$data['entry_select'] 				= $this->lang->line('entry_select');
		$data['entry_occassion'] 			= $this->lang->line('entry_occassion');

		$data['button_check_postcode'] 		= $this->lang->line('button_check_postcode');
		$data['button_find'] 				= $this->lang->line('button_find');
		$data['button_time'] 				= $this->lang->line('button_time');
		$data['button_back'] 				= $this->lang->line('button_back');
		
		$data['locations'] = array();
		$locations = $this->Locations_model->getLocations();
		foreach ($locations as $location) {
			$data['locations'][] = array(
				'id' 		=> $location['location_id'],
				'name'		=> $location['location_name']
			);
		}
		
		$data['guest_nums'] = array('2', '3', '4', '5','6', '7', '8', '9', '10');

		$data['occasions'] = array(
			'0' => 'not applicable',
			'1' => 'birthday',
			'2' => 'anniversary',
			'3' => 'general celebration',
			'4' => 'hen party',
			'5' => 'stag party'
		);
			
		if ($this->input->get('location')) {
			$data['location_id'] 	= $this->input->get('location');
		} else {
			$data['location_id'] 	= '';
		}
		
		if ($this->input->get('guest_num')) {
			$data['guest_num'] 	= $this->input->get('guest_num');
		} else {
			$data['guest_num'] 	= '';
		}
		
		if ($this->input->get('reserve_date')) {
			$data['date'] 	= $this->input->get('reserve_date');
		} else {
			$data['date'] 	= '';
		}
		
		if ($this->input->get('occasion')) {
			$data['occasion'] 	= $this->input->get('occasion');
		} else {
			$data['occasion'] 	= '';
		}

		if (!$this->input->post('reserve_time') AND $this->_findTable() === TRUE) {
			
			redirect('find/table');
		}
		
		if ($this->session->userdata('show_times') === 'show') {
			$data['show_times'] = TRUE;
			$data['text_time_msg'] 	= 'AVAILABLE RESERVATIONS ON '. mdate('%l, %F %j, %Y', strtotime($data['date'])). ' FOR ' .$data['guest_num'].' GUESTS:';

			if ($this->input->get('reserve_time')) {
				$data['time'] 	= $this->input->get('reserve_time');
			} else {
				$data['time'] 	= '';
			}
		
			$reserve_day = date('l', strtotime($data['date']));
			$opening_hour = $this->Locations_model->getOpeningHourByDay($data['location_id'], $reserve_day);
			$opening_time = $opening_hour['open'];
			$closing_time = $opening_hour['close'];

			$interval = $this->location->getReserveInterval();
		
			$data['reserve_times'] = array();
			$reserve_times = $this->location->generateHours($opening_time, $closing_time, $interval);
			foreach ($reserve_times as $key => $value) {
				$data['reserve_times'][] = array(
					'24hr' 		=> $value,
					'12hr'		=> mdate('%h:%i %a', strtotime($value))
				);
			}
		
		} else {
			$data['show_times'] = FALSE;
			$data['text_time_msg'] 	= '';
		}
		
		$regions = array(
			'main/header',
			'main/content_right',
			'main/footer'
		);
		
		$this->template->regions($regions);
		$this->template->load('main/find_table', $data);
	}


	public function _findTable() {

		$time_format = '%h:%i %a';
		$date_format = '%d-%m-%Y';
		$current_date_time = time();
	
		$this->session->unset_userdata('show_times');
		$this->session->unset_userdata('reservation');
		$_POST=$_GET;
		
		$this->form_validation->set_rules('location', 'Location', 'trim|required|integer');
		$this->form_validation->set_rules('guest_num', 'Guest Number', 'trim|required|integer');
		$this->form_validation->set_rules('reserve_date', 'Date', 'trim|required|valid_date|callback_valid_date');
		$this->form_validation->set_rules('occasion', 'Occasion', 'trim|required|integer');

  		if ($this->form_validation->run() === TRUE) {
		
			$check['location'] 			= $this->input->post('location');
			$check['guest_num'] 		= $this->input->post('guest_num');
		 	$check['reserve_date']		= mdate($date_format, strtotime($this->input->post('reserve_date')));
		 	$check['reserve_time']		= $this->input->post('reserve_time');
			$check['occasion'] 			= $this->input->post('occasion');
			
			$result = $this->Reservations_model->checkAvailability($check);
			
			if ($result === 'NO_GUEST_TABLE') {
        		$this->session->set_flashdata('alert', $this->lang->line('warning_no_guest'));
			} else if ($result === 'NO_TABLE_AVAIL') {
        		$this->session->set_flashdata('alert', $this->lang->line('warning_no_time'));
			}
			
			if (is_array($result) AND isset($result['tables']) AND empty($check['reserve_time'])) {
				$location = $this->Locations_model->getLocation($check['location']);
			
				if ($location) {
					$this->Locations_model->getLocalRestaurant($location['location_lat'], $location['location_lng']);
				}

				$this->session->set_userdata('show_times', 'show');
				return FALSE;
			} else if (is_array($result) AND isset($result['tables']) AND $this->validate_time($check['reserve_time']) === TRUE) {
				$this->session->set_userdata('reservation', $check);
				redirect('reserve/table');				
			}
			
			return TRUE;
		}
	}

	public function validate_date($str) {
		
		if (strtotime($str) < strtotime($this->location->currentDate())) {
        	$this->form_validation->set_message('validate_date', 'Date must be after today, you can only make future reservations!');
      		return FALSE;
		} else {
      		return TRUE;
		}
	}

 	public function validate_guest($str) {
 	
 		$result = $this->Reservations_model->getTablesByGuestNum($this->input->post('location'), $str);
		//$this->Reservations_model->getTotalSeats($this->input->post('location'));
		if ($this->input->post('location') && !empty($result)) {
        	$this->form_validation->set_message('validate_guest', 'No tables available at the selected location!');
      		return FALSE;
 		} else {
      		return TRUE;
		}
    }
}