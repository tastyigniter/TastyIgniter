<?php if (!defined('BASEPATH')) exit('No direct access allowed');

class Reservation_module extends Base_Component
{

	public function index() {
		if ($this->config->item('reservation_mode') != '1') {
			$this->alert->set('alert', $this->lang->line('alert_reservation_disabled'));
			$this->redirect('home');
		}

		$this->load->model('Reservations_model');

		$this->load->library('location'); // load the location library
		$this->location->initialize();

		$this->lang->load('reservation_module/reservation_module');

		$this->assets->setStyleTag(extension_url('reservation_module/assets/stylesheet.css'), 'reservation-module-css', '154000');
		$this->assets->setStyleTag(assets_url('js/datepicker/datepicker.css'), 'datepicker-css', '124000');
		$this->assets->setScriptTag(assets_url("js/datepicker/bootstrap-datepicker.js"), 'bootstrap-datepicker-js', '12000');
		$this->assets->setStyleTag(assets_url('js/datepicker/bootstrap-timepicker.css'), 'bootstrap-timepicker-css', '124440');
		$this->assets->setScriptTag(assets_url("js/datepicker/bootstrap-timepicker.js"), 'bootstrap-timepicker-js', '12550');

		$date_format = ($this->config->item('date_format')) ? $this->config->item('date_format') : '%d %M %y';
		$time_format = ($this->config->item('time_format')) ? $this->config->item('time_format') : '%h:%i %a';

		$data['date_formats'] = array(
			'%j%S %F %Y' => 'dd mm yyyy',
			'%d/%m/%Y' => 'dd/mm/yyyy',
			'%m/%d/%Y' => 'mm/dd/yyyy',
			'%Y-%m-%d' => 'yyyy-mm-dd',
		);

		$data['date_format'] = isset($data['date_formats'][$date_format]) ? $data['date_formats'][$date_format] : $date_format;

		$page_url = $this->uri->rsegment('1') === 'reservation' ? page_url() : site_url('reservation');
		$data['current_url'] = $page_url . '?action=find_table&';
		$data['reset_url'] = site_url('reservation');

		$data['find_table_action'] = 'find_table';

		if ($this->uri->rsegment('1') === 'reservation' AND $this->input->get() AND ($response = $this->findTable()) !== FALSE) {
			if ($this->input->get('action') === 'select_time' AND $this->input->get('selected_time')) {
				$data['find_table_action'] = 'view_summary';
				$data['current_url'] = page_url() . '?action=select_time&';
			} else {
				$data['find_table_action'] = 'select_time';
				$data['current_url'] = page_url() . '?action=select_time&';
			}
		}

		$data['locations'] = array();
		$locations = $this->Locations_model->getLocations();
		foreach ($locations as $location) {
			$data['locations'][] = array(
				'id'   => $location['location_id'],
				'name' => $location['location_name'],
			);
		}

		$data['guest_numbers'] = array('2', '3', '4', '5', '6', '7', '8', '9', '10');

		$data['location_image'] = $this->location->getImage();

		if ($this->input->get('location')) {
			$data['location_id'] = $this->input->get('location');
			$data['current_url'] .= 'location=' . $data['location_id'] . '&';
		} else {
			$data['location_id'] = $this->location->getId();
		}

		if ($this->input->get('guest_num')) {
			$data['guest_num'] = $this->input->get('guest_num');
			$data['current_url'] .= 'guest_num=' . $data['guest_num'] . '&';
		} else {
			$data['guest_num'] = '';
		}

		if ($this->input->get('reserve_date')) {
			$data['date'] = $this->input->get('reserve_date');
			$data['current_url'] .= 'reserve_date=' . urlencode($data['date']) . '&';
		} else {
			$data['date'] = mdate($date_format, strtotime('+1 day', time()));
		}

		if ($this->input->get('selected_time')) {
			$data['time'] = mdate($time_format, strtotime($this->input->get('selected_time')));
			$data['current_url'] .= 'reserve_time=' . urlencode($data['time']) . '&';
		} else if ($this->input->get('reserve_time')) {
			$data['time'] = mdate($time_format, strtotime($this->input->get('reserve_time')));
			$data['current_url'] .= 'reserve_time=' . urlencode($data['time']) . '&';
		} else {
			$data['time'] = '';
		}

		$opening_time = mdate('%d-%m-%Y %H:%i', $this->location->workingTime('opening', 'open', FALSE));
		$closing_time = mdate('%d-%m-%Y %H:%i', $this->location->workingTime('opening', 'close', FALSE));
		$start_time = mdate('%H:%i', strtotime($opening_time) + $this->location->getReservationInterval() * 60);

		$data['reservation_times'] = array();
		$reservation_times = time_range($start_time, $closing_time, $this->location->getReservationInterval());    // retrieve the location delivery times from location library
		if (!empty($reservation_times)) {
			foreach ($reservation_times as $key => $value) {                                            // loop through delivery times
				$data['reservation_times'][$value] = mdate($time_format, strtotime($value));
			}
		}

		$data['time_slots'] = array();
		if (!empty($response['time_slots'])) {
			for ($i = 0; $i < 5; $i++) {
				if (isset($response['time_slots'][$i])) {
					$data['time_slots'][$i]['state'] = '';
					$data['time_slots'][$i]['time'] = $response['time_slots'][$i];
					$data['time_slots'][$i]['formatted_time'] = mdate($time_format, strtotime($response['time_slots'][$i]));
				} else {
					$data['time_slots'][$i]['state']    = 'disabled';
					$data['time_slots'][$i]['time']     = '--';
					$data['time_slots'][$i]['formatted_time']     = '--';
				}
			}
		}

		$data['reservation_alert'] = $this->alert->display('reservation_module');

		return $this->load->view('reservation_module/reservation_module', $data);
	}


