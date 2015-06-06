<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Logout extends Main_Controller {

	public function index() {
		$this->load->library('customer');
        $this->load->model('Pages_model');
		$this->lang->load('account/login_register');

		$this->template->setBreadcrumb('<i class="fa fa-home"></i>', '/');
		$this->template->setBreadcrumb($this->lang->line('text_heading'), 'account/logout');

		$this->template->setTitle($this->lang->line('text_logout_heading'));
		//$this->template->setHeading($this->lang->line('text_logout_heading'));
		$data['text_logout_msg'] 		= sprintf($this->lang->line('text_logout_msg'), site_url('account/login'));

        log_activity($this->customer->getId(), 'logged out', 'customers', get_activity_message('activity_logged_out',
            array('{customer}', '{link}'),
            array($this->customer->getName(), admin_url('customers/edit?id='.$this->customer->getId()))
        ));

        $this->customer->logout();

        $this->template->setPartials(array('header', 'footer'));
		$this->template->render('account/logout', $data);
	}
}

/* End of file logout.php */
/* Location: ./main/controllers/logout.php */