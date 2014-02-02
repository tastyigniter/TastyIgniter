<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reserve_table extends MX_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->model('Customers_model');
		$this->load->model('Security_questions_model');
		$this->load->model('Reservations_model');
	}

	public function index() {
		$this->output->enable_profiler(TRUE); // for debugging profiler... remove later
		$this->load->library('location'); // load the location library
		$this->lang->load('main/reserve_table');  // loads language file
		
		if ( !file_exists(APPPATH .'/views/main/reserve_table.php')) { //check if file exists in views folder
			show_404(); // Whoops, show 404 error page!
		}

		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		$data['text_heading'] 				= $this->lang->line('text_heading');
		$data['text_local'] 				= $this->lang->line('text_local');
		$data['text_postcode'] 				= $this->lang->line('text_postcode');
		$data['text_find'] 					= $this->lang->line('text_find');
		$data['text_no_table'] 				= $this->lang->line('text_no_table');
		$data['text_no_opening'] 			= $this->lang->line('text_no_opening');
		$data['text_reservation_msg'] 		= $this->lang->line('text_reservation_msg');
		$data['text_login_register']		= $this->customer->isLogged() ? sprintf($this->lang->line('text_logout'), site_url('account/logout')) : sprintf($this->lang->line('text_login'), site_url('account/login'));
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
		$data['button_reservation'] 		= $this->lang->line('button_reservation');
		$data['button_find_again'] 			= $this->lang->line('button_find_again');

		$data['action'] 					= $this->config->site_url('reserve/table');
		$data['continue'] 					= $this->config->site_url('reserve/success');
		
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
		
		if ($this->session->userdata('table_details')) {
			$table_details = $this->session->userdata('table_details');
			
			$time_format = '%h:%i %a';
			$location = $this->Locations_model->getLocation($table_details['location']);
			
			$data['location'] 	= $location['location_name'];
			$data['guest_num'] 	= $table_details['guest_num'] .' person(s)';
			$data['date'] 		= mdate('%l, %F %j, %Y', strtotime($table_details['reserve_date']));
			$data['time'] 		= mdate($time_format, strtotime($table_details['reserve_time']));
			$data['occasion'] 	= $table_details['occasion'];
		} else {
			$this->session->set_flashdata('alert', '<p class="warning">An error occured, please start again!</p>');
			redirect('find/table');
		}
		
		if ($this->input->post() && $this->_reserveTable() === TRUE) {
			
			//redirect('checkout');		
		
		}
			
		$this->load->view('main/header', $data);
		$this->load->view('main/content_right', $data);
		$this->load->view('main/reserve_table', $data);
		$this->load->view('main/footer');
	}


	public function _reserveTable() {
		
		$date_format = '%Y-%m-%d';
		$time_format = '%h:%i';
		$current_date_time = time();
			
		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|min_length[2]|max_length[32]');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|min_length[2]|max_length[32]');
		$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');
		$this->form_validation->set_rules('confirm_email', 'Confirm Email Address', 'trim|required|valid_email|matches[email]');
		$this->form_validation->set_rules('telephone', 'Telephone', 'trim|required|integer');
		$this->form_validation->set_rules('comment', 'Comment', 'trim|max_length[520]');
		

  		if ($this->form_validation->run() === TRUE) {
			$reserve_details = array();
		
			$table_details = $this->session->userdata('table_details');
			
			if ($result = $this->Reservations_model->checkAvailability($table_details)) {
			
				if (!empty($result['location_id'])) {
					$data['location_id'] = (int)$result['location_id'];
				}
			
				if (!empty($result['tables'])) {
					$data['table_id'] = $result['tables'][0];
				}

				if (!empty($table_details['guest_num'])) {
					$data['guest_num'] = (int)$table_details['guest_num'];
				}

				if (strtotime($result['reserve_date']) > strtotime($this->location->currentDate())) {
					$data['reserve_date'] = mdate($date_format, strtotime($result['reserve_date']));
					$data['date_added'] = mdate($date_format, $current_date_time);
					$data['date_modified'] = mdate($date_format, $current_date_time);
				}
			
				if (strtotime($result['reserve_time'])) {
					$data['reserve_time'] = $result['reserve_time'];
				}
				
				if (!empty($table_details['occasion'])) {
					$data['occasion_id'] = (int)$table_details['occasion'];
				}
				
				if ($this->customer->getId()) {
					$data['customer_id'] = $this->customer->getId();
				} else {
					$data['customer_id'] = '0';
				}
			
				if ($this->input->post('first_name')) {
					$data['first_name'] = $this->input->post('first_name');
				}
				
				if ($this->input->post('last_name')) {
					$data['last_name'] = $this->input->post('last_name');
				}
				
				if ($this->input->post('email')) {
					$data['email'] = $this->input->post('email');
				}
				
				if ($this->input->post('telephone')) {
					$data['telephone'] = $this->input->post('telephone');
				}
				
				if ($this->input->post('comment')) {
					$data['comment'] = $this->input->post('comment');
				}

				if ($this->input->ip_address()) {
					$data['ip_address'] = $this->input->ip_address();
				}
			
				if ($this->input->user_agent()) {	
					$data['user_agent'] = $this->input->user_agent();
				}
														
			}
		
			if ($this->Reservations_model->addReservation($data)) {
				$this->session->unset_userdata('table_details');
				return TRUE;
			} else {
				$this->session->set_flashdata('alert', '<p class="warning">An error occured, please start again!</p>');
				redirect('find/table');
			}
		}
	}
}