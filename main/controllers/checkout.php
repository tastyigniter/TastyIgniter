<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Checkout extends Main_Controller {

	public function __construct() {
		parent::__construct(); 																	//  calls the constructor
		$this->load->library('customer'); 														// load the customer library
		$this->load->library('cart'); 															// load the cart library
		$this->load->library('location'); 														// load the location library
		$this->load->library('currency'); 														// load the currency library
		$this->load->library('country'); 														// load the currency library
		$this->load->model('Pages_model');
		$this->load->model('Addresses_model'); 													// load the addresses model
		$this->load->model('Orders_model'); 													// load the orders model
		$this->load->model('Locations_model'); 													// load the locations model
		$this->load->model('Countries_model');
		$this->load->model('Extensions_model');
		$this->load->library('user_agent');
		$this->lang->load('checkout');
	}

	public function index() {
		if ( ! $this->cart->contents()) { 														// checks if cart contents is empty
			$this->alert->set('alert', $this->lang->line('alert_no_cart'));
  			redirect('menus');																	// redirect to menus page and display error
		}

		if ( ! $this->location->local() AND $this->config->item('location_order') === '1') { 														// else if local restaurant is not selected
			$this->alert->set('alert', $this->lang->line('alert_no_local'));
            redirect('menus');																	// redirect to menus page and display error
        }

        if ( ! $this->location->isOpened() AND $this->config->item('future_orders') !== '1') { 													// else if local restaurant is not open
            $this->alert->set('alert', $this->lang->line('alert_closed'));
            redirect('menus');																	// redirect to menus page and display error
		}

		if (( ! $this->location->hasDelivery() AND ! $this->location->hasCollection()) AND $this->config->item('location_order') === '1') { 													// else if local restaurant is not open
			$this->alert->set('alert', $this->lang->line('alert_no_order'));
  			redirect('menus');																	// redirect to menus page and display error
		}

		if ($this->location->orderType() === '1' AND ! $this->location->checkMinimumOrder($this->cart->total())) { 							// checks if cart contents is empty
  			redirect('menus');																	// redirect to menus page and display error
		}

		if ( ! $this->customer->islogged() AND $this->config->item('guest_order') !== '1') { 											// else if customer is not logged in
			$this->alert->set('alert', $this->lang->line('alert_not_logged'));
  			redirect('account/login');															// redirect to account register page and display error
		}

		if ($this->input->post() AND $this->_validateCheckout() === TRUE) { 						// check if post data and validate checkout is successful
            redirect('checkout');
        }

		$this->template->setBreadcrumb('<i class="fa fa-home"></i>', '/');
		$this->template->setBreadcrumb($this->lang->line('text_heading'), 'checkout');

		// START of retrieving lines from language file to pass to view.
		$this->template->setTitle($this->lang->line('text_heading'));
		//$this->template->setHeading($this->lang->line('text_heading'));
		$data['text_heading'] 			= $this->lang->line('text_heading');
		$data['text_checkout'] 			= $this->lang->line('text_checkout');
		$data['text_login_register']	= $this->customer->isLogged() ? sprintf($this->lang->line('text_logout'), $this->customer->getFirstName(), site_url('account/logout')) : sprintf($this->lang->line('text_registered'), site_url('account/login'));
		$data['text_asap']				= $this->lang->line('text_asap');
		$data['text_closed']			= $this->lang->line('text_closed');
		$data['text_edit']				= $this->lang->line('text_edit');
		$data['text_existing']			= $this->lang->line('text_existing');
		$data['text_payments'] 			= $this->lang->line('text_payments');
		$data['text_ip_warning'] 		= $this->lang->line('text_ip_warning');
		$data['entry_first_name'] 		= $this->lang->line('entry_first_name');
		$data['entry_last_name'] 		= $this->lang->line('entry_last_name');
		$data['entry_email'] 			= $this->lang->line('entry_email');
		$data['entry_telephone'] 		= $this->lang->line('entry_telephone');
		$data['entry_order_type'] 		= $this->lang->line('entry_order_type');
		$data['entry_delivery'] 		= $this->lang->line('entry_delivery');
		$data['entry_collection'] 		= $this->lang->line('entry_collection');
		$data['entry_order_time'] 		= $this->lang->line('entry_order_time');
		$data['entry_address'] 			= $this->lang->line('entry_address');
		$data['entry_address_1'] 		= $this->lang->line('entry_address_1');
		$data['entry_address_2'] 		= $this->lang->line('entry_address_2');
		$data['entry_city'] 			= $this->lang->line('entry_city');
		$data['entry_postcode'] 		= $this->lang->line('entry_postcode');
		$data['entry_country'] 			= $this->lang->line('entry_country');
		$data['entry_payment_method'] 	= $this->lang->line('entry_payment_method');
        $data['entry_terms'] 			= $this->lang->line('entry_terms');
        $data['entry_comments'] 		= $this->lang->line('entry_comments');
		$data['entry_ip'] 				= $this->lang->line('entry_ip');
		$data['button_check_postcode'] 	= $this->lang->line('button_check_postcode');
		// END of retrieving lines from language file to send to view.

        $order_data = $this->session->userdata('order_data');

        $data['action'] = site_url('checkout');

		if (isset($order_data['customer_id']) AND $order_data['customer_id'] !== $this->customer->getId()) {
            $order_data = array();
            $this->session->unset_userdata('order_data');
		}

        $data = $this->getFormData($order_data, $data);

		$data['countries'] = array();
		$results = $this->Countries_model->getCountries(); 										// retrieve countries array from getCountries method in locations model
		foreach ($results as $result) {															// loop through crountries array
			$data['countries'][] = array( 														// create array of countries data to pass to view
				'country_id'	=>	$result['country_id'],
				'name'			=>	$result['country_name'],
			);
		}

		$start_time = $this->location->openingTime();
		$end_time = $this->location->lastOrderTime();											// retrieve location closing time from location library
		$current_time = $this->location->currentTime(); 								// retrieve the location current time from location library
		$delivery_time = $this->location->deliveryTime();

		$data['asap_time'] = mdate('%H:%i', strtotime($current_time) + $delivery_time * 60);
		$data['delivery_times'] = array();
		$delivery_times = $this->location->generateHours($start_time, $end_time, $delivery_time); 	// retrieve the location delivery times from location library
		foreach ($delivery_times as $key => $value) {											// loop through delivery times
			if (strtotime($value) > (strtotime($current_time)) OR $this->config->item('future_orders') === '1') {
				$data['delivery_times'][] = array( 													// create array of delivery_times data to pass to view
					'12hr'		=> mdate('%h:%i %a', strtotime($value)),
					'24hr'		=> $value
				);
			}
		}

        $data['payments'] = array();
        $payments = $this->Extensions_model->getPayments();
        $local_payments = $this->location->payments();
        foreach ($payments as $payment) {
            if (!empty($local_payments) AND !in_array($payment['name'], $local_payments)) continue;

            if (!empty($payment['ext_data'])) {
                if ($payment['ext_data']['status'] === '1') {

                    $data['payments'][] = array(
						'name'		=> $payment['title'],
						'code'		=> $payment['name'],
						'priority'	=> $payment['ext_data']['priority'],
						'status'	=> $payment['ext_data']['status'],
                        'data'      => Modules::run($payment['name'] . '/' . $payment['name'] . '/index')
					);
				}
			}
		}

        $sort_order = array();
        foreach ($data['payments'] as $key => $value) {
            $sort_order[$key] = $value['priority'];
        }
        array_multisort($sort_order, SORT_ASC, $data['payments']);

		$this->template->setPartials(array('header', 'content_top', 'content_left', 'content_right', 'content_bottom', 'footer'));
		$this->template->render('checkout', $data);
	}

	public function success() {
		if ($this->customer->islogged()) {														// checks if customer is logged in
			$customer_id = $this->customer->getId();											// retrieve customer id from customer library
		} else {
			$customer_id = '';
		}

        $order_data = $this->session->userdata('order_data'); 						            // retrieve order details from session userdata

        $order_id = is_numeric($order_data['order_id']) ? $order_data['order_id'] : '0';
        $order_info = $this->Orders_model->getOrder($order_id, $customer_id);	// retrieve order details array from getMainOrder method in Orders model

        if (empty($order_info) AND empty($order_info['order_id']) AND empty($order_info['status_id'])) {																	// checks if array is returned
            redirect('menus');
        }

        $this->template->setBreadcrumb('<i class="fa fa-home"></i>', '/');
		$this->template->setBreadcrumb($this->lang->line('text_success_heading'), 'checkout/success');

		// START of retrieving lines from language file to pass to view.
		$this->template->setTitle($this->lang->line('text_success_heading'));
//		$this->template->setHeading($this->lang->line('text_success_heading'));
		$data['text_heading'] 				= $this->lang->line('text_success_heading');
		$data['text_order_details'] 		= $this->lang->line('text_order_details');
		$data['text_order_items'] 			= $this->lang->line('text_order_items');
		$data['text_delivery_address'] 		= $this->lang->line('text_delivery_address');
		$data['text_local'] 				= $this->lang->line('text_local');
		$data['text_thank_you'] 			= $this->lang->line('text_thank_you');
		// END of retrieving lines from language file to send to view.

        $data['message'] = sprintf($this->lang->line('text_success_message'), $order_info['order_id'], site_url('account/orders'));

        // checks if order type is delivery or collection
        $order_type = ($order_info['order_type'] === '1') ? 'delivery' : 'collection';

        if (!empty($order_data['ext_payment']['title'])) { 										// checks if payment method is paypal or cod
            $payment_method = $order_data['ext_payment']['title'];
        } else {
            $payment_method = 'N/A';
        }

        $data['order_details'] = sprintf($this->lang->line('text_order_info'), $order_type,  mdate('%d %M %y - %H:%i', strtotime($order_info['date_added'])), mdate('%d %M %y - %H:%i', strtotime($order_info['order_time'])), $payment_method);

        $data['menus'] = array();
        $menus = $this->Orders_model->getOrderMenus($order_info['order_id']);
        $menu_options = $this->Orders_model->getOrderMenuOptions($order_info['order_id']);
        foreach ($menus as $menu) {
            $option_data = array();

            if (!empty($menu_options[$menu['menu_id']])) {
                foreach ($menu_options[$menu['menu_id']] as $menu_option) {
                    $option_data[] = $menu_option['order_option_name'];
                }
            }

            $data['menus'][] = array(													// load menu data into array
                'menu_id' 		=> $menu['menu_id'],
                'name' 			=> (strlen($menu['name']) > 20) ? substr($menu['name'], 0, 20) .'...' : $menu['name'],
                'price' 		=> $this->currency->format($menu['price']),		//add currency symbol and format item price to two decimal places
                'quantity' 		=> $menu['quantity'],
                'subtotal' 		=> $this->currency->format($menu['subtotal']), 	//add currency symbol and format item subtotal to two decimal places
                'options' 		=> implode(', ', $option_data)
            );
        }

        $order_coupon = $this->Orders_model->getOrderCoupon($order_info['order_id']);
        $data['order_coupon'] = sprintf($this->lang->line('text_order_coupon'), $this->currency->format($order_coupon['amount']));

        $data['order_total'] = sprintf($this->lang->line('text_order_total'), $this->currency->format($order_info['order_total']));

        if (!empty($order_info['address_id'])) {											// checks if address_id is set then retrieve delivery address
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

        $this->template->setPartials(array('header', 'content_top', 'content_left', 'content_right', 'content_bottom', 'footer'));
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

        if ($data['checkout_step'] === 'two') {
            $data['button_back'] 		= '<a class="btn btn-default" onClick="$(\'#checkout\').fadeIn();$(\'#payment\').empty();$(this).fadeOut();$(\'.btn-checkout\').html(\'Payment\');$(\'.checkout_step\').val(\'one\')">'. $this->lang->line('button_back') .'</a>';
            $data['button_continue'] 	= '<a class="btn btn-success btn-checkout btn-lg" onclick="$(\'#checkout-form\').submit();">'. $this->lang->line('button_confirm') .'</a>';
        } else {
            $data['button_back'] 		= '<a class="btn btn-default" href="'. site_url('menus') .'">'. $this->lang->line('button_back') .'</a>';
            $data['button_continue'] 	= '<a class="btn btn-success btn-checkout btn-lg" onclick="$(\'#checkout-form\').submit();">'. $this->lang->line('button_continue') .'</a>';
        }

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

        if ($this->input->post('email')) {
            $data['email'] = $this->input->post('email');
        } else if (isset($order_data['email'])) {
            $data['email'] = $order_data['email'];                                // retrieve customer email from session data
        } else if ($this->customer->getEmail()) {
            $data['email'] = $this->customer->getEmail();                                        // retrieve customer email address from customer library
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
        if ($this->input->post('order_type')) {
            $data['order_type'] = $this->input->post('order_type');                            // retrieve order_type value from $_POST data if set
        } else if (isset($order_data['order_type'])) {
            $data['order_type'] = $order_data['order_type'];                                    // retrieve order_type from session data
        } else if (isset($local_info['order_type'])) {
            $data['order_type'] = $local_info['order_type'];
        } else {
            $data['order_type'] = '1';
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
            $addresses = array(array('address_id' => '', 'address_1' => '', 'address_2' => '', 'city' => '', 'postcode' => '', 'country_id' => $country_id));
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

        $data['checkout_terms'] = ($this->config->item('checkout_terms') === '1') ? TRUE : FALSE;

        if ($this->input->ip_address()) {
            $data['ip_address'] = $this->input->ip_address();                                    // retrieve ip_address value if set
        }

        return $data;
    }

	public function _validateCheckout() {														// method to validate checkout form fields
        if ($this->input->post() AND $this->validateForm() === TRUE) {
            $order_data = $this->session->userdata('order_data');

            if ($this->location->getId()) {
                $order_data['location_id'] = $this->location->getId();					// retrieve location id from location library and add to order_data array
            }

            if ($this->customer->islogged() AND $this->customer->getId()) {
                $order_data['customer_id'] = $this->customer->getId();					// retrive customer id from customer library and add to order_data array
            } else {
                $order_data['customer_id'] = '';
            }

            $order_data['checkout_step'] = $this->input->post('checkout_step');
            $order_data['first_name'] 	= $this->input->post('first_name');
            $order_data['last_name'] 	= $this->input->post('last_name');
            $order_data['email'] 		= $this->input->post('email');
            $order_data['telephone'] 	= $this->input->post('telephone');
            $order_data['order_time'] 	= $this->input->post('order_time');					// retrieve order_time value from $_POST data if set and add to order_data array
            $order_data['order_type'] 	= $this->input->post('order_type');				// retrieve order_type value from $_POST data if set and convert to integer then add to order_data array
            $order_data['address_id'] 	= (int) $this->input->post('address_id');				// retrieve address_id value from $_POST data if set and convert to integer then add to order_data array
            $order_data['comment'] 		= $this->input->post('comment');						// retrieve comment value from $_POST data if set and convert to integer then add to order_data array

            if ($this->input->post('order_type') === '1') {
                foreach ($this->input->post('address') as $key => $address) {
                    $address['country'] = $address['country_id'];

                    !empty($address['address_id']) OR $address['address_id'] = NULL;

                    $address['address_id'] = $this->Addresses_model->saveAddress($order_data['customer_id'], $address['address_id'], $address);    // send new-address $_POST data and customer id to saveAddress method in Customers model

                    if (empty($order_data['address_id']) OR $address['address_id'] === $order_data['address_id']) {
                        $order_data['address_id'] = $address['address_id'];
                        $order_data['address'] = $address;
                    }
                }
            }

            if ($this->input->post('checkout_step') === 'one') {
                $order_data['checkout_step'] = 'two';
            }

            if ($this->input->post('checkout_step') === 'two' AND $this->input->post('payment')) {
                $order_data['payment'] = $this->input->post('payment');
                $order_data['ext_payment'] = $this->Extensions_model->getPayment($order_data['payment']);

                if ($this->config->item('checkout_terms') === '1') {
                    $order_data['terms_condition'] = $this->input->post('terms_condition');
                }

                $this->_confirmPayment($order_data, $this->session->userdata('cart_contents'));
            } else {
                $this->session->set_userdata('order_data', $order_data);					// save order details to session and return TRUE
            }

            return TRUE;
        } else {
            $this->session->unset_userdata('order_data');					// remove order details to session and return TRUE
        }

    }

	public function _confirmPayment($order_data, $cart_contents) {

        if (!empty($order_data) AND !empty($cart_contents) AND $this->input->post('payment')) {

            $order_data['order_id'] = $this->Orders_model->addOrder($order_data, $cart_contents);

            $this->session->set_userdata('order_data', $order_data);					// save order details to session and return TRUE

            if ($order_info = $this->Orders_model->getOrder($order_data['order_id'], $order_data['customer_id'])) {	// retrieve order details array from getMainOrder method in Orders model

                if (!empty($order_info['order_id']) AND !empty($order_data['ext_payment'])) {

                    $payment = $order_data['ext_payment'];

                    $payment_class = strtolower($payment['name']);
                    $payment_controller = $payment_class.'/'.$payment_class;

                    $this->load->module($payment_controller);
                    $response = $this->{$payment_class}->confirm();

                    return $response;
                }
            }
		}
	}

	public function validateForm() {
		// START of form validation rules
		$this->form_validation->set_rules('first_name', 'First Name', 'xss_clean|trim|required|min_length[2]|max_length[32]');
		$this->form_validation->set_rules('last_name', 'Last Name', 'xss_clean|trim|required|min_length[2]|max_length[32]');
		$this->form_validation->set_rules('email', 'Email', 'xss_clean|trim|required|valid_email|max_length[96]');

		if (strtolower($this->input->post('email')) !== $this->customer->getEmail()) {
			$this->form_validation->set_rules('email', 'Email', 'is_unique[customers.email]');
			$this->form_validation->set_message('is_unique', 'Warning: E-Mail Address is already registered!');
		}

		$this->form_validation->set_rules('telephone', 'Telephone', 'xss_clean|trim|required|numeric|max_length[20]');
		$this->form_validation->set_rules('order_type', 'Order Type', 'xss_clean|trim|required|integer|callback_order_type');
		$this->form_validation->set_rules('order_time', 'Delivery or Collection Time', 'xss_clean|trim|required|valid_time|callback_validate_time');

        if ($this->input->post('order_type') === '1' AND $this->input->post('address')) {
            $this->form_validation->set_rules('address_id', 'Address', 'xss_clean|trim|integer|callback_validate_address');

            foreach ($this->input->post('address') as $key => $address) {
				$this->form_validation->set_rules('address['.$key.'][address_id]', 'Address', 'xss_clean|trim');
				$this->form_validation->set_rules('address['.$key.'][address_1]', 'Address 1', 'xss_clean|trim|required|min_length[3]|max_length[128]');
				$this->form_validation->set_rules('address['.$key.'][city]', 'City', 'xss_clean|trim|required|min_length[2]|max_length[128]');
				$this->form_validation->set_rules('address['.$key.'][postcode]', 'Postcode', 'xss_clean|trim|required|min_length[2]|max_length[10]');
				$this->form_validation->set_rules('address['.$key.'][country_id]', 'Country', 'xss_clean|trim|required|integer');
			}
		}

		$this->form_validation->set_rules('comment', 'Comment', 'xss_clean|trim|max_length[520]');

		if ($this->input->post('checkout_step') === 'two') {
			$this->form_validation->set_rules('payment', 'Payment Method', 'xss_clean|trim|required|alpha_dash|callback_validate_payment');

            if ($this->config->item('checkout_terms') === '1') {
                $this->form_validation->set_rules('terms_condition', 'Terms & Condition', 'xss_clean|trim|required|integer');
            }
		}

		// END of form validation rules

  		if ($this->form_validation->run() === TRUE) {											// checks if form validation routines ran successfully
			return TRUE;
		} else {
			return FALSE;
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
		if ($this->config->item('location_order') === '1') {
			if (($type == '1') AND ( ! $this->location->hasDelivery())) { 					// checks if cart contents is empty
				$this->form_validation->set_message('order_type', $this->lang->line('error_no_delivery'));
				return FALSE;
			} else if (($type == '2') AND ( ! $this->location->hasCollection())) { 				// checks if cart contents is empty
				$this->form_validation->set_message('order_type', $this->lang->line('error_no_collection'));
				return FALSE;
			} else {																				// else validation is successful
				return TRUE;
			}
		}
	}

	public function validate_address($address_id) {
        if ($this->input->post('order_type') === '1' AND $this->input->post('address')) {
            foreach ($this->input->post('address') as $address) {
                if (empty($address_id) OR $address['address_id'] === $address_id) {
                    $country = $this->Countries_model->getCountry($address['country_id']);
                    $address['country'] = $country['country_name'];
                    unset($address['address_id'], $address['country_id']);

                    if ($this->location->checkDeliveryCoverage($address)) {
                        return TRUE;
                    }
                }
            }

            $this->form_validation->set_message('validate_address', $this->lang->line('error_covered_area'));
            return FALSE;
		}
	}

	public function validate_payment($payment) {
        $local_payments = $this->location->payments();
        if (is_array($local_payments) AND !in_array($payment, $local_payments)) {
            $this->form_validation->set_message('validate_payment', $this->lang->line('error_local_payment'));
            return FALSE;
        }

        return TRUE;
	}
}

/* End of file checkout.php */
/* Location: ./main/controllers/checkout.php */