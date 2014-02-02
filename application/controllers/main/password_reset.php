<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Password_reset extends MX_Controller {

	public function __construct() {
		parent::__construct(); 																	// calls the constructor
		$this->load->model('Customers_model');													// load the customers model
		$this->load->model('Security_questions_model');											// load the security questions model
	}

	public function index() {
		$this->lang->load('main/password_reset');  												// loads language file
		
		if ( !file_exists(APPPATH .'/views/main/password_reset.php')) { 						//check if file exists in views folder
			show_404(); 																		// Whoops, show 404 error page!
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  								// retrieve session flashdata variable if available
		}
		
		if ($this->customer->islogged()) {  
  			redirect('account');
		}

		$data['heading'] = 'Account Password Reset';
		$data['action'] = $this->config->site_url('main/password_reset');

		$data['questions'] = array();
		$results = $this->Security_questions_model->getQuestions();
		foreach ($results as $result) {
			$data['questions'][] = array(
				'id'	=> $result['question_id'],
				'text'	=> $result['question_text']
			);
		}

		if (isset($this->session->userdata['customer_id_to_reset'])) {							// checks if session userdata customer_id_to_reset value is set
			$customer_data = $this->Customers_model->getCustomer($this->session->userdata('customer_id_to_reset'));	// retrieve customer data from getCustomer method in Customers model
			if ($customer_data) {																// check if customer data is available send customer email and customer security question to view
				$data['customer_email'] = $customer_data['email'];
				$security_question_id = $customer_data['security_question_id'];
				$question_data = $this->Security_questions_model->getQuestion($security_question_id);	// retrieve security question data from getQuestions method in Security questions model
				$data['security_question'] = $question_data['question_text'];
		
			} else {																			// else send nothing to view
				$data['customer_email'] = '';
				$data['security_question'] = '';
			}
		}

		if ($this->input->post()) {																// checks if $_POST data is set
			
			$this->_resetPassword();															// invoke this _resetPassword method
				
		}
				
		// pass array $data and load view files
		if ($this->session->flashdata('security_question_id')) {
				
			$security_question_id = $this->session->flashdata('security_question_id');
			$question_data = $this->Customers_model->getQuestion($security_question_id);
			
			$data['security_question'] = $question_data['question_text'];
			$data['customer_email'] = $this->session->flashdata('customer_email');
		
		} else {
			$data['security_question'] = '';
		}

		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			
			if ($this->_resetPassword()) { 
				
			}
				
		}
		
		$this->load->view('main/header', $data);
		$this->load->view('main/password_reset', $data);
		$this->load->view('main/footer');
	}

	public function _resetPassword() {															// method to validate password reset
		$this->lang->load('main/password_reset');  												// loads language file
		
		if ($this->input->post()) { 
			
			$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');	//validate form
			$this->form_validation->set_rules('security_question', 'Security Question', 'trim|required|integer');
			$this->form_validation->set_rules('security_answer', 'Security Answer', 'trim|required|min_length[2]');
  		
  			if ($this->form_validation->run() === TRUE) {										// checks if form validation routines ran successfully

				$email 					= $this->input->post('email');
				$security_question_id	= $this->input->post('security_question');
				$security_answer 		= $this->input->post('security_answer');

				$customer_data = $this->Customers_model->getCustomerByEmail($email); 			// retrieve customer data based on $_POST email value from getCustomerByEmail method in Customers model

				if ($customer_data['email'] !== $email) {																// check if customer data is available send customer email and customer security question to view
					
					$this->session->set_flashdata('alert', $this->lang->line('text_no_email'));

				} else if ($customer_data['security_question_id'] !== $security_question_id) {
					
					$this->session->set_flashdata('alert', $this->lang->line('text_no_s_answer'));
				
				} else if ($customer_data['security_answer'] !== $security_answer) {
					
					$this->session->set_flashdata('alert', $this->lang->line('text_no_s_answer'));

				} else {

					$customer_id 			= $customer_data['customer_id'];
					//$security_question_id 	= $customer_data['security_question_id'];
		
					$reset_password = $this->Customers_model->resetPassword($customer_id, $email, $security_question_id, $security_answer); // invoke reset password method in Customers model using customer id, email and security answer
				
				}
				
				if ($reset_password) {													// checks if password reset was sucessful then display success message and delete customer_id_to_reset from session userdata
					$this->session->set_flashdata('alert', $this->lang->line('text_reset_success'));
					redirect('account/login');		
				}		

				redirect('main/password_reset');												// redirect to password reset page
			}
		}
	}
	
	/*public function _checkEmail() {
						
		if ($this->input->post('submit') === 'Check Email') {
			
			//validate form
  		
  			if ($this->form_validation->run() === TRUE) {
  		
				$customer_data = $this->Customers_model->getCustomersByEmail($email);

				if ($customer_data) {	

					$this->session->set_flashdata('customer_id', $customer_data['customer_id']);
					$this->session->set_flashdata('customer_email', $customer_data['email']);
					$this->session->set_flashdata('security_question_id', $customer_data['security_question_id']);
  				
				} else {
				
					$this->session->set_flashdata('alert', 'No Matching Email Address');

  				}
  			
				redirect('main/password_reset');	
			}
		}
	}*/

	public function _resetPassword() {
		
		//validate form
		$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');
		$this->form_validation->set_rules('security_question', 'Security Question', 'trim|required|integer');
		$this->form_validation->set_rules('security_answer', 'Security Answer', 'trim|required');
		$this->form_validation->set_rules('new_password', 'New Password', 'trim|required|min_length[6]|max_length[32]|matches[confirm_new_password]|md5');
		$this->form_validation->set_rules('confirm_new_password', 'Confirm New Password', 'trim|required');
	
  		if ($this->form_validation->run() === TRUE) {
			
			//$customer_id = $this->session->flashdata('customer_id');
			$email = $this->input->post('email');
			$security_question = $this->input->post('security_question');
			$security_answer = $this->input->post('security_answer');
			$password = $this->input->post('new_password');
			
			$customer_data = $this->Customers_model->getCustomersByEmail($email);

			if (!$customer_data) {				
				$this->session->set_flashdata('alert', 'No Matching Email Address');
			}
			
			if ($customer_data['security_question_id'] !== $security_question) {
				$this->session->set_flashdata('alert', 'Security Question Does Not Match');
			}
			
			if ($customer_data['security_answer'] !== $security_answer) {
				$this->session->set_flashdata('alert', 'Security Answer Does Not Match');
			}

			$reset_password = $this->Customers_model->resetPassword($customer_data['customer_id'], $email, $security_question, $security_answer, $password);
			
			if ($reset_password) {
				$this->session->set_flashdata('alert', 'Password Reset Successfully');
				
  				redirect('account/login');
			}
		
			redirect('main/password_reset');
		}
	}
}

/* End of file password_reset.php */
/* Location: ./application/controllers/password_reset.php */