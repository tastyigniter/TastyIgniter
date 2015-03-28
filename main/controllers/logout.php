<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Logout extends Main_Controller {

	public function index() {
		$this->load->library('customer');
				$this->load->model('Pages_model');
		$this->lang->load('login_register');

		$this->template->setBreadcrumb('<i class="fa fa-home"></i>', '/');
		$this->template->setBreadcrumb($this->lang->line('text_heading'), 'logout');

		$this->template->setTitle($this->lang->line('text_logout_heading'));
		//$this->template->setHeading($this->lang->line('text_logout_heading'));
		$data['text_logout_msg'] 		= sprintf($this->lang->line('text_logout_msg'), site_url('login'));

		$this->customer->logout();

		$this->template->setPartials(array('header', 'footer'));
		$this->template->render('logout', $data);
	}
}

/* End of file logout.php */
/* Location: ./main/controllers/logout.php */