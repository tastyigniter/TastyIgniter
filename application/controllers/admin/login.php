<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Login extends CI_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
		//$this->load->model('Admin_model');
	}

	public function index() {
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		$this->template->setTitle('Login');

		if ($this->user->islogged()) {  
  			redirect(ADMIN_URI.'/dashboard');
		}

		if ($this->input->post() AND $this->validateForm() === TRUE) {
			redirect(ADMIN_URI.'/dashboard');
		}
		
		$this->template->regions(array('header', 'footer'));
		if (file_exists(APPPATH .'views/themes/'.ADMIN_URI.'/'.$this->config->item('admin_theme').'login.php')) {
			$this->template->render('themes/'.ADMIN_URI.'/'.$this->config->item('admin_theme'), 'login', $data);
		} else {
			$this->template->render('themes/'.ADMIN_URI.'/default/', 'login', $data);
		}
	}

	public function validateForm() {
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
}

/* End of file login.php */
/* Location: ./application/controllers/admin/login.php */