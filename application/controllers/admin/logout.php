<?php
class Logout extends CI_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
	}

	public function index() {
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		$data['heading'] = 'Logged Out'; 

		$this->user->logout();
		
		$regions = array(
			'admin/header',
			'admin/footer'
		);
		
		$this->template->regions($regions);
		$this->template->load('admin/logout', $data);
	}
}