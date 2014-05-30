<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends MX_Controller {

	public function __construct() {
		parent::__construct(); 																	//  calls the constructor
		$this->load->library('language');
		$this->lang->load('main/login_register', $this->language->folder());
	}

	public function index() {
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  								// retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		// START of retrieving lines from language file to pass to view.
		$this->template->setTitle($this->lang->line('text_heading'));
		$this->template->setHeading($this->lang->line('text_heading'));
		$data['text_login_register'] 		= $this->lang->line('text_login_register');
		$data['text_login'] 				= $this->lang->line('text_login');
		$data['text_register'] 				= $this->lang->line('text_register');
		$data['text_required'] 				= $this->lang->line('text_required');
		$data['entry_first_name'] 			= $this->lang->line('entry_first_name');
		$data['entry_last_name'] 			= $this->lang->line('entry_last_name');
		$data['entry_email'] 				= $this->lang->line('entry_email');
		$data['entry_password'] 			= $this->lang->line('entry_password');
		$data['entry_password_confirm'] 	= $this->lang->line('entry_password_confirm');
		$data['entry_telephone'] 			= $this->lang->line('entry_telephone');
		$data['entry_s_question'] 			= $this->lang->line('entry_s_question');
		$data['entry_s_answer'] 			= $this->lang->line('entry_s_answer');
		$data['entry_newsletter'] 			= $this->lang->line('entry_newsletter');
		$data['button_register'] 			= $this->lang->line('button_register');
		// END of retrieving lines from language file to send to view.
		
		$this->load->model('Security_questions_model');											// load the security questions model
		$data['questions'] = array();
		$results = $this->Security_questions_model->getQuestions();								// retrieve array of security questions from getQuestions method in Security questions model
		foreach ($results as $result) {															// loop through security questions array
			$data['questions'][] = array(														// create an array of security questions to pass to view
				'id'	=> $result['question_id'],
				'text'	=> $result['text']
			);
		}

		if ($this->input->post() AND $this->_addCustomer() === TRUE) {							// checks if $_POST data is set and if registration validation was successful
			$this->session->set_flashdata('alert', $this->lang->line('text_account_created'));	// display success message and redirect to account login page
			redirect('account/login');
		}
		
		$this->template->regions(array('header', 'footer'));
		if (file_exists(APPPATH .'views/themes/main/'.$this->config->item('main_theme').'register.php')) {
			$this->template->render('themes/main/'.$this->config->item('main_theme'), 'register', $data);
		} else {
			$this->template->render('themes/main/default/', 'register', $data);
		}
	}

	public function _addCustomer() {
		if ($this->validateForm() === TRUE) {			
  			$add = array();
  			
  			// if successful CREATE an array with the following $_POST data values
			$add['first_name'] 				= $this->input->post('first_name');
			$add['last_name'] 				= $this->input->post('last_name');
			$add['email'] 					= $this->input->post('email');
			$add['password'] 				= $this->input->post('password');
			$add['telephone'] 				= $this->input->post('telephone');
			$add['security_question_id']	= $this->input->post('security_question');
			$add['security_answer'] 		= $this->input->post('security_answer');
			$add['newsletter'] 				= $this->input->post('newsletter');
			$add['customer_group_id'] 		= $this->config->item('customer_group_id');
			$add['date_added'] 				= mdate('%Y-%m-%d', time());

			$this->load->model('Customers_model');													// load the customers model
			$this->load->model('Customer_groups_model');
			$result = $this->Customer_groups_model->getCustomerGroup($this->config->item('customer_group_id'));
			if ($result['approval'] === '1') {
				$add['status'] = '0';
			} else {				
				$add['status'] = '1';
			}

			if (!empty($add)) {																	// checks if add array is not empty
				$this->Customers_model->addCustomer($add);										// pass add array data to addCustomer method in Customers model then return TRUE
  				return TRUE;		
			}
		}
	}

	public function validateForm() {
		// START of form validation rules
		$this->form_validation->set_rules('first_name', 'First Name', 'xss_clean|trim|required|min_length[2]|max_length[12]');
		$this->form_validation->set_rules('last_name', 'First Name', 'xss_clean|trim|required|min_length[2]|max_length[12]');
		$this->form_validation->set_rules('email', 'Email Address', 'xss_clean|trim|required|valid_email|is_unique[customers.email]');
		$this->form_validation->set_rules('password', 'Password', 'xss_clean|trim|required|min_length[6]|max_length[32]|matches[password_confirm]');
		$this->form_validation->set_rules('password_confirm', 'Password Confirm', 'xss_clean|trim|required');
		$this->form_validation->set_rules('telephone', 'Telephone', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('security_question', 'Security Question', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('security_answer', 'Security Answer', 'xss_clean|trim|required|min_length[2]');
		$this->form_validation->set_rules('newsletter', 'Newsletter', 'xss_clean|trim|integer');
		// END of form validation rules

  		if ($this->form_validation->run() === TRUE) {											// checks if form validation routines ran successfully
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

/* End of file register.php */
/* Location: ./application/controllers/main/register.php */