<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Login extends CI_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
	}

	public function index() {
		if ($this->user->islogged()) {  
  			redirect(ADMIN_URI.'/dashboard');
		}

		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		$this->template->setTitle('Login');
		$data['reset_url'] = site_url(ADMIN_URI.'/login/reset');
		
		if ($this->input->post() AND $this->validateLoginForm() === TRUE) {
			redirect(ADMIN_URI.'/dashboard');
		}
		
		$this->template->regions(array('header', 'footer'));
		if (file_exists(APPPATH .'views/themes/'.ADMIN_URI.'/'.$this->config->item('admin_theme').'login.php')) {
			$this->template->render('themes/'.ADMIN_URI.'/'.$this->config->item('admin_theme'), 'login', $data);
		} else {
			$this->template->render('themes/'.ADMIN_URI.'/default/', 'login', $data);
		}
	}

	public function reset() {
		$this->load->model('Staffs_model');
		if ($this->user->islogged()) {  
  			redirect(ADMIN_URI.'/dashboard');
		}

		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		$this->template->setTitle('Reset Password');
		$data['login_url'] = site_url(ADMIN_URI.'/login');

		if ($this->input->post() AND $this->validateResetForm() === TRUE) {
			redirect(ADMIN_URI.'/login');
		}
		
		$this->template->regions(array('header', 'footer'));
		if (file_exists(APPPATH .'views/themes/'.ADMIN_URI.'/'.$this->config->item('admin_theme').'login_reset.php')) {
			$this->template->render('themes/'.ADMIN_URI.'/'.$this->config->item('admin_theme'), 'login_reset', $data);
		} else {
			$this->template->render('themes/'.ADMIN_URI.'/default/', 'login_reset', $data);
		}
	}

	public function validateLoginForm() {
		// START of form validation rules
		$this->form_validation->set_rules('user', 'Username', 'xss_clean|trim|required');
		$this->form_validation->set_rules('password', 'Password', 'xss_clean|trim|required|min_length[6]|max_length[32]');
		// END of form validation rules

		if ($this->form_validation->run() === TRUE) {
			if (!$this->user->login($this->input->post('user'), $this->input->post('password'))) {										// checks if form validation routines ran successfully
				$this->session->set_flashdata('alert', '<p class="alert-danger">Username and Password not found!</p>');
				redirect(ADMIN_URI.'/login');
			} else {
				return TRUE;
			}
		}
	}

	public function validateResetForm() {
		$this->form_validation->set_rules('user_email', 'Username or Email', 'xss_clean|trim|required|callback_check_user');	//validate form
	
		if ($this->form_validation->run() === TRUE) {										// checks if form validation routines ran successfully
			if ($this->Staffs_model->resetPassword($this->input->post('user_email'))) {		// checks if form validation routines ran successfully
				$this->session->set_flashdata('alert', '<p class="alert-success">A new password will be e-mailed to you.</p>');
				return TRUE;
			} else {
				$this->session->set_flashdata('alert', '<p class="alert-danger">The e-mail could not be sent. Possible reason: your host may have disabled the mail() function.</p>');
				redirect(ADMIN_URI.'/login/reset');
			}
		} else {
			return FALSE;
		}
	}

	public function check_user($str) {
		if (empty($str)) {
			$this->form_validation->set_message('check_user', 'Enter a username or email address.');
			return FALSE;
		} else if (!$this->Staffs_model->resetPassword($str)) {
			$this->form_validation->set_message('check_user', 'There is no user registered with that email address.');
			return FALSE;
		}

		return TRUE;
	}
}

/* End of file login.php */
/* Location: ./application/controllers/admin/login.php */