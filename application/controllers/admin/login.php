<?php
class Login extends CI_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
		//$this->load->model('Admin_model');
	}

	public function index() {

		if (!file_exists(APPPATH .'views/admin/login.php')) {
			show_404();
		}
			
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		$data['heading'] = 'Adminstrator Login'; 
		
		if ($this->user->islogged()) {  
  			redirect('admin/dashboard');
		}

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
		
		$regions = array(
			'admin/header',
			'admin/footer'
		);
		
		$this->template->regions($regions);
		$this->template->load('admin/login', $data);
	}
}