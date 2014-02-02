<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Find_table extends MX_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('location'); // load the location library
		$this->load->model('Reservations_model');
		$this->load->model('Customers_model');
		$this->load->model('Security_questions_model');
		$this->output->enable_profiler(TRUE); // for debugging profiler... remove later
	}

	public function index() {
		$this->lang->load('main/reserve_table');  // loads language file
		
		if ( !file_exists(APPPATH .'/views/main/find_table.php')) { //check if file exists in views folder
			show_404(); // Whoops, show 404 error page!
		}

		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		$data['text_heading'] 				= $this->lang->line('text_find_heading');
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
		
		$data['locations'] = array();
		$locations = $this->Locations_model->getLocations();
		foreach ($locations as $location) {
			$data['locations'][] = array(
				'id' 		=> $location['location_id'],
				'name'		=> $location['location_name']
			);
		}
		
		$data['guest_nums'] = array('2', '3', '4', '5','6', '7', '8', '9', '10');

		$opening_time = '11:00';
		$closing_time = '23:00';
		$interval = '45';
		
		$data['reserve_times'] = array();
		$reserve_times = $this->location->getHours($opening_time, $closing_time, $interval);
		foreach ($reserve_times as $key => $value) {
			$data['reserve_times'][] = array(
				'24hr' 		=> $value,
				'12hr'		=> mdate('%h:%i %a', strtotime($value))
			);
		}
		
		$data['occasions'] = array(
			'0' => 'not applicable',
			'1' => 'birthday',
			'2' => 'anniversary',
			'3' => 'general celebration',
			'4' => 'hen party',
			'5' => 'stag party'
		);
	
		$table_details = $this->session->userdata('table_details');
		
		if (!empty($table_details['location'])) {
			$data['location_id'] 	= $table_details['location'];
		} else {
			$data['location_id'] 	= '';
		}
		
		if (!empty($table_details['guest_num'])) {
			$data['guest_num'] 	= $table_details['guest_num'];
		} else {
			$data['guest_num'] 	= '';
		}
		
		if (!empty($table_details['reserve_date'])) {
			$data['date'] 	= $table_details['reserve_date'];
		} else {
			$data['date'] 	= '';
		}
		
		if (!empty($table_details['reserve_time'])) {
			$data['time'] 	= $table_details['reserve_time'];
		} else {
			$data['time'] 	= '';
		}
		
		if (!empty($table_details['occasion'])) {
			$data['occasion'] 	= $table_details['occasion'];
		} else {
			$data['occasion'] 	= '';
		}

		if (!empty($table_details['available_times'])) {
			$data['text_time_msg'] 	= 'AVAILABLE RESERVATIONS ON ' .mdate('%l, %F %j, %Y', strtotime($table_details['reserve_date'])). ' FOR ' .$table_details['guest_num'].' GUESTS:';
			$data['select_times'] 	= $table_details['available_times'];
		} else {
			$data['text_time_msg'] 	= '';
			$data['select_times'] 	= '';
		}
		
		if ( ! $this->input->post('select_time') && $this->_findTable($reserve_times, $interval) === TRUE) {
			
			redirect('find/table');		
		}	
			
		if ($this->input->post('select_time') && $this->_selectTime($table_details) === TRUE) {
			
			redirect('reserve/table');		
		}	
			
		$this->load->view('main/header', $data);
		$this->load->view('main/find_table', $data);
		$this->load->view('main/footer');
	}


	public function _findTable($reserve_times, $interval) {

		$time_format = '%h:%i %a';
		$date_format = '%d-%m-%Y';
		$current_date_time = time();
	
		$table_details = array();
		//$this->session->unset_userdata('table_details');
		
		$this->form_validation->set_rules('location', 'Location', 'trim|required|integer');
		$this->form_validation->set_rules('guest_num', 'Guest Number', 'trim|required|integer|callback_validate_guest');
		$this->form_validation->set_rules('reserve_date', 'Date', 'trim|required|callback_validate_date');
		$this->form_validation->set_rules('reserve_time', 'Time', 'trim|required|callback_validate_time');
		$this->form_validation->set_rules('occasion', 'Occasion', 'trim|required|integer');

  		if ($this->form_validation->run() === TRUE) {
		
			$table_details['location'] 		= $this->input->post('location');
			$table_details['guest_num'] 	= $this->input->post('guest_num');
		 	$table_details['reserve_date']	= mdate($date_format, strtotime($this->input->post('reserve_date')));
		 	$table_details['reserve_time']	= $this->input->post('reserve_time');
			$table_details['occasion'] 		= $this->input->post('occasion');
			
			$table_details['available_times'] = $this->location->getReserveTimes($reserve_times, $this->input->post('reserve_time'), $interval, '2');

			if (!empty($table_details)) {
				$this->session->set_userdata('table_details', $table_details);
				return TRUE;
			}
		}
	}

	public function _selectTime($table_details) {
		$time_format = '%h:%i %a';
		
		$this->form_validation->set_rules('select_time', 'Select Time', 'trim|required|callback_validate_time');

  		if ($this->form_validation->run() === TRUE) {

			$table_details['reserve_time'] = $this->input->post('select_time');
			
			$this->session->set_userdata('table_details', $table_details);

			return TRUE;
		}
			
	}
	
	public function validate_date($str) {
		
		if ( ! strtotime($str)) {
        	$this->form_validation->set_message('validate_date', 'The %s field must be valid.');
			return FALSE;
		} else if (strtotime($str) < strtotime($this->location->currentDate())) {
        	$this->form_validation->set_message('validate_date', 'Date must be after today!');
      		return FALSE;
		} else {
      		return TRUE;
		}
	}

	public function validate_time($str) {
		
		if ( ! preg_match('/^([01]?[0-9]|2[0-3]):[0-5][0-9]:00$/', $str) &&  ! strtotime($str)) {
        	$this->form_validation->set_message('validate_time', 'The %s field must be valid.');
			return FALSE;
		} else {
      		return TRUE;
		}
	}

 	public function validate_guest($str) {
 	
 		$result = $this->Reservations_model->checkTableSize($this->input->post('location'), $str);

		if ($this->input->post('location') && $result === FALSE) {
        	$this->form_validation->set_message('validate_guest', 'No tables available at the selected location!');
      		return FALSE;
		} else if ( ! $this->Reservations_model->checkAvailability($this->input->post())) {
        	$this->form_validation->set_message('validate_guest', 'No tables available for the selected date and time!');
      		return FALSE;
 		} else {
      		return TRUE;
		}
    }
}