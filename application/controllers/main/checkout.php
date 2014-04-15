<?php
class Checkout extends MX_Controller {
	
	public function __construct() {
		parent::__construct(); 																	//  calls the constructor
		$this->load->library('customer'); 														// load the customer library
		$this->load->library('cart'); 															// load the cart library
		$this->load->library('location'); 														// load the location library
		$this->load->library('currency'); 														// load the currency library
		$this->load->model('Customers_model'); 													// load the customers model
		$this->load->model('Orders_model'); 													// load the orders model
		$this->load->model('Locations_model'); 													// load the locations model
		$this->load->model('Payments_model'); 													// load the payments model
		$this->load->model('Countries_model');

        $this->form_validation->CI =& $this;
	}

	public function index() {
		$this->load->library('user_agent');
		$this->lang->load('main/checkout');  													// loads language file
		
		if (!file_exists(APPPATH .'views/main/checkout.php')) {
			show_404();
		}
			
		if ( ! $this->cart->contents()) { 														// checks if cart contents is empty  
			$this->session->set_flashdata('alert', $this->lang->line('warning_no_cart'));
  			redirect('menus');																	// redirect to menus page and display error
		}
		
		if ( ! $this->location->local() AND $this->config->item('location_order') === '1') { 														// else if local restaurant is not selected
			$this->session->set_flashdata('alert', $this->lang->line('warning_no_local'));
  			redirect('menus');																	// redirect to menus page and display error
		}
		
		if ( ! $this->location->isOpened()) { 													// else if local restaurant is not open
			$this->session->set_flashdata('alert', $this->lang->line('warning_is_closed'));
  			redirect('menus');																	// redirect to menus page and display error
		}
		
		if ( ! $this->location->checkMinTotal($this->cart->total())) { 							// checks if cart contents is empty  
			//$this->session->set_flashdata('alert', $this->lang->line('warning_min_delivery'));
  			redirect('menus');																	// redirect to menus page and display error
		}
		
		if ( ! $this->customer->islogged() AND $this->config->item('guest_order') === '0') { 											// else if customer is not logged in
			//$this->session->set_flashdata('alert', $this->lang->line('warning_not_logged'));
  			redirect('account/login');															// redirect to account register page and display error
		}

		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  								// retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		// START of retrieving lines from language file to pass to view.
		$data['text_heading'] 			= $this->lang->line('text_heading');
		$data['text_checkout'] 			= $this->lang->line('text_checkout');
		$data['text_asap']				= $this->lang->line('text_asap');
		$data['text_new']				= $this->lang->line('text_new');
		$data['text_existing']			= $this->lang->line('text_existing');
		$data['text_cod'] 				= $this->lang->line('text_cod');
		$data['text_paypal'] 			= $this->lang->line('text_paypal');
		$data['text_ip_warning'] 		= $this->lang->line('text_ip_warning');
		$data['text_postcode'] 			= $this->lang->line('text_postcode');
		$data['entry_first_name'] 		= $this->lang->line('entry_first_name');
		$data['entry_last_name'] 		= $this->lang->line('entry_last_name');
		$data['entry_email'] 			= $this->lang->line('entry_email');
		$data['entry_telephone'] 		= $this->lang->line('entry_telephone');
		$data['entry_order_type'] 		= $this->lang->line('entry_order_type');
		$data['entry_delivery'] 		= $this->lang->line('entry_delivery');
		$data['entry_collection'] 		= $this->lang->line('entry_collection');
		$data['entry_order_time'] 		= $this->lang->line('entry_order_time');
		$data['entry_address'] 			= $this->lang->line('entry_address');
		$data['entry_use_address'] 		= $this->lang->line('entry_use_address');
		$data['entry_address_1'] 		= $this->lang->line('entry_address_1');
		$data['entry_address_2'] 		= $this->lang->line('entry_address_2');
		$data['entry_city'] 			= $this->lang->line('entry_city');
		$data['entry_postcode'] 		= $this->lang->line('entry_postcode');
		$data['entry_country'] 			= $this->lang->line('entry_country');
		$data['entry_payment_method'] 	= $this->lang->line('entry_payment_method');
		$data['entry_comments'] 		= $this->lang->line('entry_comments');
		$data['entry_ip'] 				= $this->lang->line('entry_ip');
		$data['button_check_postcode'] 	= $this->lang->line('button_check_postcode');

		$data['button_left'] 	= '<a class="button" href='. $this->config->site_url("menus") .'>'. $this->lang->line('button_back') .'</a>';
		$data['button_right'] 	= '<a class="button" onclick="$(\'#checkout-form\').submit();">'. $this->lang->line('button_continue') .'</a>';

		// END of retrieving lines from language file to send to view.
		
		$order_data = $this->session->userdata('order_data');
		
		if (isset($order_data['first_name'])) {
			$data['first_name'] = $order_data['first_name']; 								// retrieve customer first name from session data
		} else if ($this->customer->getFirstName()) {
			$data['first_name'] = $this->customer->getFirstName(); 								// retrieve customer first name from customer library
		} else {
			$data['first_name'] = '';
		}
		
		if (isset($order_data['last_name'])) {
			$data['last_name'] = $order_data['last_name']; 								// retrieve customer last name from session data
		} else if ($this->customer->getLastName()) {
			$data['last_name'] = $this->customer->getLastName(); 								// retrieve customer last name from customer library
		} else {
			$data['last_name'] = '';
		}
		
		if (isset($order_data['email'])) {
			$data['email'] = $order_data['email']; 								// retrieve customer email from session data
		} else if ($this->customer->getEmail()) {
			$data['email'] = $this->customer->getEmail(); 										// retrieve customer email address from customer library
		} else {
			$data['email'] = '';
		}
		
		if (isset($order_data['telephone'])) {
			$data['telephone'] = $order_data['telephone']; 										// retrieve telephone from session data
		} else if ($this->customer->getTelephone()) {
			$data['telephone'] = $this->customer->getTelephone(); 								// retrieve customer telephone from customer library
		} else {
			$data['telephone'] = '';
		}
		
		if ($this->config->item('country_id')) {
			$data['country_id'] = $this->config->item('country_id'); 						// retrieve country_id from config settings
		}
						
		if ($this->input->post('order_type')) {
			$data['order_type'] = $this->input->post('order_type'); 							// retrieve order_type value from $_POST data if set
		} else if (isset($order_data['order_type'])) {
			$data['order_type'] = $order_data['order_type']; 									// retrieve order_type from session data
		} else {
			$data['order_type'] = '1';
		}
						
		if ($this->input->post('order_time')) {
			$data['order_time'] = $this->input->post('order_time'); 							// retrieve order_time value from $_POST data if set
		} else if (isset($order_data['order_time'])) {
			$data['order_time'] = $order_data['order_time']; 									// retrieve order_type from session data
		} else {
			$data['order_time'] = '';
		}
						
		if ($this->input->post('existing_address')) {
			$data['existing_address'] = $this->input->post('existing_address'); 				// retrieve existing_address value from $_POST data if set
		} else if (isset($order_data['address_id'])) {
			$data['existing_address'] = $order_data['address_id']; 						// retrieve existing_address from session data
		} else {
			$data['existing_address'] = '';
		}
						
		if ($this->input->post('new_address')) {
			$data['new_address'] = $this->input->post('new_address'); 							// retrieve new_address value from $_POST data if set
		} else if (isset($order_data['new_address'])) {
			$data['new_address'] = $order_data['new_address']; 									// retrieve new_address from session data
		} else {
			$data['new_address'] = '';
		}
						
     	$data['addresses'] = array();
		$addresses = $this->Customers_model->getCustomerAddresses($this->customer->getId());  							// retrieve customer addresses array from getCustomerAddresses method in Customers model
		if ($addresses) {
      		foreach ($addresses as $address) {													// loop through customer addresses arrary
				$data['addresses'][] = array( 													// create array of address data to pass to view
					'address_id'	=> $address['address_id'],
					'address_1'		=> $address['address_1'],
					'address_2' 	=> $address['address_2'],
					'city' 			=> $address['city'],			
					'postcode' 		=> $address['postcode'],	
					'country' 		=> $address['country']
				);
			}
		}
		
		$data['countries'] = array();
		$results = $this->Countries_model->getCountries(); 										// retrieve countries array from getCountries method in locations model
		foreach ($results as $result) {															// loop through crountries array
			$data['countries'][] = array( 														// create array of countries data to pass to view
				'country_id'	=>	$result['country_id'],
				'name'			=>	$result['country_name'],
			);
		}

		$start_time = $this->location->openingTime();
		$end_time = ($this->location->closingTime() === '00:00') ? '23:59' : $this->location->closingTime();											// retrieve location closing time from location library
		$current_time = $this->location->currentTime(); 								// retrieve the location current time from location library
		
		if ($this->location->readyTime()) {
			$ready_time = $this->location->readyTime();
		}
		
		$data['asap_time'] = mdate('%H:%i', strtotime($current_time) + 5 * 60);
		$data['delivery_times'] = array();
		$delivery_times = $this->location->generateHours($start_time, $end_time, $ready_time); 	// retrieve the location delivery times from location library
		foreach ($delivery_times as $key => $value) {											// loop through delivery times
			if (strtotime($value) > (strtotime($current_time) + $ready_time * 60)) {
				$data['delivery_times'][] = array( 													// create array of delivery_times data to pass to view
					'12hr'		=> mdate('%h:%i %a', strtotime($value)),
					'24hr'		=> $value
				);
			}
		}
		
		if ($this->input->post() AND $this->_validateCheckout() === TRUE) { 						// check if post data and validate checkout is successful
			redirect('payments');
		}

		$regions = array('main/header', 'main/content_top', 'main/content_left', 'main/content_right', 'main/footer');
		$this->template->regions($regions);
		$this->template->load('main/checkout', $data);
	}
		
