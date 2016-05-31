<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Account_module extends Main_Controller {

	public function index($module = array()) {
		$this->lang->load('account_module/account_module');

		if ( ! file_exists(EXTPATH .'account_module/views/account_module.php')) { 								//check if file exists in views folder
			show_404(); 																		// Whoops, show 404 error page!
		}

		$ext_data = (!empty($module['data'])) ? $module['data'] : array();

		if ($this->uri->rsegment(1)) {
			$data['page'] = $this->uri->rsegment(1, FALSE);
		} else {
			$data['page'] = 'account';
		}

		$data['heading'] = (!empty($ext_data['heading'])) ? $ext_data['heading'] : $this->lang->line('text_heading');

		$this->load->model('Messages_model');													// load the customers model
        $data['inbox_total'] = $this->Messages_model->getUnreadCount($this->customer->getId());					// retrieve total number of customer messages from getUnreadCount method in Messages model

		// pass array $data and load view files
		return $this->load->view('account_module/account_module', $data, TRUE);
	}
}

/* End of file account_module.php */
/* Location: ./extensions/account_module/controllers/account_module.php */