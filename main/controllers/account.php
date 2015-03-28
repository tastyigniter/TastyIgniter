<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Account extends Main_Controller {

	public function __construct() {
		parent::__construct(); 																	//  calls the constructor
		$this->load->library('customer'); 														// load the customer library
		$this->load->library('cart'); 															// load the cart library
		$this->load->library('currency'); 														// load the currency library
		$this->load->library('country');

		$this->load->model('Pages_model');
		$this->lang->load('account');
	}

	public function index() {
		$this->load->model('Customers_model');													// load the customers model
		$this->load->model('Addresses_model');													// load the addresses model
		$this->load->model('Security_questions_model');											// load the security questions model
		$this->load->model('Messages_model');													// load the messages model
		$this->load->model('Orders_model');														// load the orders model
		$this->load->model('Reservations_model');												// load the reservations model

		if (!$this->customer->isLogged()) {  													// if customer is not logged in redirect to account login page
  			redirect('login');
		}

		$inbox_total = $this->Messages_model->getInboxTotal();					// retrieve total number of customer messages from getInboxTotal method in Messages model

		$this->template->setBreadcrumb('<i class="fa fa-home"></i>', '/');
		$this->template->setBreadcrumb($this->lang->line('text_heading'), 'account');

		// START of retrieving lines from language file to pass to view.
		$this->template->setTitle($this->lang->line('text_heading'));
		$this->template->setHeading($this->lang->line('text_heading'));
		$data['text_heading'] 			= $this->lang->line('text_heading');
		$data['text_no_default_add'] 	= $this->lang->line('text_no_default_add');
		$data['text_no_cart_items'] 	= $this->lang->line('text_no_cart_items');
		$data['text_no_orders'] 		= $this->lang->line('text_no_orders');
		$data['text_no_reservations'] 	= $this->lang->line('text_no_reservations');
		$data['text_no_inbox'] 			= $this->lang->line('text_no_inbox');
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
		$data['column_date'] 			= $this->lang->line('column_date');
		$data['column_id'] 				= $this->lang->line('column_id');
		$data['column_status'] 			= $this->lang->line('column_status');
		$data['column_subject'] 		= $this->lang->line('column_subject');
		// END of retrieving lines from language file to send to view.

		$data['button_checkout'] 		= site_url('checkout');
		$data['password_url'] 			= site_url('details');
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
			'security_question' => (isset($question_result['text'])) ? $question_result['text'] : '',
			'security_answer' 	=> $result['security_answer']
		);

		$data['address_info'] = array();
		$result = $this->Addresses_model->getAddress($this->customer->getId(), $this->customer->getAddressId());			// retrieve customer address data based on customer address id from getAddress method in Customers model

		if ($result) {
			$data['address_info'] = $this->country->addressFormat($result);
		}

		$filter = array('customer_id' => $this->customer->getId(), 'limit' => '5', 'page' => '');

		$data['orders'] = array();
		$results = $this->Orders_model->getList($filter);									// retrieve customer orders based on customer id from getMainOrders method in Orders model
		foreach ($results as $result) {
			$data['orders'][] = array(															// create array of customer orders to pass to view
				'order_id' 				=> $result['order_id'],
				'date_added' 			=> mdate('%d %M %y', strtotime($result['date_added'])),
				'order_time'			=> mdate('%H:%i', strtotime($result['order_time'])),
				'status_name' 			=> $result['status_name'],
				'view' 					=> site_url('orders/view/' . $result['order_id'])
			);
		}

		$data['reservations'] = array();
		$results = $this->Reservations_model->getList($filter);								// retrieve customer reservations based on customer id from getMainReservations method in Reservations model
		foreach ($results as $result) {
			$data['reservations'][] = array(															// create array of customer reservations to pass to view
				'reservation_id' 		=> $result['reservation_id'],
				'status_name' 			=> $result['status_name'],
				'reserve_date' 			=> mdate('%d %M %y', strtotime($result['reserve_date'])),
				'reserve_time'			=> mdate('%H:%i', strtotime($result['reserve_time'])),
				'view' 					=> site_url('reservations/view/' . $result['reservation_id'])
			);
		}

		$data['messages'] = array();
		$results = $this->Messages_model->getList($filter);									// retrieve all customer messages from getMainInbox method in Messages model
		foreach ($results as $result) {
			$data['messages'][] = array(														// create array of customer messages to pass to view
				'date_added'	=> mdate('%d %M %y - %H:%i', strtotime($result['date_added'])),
				'subject' 		=> $result['subject'],
				'body' 			=> substr(strip_tags(html_entity_decode($result['body'], ENT_QUOTES, 'UTF-8')), 0, 50) . '..',
				'state'			=> ($result['state'] === '0') ? 'unread' : 'read',
				'view'			=> site_url('inbox/view/'. $result['message_id'])
			);
		}

		$this->template->setPartials(array('header', 'content_top', 'content_left', 'content_right', 'content_bottom', 'footer'));
		$this->template->render('account', $data);
	}
}

/* End of file account.php */
/* Location: ./main/controllers//account.php */