	public function success() {
		$this->lang->load('main/checkout');
		
		if (!file_exists(APPPATH .'views/main/checkout_success.php')) {
			show_404();
		}
			
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  								// retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		if ($this->customer->islogged()) {														// checks if customer is logged in
			$customer_id = $this->customer->getId();											// retrieve customer id from customer library
		}

		// START of retrieving lines from language file to pass to view.
		$data['text_heading'] 				= $this->lang->line('text_success_heading');
		$data['text_order_details'] 		= $this->lang->line('text_order_details');
		$data['text_order_items'] 			= $this->lang->line('text_order_items');
		$data['text_delivery_address'] 		= $this->lang->line('text_delivery_address');
		$data['text_local'] 				= $this->lang->line('text_local');
		$data['text_thank_you'] 			= $this->lang->line('text_thank_you');
		// END of retrieving lines from language file to send to view.

		if (is_numeric($this->input->cookie('last_order_id'))) {
			$order_info = $this->Orders_model->getMainOrder($this->input->cookie('last_order_id'), $customer_id);	// retrieve order details array from getMainOrder method in Orders model
		} else {
			$this->input->set_cookie('last_order_id', '', '');
			$order_info = array();
		}

		if ($order_info) {																	// checks if array is returned
			$this->session->unset_userdata('order_data');

			$data['message'] = sprintf($this->lang->line('text_success_message'), $order_info['order_id'], $this->config->site_url('account/orders'));
		
			if ($order_info['order_type'] === 1) { 											// checks if order type is delivery or collection
				$order_type = 'delivery';
			} else {
				$order_type = 'collection';
			}
		
			if ($order_info['payment'] === 'paypal') { 										// checks if payment method is paypal or cod
				$payment_method = 'PayPal';
			} else if ($order_info['payment'] === 'cod'){
				$payment_method = 'Cash On Delivery';
			}
		
			$data['order_details'] = sprintf($this->lang->line('text_order_info'), $order_type,  mdate('%d %M %y - %H:%i', strtotime($order_info['date_added'])), mdate('%d %M %y - %H:%i', strtotime($order_info['order_time'])), $payment_method);
		
			$data['menus'] = $this->Orders_model->getOrderMenus($order_info['order_id']);
			
			$data['order_total'] = sprintf($this->lang->line('text_order_total'), $this->currency->format($order_info['order_total']));
		
			if (!empty($order_info['address_id'])) {											// checks if address_id is set then retrieve delivery address
				$this->load->library('country');
				$delivery_address = $this->Customers_model->getCustomerAddress($customer_id, $order_info['address_id']);
				$data['delivery_address'] = $this->country->addressFormat($delivery_address);
			} else {
				$data['delivery_address'] = FALSE;
			}
		
			$this->load->library('country');
			$location_address = $this->Locations_model->getLocationAddress($order_info['location_id']);
			$data['location_name'] = $location_address['location_name'];
			$data['location_address'] = $this->country->addressFormat($location_address);
	
		} else {																				// else redirect to checkout
			redirect('home');
		}
				
