<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Login extends Main_Controller {

	public function index() {
		if ($this->customer->islogged()) { 														// checks if customer is logged in then redirect to account page.
			redirect('account/account');
		}

		$this->load->model('Pages_model');
		$this->lang->load('account/login_register');

		$this->template->setTitle($this->lang->line('text_heading'));

		$data['reset_url'] 				= site_url('account/reset');
		$data['register_url'] 			= site_url('account/register');

		if ($this->input->post()) {																// checks if $_POST data is set
			if ($this->validateForm() === TRUE) {
				$email = $this->input->post('email');											// retrieves email value from $_POST data if set
				$password = $this->input->post('password');										// retrieves password value from $_POST data if set

				if ($this->customer->login($email, $password) === FALSE) {						// invoke login method in customer library with email and password $_POST data value then check if login was unsuccessful
					$this->alert->set('alert', $this->lang->line('alert_invalid_login'));	// display error message and redirect to account login page
					redirect(current_url());
    			} else {																		// else if login was successful redirect to account page
                    log_activity($this->customer->getId(), 'logged in', 'customers', get_activity_message('activity_logged_in',
                        array('{customer}', '{link}'),
                        array($this->customer->getName(), admin_url('customers/edit?id='.$this->customer->getId()))
                    ));

					if ($redirect_url = $this->input->get('redirect')) {
						redirect($redirect_url);
					}

					redirect('account/account');
  				}
    		}
		}

		$this->template->render('account/login', $data);
	}

	private function validateForm() {
		// START of form validation rules
		$this->form_validation->set_rules('email', 'lang:label_email', 'xss_clean|trim|required|valid_email');
		$this->form_validation->set_rules('password', 'lang:label_password', 'xss_clean|trim|required|min_length[6]|max_length[32]');
		// END of form validation rules

		if ($this->form_validation->run() === TRUE) {										// checks if form validation routines ran successfully
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

/* End of file login.php */
/* Location: ./main/controllers/login.php */