<?php if (!defined('BASEPATH')) exit('No direct access allowed');

class Register extends Main_Controller
{
	var $recaptcha_error = '';

	public function __construct() {
		parent::__construct();                                                                    //  calls the constructor

		if ($this->customer->islogged()) {                                                        // checks if customer is logged in then redirect to account page.
			redirect('account/account');
		}

		$this->load->model('Pages_model');
		$this->lang->load('account/login_register');
	}

	public function index() {
		if ($this->input->post() AND $this->_addCustomer() === TRUE) {                            // checks if $_POST data is set and if registration validation was successful
			$this->alert->set('alert', $this->lang->line('alert_account_created'));    // display success message and redirect to account login page

			if ($redirect_url = $this->input->get('redirect')) {
				redirect($redirect_url);
			}

			redirect('account/login');
		}

		$this->template->setTitle($this->lang->line('text_register_heading'));

		$data['login_url'] = $this->pageUrl('account/login');

		if ($this->config->item('registration_terms') > 0) {
			$data['registration_terms'] = str_replace(root_url(), '/', $this->pageUrl('pages?popup=1&page_id=' . $this->config->item('registration_terms')));
		} else {
			$data['registration_terms'] = FALSE;
		}

		$this->load->model('Security_questions_model');                                            // load the security questions model
		$data['questions'] = $this->Security_questions_model->dropdown('text');                                // retrieve array of security questions from getQuestions method in Security questions model

		$data['captcha'] = $this->createCaptcha();

		$this->template->render('account/register', $data);
	}

	protected function _addCustomer() {
		$this->load->model('Customers_model');                                                    // load the customers model
		$this->load->model('Customer_groups_model');

		if ($this->validateForm() === TRUE) {
			// if successful CREATE an array with the following $_POST data values
			$add['first_name'] = $this->input->post('first_name');
			$add['last_name'] = $this->input->post('last_name');
			$add['email'] = $this->input->post('email');
			$add['password'] = $this->input->post('password');
			$add['telephone'] = $this->input->post('telephone');
			$add['security_question_id'] = $this->input->post('security_question');
			$add['security_answer'] = $this->input->post('security_answer');
			$add['newsletter'] = $this->input->post('newsletter');
			$add['terms_condition'] = $this->input->post('terms_condition');
			$add['customer_group_id'] = $this->config->item('customer_group_id');
			$add['date_added'] = mdate('%Y-%m-%d', time());

			$result = $this->Customer_groups_model->getCustomerGroup($this->config->item('customer_group_id'));
			if ($result['approval'] === '1') {
				$add['status'] = '0';
			} else {
				$add['status'] = '1';
			}

			if (!empty($add) AND $customer_id = $this->Customers_model->saveCustomer(NULL, $add)) {                                // pass add array data to saveCustomer method in Customers model then return TRUE
				log_activity($customer_id, 'registered', 'customers', get_activity_message('activity_registered_account',
					array('{customer}', '{link}'),
					array($this->input->post('first_name') . ' ' . $this->input->post('last_name'), admin_url('customers/edit?id=' . $customer_id))
				));

				return TRUE;
			}
		}
	}

	protected function validateForm() {
		// START of form validation rules
		$rules[] = array('first_name', 'lang:label_first_name', 'xss_clean|trim|required|min_length[2]|max_length[32]');
		$rules[] = array('last_name', 'lang:label_last_name', 'xss_clean|trim|required|min_length[2]|max_length[32]');
		$rules[] = array('email', 'lang:label_email', 'xss_clean|trim|required|valid_email|is_unique[customers.email]');
		$rules[] = array('password', 'lang:label_password', 'xss_clean|trim|required|min_length[6]|max_length[32]|matches[password_confirm]');
		$rules[] = array('password_confirm', 'lang:label_password_confirm', 'xss_clean|trim|required');
		$rules[] = array('telephone', 'lang:label_telephone', 'xss_clean|trim|required|integer');
		$rules[] = array('security_question', 'lang:label_s_question', 'xss_clean|trim|required|integer');
		$rules[] = array('security_answer', 'lang:label_s_answer', 'xss_clean|trim|required|min_length[2]');
		$rules[] = array('newsletter', 'lang:label_subscribe', 'xss_clean|trim|integer');
		$rules[] = array('captcha', 'lang:label_captcha', 'xss_clean|trim|required|callback__validate_captcha');

		if ($this->config->item('registration_terms') === '1') {
			$rules[] = array('terms_condition', 'lang:label_i_agree', 'xss_clean|trim|integer|required');
		}

		// END of form validation rules

		return $this->Customers_model->set_rules($rules)->validate();
	}

	public function _validate_captcha($word) {
		$session_caption = $this->session->tempdata('captcha');

		if (strtolower($word) !== strtolower($session_caption['word'])) {
			$this->form_validation->set_message('_validate_captcha', $this->lang->line('error_captcha'));

			return FALSE;
		} else {
			return TRUE;
		}
	}

	protected function createCaptcha() {
		$this->load->helper('captcha');

		$captcha = create_captcha();
		$this->session->set_tempdata('captcha', array('word' => $captcha['word'], 'image' => $captcha['time'] . '.jpg'), '120'); //set data to session for compare
		return $captcha;
	}
}

/* End of file Register.php */
/* Location: ./main/controllers/Register.php */