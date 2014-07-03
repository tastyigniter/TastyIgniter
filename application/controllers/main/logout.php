<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Logout extends MX_Controller {

	public function index() {
		$this->load->library('customer');
		$this->load->library('language');
		$this->lang->load('main/login_register', $this->language->folder());

		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		$this->template->setTitle($this->lang->line('text_logout_heading'));
		$this->template->setHeading($this->lang->line('text_logout_heading'));
		$data['text_logout_msg'] 		= sprintf($this->lang->line('text_logout_msg'), site_url('main/login'));

		$this->customer->logout();
		
		$this->template->regions(array('header', 'footer'));
		if (file_exists(APPPATH .'views/themes/main/'.$this->config->item('main_theme').'logout.php')) {
			$this->template->render('themes/main/'.$this->config->item('main_theme'), 'logout', $data);
		} else {
			$this->template->render('themes/main/default/', 'logout', $data);
		}
	}
}

/* End of file logout.php */
/* Location: ./application/controllers/logout.php */