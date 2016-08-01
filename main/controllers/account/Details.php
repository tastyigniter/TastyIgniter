<?php if (!defined('BASEPATH')) exit('No direct access allowed');

class Details extends Main_Controller
{

	public function __construct() {
		parent::__construct();                                                                    //  calls the constructor

		if (!$this->customer->isLogged()) {                                                    // if customer is not logged in redirect to account login page
			$this->redirect('account/login');
		}

		$this->load->model('Customers_model');
		$this->load->model('Security_questions_model');                                            // load the security questions model

		$this->lang->load('account/details');
	}

	public function index() {
		$this->template->setBreadcrumb('<i class="fa fa-home"></i>', '/');
		$this->template->setBreadcrumb($this->lang->line('text_my_account'), 'account/account');
		$this->template->setBreadcrumb($this->lang->line('text_heading'), 'account/details');

		$this->template->setTitle($this->lang->line('text_heading'));
		$this->template->setHeading($this->lang->line('text_heading'));

		$data['back_url'] = site_url('account/account');

		$result = $this->Customers_model->getCustomer($this->customer->getId());                // retrieve customer data based on customer id from getCustomer method in Customers model
		if ($result) {
			$data['first_name'] = $result['first_name'];
			$data['last_name'] = $result['last_name'];
			$data['email'] = $result['email'];
			$data['telephone'] = $result['telephone'];
			$data['security_question'] = $result['security_question_id'];
			$data['security_answer'] = $result['security_answer'];
			$data['newsletter'] = $result['newsletter'];
		}

		$data['questions'] = $this->Security_questions_model->dropdown('text');                        // retrieve security questions from getQuestions in Security questions model

		// check if $_POST is set and if update details validation was successful then redirect
		if ($this->input->post() AND $this->_updateDetails() === TRUE) {
			$this->redirect('account/details');
		}

		$this->template->render('account/details', $data);
	}

	protected function _updateDetails() {                                                            // method to validate update details form fields
		if ($this->validateForm() === TRUE) {
			$update = array();

			// START: retrieve $_POST data if $_POST data is not same as existing customer library data
			$update['first_name'] = $this->input->post('first_name');
			$update['last_name'] = $this->input->post('last_name');
			$update['telephone'] = $this->input->post('telephone');
			$update['security_question_id'] = $this->input->post('security_question_id');
			$update['security_answer'] = $this->input->post('security_answer');
			$update['password'] = $this->input->post('new_password');
			$update['newsletter'] = $this->input->post('newsletter');
			$update['status'] = '1';
			// END: retrieve $_POST data if $_POST data is not same as existing customer library data

			if (!empty($update)) {                                                                // if update array is not empty then update customer details and display success message
				if ($this->Customers_model->saveCustomer($this->customer->getId(), $update)) {
					log_activity($this->customer->getId(), 'updated', 'customers', get_activity_message('activity_updated_account',
						array('{customer}', '{link}'),
						array($this->customer->getName(), admin_url('customers/edit?id=' . $this->customer->getId()))
					));

					if (!empty($update['password'])) {
						log_activity($this->customer->getId(), 'updated', 'customers', get_activity_message('activity_changed_password',
							array('{customer}', '{link}'),
							array($this->customer->getName(), admin_url('customers/edit?id=' . $this->customer->getId()))
						));
					}

					$this->alert->set('alert', $this->lang->line('alert_updated_success'));
				}

				return TRUE;
			}
		}
	}

	protected function validateForm() {
		// START of form validation rules
		$rules[] = array('first_name', 'lang:label_first_name', 'xss_clean|trim|required|min_length[2]|max_length[32]');
		$rules[] = array('last_name', 'lang:label_last_name', 'xss_clean|trim|required|min_length[2]|max_length[32]');
		$rules[] = array('telephone', 'lang:label_telephone', 'xss_clean|trim|required|integer');
		$rules[] = array('security_question_id', 'lang:label_s_question', 'xss_clean|trim|required|integer');
		$rules[] = array('security_answer', 'lang:label_s_answer', 'xss_clean|trim|required|min_length[2]');

		if ($this->input->post('old_password')) {
			$rules[] = array('old_password', 'lang:label_old_password', 'xss_clean|trim|required|min_length[6]|max_length[32]|callback__check_old_password');
			$rules[] = array('new_password', 'lang:label_password', 'xss_clean|trim|required|min_length[6]|max_length[32]|matches[confirm_new_password]');
			$rules[] = array('confirm_new_password', 'lang:label_password_confirm', 'xss_clean|trim|required');
		}

		// END of form validation rules

		return $this->Customers_model->set_rules($rules)->validate();
	}

	public function _check_old_password($pwd) {                                                    // validation callback function to check if old password is valid

		if (!$this->customer->checkPassword($pwd)) {
			$this->form_validation->set_message('_check_old_password', $this->lang->line('error_password'));

			return FALSE;
		} else {
			return TRUE;
		}
	}
}

/* End of file Details.php */
/* Location: ./main/controllers/Details.php */