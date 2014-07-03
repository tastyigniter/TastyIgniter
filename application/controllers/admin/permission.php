<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Permission extends CI_Controller {

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

		$this->template->setTitle('Permission');
		$this->template->setHeading('Permission');

		$this->template->regions(array('header', 'footer'));
		if (file_exists(APPPATH .'views/themes/'.ADMIN_URI.'/'.$this->config->item('admin_theme').'permission.php')) {
			$this->template->render('themes/'.ADMIN_URI.'/'.$this->config->item('admin_theme'), 'permission', $data);
		} else {
			$this->template->render('themes/'.ADMIN_URI.'/default/', 'permission', $data);
		}
	}
}

/* End of file permission.php */
/* Location: ./application/controllers/admin/permission.php */