<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Reservation_module extends Main_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor

        $this->load->model('Reservations_model');

        $this->load->library('location'); // load the location library

        $this->lang->load('reservation_module/reservation_module');
	}

	public function index() {
		if ( ! file_exists(EXTPATH .'reservation_module/views/reservation_module.php')) { 								//check if file exists in views folder
			show_404(); 																		// Whoops, show 404 error page!
		}

        $this->template->setStyleTag(extension_url('reservation_module/views/stylesheet.css'), 'reservation-module-css', '154000');
        $this->template->setStyleTag(base_url('assets/js/datepicker/datepicker.css'), 'datepicker-css', '124000');
        $this->template->setScriptTag(base_url("assets/js/datepicker/bootstrap-datepicker.js"), 'bootstrap-datepicker-js', '12000');
        $this->template->setStyleTag(base_url('assets/js/datepicker/bootstrap-timepicker.css'), 'bootstrap-timepicker-css', '124440');
        $this->template->setScriptTag(base_url("assets/js/datepicker/bootstrap-timepicker.js"), 'bootstrap-timepicker-js', '12550');

        if ($this->config->item('reservation_mode') !== '1') {
            $this->alert->set('alert', $this->lang->line('alert_reservation_disabled'));
            redirect('home');
        }

		$data['current_url'] 			= page_url().'?action=find_table&';
		$data['reset_url'] 				= site_url('reservation');

        $data['find_table_action'] = 'find_table';

        if ($this->input->get() AND ($response = $this->findTable()) !== FALSE) {
            if ($this->input->get('action') === 'select_time' AND $this->input->get('selected_time')) {
                $data['find_table_action'] = 'view_summary';
                $data['current_url'] = page_url().'?action=select_time&';
            } else {
                $data['find_table_action'] = 'select_time';
                $data['current_url'] = page_url().'?action=select_time&';
            }
        }

        $data['locations'] = array();
		$locations = $this->Locations_model->getLocations();
		foreach ($locations as $location) {
			$data['locations'][] = array(
				'id' 		=> $location['location_id'],
				'name'		=> $location['location_name']
			);
		}

		$data['guest_numbers'] = array('2', '3', '4', '5','6', '7', '8', '9', '10');

        $data['location_image'] = $this->location->getImage();

        if ($this->input->get('location')) {
			$data['location_id'] 	= $this->input->get('location');
            $data['current_url'] .= 'location='. $data['location_id'] .'&';
		} else {
			$data['location_id'] 	= '';
		}

		if ($this->input->get('guest_num')) {
			$data['guest_num'] 	= $this->input->get('guest_num');
            $data['current_url'] .= 'guest_num='. $data['guest_num'] .'&';
        } else {
			$data['guest_num'] 	= '';
		}

		if ($this->input->get('reserve_date')) {
			$data['date'] 	= $this->input->get('reserve_date');
            $data['current_url'] .= 'reserve_date='. urlencode($data['date']) .'&';
        } else {
			$data['date'] 	= '';
		}

		if ($this->input->get('selected_time')) {
            $data['time'] 	= mdate('%g:%i %A', strtotime($this->input->get('selected_time')));
            $data['current_url'] .= 'reserve_time='. urlencode($data['time']) .'&';
        } else if ($this->input->get('reserve_time')) {
			$data['time'] 	= mdate('%g:%i %A', strtotime($this->input->get('reserve_time')));
            $data['current_url'] .= 'reserve_time='. urlencode($data['time']) .'&';
        } else {
			$data['time'] 	= '';
		}

        $data['time_slots'] = array();
        if (!empty($response['time_slots'])) {
            for ($i = 0; $i < 5; $i++) {
                if (isset($response['time_slots'][$i])) {
                    $time = mdate('%g:%i %A', strtotime($response['time_slots'][$i]));
                    $data['time_slots'][$i]['state'] = '';
                    $data['time_slots'][$i]['time'] = $time;
                } else {
                    $data['time_slots'][$i]['state']    = 'disabled';
                    $data['time_slots'][$i]['time']     = '--';
                }
            }
        }

        $data['reservation_alert'] = $this->alert->display('reservation_module');

		$this->load->view('reservation_module/reservation_module', $data);
	}


	private function findTable() {
        if ($this->validateForm() === TRUE) {

            $this->location->setLocation($this->input->get('location'));

            $find['location'] 			    = $this->input->get('location');
			$find['guest_num'] 		        = $this->input->get('guest_num');
		 	$find['reserve_date']		    = mdate('%d-%m-%Y', strtotime($this->input->get('reserve_date')));
		 	$find['reserve_time']		    = mdate('%H:%i', strtotime($this->input->get('reserve_time')));
		 	$find['selected_time']		    = mdate('%H:%i', strtotime($this->input->get('selected_time')));
		 	$find['time_interval']		    = $this->location->getReservationInterval();

			$response = $this->Reservations_model->findATable($find);

            if ($response === 'NO_ARGUMENTS') {
                log_message('debug', 'Reservations_model -> checkAvailability() failed -> '.$response);
            } else if ($response === 'NO_TABLE') {
        		$this->alert->set('alert_now', $this->lang->line('alert_no_table_available'), 'reservation_module');
			} else if ($response === 'FULLY_BOOKED') {
                $this->alert->set('alert_now', $this->lang->line('alert_fully_booked'), 'reservation_module');
			} else if (is_array($response)) {

                if ($this->input->get('selected_time') AND isset($response['time_slots'])) {
                    $selected_time = mdate('%H:%i', strtotime($this->input->get('reserve_date') .' '. $this->input->get('selected_time')));

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

    private function validateForm() {
        $this->form_validation->reset_validation();
        $this->form_validation->set_data($_GET);

        $this->form_validation->set_rules('location', 'lang:label_location', 'xss_clean|trim|required|integer');
        $this->form_validation->set_rules('guest_num', 'lang:label_guest_num', 'xss_clean|trim|required|integer');
        $this->form_validation->set_rules('reserve_date', 'lang:label_date', 'xss_clean|trim|required|valid_date|callback__validate_date');
        $this->form_validation->set_rules('reserve_time', 'lang:label_time', 'xss_clean|trim|required|valid_time|callback__validate_time');

        if ($this->input->get('selected_time')) {
            $this->form_validation->set_rules('selected_time', 'lang:label_time', 'xss_clean|trim|required|valid_time|callback__validate_time');
        }

        if ($this->form_validation->run() === TRUE) {											// checks if form validation routines ran successfully
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function _validate_date($str) {
		if (strtotime($str) < time()) {
        	$this->form_validation->set_message('_validate_date', 'Date must be after today, you can only make future reservations!');
      		return FALSE;
		} else {
      		return TRUE;
		}
	}

    public function _validate_time($str) {

        if (!empty($str)) {

            $reserve_time = strtotime(urldecode($str));

            if ($hour = $this->Locations_model->getOpeningHourByDay(urldecode($this->input->get('location')), $this->input->get('reserve_date'))) {
                if ($hour['status'] === '1' AND (strtotime($hour['open']) <= $reserve_time AND strtotime($hour['close']) >= $reserve_time)) {
                    return TRUE;
                }
            }

            $this->form_validation->set_message('_validate_time', 'Time must be between restaurant opening time!');
            return FALSE;
		}
	}
}

/* End of file reservation_module.php */
/* Location: ./extensions/reservation_module/controllers/reservation_module.php */