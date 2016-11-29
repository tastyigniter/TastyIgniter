<?php if (!defined('BASEPATH')) exit('No direct access allowed');

class Account extends Main_Controller
{

	public function __construct()
	{
		parent::__construct();                                                                    //  calls the constructor

		if (!$this->customer->isLogged()) {                                                    // if customer is not logged in redirect to account login page
			redirect('account/login');
		}

		$this->load->model('Pages_model');
		$this->load->model('Customers_model');                                                    // load the customers model
		$this->load->model('Addresses_model');                                                    // load the addresses model
		$this->load->model('Security_questions_model');                                            // load the security questions model
		$this->load->model('Messages_model');                                                    // load the messages model
		$this->load->model('Orders_model');                                                        // load the orders model
		$this->load->model('Reservations_model');                                                // load the reservations model

		$this->load->library('cart');                                                            // load the cart library
		$this->load->library('currency');                                                        // load the currency library
		$this->load->library('country');

		$this->lang->load('account/account');
	}

	public function index()
	{
		$time_format = ($this->config->item('time_format')) ? $this->config->item('time_format') : '%h:%i %a';

		$total = $this->Messages_model->getUnreadCount($this->customer->getId());                    // retrieve total number of customer messages from getUnreadCount method in Messages model
		$data['inbox_total'] = ($total < 1) ? '' : $total;

		$this->template->setBreadcrumb('<i class="fa fa-home"></i>', '/');
		$this->template->setBreadcrumb($this->lang->line('text_heading'), 'account/account');

		$this->template->setTitle($this->lang->line('text_heading'));
		$this->template->setHeading($this->lang->line('text_heading'));

		$data['checkout_url'] = site_url('checkout');
		$data['password_url'] = site_url('account/details');
		$data['cart_items'] = $this->cart->total_items();
		$data['cart_total'] = $this->currency->format($this->cart->order_total());

		$result = $this->Customers_model->getCustomer($this->customer->getId());                // retrieve customer data based on customer id from getCustomer method in Customers model
		$question_result = $this->Security_questions_model->getQuestion($result['security_question_id']); // retrieve security questions based on security question id

		//store customer data in array
		$data['customer_info'] = [
			'first_name'        => $result['first_name'],
			'last_name'         => $result['last_name'],
			'email'             => $result['email'],
			'telephone'         => $result['telephone'],
			'security_question' => (isset($question_result['text'])) ? $question_result['text'] : '',
			'security_answer'   => '******',
		];

		$data['address_info'] = [];
		$result = $this->Addresses_model->getAddress($this->customer->getId(), $this->customer->getAddressId());            // retrieve customer address data based on customer address id from getAddress method in Customers model
		if ($result) {
			$data['address_info'] = $this->country->addressFormat($result);
			$data['address_info_edit'] = site_url('account/address/edit/' . $this->customer->getAddressId());
		}

		$filter = ['customer_id' => $this->customer->getId(), 'limit' => '5', 'page' => '', 'order_by' => 'DESC'];

		$data['orders'] = [];
		$results = $this->Orders_model->paginateWithFilter($filter + ['sort_by' => 'order_id']);                                    // retrieve customer orders based on customer id from getMainOrders method in Orders model
		foreach ($results->list as $result) {
			$data['orders'][] = array_merge($result, [                                                            // create array of customer orders to pass to view
				'order_date' => day_elapsed($result['order_date']),
				'order_time' => mdate($time_format, strtotime($result['order_time'])),
				'view'       => site_url('account/orders/view/' . $result['order_id']),
			]);
		}

		$data['reservations'] = [];
		$results = $this->Reservations_model->paginateWithFilter($filter + ['sort_by' => 'reserve_date']);                                // retrieve customer reservations based on customer id from getMainReservations method in Reservations model
		foreach ($results->list as $result) {
			$data['reservations'][] = array_merge($result, [                                                            // create array of customer reservations to pass to view
				'reserve_date' => day_elapsed($result['reserve_date']),
				'reserve_time' => mdate($time_format, strtotime($result['reserve_time'])),
				'view'         => site_url('account/reservations/view/' . $result['reservation_id']),
			]);
		}

		$data['messages'] = [];
		$results = $this->Messages_model->paginateWithFilter($filter + ['sort_by' => 'messages.date_added']);                                    // retrieve all customer messages from getMainInbox method in Messages model
		foreach ($results->list as $result) {
			$data['messages'][] = array_merge($result, [                                                        // create array of customer messages to pass to view
				'date_added' => day_elapsed($result['date_added']),
				'body'       => substr(strip_tags(html_entity_decode($result['body'], ENT_QUOTES, 'UTF-8')), 0, 50) . '..',
				'state'      => ($result['state'] == '0') ? 'unread' : 'read',
				'view'       => site_url('account/inbox/view/' . $result['message_id']),
			]);
		}

		$this->template->render('account/account', $data);
	}
}

/* End of file Account.php */
/* Location: ./main/controllers/Account.php */