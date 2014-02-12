<?php

class Details extends MX_Controller {

	public function __construct() {
		parent::__construct(); 																	//  calls the constructor
		$this->load->library('customer'); 													// load the customer library
		$this->load->model('Customers_model');													// load the customers model
		$this->load->model('Security_questions_model');											// load the security questions model
	}

	public function index() {
		$this->lang->load('main/details');  													// loads language file
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  								// retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		if (!$this->customer->isLogged()) {  													// if customer is not logged in redirect to account login page
  			redirect('account/login');
		}

		$this->load->model('Messages_model');													// load the customers model
		$inbox_total = $this->Messages_model->getMainInboxTotal();					// retrieve total number of customer messages from getMainInboxTotal method in Messages model

		// START of retrieving lines from language file to pass to view.
		$data['text_heading'] 			= $this->lang->line('text_heading');
		$data['text_details'] 			= $this->lang->line('text_details');
		$data['text_password'] 			= $this->lang->line('text_password');
		$data['text_select'] 			= $this->lang->line('text_select');
		$data['entry_first_name'] 		= $this->lang->line('entry_first_name');
		$data['entry_last_name'] 		= $this->lang->line('entry_last_name');
		$data['entry_email'] 			= $this->lang->line('entry_email');
		$data['entry_password'] 		= $this->lang->line('entry_password');
		$data['entry_password_confirm'] = $this->lang->line('entry_password_confirm');
		$data['entry_old_password'] 	= $this->lang->line('entry_old_password');
		$data['entry_telephone'] 		= $this->lang->line('entry_telephone');
		$data['entry_s_question'] 		= $this->lang->line('entry_s_question');
		$data['entry_s_answer'] 		= $this->lang->line('entry_s_answer');
		$data['button_back'] 			= $this->lang->line('button_back');
		$data['button_save'] 			= $this->lang->line('button_save');
		// END of retrieving lines from language file to pass to view.

		$data['back'] 					= $this->config->site_url('account');

		$result = $this->Customers_model->getCustomer($this->customer->getId());				// retrieve customer data based on customer id from getCustomer method in Customers model
		if ($result) {		
			$data['first_name'] 		= $result['first_name'];
			$data['last_name'] 			= $result['last_name'];
			$data['email'] 				= $result['email'];
			$data['telephone'] 			= $result['telephone'];
			$data['security_question'] 	= $result['security_question_id'];
			$data['security_answer'] 	= $result['security_answer'];
		}

		$data['questions'] = array();
		$results = $this->Security_questions_model->getQuestions();						// retrieve security questions from getQuestions in Security questions model
		foreach ($results as $result) {
			$data['questions'][] = array(														// create array of security questions to pass to view
				'id'	=> $result['question_id'],
				'text'	=> $result['question_text']
			);
		}
		

		// check if $_POST is set and if update details validation was successful then redirect
		if ($this->input->post() && $this->_updateDetails() === TRUE) {
						
			redirect('account');
		}

		$regions = array(
			'main/header',
			'main/content_left',
			'main/footer'
		);
		
		$this->template->regions($regions);
		$this->template->load('main/details', $data);
	}

	public function _updateDetails() {															// method to validate update details form fields

		// START of form validation rules
		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|min_length[2]|max_length[12]');
		$this->form_validation->set_rules('last_name', 'First Name', 'trim|required|min_length[2]|max_length[12]');
		$this->form_validation->set_rules('telephone', 'Telephone', 'trim|required|integer');
		$this->form_validation->set_rules('security_question', 'Security Question', 'required');
		$this->form_validation->set_rules('security_answer', 'Security Answer', 'required');

		if ($this->input->post('old_password')) {
			$this->form_validation->set_rules('old_password', 'Old Password', 'trim|required|min_length[6]|max_length[32]|callback_check_old_password');
			$this->form_validation->set_rules('new_password', 'New Password', 'trim|required|min_length[6]|max_length[32]|matches[confirm_new_password]');
			$this->form_validation->set_rules('confirm_new_password', 'Confirm New Password', 'trim|required');
		}
		// END of form validation rules
			
  		if ($this->form_validation->run() === TRUE) {											// checks if form validation routines ran successfully
			$update = array();
				
			if ($this->customer->getId()) {  
				$update['customer_id'] = $this->customer->getId();										// retrieve customer id from customer library
			}
 			
			// START: retrieve $_POST data if $_POST data is not same as existing customer library data
 			if ($this->input->post('first_name') !== $this->customer->getFirstName()) {
				$update['first_name'] = $this->input->post('first_name');
			}			 	

 			if ($this->input->post('last_name') !== $this->customer->getLastName()) {
				$update['last_name'] = $this->input->post('last_name');
			}			 	
					
 			if ($this->input->post('telephone') !== $this->customer->getTelephone()) {
				$update['telephone'] = $this->input->post('telephone');
			}			 	

 			if ($this->input->post('security_question') !== $this->customer->getSecurityQuestionId()) {
				$update['security_question_id'] = $this->input->post('security_question');
			}			 	

 			if ($this->input->post('security_answer') !== $this->customer->getSecurityAnswer()) {
				$update['security_answer'] = $this->input->post('security_answer');
			}			 	

 			if ($this->input->post('new_password') && !$this->customer->checkPassword($this->input->post('new_password'))) {
				$update['password'] = $this->input->post('new_password');
			}			 	
			// END: retrieve $_POST data if $_POST data is not same as existing customer library data

			if (!empty($update)) {																// if update array is not empty then update customer details and display success message
				if ($this->Customers_model->updateCustomer($update)) {
					$this->session->set_flashdata('alert', $this->lang->line('success_updated'));
				}
	
				return TRUE;
						
			} else {																			// else nothing was updated so display warning message
				$this->session->set_flashdata('alert', $this->lang->line('error_nothing'));
	
				return TRUE;
			}
		}
	}

 	public function validate_email($email) {													// validation callback function to check if email already exist in database
		if ($this->Customers_model->getCustomerByEmail($email)) {
        	$this->form_validation->set_message('validate_email', $this->lang->line('error_email'));
      		return FALSE;
    	} else {
        	return TRUE;        
      	}
	}
	
 	public function check_old_password($pwd) {													// validation callback function to check if old password is valid
      		
		if (!$this->customer->checkPassword($pwd)) {									
        	$this->form_validation->set_message('check_old_password', $this->lang->line('error_password'));
      		return FALSE;
    	} else {
        	return TRUE;        
      	}
    }
}
