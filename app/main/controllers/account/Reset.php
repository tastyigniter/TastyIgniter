<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Reset extends Main_Controller {

	public function __construct() {
		parent::__construct(); 																	// calls the constructor

        if ($this->customer->islogged()) { 														// checks if customer is logged in then redirect to account page.
            redirect('account/account');
        }

        $this->load->model('Customers_model');													// load the customers model
        $this->load->model('Security_questions_model');											// load the security questions model

		$this->lang->load('account/reset');
	}

	public function index() {
		$this->template->setTitle($this->lang->line('text_heading'));

		$data['login_url'] 				= site_url('account/login');

		$data['questions'] = array();
		$results = $this->Security_questions_model->getQuestions();						// retrieve array of security questions from getQuestions method in Security questions model
		foreach ($results as $result) {															// loop through security questions array
			$data['questions'][] = array(														// create an array of security questions to pass to view
				'id'	=> $result['question_id'],
				'text'	=> $result['text']
			);
		}

		if ($this->input->post() AND $this->_resetPassword() === TRUE) {
            redirect('account/login');
		}

		$this->template->render('account/reset', $data);
	}

	private function _resetPassword() {															// method to validate password reset
		if ($this->validateForm() === TRUE) {
            $reset['email'] 				= $this->input->post('email');
            $reset['security_question_id']	= $this->input->post('security_question');
            $reset['security_answer'] 		= $this->input->post('security_answer');

            if ($this->Customers_model->resetPassword($this->input->post('customer_id'), $reset)) { // invoke reset password method in Customers model using customer id, email and security answer
                // checks if password reset was sucessful then display success message and delete customer_id_to_reset from session userdata
                $this->alert->set('alert', $this->lang->line('alert_reset_success'));
                return TRUE;
            }

            $this->alert->set('alert', $this->lang->line('alert_reset_error'));
            redirect('account/reset');												// redirect to password reset page
		}
	}

	private function validateForm() {
		$this->form_validation->set_rules('email', 'lang:label_email', 'xss_clean|trim|required|valid_email|callback__check_reset');	//validate form
		$this->form_validation->set_rules('security_question', 'lang:label_s_question', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('security_answer', 'lang:label_s_answer', 'xss_clean|trim|required|min_length[2]');

		if ($this->form_validation->run() === TRUE) {										// checks if form validation routines ran successfully
            return TRUE;
        } else {
			return FALSE;
		}
	}

    public function _check_reset() {
        $customer_data = $this->Customers_model->getCustomerByEmail($this->input->post('email'));            // retrieve customer data based on $_POST email value from getCustomerByEmail method in Customers model
        if ($customer_data['email'] !== strtolower($this->input->post('email'))) {
            $this->form_validation->set_message('_check_reset', $this->lang->line('alert_no_email_match'));

            return FALSE;
        } else if ($customer_data['security_question_id'] !== $this->input->post('security_question')) {
            $this->form_validation->set_message('_check_reset', $this->lang->line('alert_no_s_question_match'));

            return FALSE;
        } else if ($customer_data['security_answer'] !== $this->input->post('security_answer')) {
            $this->form_validation->set_message('_check_reset', $this->lang->line('alert_no_s_answer_match'));

            return FALSE;
        } else {
            $_POST['customer_id'] = $customer_data['customer_id'];

            return TRUE;
        }
    }
}

/* End of file reset.php */
/* Location: ./main/controllers/reset.php */