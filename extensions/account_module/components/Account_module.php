<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Account_module extends Base_Component {

	public function index() {
		$this->lang->load('account_module/account_module');

		if ($this->uri->rsegment(1)) {
			$data['page'] = $this->uri->rsegment(1, FALSE);
		} else {
			$data['page'] = 'account';
		}

		$data['heading'] = $this->setting('heading', $this->lang->line('text_heading'));

		$this->load->model('Messages_model');													// load the customers model
        $total = $this->Messages_model->getUnreadCount($this->customer->getId());					// retrieve total number of customer messages from getUnreadCount method in Messages model
		$data['inbox_total'] = ($total < 1) ? '' : $total;
		
		// pass array $data and load view files
		return $this->load->view('account_module/account_module', $data, TRUE);
	}
}

/* End of file Account_module.php */
/* Location: ./extensions/account_module/components/Account_module.php */