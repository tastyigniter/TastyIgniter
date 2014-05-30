<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reserve_table extends MX_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('customer'); 														// load the customer library
		$this->load->model('Customers_model');
		$this->load->model('Security_questions_model');
		$this->load->model('Reservations_model');
		$this->load->library('location'); // load the location library
		$this->load->library('language');
		$this->lang->load('main/reserve_table', $this->language->folder());
	}

	public function index() {
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		$this->template->setTitle($this->lang->line('text_heading'));
		$this->template->setHeading($this->lang->line('text_heading'));
		$data['text_local'] 				= $this->lang->line('text_local');
		$data['text_postcode'] 				= $this->lang->line('text_postcode');
		$data['text_find'] 					= $this->lang->line('text_find');
		$data['text_no_table'] 				= $this->lang->line('text_no_table');
		$data['text_no_opening'] 			= $this->lang->line('text_no_opening');
		$data['text_reservation_msg'] 		= $this->lang->line('text_reservation_msg');
		$data['text_login_register']		= $this->customer->isLogged() ? sprintf($this->lang->line('text_logout'), site_url('main/logout')) : sprintf($this->lang->line('text_login'), site_url('main/login'));
		$data['entry_postcode'] 			= $this->lang->line('entry_postcode');
		$data['entry_no_guest'] 			= $this->lang->line('entry_no_guest');
		$data['entry_date'] 				= $this->lang->line('entry_date');
		$data['entry_time'] 				= $this->lang->line('entry_time');
		$data['entry_select'] 				= $this->lang->line('entry_select');
		$data['entry_occassion'] 			= $this->lang->line('entry_occassion');
		$data['entry_first_name'] 			= $this->lang->line('entry_first_name');
		$data['entry_last_name'] 			= $this->lang->line('entry_last_name');
		$data['entry_email'] 				= $this->lang->line('entry_email');
		$data['entry_confirm_email'] 		= $this->lang->line('entry_confirm_email');
		$data['entry_telephone'] 			= $this->lang->line('entry_telephone');
		$data['entry_comments'] 			= $this->lang->line('entry_comments');

		$data['button_check_postcode'] 		= $this->lang->line('button_check_postcode');
		$data['button_find_again'] 			= $this->lang->line('button_find_again');

		$data['button_right'] 				= '<a class="button" onclick="$(\'#reserve-form\').submit();">'. $this->lang->line('button_reservation') .'</a>';

		$data['action'] 					= site_url('main/reserve_table');
		$data['continue'] 					= site_url('main/reserve_table/success');
		
		$data['occasions'] = array(
			'0' => 'not applicable',
			'1' => 'birthday',
			'2' => 'anniversary',
			'3' => 'general celebration',
			'4' => 'hen party',
			'5' => 'stag party'
		);

		if ($this->input->post('first_name')) {
			$data['first_name'] = $this->input->post('first_name');
		} else if ($this->customer->getFirstName()) {
			$data['first_name'] = $this->customer->getFirstName(); 								// retrieve customer first name from customer library
		} else {
			$data['first_name'] = ''; 
		}
		
		if ($this->input->post('last_name')) {
			$data['last_name'] = $this->input->post('last_name');
		} else if ($this->customer->getLastName()) {
			$data['last_name'] = $this->customer->getLastName(); 								// retrieve customer last name from customer library
		} else {
			$data['last_name'] = ''; 
		}
		
		if ($this->input->post('email')) {
			$data['email'] = $this->input->post('email');
		} else if ($this->customer->getEmail()) {
			$data['email'] = $this->customer->getEmail(); 										// retrieve customer email address from customer library
		} else {
			$data['email'] = ''; 
		}
		
		if ($this->input->post('telephone')) {
			$data['telephone'] = $this->input->post('telephone');
		} else if ($this->customer->getTelephone()) {
			$data['telephone'] = $this->customer->getTelephone(); 								// retrieve customer telephone from customer library
		} else {
			$data['telephone'] = ''; 
		}
		
		if ($this->input->post('comment')) {
			$data['comment'] = $this->input->post('comment');
		} else {
			$data['comment'] = ''; 
		}
		
		if ($this->input->post() && $this->_reserveTable() === TRUE) {
			redirect('reserve/success');		
		}
			
		$this->template->regions(array('header', 'content_top', 'content_left', 'content_right', 'footer'));
		if (file_exists(APPPATH .'views/themes/main/'.$this->config->item('main_theme').'reserve_table.php')) {
			$this->template->render('themes/main/'.$this->config->item('main_theme'), 'reserve_table', $data);
		} else {
			$this->template->render('themes/main/default/', 'reserve_table', $data);
		}
	}

	public function success() {
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		$reservation_id = $this->input->cookie('last_reserve_id');
		$result = $this->Reservations_model->getMainReservation($reservation_id);
		
		if ($result) {
			$data['text_heading'] 	= $this->lang->line('text_heading_success');
			$guest_num = $result['guest_num'] .' person(s)';
			
			$data['text_success'] 	= sprintf($this->lang->line('text_success'), $result['location_name'], $guest_num, mdate('%l, %F %j, %Y', strtotime($result['reserve_date'])), mdate('%h:%i %a', strtotime($result['reserve_time'])));
			$data['text_greetings'] = sprintf($this->lang->line('text_greetings'), $result['first_name'] .' '. $result['last_name']);
			$data['text_signature'] = sprintf($this->lang->line('text_signature'), $this->config->item('site_name'));
			$this->session->unset_userdata('reservation');
		} else {
			redirect('find/table');
		}		
		
		$this->template->regions(array('header', 'content_top', 'content_left', 'content_right', 'footer'));
		if (file_exists(APPPATH .'views/themes/main/'.$this->config->item('main_theme').'reserve_success.php')) {
			$this->template->render('themes/main/'.$this->config->item('main_theme'), 'reserve_success', $data);
		} else {
			$this->template->render('themes/main/default/', 'reserve_success', $data);
		}
	}
	
	public function _reserveTable() {
		
		$date_format = '%Y-%m-%d';
		$time_format = '%h:%i';
		$current_time = time();
			
		if ($this->validateForm() === TRUE) {
			$data = array();
		
			$reservation = $this->session->userdata('reservation');
			$result = $this->Reservations_model->checkAvailability($reservation);
			if ($result !== 'NO_GUEST_TABLE' AND $result !== 'NO_TABLE_AVAIL') {
				if (!empty($reservation['location'])) {
					$data['location_id'] = (int)$reservation['location'];
				}
			
				if (!empty($result['tables'])) {
					$data['table_id'] = $result['tables'][0];
				}

				if (!empty($reservation['guest_num'])) {
					$data['guest_num'] = (int)$reservation['guest_num'];
				}

				if (strtotime($reservation['reserve_date']) > strtotime($this->location->currentDate())) {
					$data['reserve_date'] = mdate('%Y-%m-%d', strtotime($reservation['reserve_date']));
					$data['date_added'] = mdate('%Y-%m-%d', $current_time);
					$data['date_modified'] = mdate('%Y-%m-%d', $current_time);
				}
			
				if (strtotime($reservation['reserve_time'])) {
					$data['reserve_time'] = $reservation['reserve_time'];
				}
				
				if (!empty($reservation['occasion'])) {
					$data['occasion_id'] = (int)$reservation['occasion'];
				}
				
				if ($this->customer->getId()) {
					$data['customer_id'] = $this->customer->getId();
				} else {
					$data['customer_id'] = '0';
				}
			
				$data['first_name'] = $this->input->post('first_name');
				$data['last_name'] 	= $this->input->post('last_name');
				$data['email'] 		= $this->input->post('email');
				$data['telephone'] 	= $this->input->post('telephone');
				$data['comment'] 	= $this->input->post('comment');
				$data['ip_address'] = $this->input->ip_address();
				$data['user_agent'] = $this->input->user_agent();
			}
		
			if (!empty($data)) {
				$reservation_id = $this->Reservations_model->addReservation($data);
				$this->input->set_cookie('last_reserve_id', $reservation_id, 300, '.'.$_SERVER['HTTP_HOST']);
				return TRUE;
			} else {
				$this->session->set_flashdata('alert', '<p class="warning">An error occured, please find a table again!</p>');
				redirect('find/table');
			}
		}
	}

	public function validateForm() {
		$this->form_validation->set_rules('first_name', 'First Name', 'xss_clean|trim|required|min_length[2]|max_length[32]');
		$this->form_validation->set_rules('last_name', 'Last Name', 'xss_clean|trim|required|min_length[2]|max_length[32]');
		$this->form_validation->set_rules('email', 'Email Address', 'xss_clean|trim|required|valid_email');
		$this->form_validation->set_rules('confirm_email', 'Confirm Email Address', 'xss_clean|trim|required|valid_email|matches[email]');
		$this->form_validation->set_rules('telephone', 'Telephone', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('comment', 'Comment', 'xss_clean|trim|max_length[520]');
		
  		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

/* End of file reserve_table.php */
/* Location: ./application/controllers/main/reserve_table.php */