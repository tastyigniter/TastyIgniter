<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Reservation_module extends MX_Controller {
	public $reservation_alert;
	
	public function __construct() {
		parent::__construct(); //  calls the constructor
        $this->form_validation->CI =& $this;
		$this->load->library('location'); // load the location library
		$this->load->model('Extensions_model');
		$this->load->model('Reservations_model');
		$this->load->model('Customers_model');
		$this->load->model('Security_questions_model');
		$this->load->library('language');
		$this->lang->load('reservation_module/reservation_module', $this->language->folder());
	}

	public function index() {
		if ( ! file_exists(EXTPATH .'modules/reservation_module/views/main/reservation_module.php')) { 								//check if file exists in views folder
			show_404(); 																		// Whoops, show 404 error page!
		}
			
		if ($this->session->flashdata('reservation_alert')) {
			$data['reservation_alert'] = $this->session->flashdata('reservation_alert');  								// retrieve session flashdata variable if available
		} else if ($this->reservation_alert) {
			$data['reservation_alert'] = $this->reservation_alert;
		} else {
			$data['reservation_alert'] = '';
		}
		
		$data['text_heading'] 				= $this->lang->line('text_heading');
		$data['text_heading_time'] 			= $this->lang->line('text_heading_time');
		$data['text_reservation'] 			= $this->lang->line('text_reservation');
		$data['text_local'] 				= $this->lang->line('text_local');
		$data['text_postcode_warning'] 		= $this->lang->line('text_postcode_warning');
		$data['text_delivery_charge'] 		= $this->lang->line('text_delivery_charge');
		$data['text_postcode'] 				= $this->lang->line('text_postcode');
		$data['text_find'] 					= $this->lang->line('text_find');
		$data['text_find_msg'] 				= $this->lang->line('text_find_msg');
		$data['alert_no_times'] 			= $this->lang->line('alert_no_times');
		$data['text_no_table'] 				= $this->lang->line('text_no_table');
		$data['text_no_opening'] 			= $this->lang->line('text_no_opening');
		$data['entry_location'] 			= $this->lang->line('entry_location');
		$data['entry_postcode'] 			= $this->lang->line('entry_postcode');
		$data['entry_guest_num'] 			= $this->lang->line('entry_guest_num');
		$data['entry_date'] 				= $this->lang->line('entry_date');
		$data['entry_time'] 				= $this->lang->line('entry_time');
		$data['entry_select'] 				= $this->lang->line('entry_select');
		$data['entry_occassion'] 			= $this->lang->line('entry_occassion');

		$data['button_check_postcode'] 		= $this->lang->line('button_check_postcode');
		$data['button_reservation'] 		= $this->lang->line('button_reservation');
		$data['button_find'] 				= $this->lang->line('button_find');
		$data['button_find_again'] 			= $this->lang->line('button_find_again');
		$data['button_time'] 				= $this->lang->line('button_time');
		$data['button_back'] 				= $this->lang->line('button_back');
		$data['button_reset'] 				= $this->lang->line('button_reset');
		$data['back'] 						= site_url('main/reserve_table');
		
		$data['locations'] = array();
		$locations = $this->Locations_model->getLocations();
		foreach ($locations as $location) {
			$data['locations'][] = array(
				'id' 		=> $location['location_id'],
				'name'		=> $location['location_name']
			);
		}
		
		$data['guest_nums'] = array('2', '3', '4', '5','6', '7', '8', '9', '10');

		$occasions = array(
			'1' => 'birthday',
			'2' => 'anniversary',
			'3' => 'general celebration',
			'4' => 'hen party',
			'5' => 'stag party',
			'6' => 'not applicable'
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
			$data['occasion'] 	= '1';
		}

		$data['text_time_msg'] 	= 'AVAILABLE RESERVATIONS ON '. mdate('%l, %F %j %Y', strtotime($data['date'])). ' FOR ' .$data['guest_num'].' GUESTS:';
		$data['show_times'] = $data['show_reserve'] = FALSE;
		$data['reserve_times'] = array();

		if ($this->input->get() AND $this->findTable() === TRUE) {
			if ( ! $this->input->get('reserve_time')) {
				$data['show_times'] = TRUE;
			}
		
			$reservation = $this->session->userdata('reservation');
			if (!empty($reservation) AND $this->input->get('reserve_time')) {
				$data['show_reserve'] = TRUE;
		
				$location = $this->Locations_model->getLocation($reservation['location']);
		
				$data['location_name'] 		= $location['location_name'];
				$data['guest_num'] 			= $reservation['guest_num'] .' person(s)';
				$data['reserve_date'] 		= mdate('%l, %F %j, %Y', strtotime($reservation['reserve_date']));
				$data['reserve_time'] 		= mdate('%h:%i %a', strtotime($reservation['reserve_time']));
				$data['occasion'] 			= (isset($reservation['occasion']) AND $reservation['occasion'] > 0) ? $occasions[$reservation['occasion']] : '';
			}
			
			$data['time'] = mdate('%H:%i', strtotime(urldecode($this->input->get('reserve_time'))));
			$interval = $this->location->getReservationInterval();
			$reserve_day = date('l', strtotime(urldecode($this->input->get('reserve_date'))));
			$working_hour = $this->Locations_model->getOpeningHourByDay(urldecode($this->input->get('location')), $reserve_day);
			$opening_time = ($working_hour['open'] === '00:00:00') ? '01:00' : $working_hour['open'];
			$closing_time = ($working_hour['close'] === '00:00:00') ? '23:59' : $working_hour['close'];

			$reserve_times = $this->location->generateHours($opening_time, $closing_time, 45);
			if ($reserve_times) {
				foreach ($reserve_times as $key => $value) {
					$data['reserve_times'][] = array(
						'24hr' 		=> $value,
						'12hr'		=> mdate('%h:%i %a', strtotime($value))
					);
				}
			} else {
				$this->reservation_alert = $this->lang->line('alert_no_times');
			}
		}
		
		$data['reservation_alert'] = $this->reservation_alert;

		$this->load->view('reservation_module/main/reservation_module', $data);
	}


	public function findTable() {
		$time_format = '%h:%i %a';
		$date_format = '%d-%m-%Y';
		$current_date_time = time();
	
		$_POST=$_GET;
		
		$this->form_validation->set_rules('location', 'Location', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('guest_num', 'Guest Number', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('reserve_date', 'Date', 'xss_clean|trim|required|valid_date|callback_validate_date');
		$this->form_validation->set_rules('occasion', 'Occasion', 'xss_clean|trim|required|integer');

  		if ($this->form_validation->run() === TRUE) {
			$this->session->unset_userdata('reservation');
	
			$check['location'] 			= $this->input->post('location');
			$check['guest_num'] 		= $this->input->post('guest_num');
		 	$check['reserve_date']		= mdate($date_format, strtotime($this->input->post('reserve_date')));
		 	$check['reserve_time']		= $this->input->post('reserve_time');
			$check['occasion'] 			= $this->input->post('occasion');
			
			$result = $this->Reservations_model->checkAvailability($check);
			
			if ($result === 'NO_GUEST_TABLE') {
        		$this->reservation_alert = $this->lang->line('alert_no_guest');
			} else if ($result === 'NO_TABLE_AVAIL') {
        		$this->reservation_alert = $this->lang->line('alert_no_time');
			}
			
			if (is_array($result) AND isset($result['tables']) AND empty($check['reserve_time'])) {
				$location = $this->Locations_model->getLocation($check['location']);
			
				if ($location) {
					$this->Locations_model->getLocalRestaurant($location['location_lat'], $location['location_lng']);
				}

				return TRUE;
			} else if (is_array($result) AND isset($result['tables']) AND $this->form_validation->valid_time($check['reserve_time']) === TRUE) {
				$this->session->set_userdata('reservation', $check);
				return TRUE;
			}
			
			return FALSE;
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

/* End of file reservation_module.php */
/* Location: ./application/extensions/modules/reservation_module/controllers/main/reservation_module.php */