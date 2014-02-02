<?php
class Permission extends CI_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
	}

	public function index() {
		
		if ( !file_exists(APPPATH .'/views/admin/permission.php')) { //check if file exists in views folder
			show_404(); // Whoops, show 404 error page!
		}

		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		$data['heading'] = 'Permission'; 

		$this->load->view('admin/header', $data);
		$this->load->view('admin/permission', $data);
		$this->load->view('admin/footer');
	}
}