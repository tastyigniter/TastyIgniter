<?php
class Payments extends MX_Controller {
	
	public function __construct() {
		parent::__construct(); 																	//  calls the constructor
		$this->load->library('customer'); 														// load the customer library
		$this->load->library('cart'); 															// load the cart library
		$this->load->library('location'); 														// load the location library
		$this->load->library('currency'); 														// load the currency library
		$this->load->model('Orders_model'); 													// load the orders model
		$this->load->model('Payments_model'); 													// load the payments model
	}

	public function index() {
		$this->lang->load('main/payments');  													// loads language file
		
		if (!file_exists(APPPATH .'views/main/payments.php')) {
			show_404();
		}
			
		if ( ! $this->cart->contents()) { 														// checks if cart contents is empty  
			$this->session->set_flashdata('alert', $this->lang->line('warning_no_cart'));
		  	redirect('menus');																	// redirect to menus page and display error
		} else if ( ! $this->location->local() AND $this->config->item('location_order') === '1') { 												// else if local restaurant is not selected
			$this->session->set_flashdata('alert', $this->lang->line('warning_no_local'));
  			redirect('home');																	// redirect to home page and display error
		} else if ( ! $this->location->isOpened()) { 											// else if local restaurant is not open
			$this->session->set_flashdata('alert', $this->lang->line('warning_is_closed'));
  			redirect('menus');																	// redirect to menus page and display error
		} else if ( ! $this->customer->islogged() AND $this->config->item('guest_order') === '0') { 											// else if customer is not logged in
  			redirect('account/login');														// redirect to account register page and display error
		} else if ( ! $this->session->userdata('order_data')) {
  			redirect('checkout');														// redirect to account register page and display error
		}

		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  								// retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		// START of retrieving lines from language file to pass to view.
		$data['text_heading'] 			= $this->lang->line('text_heading');
		$data['text_payments'] 			= $this->lang->line('text_payments');
		$data['text_cod'] 				= $this->lang->line('text_cod');
		$data['text_paypal'] 			= $this->lang->line('text_paypal');
		$data['text_ip_warning'] 		= $this->lang->line('text_ip_warning');
		$data['entry_payment_method'] 	= $this->lang->line('entry_payment_method');
		$data['entry_ip'] 				= $this->lang->line('entry_ip');
		$data['button_check_postcode'] 	= $this->lang->line('button_check_postcode');

		$data['button_left'] 			= '<a class="button" href='. $this->config->site_url("checkout") .'>'. $this->lang->line('button_back') .'</a>';
		$data['button_right'] 			= '<a class="button" onclick="$(\'#payment-form\').submit();">'. $this->lang->line('button_continue') .'</a>';
		// END of retrieving lines from language file to send to view.
		
		if ($this->input->post('payment')) {
			$data['payment'] = $this->input->post('payment'); 									// retrieve payment value from $_POST data if set
		} else {
			$data['payment'] = '';
		}
						
		if ($this->input->ip_address()) {
			$data['ip_address'] = $this->input->ip_address(); 									// retrieve ip_address value if set
		}
		
		if ($this->input->post() AND $this->_validatePayment() === TRUE) { 						// check if post data and validate checkout is successful
			redirect('payments');				
		}
		
		$regions = array('main/header', 'main/content_top', 'main/content_left', 'main/content_right', 'main/footer');
		$this->template->regions($regions);
		$this->template->load('main/payments', $data);
	}

	public function paypal() {
		if ( ! $this->customer->islogged() AND $this->config->item('guest_order') === '0') { 														// if customer is logged in
  			redirect('account/login');														// redirect to account register page and display error
		}

		if ( ! $this->session->userdata('order_data')) {
  			redirect('checkout');														// redirect to account register page and display error
		}
		
		if ($this->input->get('token') AND $this->input->get('PayerID')) { 						// check if token and PayerID is in $_GET data

			$token 			= $this->input->get('token'); 												// retrieve token from $_GET data
			$payer_id 		= $this->input->get('PayerID'); 											// retrieve PayerID from $_GET data
			$order_data 	= $this->session->userdata('order_data'); 						// retrieve order details from session userdata
			$cart_contents 	= $this->session->userdata('cart_contents'); 												// retrieve cart contents

			$transaction_id = $this->Payments_model->doExpressCheckout($token, $payer_id);
			
			if ($transaction_id) {
				$order_data['payment'] = 'paypal';
				$order_id = $this->Orders_model->addOrder($order_data, $cart_contents);
				
				$this->input->set_cookie('last_order_id', $order_id, 300);
				redirect('checkout/success');
			}
		} else {
			redirect('payments');
		}
	}

	public function _validatePayment() {

		$this->form_validation->set_rules('payment', 'Payment Method', 'trim|required');
		
		if ($this->form_validation->run() === TRUE) {
			
			$order_data = $this->session->userdata('order_data'); 						// retrieve order details from session userdata
			$cart_contents = $this->session->userdata('cart_contents'); 												// retrieve cart contents
		
			if ($this->input->post('payment') === 'cod') { 											// else if payment method is cash on delivery
				$order_data['payment'] = 'cod';
				$order_id = $this->Orders_model->addOrder($order_data, $cart_contents);

				$this->input->set_cookie('last_order_id', $order_id, 300);
				redirect('checkout/success');									// redirect to checkout success page with returned order id

			}
		
			if ($this->input->post('payment') === 'paypal') { 								// check if payment method is equal to paypal
				$response = $this->Payments_model->setExpressCheckout();
				
				if (strtoupper($response['ACK']) === 'SUCCESS' OR strtoupper($response['ACK']) === 'SUCCESSWITHWARNING') {
					if ($this->config->item('paypal_mode') === 'sandbox') {
						$api_mode = '.sandbox';
					} else {
						$api_mode = '';
					}
				
					redirect('https://www'. $api_mode .'.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token='. $response['TOKEN'] .'');
				} else {
					log_message('error', $response['L_ERRORCODE0'] .' --> '. $response['L_LONGMESSAGE0'] .' --> '. $response['CORRELATIONID']);			
				}
			}
	
			return TRUE;
		}
	}
}