	protected function findTable() {
		if ($this->validateForm() === TRUE) {

			$this->location->setLocation($this->input->get('location'));

			$find['location'] = $this->input->get('location');
			$find['guest_num'] = $this->input->get('guest_num');
			$find['reserve_date'] = mdate('%d-%m-%Y', strtotime($this->input->get('reserve_date')));
			$find['reserve_time'] = mdate('%H:%i', strtotime($this->input->get('reserve_time')));
			$find['selected_time'] = mdate('%H:%i', strtotime($this->input->get('selected_time')));
			$find['time_interval'] = $this->location->getReservationInterval();

			$response = $this->Reservations_model->findATable($find);

			if ($response === 'NO_ARGUMENTS') {
				log_message('debug', 'Reservations_model -> checkAvailability() failed -> ' . $response);
			} else if ($response === 'NO_TABLE') {
				$this->alert->set('alert_now', $this->lang->line('alert_no_table_available'), 'reservation_module');
			} else if ($response === 'FULLY_BOOKED') {
				$this->alert->set('alert_now', $this->lang->line('alert_fully_booked'), 'reservation_module');
			} else if (is_array($response)) {

				if ($this->input->get('selected_time') AND isset($response['time_slots'])) {
					$selected_time = mdate('%H:%i', strtotime($this->input->get('reserve_date') . ' ' . $this->input->get('selected_time')));

					if (in_array($selected_time, $response['time_slots'])) {
						$response['table_found'] = array_shift($response['table_found']);
						$this->session->set_tempdata('reservation_data', array_merge($find, $response), 300);
					} else {
						$this->alert->set('alert_now', $this->lang->line('alert_fully_booked'), 'reservation_module');

						return FALSE;
					}
				}

				return $response;
			}
		}

		return FALSE;
	}

	protected function validateForm() {
		$this->form_validation->reset_validation();
		$this->form_validation->set_data($_GET);

		$this->form_validation->set_rules('location', 'lang:label_location', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('guest_num', 'lang:label_guest_num', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('reserve_date', 'lang:label_date', 'xss_clean|trim|required|valid_date|callback__validate_date');
		$this->form_validation->set_rules('reserve_time', 'lang:label_time', 'xss_clean|trim|required|valid_time|callback__validate_time');

		if ($this->input->get('action') === 'select_time') {
			$this->form_validation->set_rules('selected_time', 'lang:label_time', 'xss_clean|trim|required|valid_time|callback__validate_time');
		}

		if ($this->form_validation->run() === TRUE) {                                            // checks if form validation routines ran successfully
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function _validate_date($str) {
		if (strtotime($str) < time()) {
			$this->form_validation->set_message('_validate_date', $this->lang->line('error_invalid_date'));

			return FALSE;
		} else {
			return TRUE;
		}
	}

	public function _validate_time($str) {

		if (!empty($str)) {

			$reserve_time = strtotime(urldecode($str));

			if ($hour = $this->Locations_model->getOpeningHourByDay(urldecode($this->input->get('location')), $this->input->get('reserve_date'))) {
				if ($hour['status'] == '1' AND (strtotime($hour['open']) <= $reserve_time AND strtotime($hour['close']) >= $reserve_time)) {
					return TRUE;
				}
			}

			$this->form_validation->set_message('_validate_time', $this->lang->line('error_invalid_time'));

			return FALSE;
		}
	}
}

/* End of file Reservation_module.php */
/* Location: ./extensions/reservation_module/components/Reservation_module.php */