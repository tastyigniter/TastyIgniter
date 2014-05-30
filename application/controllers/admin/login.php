<?php
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
  			redirect('admin/dashboard');
		}

		$this->validateForm();
		
		$this->template->regions(array('header', 'footer'));
		if (file_exists(APPPATH .'views/themes/admin/'.$this->config->item('admin_theme').'login.php')) {
			$this->template->render('themes/admin/'.$this->config->item('admin_theme'), 'login', $data);
		} else {
			$this->template->render('themes/admin/default/', 'login', $data);
		}
	}

	public function validateForm() {
		if (($this->input->post('user')) || ($this->input->post('password'))) {
			$user = $this->input->post('user');
			$password = $this->input->post('password');
		
			if (!$this->user->login($user, $password)) {
				$this->session->set_flashdata('alert', '<p class="error">Username and Password not found!</p>');
				redirect('admin/login');
			} else {
				redirect('admin/dashboard');
			}
		}
	}
}

/* End of file login.php */
/* Location: ./application/controllers/admin/login.php */