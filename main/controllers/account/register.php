<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Register extends Main_Controller {
	var $recaptcha_error = '';

	public function __construct() {
		parent::__construct(); 																	//  calls the constructor
				$this->load->model('Pages_model');
		$this->lang->load('account/login_register');
	}

	public function index() {
		if ($this->input->post() AND $this->_addCustomer() === TRUE) {							// checks if $_POST data is set and if registration validation was successful
			$this->alert->set('alert', $this->lang->line('alert_account_created'));	// display success message and redirect to account login page
			redirect('account/login');
		}

		$this->template->setBreadcrumb('<i class="fa fa-home"></i>', '/');
		$this->template->setBreadcrumb($this->lang->line('text_heading'), 'account/register');

		// START of retrieving lines from language file to pass to view.
		$this->template->setTitle($this->lang->line('text_register_heading'));
		//$this->template->setHeading($this->lang->line('text_register_heading'));
		$data['text_login_register']		= sprintf($this->lang->line('text_login_register'), site_url('account/login'));
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
		$data['entry_captcha'] 				= $this->lang->line('entry_captcha');
		$data['entry_newsletter'] 			= $this->lang->line('entry_newsletter');
		$data['entry_terms'] 				= $this->lang->line('entry_terms');
		$data['button_register'] 			= $this->lang->line('button_register');
		$data['button_login'] 				= $this->lang->line('button_login');
		// END of retrieving lines from language file to send to view.

		$data['login_url'] 				= site_url('account/login');
		$data['config_registration_terms'] 		= $this->config->item('registration_terms');

		$this->load->model('Security_questions_model');											// load the security questions model
		$data['questions'] = array();
		$results = $this->Security_questions_model->getQuestions();								// retrieve array of security questions from getQuestions method in Security questions model
		foreach ($results as $result) {															// loop through security questions array
			$data['questions'][] = array(														// create an array of security questions to pass to view
				'id'	=> $result['question_id'],
				'text'	=> $result['text']
			);
		}

		$data['captcha_image'] = $this->createCaptcha();

		$this->template->setPartials(array('header', 'footer'));
		$this->template->render('account/register', $data);
	}

	private function _addCustomer() {
		if ($this->validateForm() === TRUE) {
            $this->load->model('Customers_model');													// load the customers model
            $this->load->model('Customer_groups_model');

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
			$add['terms_condition'] 		= $this->input->post('terms_condition');
			$add['customer_group_id'] 		= $this->config->item('customer_group_id');
			$add['date_added'] 				= mdate('%Y-%m-%d', time());

			$result = $this->Customer_groups_model->getCustomerGroup($this->config->item('customer_group_id'));
			if ($result['approval'] === '1') {
				$add['status'] = '0';
			} else {
				$add['status'] = '1';
			}

			if (!empty($add) AND $this->Customers_model->saveCustomer(NULL, $add)) {								// pass add array data to saveCustomer method in Customers model then return TRUE
  				return TRUE;
			}
		}
	}

	private function validateForm() {
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
		$this->form_validation->set_rules('captcha', 'Captcha', 'xss_clean|trim|required|callback__validate_captcha');

		if ($this->config->item('registration_terms') === '1') {
			$this->form_validation->set_rules('terms_condition', 'Terms & Condition', 'xss_clean|trim|integer');
		}
		// END of form validation rules

  		if ($this->form_validation->run() === TRUE) {											// checks if form validation routines ran successfully
			return TRUE;
		} else {
			return FALSE;
		}
	}

    public function _validate_captcha($word) {
		$session_caption = $this->session->tempdata('captcha');

        if (empty($word) OR strtolower($word) !== strtolower($session_caption['word'])) {
            $this->form_validation->set_message('_validate_captcha', 'The letters you entered does not match the image.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

	private function createCaptcha() {
        $this->load->helper('captcha');

		$prefs = array(
            'img_path' 		=> './assets/images/thumbs/',
            'img_url' 		=> root_url() . '/assets/images/thumbs/',
			'font_path'     => './system/fonts/texb.ttf',
			'img_width'     => '150',
			'img_height'    => 30,
			'expiration'    => 300,
			'word_length'   => 8,
			'pool'          => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',

			// White background and border, black text and white grid
			'colors'        => array(
				'background' 	=> array(255, 255, 255),
				'border' 		=> array(255, 255, 255),
				'text' 			=> array(0, 0, 0),
				'grid' 			=> array(255, 255, 255)
			)
		);

        $captcha = create_captcha($prefs);
        $this->session->set_tempdata('captcha', array('word' => $captcha['word'], 'image' => $captcha['time'].'.jpg')); //set data to session for compare
        return $captcha['image'];
    }
}

/* End of file register.php */
/* Location: ./main/controllers//register.php */