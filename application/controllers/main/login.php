<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends MX_Controller {

	public function index() {
		$this->load->library('customer');
		$this->lang->load('main/login_register');  												// loads language file

		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');
		} else {
			$data['alert'] = '';
		}
		
		if ($this->customer->islogged()) { 														// checks if customer is logged in then redirect to account page.	
  			redirect('account');
		}

		// START of retrieving lines from language file to pass to view.
		$data['text_heading'] 			= $this->lang->line('text_heading');
		$data['text_login'] 			= $this->lang->line('text_login');
		$data['text_register'] 			= $this->lang->line('text_register');
		$data['text_forgot'] 			= $this->lang->line('text_forgot');
		$data['entry_email'] 			= $this->lang->line('entry_email');
		$data['entry_password'] 		= $this->lang->line('entry_password');
		$data['button_login'] 			= $this->lang->line('button_login');
		$data['text_login_register'] 		= $this->lang->line('text_login_register');
		// END of retrieving lines from language file to send to view.

		$data['reset_url'] 				= site_url('main/password_reset');

		if ($this->input->post('submit') === 'Login') {																// checks if $_POST data is set 
	
			if ($this->validateForm() === TRUE) {	
				$email = $this->input->post('email');											// retrieves email value from $_POST data if set
				$password = $this->input->post('password');										// retrieves password value from $_POST data if set
			
				if ($this->customer->login($email, $password) === FALSE) {						// invoke login method in customer library with email and password $_POST data value then check if login was unsuccessful
					$this->session->set_flashdata('alert', $this->lang->line('text_invalid_login'));	// display error message and redirect to account login page
  					redirect('main/login');
    			} else {																		// else if login was successful redirect to account page
 					redirect('account');
  				}
    		}
		}
		
		$regions = array('header', 'footer');
		if (file_exists(APPPATH .'views/themes/main/'.$this->config->item('main_theme').'login.php')) {
			$this->template->render('themes/main/'.$this->config->item('main_theme'), 'login', $regions, $data);
		} else {
			$this->template->render('themes/main/default/', 'login', $regions, $data);
		}
	}
		public function validateForm() {
			// START of form validation rules
			$this->form_validation->set_rules('email', 'Email Address', 'xss_clean|trim|required|valid_email');
			$this->form_validation->set_rules('password', 'Password', 'xss_clean|trim|required|min_length[6]|max_length[32]');
			// END of form validation rules

  			if ($this->form_validation->run() === TRUE) {										// checks if form validation routines ran successfully
				return TRUE;
			} else {
				return FALSE;
			}
		}
}

/* End of file login.php */
/* Location: ./application/controllers/main/login.php */