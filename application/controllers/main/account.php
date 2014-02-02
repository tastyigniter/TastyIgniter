<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends MX_Controller {

	public function __construct() {
		parent::__construct(); 																	//  calls the constructor
		$this->load->model('Customers_model');													// load the customers model
		$this->load->model('Security_questions_model');											// load the security questions model
		$this->output->enable_profiler(TRUE); // for debugging profiler... remove later
	}

	public function index() {
		$this->load->library('cart'); 															// load the cart library
		$this->load->library('currency'); 														// load the currency library
		$this->lang->load('main/account');  													// loads language file
			
		if ( !file_exists(APPPATH .'/views/main/account.php')) { 								//check if file exists in views folder
			show_404(); 																		// Whoops, show 404 error page!
		}

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
		$data['text_heading'] 			= $this->lang->line('text_heading');
		$data['text_no_default_add'] 	= $this->lang->line('text_no_default_add');
		$data['text_no_cart_items'] 	= $this->lang->line('text_no_cart_items');
		$data['text_cart'] 				= $this->lang->line('text_cart');
		$data['text_edit'] 				= $this->lang->line('text_edit');
		$data['text_edit_add'] 			= $this->lang->line('text_edit_add');
		$data['text_checkout'] 			= $this->lang->line('text_checkout');
		$data['text_view'] 				= $this->lang->line('text_view');
		$data['text_my_details'] 		= $this->lang->line('text_my_details');
		$data['text_default_address'] 	= $this->lang->line('text_my_details');
		$data['text_password'] 			= $this->lang->line('text_password');
		$data['text_cart_items'] 		= $this->lang->line('text_cart_items');
		$data['text_cart_total'] 		= $this->lang->line('text_cart_total');
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

		$data['cart_items'] 			= $this->cart->total_items();
		$data['cart_total'] 			= $this->currency->format($this->cart->total());

		$result = $this->Customers_model->getCustomer($this->customer->getId());				// retrieve customer data based on customer id from getCustomer method in Customers model

		//store customer data in array
		$data['customer_info'] = array();
		$result = $this->Customers_model->getCustomer($this->customer->getId());

		$question_result = $this->Security_questions_model->getQuestion($result['security_question_id']); // retrieve security questions based on security question id
		
		$data['customer_info'] = array(
			'first_name' 		=> $result['first_name'],
			'last_name' 		=> $result['last_name'],
			'email' 			=> $result['email'],
			'telephone' 		=> $result['telephone'],
			'security_question' => $question_result['question_text'],
			'security_answer' 	=> $result['security_answer']
		);

		$data['address_info'] = array();
		$result = $this->Customers_model->getCustomerAddress($this->customer->getId(), $this->customer->getAddressId());			// retrieve customer address data based on customer address id from getAddress method in Customers model
		if ($result) {
			$data['address_info'] = array(														// create array of customer address data to pass to view
				'address_1' 	=> $result['address_1'],
				'address_2' 	=> $result['address_2'],
				'city' 			=> $result['city'],
				'postcode' 		=> $result['postcode'],
				'country' 		=> $result['country']		
			);
		}

		// pass array $data and load view files
		$this->load->view('main/header', $data);
		$this->load->view('main/content_left');
		$this->load->view('main/account', $data);
		$this->load->view('main/footer');
	}
}