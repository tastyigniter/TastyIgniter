<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Account_module extends Main_Controller {

	public function __construct() {
		parent::__construct(); 																	// calls the constructor

        $this->load->library('customer');  														// loads language file

        $this->lang->load('account_module/account_module');
	}

	public function index() {
		if ( ! file_exists(EXTPATH .'account_module/views/account_module.php')) { 								//check if file exists in views folder
			show_404(); 																		// Whoops, show 404 error page!
		}

		if ($this->uri->rsegment(1)) {
			$data['page'] = $this->uri->rsegment(1, FALSE);
		} else {
			$data['page'] = 'account';
		}

		$this->load->model('Messages_model');													// load the customers model
        $data['inbox_total'] = $this->Messages_model->getUnreadCount($this->customer->getId());					// retrieve total number of customer messages from getUnreadCount method in Messages model

		// pass array $data and load view files
		return $this->load->view('account_module/account_module', $data, TRUE);
	}
}

/* End of file account_module.php */
/* Location: ./extensions/account_module/controllers/account_module.php */