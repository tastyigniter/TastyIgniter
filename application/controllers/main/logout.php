<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends MX_Controller {

	public function index() {
		$this->load->library('customer');
		$this->lang->load('main/login_register');  												// loads language file

		if (!file_exists(APPPATH .'views/main/logout.php')) {
			show_404();
		}
			
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		$data['text_heading'] 			= $this->lang->line('text_logout_heading');
		$data['text_logout_msg'] 		= sprintf($this->lang->line('text_logout_msg'), $this->config->site_url('account/login'));

		$this->customer->logout();
		
		$regions = array(
			'main/header',
			'main/footer'
		);
		
		$this->template->regions($regions);
		$this->template->load('main/logout', $data);
	}
}

/* End of file logout.php */
/* Location: ./application/controllers/logout.php */