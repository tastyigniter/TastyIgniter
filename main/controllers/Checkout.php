<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Checkout extends Main_Controller {

	public function __construct() {
		parent::__construct(); 																	//  calls the constructor

        $this->load->model('Pages_model');
        $this->load->model('Addresses_model'); 													// load the addresses model
        $this->load->model('Orders_model'); 													// load the orders model
        $this->load->model('Locations_model'); 													// load the locations model
        $this->load->model('Countries_model');
        $this->load->model('Extensions_model');

        $this->load->library('location');
        $this->location->initialize();

        $this->load->library('cart'); 															// load the cart library
        $this->load->library('currency'); 														// load the currency library
        $this->load->library('country'); 														// load the currency library
		$this->load->library('user_agent');

		$this->lang->load('checkout');
	}

	public function index() {
		if ( ! $this->cart->contents()) { 														// checks if cart contents is empty
			$this->alert->set('alert', $this->lang->line('alert_no_menu_to_order'));
            redirect(restaurant_url());																	// redirect to menus page and display error
		}

		if ($this->config->item('location_order') === '1' AND ! $this->location->hasSearchQuery()) { 														// else if local restaurant is not selected
            $this->alert->set('alert', $this->lang->line('alert_no_selected_local'));
            redirect(restaurant_url());																	// redirect to menus page and display error
        }

        if ( $this->location->isClosed()) { 													// else if local restaurant is not open
            redirect(restaurant_url());																	// redirect to previous page and display error
		}

        if ( ! $this->location->checkOrderType()) {
            redirect(restaurant_url());																	// redirect to previous page and display error
        }

		if ($this->location->orderType() === '1' AND ! $this->location->checkMinimumOrder($this->cart->total())) { 							// checks if cart contents is empty
            redirect(restaurant_url());																	// redirect to previous page and display error
		}

        $prepend = '?redirect=' . current_url();
		if ( ! $this->customer->islogged() AND $this->config->item('guest_order') !== '1') { 											// else if customer is not logged in
			$this->alert->set('alert', $this->lang->line('alert_customer_not_logged'));
  			redirect('account/login'.$prepend);															// redirect to account register page and display error
		}

		if ($this->input->post() AND $this->_validateCheckout() === TRUE) { 						// check if post data and validate checkout is successful
            redirect('checkout');
        }

		$this->template->setBreadcrumb('<i class="fa fa-home"></i>', '/');
		$this->template->setBreadcrumb($this->lang->line('text_heading'), 'checkout');

		$this->template->setTitle($this->lang->line('text_heading'));

        $this->template->setStyleTag(assets_url('js/datepicker/datepicker.css'), 'datepicker-css');
        $this->template->setScriptTag(assets_url("js/datepicker/bootstrap-datepicker.js"), 'bootstrap-datepicker-js');
        $this->template->setStyleTag(assets_url('js/datepicker/bootstrap-timepicker.css'), 'bootstrap-timepicker-css');
        $this->template->setScriptTag(assets_url("js/datepicker/bootstrap-timepicker.js"), 'bootstrap-timepicker-js');

        $data['text_login_register']	= $this->customer->isLogged() ? sprintf($this->lang->line('text_logout'), $this->customer->getFirstName(), site_url('account/logout'.$prepend)) : sprintf($this->lang->line('text_registered'), site_url('account/login'.$prepend));

        $order_data = $this->session->userdata('order_data');

        $data['_action'] = site_url('checkout');

        if (isset($order_data['customer_id']) AND isset($order_data['order_id'])) {
			$is_order_placed = $this->Orders_model->isOrderPlaced($order_data['order_id']);

            if ($is_order_placed === TRUE OR (!empty($order_data['customer_id']) AND $order_data['customer_id'] !== $this->customer->getId())) {
	            $order_data = array();
	            $this->session->unset_userdata('order_data');
			}
		}

        if (isset($order_data['location_id']) AND $order_data['location_id'] !== $this->location->getId()) {
            $order_data['checkout_step'] = 'one';
        }

        if (isset($order_data['order_type']) AND $order_data['order_type'] !== $this->location->orderType()) {
            $order_data['checkout_step'] = 'one';
        }

        $data = $this->getFormData($order_data, $data);

		$this->template->render('checkout', $data);
	}

	public function success() {
		if ($this->customer->islogged()) {														// checks if customer is logged in
			$customer_id = $this->customer->getId();											// retrieve customer id from customer library
		} else {
			$customer_id = '';
		}

        $order_data = $this->session->userdata('order_data'); 						            // retrieve order details from session userdata

        $order_id = (isset($order_data['order_id']) AND is_numeric($order_data['order_id'])) ? $order_data['order_id'] : '0';
        $order_info = $this->Orders_model->getOrder($order_id, $customer_id);	// retrieve order details array from getMainOrder method in Orders model

        if (empty($order_info) OR empty($order_info['order_id']) OR empty($order_info['status_id'])) {																	// checks if array is returned
            redirect(site_url('local/all'));
        }

        $this->template->setBreadcrumb('<i class="fa fa-home"></i>', '/');
		$this->template->setBreadcrumb($this->lang->line('text_heading'));
		$this->template->setBreadcrumb($this->lang->line('text_success_heading'));

		$this->template->setTitle($this->lang->line('text_success_heading'));

        $data['text_success_message'] = sprintf($this->lang->line('text_success_message'), $order_info['order_id'], site_url('account/orders'));

        // checks if order type is delivery or collection
        $order_type = ($order_info['order_type'] === '1') ? 'delivery' : 'collection';

        if ($payment = $this->extension->getPayment($order_info['payment'])) {
            $payment_method = !empty($payment['ext_data']['title']) ? $payment['ext_data']['title'] : $payment['title'];
        } else {
            $payment_method = $this->lang->line('text_no_payment');
        }

        $date_format = ($this->config->item('date_format')) ? $this->config->item('date_format') : '%d %M %y';
        $time_format = ($this->config->item('time_format')) ? $this->config->item('time_format') : '%h:%i %a';
        $data['order_details'] = sprintf($this->lang->line('text_order_info'), $order_type,  mdate($date_format, strtotime($order_info['date_added'])), ucwords($order_type), mdate(lang('text_date_format')." {$time_format}", strtotime("{$order_info['order_date']} {$order_info['order_time']}")), $payment_method);

        $data['menus'] = array();
        $menus = $this->Orders_model->getOrderMenus($order_info['order_id']);
        $menu_options = $this->Orders_model->getOrderMenuOptions($order_info['order_id']);
        foreach ($menus as $menu) {
            $option_data = array();

            if (!empty($menu_options)) {
                foreach ($menu_options as $menu_option) {
                    if ($menu['order_menu_id'] === $menu_option['order_menu_id']) {
	                    $option_data[] = $menu_option['order_option_name'] . $this->lang->line('text_equals') . $this->currency->format($menu_option['order_option_price']);
                    }
                }
            }

            $data['menus'][] = array(													// load menu data into array
                'menu_id' 		=> $menu['menu_id'],
                'name' 			=> (strlen($menu['name']) > 120) ? substr($menu['name'], 0, 120) .'...' : $menu['name'],
                'price' 		=> $this->currency->format($menu['price']),		//add currency symbol and format item price to two decimal places
                'quantity' 		=> $menu['quantity'],
                'subtotal' 		=> $this->currency->format($menu['subtotal']), 	//add currency symbol and format item subtotal to two decimal places
                'comment' 		=> $menu['comment'],
                'options' 		=> implode('<br />', $option_data)
            );
        }

        $data['order_totals'] = array();
        $order_totals = $this->Orders_model->getOrderTotals($order_info['order_id']);
        if ($order_totals) {
            foreach ($order_totals as $total) {
                if ($order_type === 'collection' AND $total['code'] === 'delivery') continue;

                $data['order_totals'][] = array(
                    'code'  => $total['code'],
                    'title' => htmlspecialchars_decode($total['title']),
                    'value' => $this->currency->format($total['value']),
                    'priority' => $total['priority'],
                );
            }
        }

        $data['order_total'] = $this->currency->format($order_info['order_total']);

        if ($order_type === 'delivery' AND !empty($order_info['address_id'])) {											// checks if address_id is set then retrieve delivery address
            $delivery_address = $this->Addresses_model->getAddress($customer_id, $order_info['address_id']);
            $data['delivery_address'] = $this->country->addressFormat($delivery_address);
        } else {
            $data['delivery_address'] = FALSE;
        }

        $data['location_name'] = $data['location_address'] = '';
        if (!empty($order_info['location_id'])) {
            $location_address = $this->Locations_model->getAddress($order_info['location_id']);
            $data['location_name'] = $location_address['location_name'];
            $data['location_address'] = $this->country->addressFormat($location_address);
        }

        $this->cart->destroy();
        $this->session->mark_as_temp('order_data', 300);

		$this->template->render('checkout_success', $data);
	}

    private function getFormData($order_data, $data = array()) {

        if ($this->input->post('checkout_step')) {
            $data['checkout_step'] = $this->input->post('checkout_step');
        } else if (isset($order_data['checkout_step'])) {
            $data['checkout_step'] = $order_data['checkout_step'];                                // retrieve customer first name from session data
        } else {
            $data['checkout_step'] = 'one';
        }

        $data['is_logged'] = $this->customer->isLogged();

        if ($this->input->post('first_name')) {
            $data['first_name'] = $this->input->post('first_name');
        } else if (isset($order_data['first_name'])) {
            $data['first_name'] = $order_data['first_name'];                                // retrieve customer first name from session data
        } else if ($this->customer->getFirstName()) {
            $data['first_name'] = $this->customer->getFirstName();                                // retrieve customer first name from customer library
        } else {
            $data['first_name'] = '';
        }

        if ($this->input->post('last_name')) {
            $data['last_name'] = $this->input->post('last_name');
        } else if (isset($order_data['last_name'])) {
            $data['last_name'] = $order_data['last_name'];                                // retrieve customer last name from session data
        } else if ($this->customer->getLastName()) {
            $data['last_name'] = $this->customer->getLastName();                                // retrieve customer last name from customer library
        } else {
            $data['last_name'] = '';
        }

        if ($this->customer->isLogged()) {
            $data['email'] = $this->customer->getEmail();                                        // retrieve customer email address from customer library
        } else if ($this->input->post('email')) {
            $data['email'] = $this->input->post('email');
        } else if (isset($order_data['email'])) {
            $data['email'] = $order_data['email'];                                // retrieve customer email from session data
        } else {
            $data['email'] = '';
        }

        if ($this->input->post('telephone')) {
            $data['telephone'] = $this->input->post('telephone');
        } else if (isset($order_data['telephone'])) {
            $data['telephone'] = $order_data['telephone'];                                        // retrieve telephone from session data
        } else if ($this->customer->getTelephone()) {
            $data['telephone'] = $this->customer->getTelephone();                                // retrieve customer telephone from customer library
        } else {
            $data['telephone'] = '';
        }

        $local_info = $this->session->userdata('local_info');
        if (isset($local_info['order_type'])) {
            $data['order_type'] = $local_info['order_type'];
        } else {
            $data['order_type'] = '1';
        }

        $data['order_type_text'] = ($data['order_type'] === '1') ? $this->lang->line('label_delivery') : $this->lang->line('label_collection');

        $data['order_times'] = $this->location->orderTimeRange();
        $data['order_time_interval'] = ($data['order_type'] === '1') ? $this->location->deliveryTime() : $this->location->collectionTime();

        $count = 1;
        $order_date = $order_hour = $order_minute = '';
        foreach ($data['order_times'] as $date => $times) {
            if ($date === 'asap') continue;

            if ($count === 1) {
                $order_date = $date;
                $order_hour = key($times);
                $order_minute = isset($times[$order_hour]) ? current($times[$order_hour]) : '';
            }

            $count++;
        }

        if ($this->input->post('order_time_type')) {
            $data['order_time_type'] = $this->input->post('order_time_type');                            // retrieve order_time value from $_POST data if set
        } else if (isset($order_data['order_time_type'])) {
            $data['order_time_type'] = $order_data['order_time_type'];                                    // retrieve order_type from session data
        } else if (!empty($data['order_times']['asap'])) {
            $data['order_time_type'] = 'asap';
        } else {
            $data['order_time_type'] = 'later';
        }

        if ($this->input->post('order_date')) {
            $data['order_date'] = $this->input->post('order_date');                            // retrieve order_time value from $_POST data if set
        } else if (isset($order_data['order_date']) AND !empty($data['order_times'][$order_data['order_date']])) {
            $data['order_date'] = $order_data['order_date'];                                    // retrieve order_type from session data
        } else {
            $data['order_date'] = $order_date;
        }

        if ($this->input->post('order_hour')) {
            $data['order_hour'] = $this->input->post('order_hour');                            // retrieve order_time value from $_POST data if set
        } else if (isset($order_data['order_hour']) AND !empty($data['order_times'][$data['order_date']][$order_data['order_hour']])) {
            $data['order_hour'] = $order_data['order_hour'];                                    // retrieve order_type from session data
        } else {
            $data['order_hour'] = $order_hour;
        }

        if ($this->input->post('order_minute')) {
            $data['order_minute'] = $this->input->post('order_minute');                            // retrieve order_time value from $_POST data if set
        } else if (isset($order_data['order_minute'], $data['order_times'][$data['order_date']][$order_data['order_hour']])
            AND in_array($order_data['order_minute'], $data['order_times'][$data['order_date']][$order_data['order_hour']])) {
            $data['order_minute'] = $order_data['order_minute'];                                    // retrieve order_type from session data
        } else {
            $data['order_minute'] = $order_minute;
        }

        if ($this->input->post('order_time')) {
            $data['order_time'] = $this->input->post('order_time');                            // retrieve order_time value from $_POST data if set
        } else if (isset($order_data['order_time'])) {
            $data['order_time'] = $order_data['order_time'];                                    // retrieve order_type from session data
        } else {
            $data['order_time'] = '';
        }

        if ($this->input->post('address_id')) {
            $data['address_id'] = $this->input->post('address_id');                // retrieve existing_address value from $_POST data if set
        } else if (isset($order_data['address_id'])) {
            $data['address_id'] = $order_data['address_id'];                        // retrieve existing_address from session data
        } else if ($this->customer->getAddressId()) {
            $data['address_id'] = $this->customer->getAddressId();                                        // retrieve customer default address id from customer library
        } else {
            $data['address_id'] = '';
        }

        if ($this->config->item('country_id')) {
            $country_id = $this->config->item('country_id'); 						// retrieve country_id from config settings
        }

        if ($this->input->post('address')) {
            $addresses = $this->input->post('address');                            // retrieve address value from $_POST data if set
        } else if ($this->customer->islogged()) {
            $addresses = $this->Addresses_model->getAddresses($this->customer->getId());                            // retrieve customer addresses array from getAddresses method in Customers model
        } else if (!empty($order_data['address_id'])) {
            $addresses = array($this->Addresses_model->getGuestAddress($order_data['address_id']));                            // retrieve customer addresses array from getAddresses method in Customers model
        }

        if (empty($addresses)) {
            $addresses = array(array('address_id' => '0', 'address_1' => '', 'address_2' => '', 'city' => '', 'state' => '', 'postcode' => '', 'country_id' => $country_id));
        }

        $data['addresses'] = array();
        if ($addresses) {
            foreach ($addresses as $address) {                                                    // loop through customer addresses arrary
                if (empty($address['country'])) {
                    $country = $this->Countries_model->getCountry($address['country_id']);
                    $address['country'] = !empty($address['country']) ? $address['country'] : $country['country_name'];
                }

                $data['addresses'][] = array(                                                    // create array of address data to pass to view
                    'address_id'    => (isset($address['address_id'])) ? $address['address_id'] : NULL,
                    'address_1'     => $address['address_1'],
                    'address_2'     => $address['address_2'],
                    'city'          => $address['city'],
                    'state'         => $address['state'],
                    'postcode'      => $address['postcode'],
                    'country_id'    => $address['country_id'],
                    'address'       => $this->country->addressFormat($address)
                );
            }
        }

        if ($this->input->post('comment')) {
            $data['comment'] = $this->input->post('comment');                            // retrieve comment value from $_POST data if set
        } else if (isset($order_data['comment'])) {
            $data['comment'] = $order_data['comment'];                                    // retrieve comment from session data
        } else {
            $data['comment'] = '';
        }

        if ($this->input->post('payment')) {
            $data['payment'] = $this->input->post('payment');                            // retrieve comment value from $_POST data if set
        } else if (isset($order_data['payment'])) {
            $data['payment'] = $order_data['payment'];                                    // retrieve comment from session data
        } else {
            $data['payment'] = '';
        }

        if ($this->config->item('checkout_terms') > 0) {
            $data['checkout_terms'] = str_replace(root_url(), '/', site_url('pages?popup=1&page_id='.$this->config->item('checkout_terms')));
        } else {
            $data['checkout_terms'] = FALSE;
        }

        if ($this->input->ip_address()) {
            $data['ip_address'] = $this->input->ip_address();                                    // retrieve ip_address value if set
        }

        $data['countries'] = array();
        $results = $this->Countries_model->getCountries(); 										// retrieve countries array from getCountries method in locations model
        foreach ($results as $result) {															// loop through crountries array
            $data['countries'][] = array( 														// create array of countries data to pass to view
                'country_id'	=>	$result['country_id'],
                'name'			=>	$result['country_name'],
            );
        }

        $data['payments'] = array();
        $local_payments = $this->location->payments();
        $payments = $this->extension->getAvailablePayments();
        foreach (sort_array($payments) as $code => $payment) {
            if (!empty($local_payments) AND !in_array($payment['code'], $local_payments)) continue;
            $data['payments'][] = $payment;
        }

        return $data;
    }

	private function _validateCheckout() {														// method to validate checkout form fields
        if ($this->input->post() AND $this->validateForm() === TRUE) {
            $order_data = $this->session->userdata('order_data');

            if ($this->location->getId()) {
                $order_data['location_id'] = $this->location->getId();					// retrieve location id from location library and add to order_data array
            }

            $order_data['customer_id'] = $this->customer->isLogged() ? $this->customer->getId() : '0';					// retrive customer id from customer library and add to order_data array

	        $order_data['checkout_step']    = empty($order_data['checkout_step']) ? 'one' : $order_data['checkout_step'];
	        $order_data['first_name'] 	    = $this->input->post('first_name');
            $order_data['last_name'] 	    = $this->input->post('last_name');
            $order_data['email'] 		    = $this->customer->isLogged() ? $this->customer->getEmail() : $this->input->post('email');
            $order_data['telephone'] 	    = $this->input->post('telephone');
            $order_data['order_time_type']  = $this->input->post('order_time_type');
            $order_data['order_asap_time']  = $this->input->post('order_asap_time');
            $order_data['order_date'] 	    = $this->input->post('order_date');
            $order_data['order_hour'] 	    = $this->input->post('order_hour');
            $order_data['order_minute'] 	= $this->input->post('order_minute');
            $order_data['order_time'] 	    = $this->input->post('order_time');					// retrieve order_time value from $_POST data if set and add to order_data array
            $order_data['order_type'] 	    = $this->location->orderType();				// retrieve order_type value from $_POST data if set and convert to integer then add to order_data array
            $order_data['address_id'] 	    = (int) $this->input->post('address_id');				// retrieve address_id value from $_POST data if set and convert to integer then add to order_data array
            $order_data['comment'] 		    = $this->input->post('comment');						// retrieve comment value from $_POST data if set and convert to integer then add to order_data array

            if ($this->location->orderType() === '1') {
                foreach ($this->input->post('address') as $key => $address) {
                    $_POST['address'][$key]['country'] = $address['country_id'];

                    !empty($address['address_id']) OR $address['address_id'] = NULL;

                    $_POST['address'][$key]['address_id'] = $address['address_id'] = $this->Addresses_model->saveAddress($order_data['customer_id'], $address['address_id'], $address);    // send new-address $_POST data and customer id to saveAddress method in Customers model

                    if (empty($order_data['address_id']) OR $address['address_id'] === $order_data['address_id']) {
                        $order_data['address_id'] = $address['address_id'];
                        $order_data['address'] = $address;
                    }
                }
            }

            if ($this->input->post('checkout_step') === 'one' OR $this->input->post('checkout_step') === 'two') {
	            $order_data['checkout_step'] = 'two';
            }

	        if ($this->input->post('checkout_step') === 'two' AND $order_data['checkout_step'] === 'two' AND $this->input->post('payment')) {
                $order_data['payment'] = $this->input->post('payment');
                $order_data['ext_payment'] = $this->extension->getPayment($order_data['payment']);

                if ($this->config->item('checkout_terms') > 0) {
                    $order_data['terms_condition'] = $this->input->post('terms_condition');
                }

                return $this->_confirmPayment($order_data, $this->session->userdata('cart_contents'));
            } else {
		        $this->session->set_userdata('order_data', $order_data);					// save order details to session and return TRUE
            }

            return TRUE;
        }
    }

	private function _confirmPayment($order_data, $cart_contents) {

        if (!empty($order_data) AND !empty($cart_contents) AND $this->input->post('payment')) {

            $order_data['order_id'] = $this->Orders_model->addOrder($order_data, $cart_contents);

            $this->session->set_userdata('order_data', $order_data);					// save order details to session and return TRUE

            if ($order_info = $this->Orders_model->getOrder($order_data['order_id'], $order_data['customer_id'])) {	// retrieve order details array from getMainOrder method in Orders model

                if (!empty($order_info['order_id']) AND !empty($order_data['ext_payment'])) {

                    $payment = $order_data['ext_payment'];

                    $payment_class = strtolower($payment['name']);
                    $payment_controller = $payment_class.'/'.$payment_class;

                    $this->load->module($payment_controller);
                    return $this->{$payment_class}->confirm();
                }
            }
		}
	}

	private function validateForm() {
		// START of form validation rules
		$this->form_validation->set_rules('first_name', 'lang:label_first_name', 'xss_clean|trim|required|min_length[2]|max_length[32]');
		$this->form_validation->set_rules('last_name', 'lang:label_last_name', 'xss_clean|trim|required|min_length[2]|max_length[32]');
		$this->form_validation->set_rules('email', 'lang:label_email', 'xss_clean|trim|required|valid_email|max_length[96]');

		if (strtolower($this->input->post('email')) !== $this->customer->getEmail()) {
			$this->form_validation->set_rules('email', 'lang:label_email', 'is_unique[customers.email]');
			$this->form_validation->set_message('is_unique', 'Warning: E-Mail Address is already registered!');
		}

        $order_type_text = ($this->location->orderType() === '1') ? $this->lang->line('label_delivery') : $this->lang->line('label_collection');

		$this->form_validation->set_rules('telephone', 'lang:label_telephone', 'xss_clean|trim|required|numeric|max_length[20]');
		$this->form_validation->set_rules('order_time_type', sprintf(lang('label_order_time_type'), $order_type_text), 'xss_clean|trim|required|alpha');

        if ($this->input->post('order_time_type') === 'asap') {
            $this->form_validation->set_rules('order_asap_time', sprintf(lang('label_order_asap_time'), $order_type_text), 'xss_clean|trim|required|callback__validate_time');
        } else {
            $this->form_validation->set_rules('order_date', 'lang:label_date', 'xss_clean|trim|required|valid_date');
            $this->form_validation->set_rules('order_hour', 'lang:label_hour', 'xss_clean|trim|required|numeric|callback__validate_time');
            $this->form_validation->set_rules('order_minute', 'lang:label_minute', 'xss_clean|trim|required|numeric');
        }

        if ($this->location->orderType() === '1' AND $this->input->post('address')) {
            $this->form_validation->set_rules('address_id', 'lang:label_address', 'xss_clean|trim|integer|callback__validate_address');

            foreach ($this->input->post('address') as $key => $address) {
				$this->form_validation->set_rules('address['.$key.'][address_id]', 'lang:label_address_id', 'xss_clean|trim');
				$this->form_validation->set_rules('address['.$key.'][address_1]', 'lang:label_address_1', 'xss_clean|trim|required|min_length[3]|max_length[128]');
				$this->form_validation->set_rules('address['.$key.'][city]', 'lang:label_city', 'xss_clean|trim|required|min_length[2]|max_length[128]');
				$this->form_validation->set_rules('address['.$key.'][state]', 'lang:label_state', 'xss_clean|trim|max_length[128]');
				$this->form_validation->set_rules('address['.$key.'][postcode]', 'lang:label_postcode', 'xss_clean|trim|min_length[2]|max_length[10]');
				$this->form_validation->set_rules('address['.$key.'][country_id]', 'lang:label_country', 'xss_clean|trim|required|integer');
			}
		}

		$this->form_validation->set_rules('comment', 'lang:label_comment', 'xss_clean|trim|max_length[520]');

		if ($this->input->post('checkout_step') === 'two') {
			$this->form_validation->set_rules('payment', 'lang:label_payment_method', 'xss_clean|trim|required|alpha_dash|callback__validate_payment');

            if ($this->config->item('checkout_terms') > 0) {
                $this->form_validation->set_rules('terms_condition', 'lang:button_agree_terms', 'xss_clean|trim|required|integer');
            }
		}

		// END of form validation rules

  		if ($this->form_validation->run() === TRUE) {											// checks if form validation routines ran successfully
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function _validate_time($str) { 	// validation callback function to check if order_time $_POST data is a valid time, is less than the restaurant current time and is within the restaurant opening and closing hour
        if ($this->input->post('order_time_type') === 'later') {
            $str = "{$this->input->post('order_date')} {$this->input->post('order_hour')}:{$this->input->post('order_minute')}";
        }

        $order_type = ($this->location->orderType() === '1') ? 'delivery' : 'collection';

        if (strtotime($str) < time()) {
        	$this->form_validation->set_message('_validate_time', $this->lang->line('error_delivery_less_current_time'));
      		return FALSE;
    	} else if ( ! $this->location->checkOrderTime($str, $order_type)) {
        	$this->form_validation->set_message('_validate_time', $this->lang->line('error_no_delivery_time'));
      		return FALSE;
        }

        $_POST['order_time'] = $str;
        return TRUE;
    }

	public function _validate_address($address_id) {
        $addresses = $this->input->post('address');

        if ($this->location->orderType() === '1' AND !empty($addresses[0]['address_1'])) {
            $location_id = $this->location->getId();
            $area_id = $this->location->getAreaId();

            foreach ($addresses as $address) {
                if (empty($address_id) OR $address['address_id'] === $address_id) {
                    $country = $this->Countries_model->getCountry($address['country_id']);
                    $address['country'] = $country['country_name'];
                    unset($address['address_id'], $address['country_id']);

                    if ($area = $this->location->checkDeliveryCoverage($address)) {
	                    if (isset($area['area_id']) AND ($area['area_id'] != $area_id OR $area['location_id'] != $location_id)) {
                            $this->location->setDeliveryArea($area);

                            $this->alert->set('alert', $this->lang->line('alert_delivery_area_changed'));

		                    if ($this->input->post('checkout_step') === 'two') {
			                    redirect('checkout');
		                    }
	                    }

	                    return TRUE;
                    }
                }
            }

            $this->form_validation->set_message('_validate_address', $this->lang->line('error_covered_area'));
            return FALSE;
		}
	}

	public function _validate_payment($payment) {
        $local_payments = $this->location->payments();
        if (is_array($local_payments) AND !in_array($payment, $local_payments)) {
            $this->form_validation->set_message('_validate_payment', $this->lang->line('error_invalid_payment'));
            return FALSE;
        }

        return TRUE;
    }
}

/* End of file checkout.php */
/* Location: ./main/controllers/checkout.php */