<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Logout extends Admin_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
	}

	public function index() {
		$this->user->logout();
		$this->alert->set('success', 'You are now logged out.');
		redirect('login');
	}
}

/* End of file logout.php */
/* Location: ./admin/controllers/logout.php */