		$regions = array(
			'main/header',
			'main/footer'
		);
		
		$this->template->regions($regions);
		$this->template->load('main/checkout_success', $data);
	}
	
	public function _validateCheckout() {														// method to validate checkout form fields
		$this->lang->load('main/checkout');  													// loads language file
					
		$order_data = array();
		
		// START of form validation rules
		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|min_length[2]|max_length[32]');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|min_length[2]|max_length[32]');
		
		if ($this->input->post('email') !== $this->customer->getEmail()) {
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[customers.email]|max_length[96]');
			$this->form_validation->set_message('is_unique', 'Warning: E-Mail Address is already registered!');
		}

		$this->form_validation->set_rules('telephone', 'Telephone', 'trim|required|numeric|max_length[20]');
		$this->form_validation->set_rules('order_type', 'Order Type', 'trim|required|integer|callback_order_type');
		$this->form_validation->set_rules('order_time', 'Delivery or Collection Time', 'trim|required|valid_time|callback_validate_time');
		
		if ($this->input->post('order_type') === '1') {
			$this->form_validation->set_rules('new_address', 'Use Address', 'trim|required|integer');
	
			if ($this->input->post('new_address') === '1') {
				$this->form_validation->set_rules('address[address_1]', 'Address 1', 'trim|required|min_length[3]|max_length[128]');
				$this->form_validation->set_rules('address[city]', 'City', 'trim|required|min_length[2]|max_length[128]');
				$this->form_validation->set_rules('address[postcode]', 'Postcode', 'trim|required|min_length[2]|max_length[10]|callback_validate_address');
				$this->form_validation->set_rules('address[country]', 'Country', 'trim|required|integer');
			} else {
				$this->form_validation->set_rules('existing_address', 'Delivery Address', 'trim|required|integer|callback_validate_address');
			}
		}
		
		$this->form_validation->set_rules('comment', 'Comment', 'trim|max_length[520]'); 
		// END of form validation rules

  		if ($this->form_validation->run() === TRUE) {											// checks if form validation routines ran successfully
			if ($this->location->getId()) {
				$order_data['location_id'] = $this->location->getId();					// retrieve location id from location library and add to order_data array
			} else {
				$this->session->set_flashdata('alert', $this->lang->line('warning_no_local'));
				redirect('checkout');																	// redirect to home page and display error
			}
			
			if ($this->customer->getId()) {
				$order_data['customer_id'] = $this->customer->getId();					// retrive customer id from customer library and add to order_data array
			} else {
				$order_data['customer_id'] = '0';
			}
			
			$order_data['email'] 		= $this->input->post('email');
			$order_data['first_name'] 	= $this->input->post('first_name');
			$order_data['last_name'] 	= $this->input->post('last_name');
			$order_data['telephone'] 	= $this->input->post('telephone');
			$order_data['order_time'] 	= $this->input->post('order_time');					// retrieve order_time value from $_POST data if set and add to order_data array
		 	$order_data['order_type'] 	= $this->input->post('order_type');				// retrieve order_type value from $_POST data if set and convert to integer then add to order_data array			
			$order_data['new_address'] 	= $this->input->post('new_address');
		
			if (($this->input->post('new_address') === '1') AND ($this->input->post('order_type') === '1')) {								// checks if new-address $_POST data is set else use existing address $_POST data
				$order_data['address_id'] = $this->Customers_model->addCustomerAddress($this->customer->getId(), $this->input->post('address')); 	// send new-address $_POST data and customer id to addCustomerAddress method in Customers model
			}
				
			if (($this->input->post('new_address') === '2') AND ($this->input->post('order_type') === '1')) {								// checks if new-address $_POST data is set else use existing address $_POST data
				$order_data['address_id'] = (int)$this->input->post('existing_address');
			}

		 	if ($this->input->post('comment')) {
	 			$order_data['comment'] = $this->input->post('comment');						// retrieve comment value from $_POST data if set and convert to integer then add to order_data array
			}
														
			if ( ! empty($order_data)) {														// checks if order_data is not empty
				$this->session->set_userdata('order_data', $order_data);					// save order details to session and return TRUE
				return TRUE;
			}
		}
	}

	public function validate_time($str) { 	// validation callback function to check if order_time $_POST data is a valid time, is less than the restaurant current time and is within the restaurant opening and closing hour
		
		if (strtotime($str) < strtotime($this->location->currentTime())) {
        	$this->form_validation->set_message('validate_time', $this->lang->line('error_less_time'));
      		return FALSE;
    	} else if ( ! $this->location->checkDeliveryTime($str)) {
        	$this->form_validation->set_message('validate_time', $this->lang->line('error_no_time'));
      		return FALSE;
		} else {																				// else validation is successful
			return TRUE;
		}
	}
	
	public function order_type($type) {
	
		if (($type == '1') AND ($this->location->checkDelivery() === 'no')) { 					// checks if cart contents is empty  
			$this->form_validation->set_message('order_type', $this->lang->line('warning_no_delivery'));
			return FALSE;
		} else if (($type == '2') AND ( ! $this->location->checkCollection())) { 				// checks if cart contents is empty  
			$this->form_validation->set_message('order_type', $this->lang->line('warning_no_collection'));
			return FALSE;
		} else {																				// else validation is successful
			return TRUE;
		}
	
	}

	public function validate_address() {
		$address = $this->input->post('address');
		
		if (!empty($address['postcode'])) {
			$search = $address['postcode'];
		} else if ($this->input->post('existing_address')) {
			$address = $this->Customers_model->getCustomerAddress($this->customer->getId(), $this->input->post('existing_address')); 	// send new-address $_POST data and customer id to addCustomerAddress method in Customers model
			$search = $address['postcode'];
		}
		
		if (($this->input->post('order_type') === '1') AND $this->location->checkDelivery($search) === 'outside') { 		// checks if cart contents is empty  
			$this->form_validation->set_message('validate_address', $this->lang->line('warning_covered_area'));
			return FALSE;
		} else {																				// else validation is successful
			return TRUE;
		}
	}
}