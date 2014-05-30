<?php
class Logout extends CI_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
	}

	public function index() {
		
		$this->user->logout();
		$this->session->set_flashdata('alert', '<p class="success">You are now logged out.</p>');
		redirect('admin/login');
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		$this->template->setTitle('Logged Out');
		$this->template->setHeading('Logged Out');

		$this->template->regions(array('header', 'footer'));
		if (file_exists(APPPATH .'views/themes/admin/'.$this->config->item('admin_theme').'logout.php')) {
			$this->template->render('themes/admin/'.$this->config->item('admin_theme'), 'logout', $data);
		} else {
			$this->template->render('themes/admin/default/', 'logout', $data);
		}
	}
}

/* End of file logout.php */
/* Location: ./application/controllers/admin/logout.php */