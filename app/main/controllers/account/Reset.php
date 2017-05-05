<?php if (!defined('BASEPATH')) exit('No direct access allowed');

class Reset extends Main_Controller
{

	public function __construct()
	{
		parent::__construct();                                                                    // calls the constructor

		if ($this->customer->islogged()) {                                                        // checks if customer is logged in then redirect to account page.
			$this->redirect('account/account');
		}

		$this->load->model('Customers_model');                                                    // load the customers model
		$this->load->model('Security_questions_model');                                            // load the security questions model

		$this->lang->load('account/reset');
	}

	public function index()
	{
		$this->template->setTitle($this->lang->line('text_heading'));

		$data['login_url'] = $this->pageUrl('account/login');
        $data['reset_code'] = $this->input->get_post('code');

		$data['questions'] = [];
		$results = $this->Security_questions_model->getQuestions();                        // retrieve array of security questions from getQuestions method in Security questions model
		foreach ($results as $result) {                                                            // loop through security questions array
			$data['questions'][] = [                                                        // create an array of security questions to pass to view
				'id'   => $result['question_id'],
				'text' => $result['text'],
			];
		}

		if ($this->input->post() AND $this->_resetPassword() === TRUE) {
			$this->redirect(empty($data['reset_code']) ? 'account/reset' : 'account/login');
		}

		$this->template->render('account/reset', $data);
	}

	protected function _resetPassword()
	{                                                            // method to validate password reset
		if ($this->validateForm() === TRUE) {
            if ($this->input->get_post('code')) {
                $credentials = [
                    'reset_code' => $this->input->get_post('code'),
                    'password'   => $this->input->post('password'),
                ];

                if ($this->customer->validateResetPassword($credentials)) {
                    $this->customer->completeResetPassword($credentials);
                    $this->alert->set('alert', $this->lang->line('alert_reset_success'));

                    return TRUE;
                }

                $error = $this->lang->line('alert_failed_reset');

            } else {
                $email = strtolower($this->input->post('email'));

                if ($this->Customers_model->resetPassword($email)) { // invoke reset password method in Customers model using customer id, email and security answer
                    // checks if password reset was sucessful then display success message and delete customer_id_to_reset from session userdata
                    $this->alert->set('alert', $this->lang->line('alert_reset_request_success'));

                    return TRUE;
                }

                $error = $this->lang->line('alert_reset_error');
            }

            $this->alert->set('alert', $error);
            $this->redirect(current_url());
        }
	}

	protected function validateForm()
	{
        if ($this->input->get_post('code')) {
            $this->form_validation->set_rules('password', 'lang:label_password', 'xss_clean|trim|required|min_length[6]|max_length[32]|matches[password_confirm]');
            $this->form_validation->set_rules('password_confirm', 'lang:label_password_confirm', 'xss_clean|trim|required');
        } else {
            $this->form_validation->set_rules('email', 'lang:label_email', 'xss_clean|trim|required|valid_email');
        }

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

/* End of file Reset.php */
/* Location: ./main/controllers/Reset.php */