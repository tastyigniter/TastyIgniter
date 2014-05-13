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
		
		$regions = array('header', 'footer');
		if (file_exists(APPPATH .'views/themes/admin/'.$this->config->item('admin_theme').'logout.php')) {
			$this->template->render('themes/admin/'.$this->config->item('admin_theme'), 'logout', $regions, $data);
		} else {
			$this->template->render('themes/admin/default/', 'logout', $regions, $data);
		}
	}
}

/* End of file logout.php */
/* Location: ./application/controllers/admin/logout.php */