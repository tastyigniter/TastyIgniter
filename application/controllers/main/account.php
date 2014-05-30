<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends MX_Controller {

	public function __construct() {
		parent::__construct(); 																	//  calls the constructor
		$this->load->library('customer'); 														// load the customer library
		$this->load->model('Customers_model');													// load the customers model
		$this->load->model('Security_questions_model');											// load the security questions model
		$this->load->library('cart'); 															// load the cart library
		$this->load->library('currency'); 														// load the currency library
		$this->load->library('country');

		$this->load->library('language');
		$this->lang->load('main/account', $this->language->folder());
	}

	public function index() {
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  								// retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		if (!$this->customer->isLogged()) {  													// if customer is not logged in redirect to account login page
  			redirect('account/login');
		}
		
		$this->load->model('Messages_model');													// load the customers model
		$inbox_total = $this->Messages_model->getMainInboxTotal();					// retrieve total number of customer messages from getMainInboxTotal method in Messages model

		// START of retrieving lines from language file to pass to view.
		$this->template->setTitle($this->lang->line('text_heading'));
		$this->template->setHeading($this->lang->line('text_heading'));
		$data['text_no_default_add'] 	= $this->lang->line('text_no_default_add');
		$data['text_no_cart_items'] 	= $this->lang->line('text_no_cart_items');
		$data['text_cart'] 				= $this->lang->line('text_cart');
		$data['text_checkout'] 			= $this->lang->line('text_checkout');
		$data['text_my_details'] 		= $this->lang->line('text_my_details');
		$data['text_default_address'] 	= $this->lang->line('text_default_address');
		$data['text_password'] 			= $this->lang->line('text_password');
		$data['text_orders'] 			= $this->lang->line('text_orders');
		$data['text_reservations'] 		= $this->lang->line('text_reservations');
		$data['text_inbox'] 			= sprintf($this->lang->line('text_inbox'), $inbox_total);
		$data['entry_first_name'] 		= $this->lang->line('entry_first_name');
		$data['entry_last_name'] 		= $this->lang->line('entry_last_name');
		$data['entry_email'] 			= $this->lang->line('entry_email');
		$data['entry_password'] 		= $this->lang->line('entry_password');
		$data['entry_password_confirm'] = $this->lang->line('entry_password_confirm');
		$data['entry_telephone'] 		= $this->lang->line('entry_telephone');
		$data['entry_s_question'] 		= $this->lang->line('entry_s_question');
		$data['entry_s_answer'] 		= $this->lang->line('entry_s_answer');
		$data['column_cart_items'] 		= $this->lang->line('column_cart_items');
		$data['column_cart_total'] 		= $this->lang->line('column_cart_total');
		$data['column_order_date'] 		= $this->lang->line('column_order_date');
		$data['column_order_id'] 		= $this->lang->line('column_order_id');
		$data['column_order_status'] 	= $this->lang->line('column_order_status');
		$data['column_resrv_date'] 		= $this->lang->line('column_resrv_date');
		$data['column_resrv_id'] 		= $this->lang->line('column_resrv_id');
		$data['column_resrv_status'] 	= $this->lang->line('column_resrv_status');
		$data['column_inbox_date'] 		= $this->lang->line('column_inbox_date');
		$data['column_subject'] 		= $this->lang->line('column_subject');
		$data['column_action'] 			= $this->lang->line('column_action');
		// END of retrieving lines from language file to send to view.

		$data['button_checkout'] 		= site_url('main/checkout');
		$data['password_url'] 			= site_url('main/details');
		$data['cart_items'] 			= $this->cart->total_items();
		$data['cart_total'] 			= $this->currency->format($this->cart->order_total());

		$result = $this->Customers_model->getCustomer($this->customer->getId());				// retrieve customer data based on customer id from getCustomer method in Customers model

		//store customer data in array
		$data['customer_info'] = array();

		$question_result = $this->Security_questions_model->getQuestion($result['security_question_id']); // retrieve security questions based on security question id
		
		$data['customer_info'] = array(
			'first_name' 		=> $result['first_name'],
			'last_name' 		=> $result['last_name'],
			'email' 			=> $result['email'],
			'telephone' 		=> $result['telephone'],
			'security_question' => $question_result['text'],
			'security_answer' 	=> $result['security_answer']
		);

		$data['address_info'] = array();
		$result = $this->Customers_model->getCustomerAddress($this->customer->getId(), $this->customer->getAddressId());			// retrieve customer address data based on customer address id from getAddress method in Customers model

		if ($result) {
			$data['address_info'] = $this->country->addressFormat($result);
		}

		$this->template->regions(array('header', 'content_top', 'content_left', 'content_right', 'footer'));
		if (file_exists(APPPATH .'views/themes/main/'.$this->config->item('main_theme').'account.php')) {
			$this->template->render('themes/main/'.$this->config->item('main_theme'), 'account', $data);
		} else {
			$this->template->render('themes/main/default/', 'account', $data);
		}
	}
}

/* End of file account.php */
/* Location: ./application/controllers/main/account.php */