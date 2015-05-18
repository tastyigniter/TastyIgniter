<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Account_module extends Ext_Controller {

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
		$inbox_total = $this->Messages_model->getUnreadCount($this->customer->getId());					// retrieve total number of customer messages from getUnreadCount method in Messages model

		// START of retrieving lines from language file to pass to view.
		$data['text_heading'] 			= $this->lang->line('text_heading');
		$data['text_account'] 			= $this->lang->line('text_account');
		$data['text_edit_details'] 		= $this->lang->line('text_edit_details');
		$data['text_address'] 			= $this->lang->line('text_address');
		$data['text_orders'] 			= $this->lang->line('text_orders');
		$data['text_reservations'] 		= $this->lang->line('text_reservations');
		$data['text_reviews'] 			= $this->lang->line('text_reviews');
		$data['text_inbox'] 			= sprintf($this->lang->line('text_inbox'), $inbox_total);
		$data['text_logout'] 			= $this->lang->line('text_logout');

		// END of retrieving lines from language file to send to view.

		// pass array $data and load view files
		return $this->load->view('account_module/account_module', $data, TRUE);
	}
}

/* End of file account.php */
/* Location: ./extensions/account_module/controllers/account_module.php */