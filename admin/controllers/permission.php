<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Permission extends Admin_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
	}

	public function index() {
		if (!$this->user->islogged()) {
  			redirect('login');
		}

		if (!$this->alert->get()) {
			$this->alert->warning_now('You do not have the right permission to access.');
		}

		$this->template->setTitle('Permission');
		$this->template->setHeading('Permission');

		$this->template->setPartials(array('header', 'footer'));
		$this->template->render('permission');
	}
}

/* End of file permission.php */
/* Location: ./admin/controllers/permission.php */