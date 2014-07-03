<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Logout extends CI_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
	}

	public function index() {
		$this->user->logout();
		$this->session->set_flashdata('alert', '<p class="alert-success">You are now logged out.</p>');
		redirect(ADMIN_URI.'/login');
	}
}

/* End of file logout.php */
/* Location: ./application/controllers/admin/logout.php */