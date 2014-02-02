<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account_module extends MX_Controller {

	public function index() {
		$this->output->enable_profiler(TRUE); // for debugging profiler... remove later
		$this->lang->load('main/account_module');  														// loads language file
		
		if ( !file_exists(APPPATH .'/extensions/main/views/account_module.php')) { 								//check if file exists in views folder
			show_404(); 																		// Whoops, show 404 error page!
		}
			
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  								// retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		if ($this->uri->segment(2)) {
			$data['page'] = $this->uri->segment(2, FALSE); 	
		} else {
			$data['page'] = 'account';			
		}

		$this->load->model('Messages_model');													// load the customers model
		$inbox_total = $this->Messages_model->getMainInboxTotal();					// retrieve total number of customer messages from getMainInboxTotal method in Messages model

		// START of retrieving lines from language file to pass to view.
		$data['text_order_now'] 		= $this->lang->line('text_order_now');
		$data['text_edit_details'] 		= $this->lang->line('text_edit_details');
		$data['text_address'] 			= $this->lang->line('text_address');
		$data['text_orders'] 			= $this->lang->line('text_orders');
		$data['text_reservations'] 		= $this->lang->line('text_reservations');
		$data['text_inbox'] 			= sprintf($this->lang->line('text_inbox'), $inbox_total);
		$data['text_logout'] 			= $this->lang->line('text_logout');

		// END of retrieving lines from language file to send to view.

		// pass array $data and load view files
		$this->load->view('main/account_module', $data);
	}		
}