<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Logout extends Main_Controller {

	public function index() {
        $this->load->model('Pages_model');
		$this->lang->load('account/login_register');

		$this->template->setBreadcrumb('<i class="fa fa-home"></i>', '/');
		$this->template->setBreadcrumb($this->lang->line('text_heading'), 'account/logout');

		$this->template->setTitle($this->lang->line('text_logout_heading'));

		$this->alert->set('success', $this->lang->line('alert_logout_success'));

        log_activity($this->customer->getId(), 'logged out', 'customers', get_activity_message('activity_logged_out',
            array('{customer}', '{link}'),
            array($this->customer->getName(), admin_url('customers/edit?id='.$this->customer->getId()))
        ));

        $this->customer->logout();

		if ($redirect_url = $this->input->get('redirect')) {
			redirect($redirect_url);
		}

		redirect('account/login');
	}
}

/* End of file logout.php */
/* Location: ./main/controllers/logout.php */