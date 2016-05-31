<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Account extends Main_Controller {

	public function __construct() {
		parent::__construct(); 																	//  calls the constructor

		if (!$this->customer->isLogged()) {  													// if customer is not logged in redirect to account login page
  			redirect('account/login');
		}

        $this->load->model('Pages_model');
        $this->load->model('Customers_model');													// load the customers model
        $this->load->model('Addresses_model');													// load the addresses model
        $this->load->model('Security_questions_model');											// load the security questions model
        $this->load->model('Messages_model');													// load the messages model
        $this->load->model('Orders_model');														// load the orders model
        $this->load->model('Reservations_model');												// load the reservations model

        $this->load->library('cart'); 															// load the cart library
        $this->load->library('currency'); 														// load the currency library
        $this->load->library('country');

        $this->lang->load('account/account');
	}

	public function index() {
		$time_format = ($this->config->item('time_format')) ? $this->config->item('time_format') : '%h:%i %a';

		$data['inbox_total'] = $this->Messages_model->getUnreadCount($this->customer->getId());					// retrieve total number of customer messages from getUnreadCount method in Messages model

		$this->template->setBreadcrumb('<i class="fa fa-home"></i>', '/');
		$this->template->setBreadcrumb($this->lang->line('text_heading'), 'account/account');

		$this->template->setTitle($this->lang->line('text_heading'));
		$this->template->setHeading($this->lang->line('text_heading'));

		$data['checkout_url'] 		    = site_url('checkout');
		$data['password_url'] 			= site_url('account/details');
		$data['cart_items'] 			= $this->cart->total_items();
		$data['cart_total'] 			= $this->currency->format($this->cart->order_total());

		$result = $this->Customers_model->getCustomer($this->customer->getId());				// retrieve customer data based on customer id from getCustomer method in Customers model
        $question_result = $this->Security_questions_model->getQuestion($result['security_question_id']); // retrieve security questions based on security question id

        //store customer data in array
        $data['customer_info'] = array(
			'first_name' 		=> $result['first_name'],
			'last_name' 		=> $result['last_name'],
			'email' 			=> $result['email'],
			'telephone' 		=> $result['telephone'],
			'security_question' => (isset($question_result['text'])) ? $question_result['text'] : '',
			'security_answer' 	=> '******'
		);

		$data['address_info'] = array();
		$result = $this->Addresses_model->getAddress($this->customer->getId(), $this->customer->getAddressId());			// retrieve customer address data based on customer address id from getAddress method in Customers model
		if ($result) {
			$data['address_info'] = $this->country->addressFormat($result);
            $data['address_info_edit'] = site_url('account/address/edit/'.$this->customer->getAddressId());
		}

		$filter = array('customer_id' => $this->customer->getId(), 'limit' => '5', 'page' => '', 'order_by' => 'DESC');

		$data['orders'] = array();
		$results = $this->Orders_model->getList($filter + array('sort_by' => 'order_id'));									// retrieve customer orders based on customer id from getMainOrders method in Orders model
		foreach ($results as $result) {
			$data['orders'][] = array(															// create array of customer orders to pass to view
				'order_id' 				=> $result['order_id'],
				'order_date' 			=> day_elapsed($result['order_date']),
				'order_time'			=> mdate($time_format, strtotime($result['order_time'])),
				'status_name' 			=> $result['status_name'],
				'view' 					=> site_url('account/orders/view/' . $result['order_id'])
			);
		}

		$data['reservations'] = array();
		$results = $this->Reservations_model->getList($filter + array('sort_by' => 'reserve_date'));								// retrieve customer reservations based on customer id from getMainReservations method in Reservations model
		foreach ($results as $result) {
			$data['reservations'][] = array(															// create array of customer reservations to pass to view
				'reservation_id' 		=> $result['reservation_id'],
				'status_name' 			=> $result['status_name'],
				'reserve_date' 			=> day_elapsed($result['reserve_date']),
				'reserve_time'			=> mdate($time_format, strtotime($result['reserve_time'])),
				'view' 					=> site_url('account/reservations/view/' . $result['reservation_id'])
			);
		}

		$data['messages'] = array();
		$results = $this->Messages_model->getList($filter + array('sort_by' => 'messages.date_added'));									// retrieve all customer messages from getMainInbox method in Messages model
		foreach ($results as $result) {
			$data['messages'][] = array(														// create array of customer messages to pass to view
				'date_added'	=> day_elapsed($result['date_added']),
				'subject' 		=> $result['subject'],
				'body' 			=> substr(strip_tags(html_entity_decode($result['body'], ENT_QUOTES, 'UTF-8')), 0, 50) . '..',
				'state'			=> ($result['state'] === '0') ? 'unread' : 'read',
				'view'			=> site_url('account/inbox/view/'. $result['message_id'])
			);
		}

		$this->template->render('account/account', $data);
	}
}

/* End of file account.php */
/* Location: ./main/controllers/account.php */