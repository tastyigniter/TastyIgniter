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
		
		if ( ! $this->cart->contents()) { 														// checks if cart contents is empty  
			$this->session->set_flashdata('alert', $this->lang->line('warning_no_cart'));
		  	redirect('menus');																	// redirect to menus page and display error
		} else if ( ! $this->location->local()) { 												// else if local restaurant is not selected
			$this->session->set_flashdata('alert', $this->lang->line('warning_no_local'));
  			redirect('home');																	// redirect to home page and display error
		} else if ( ! $this->location->isOpened()) { 											// else if local restaurant is not open
			$this->session->set_flashdata('alert', $this->lang->line('warning_is_closed'));
  			redirect('menus');																	// redirect to menus page and display error
		} else if ( ! $this->customer->islogged()) { 											// else if customer is not logged in
			//$this->session->set_flashdata('alert', $this->lang->line('warning_not_logged'));
  			redirect('account/login');														// redirect to account register page and display error
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

		$data['button_left'] 	= '<a class="button" href='. $this->config->site_url("checkout") .'>'. $this->lang->line('button_back') .'</a>';
		$data['button_right'] 	= '<a class="button" onclick="$(\'#payment-form\').submit();">'. $this->lang->line('button_continue') .'</a>';
		// END of retrieving lines from language file to send to view.
		
		if ($this->input->post('payment')) {
			$data['payment'] = $this->input->post('payment'); 									// retrieve payment value from $_POST data if set
		} else {
			$data['payment'] = '';
		}
						
		if ($this->input->ip_address()) {
			$data['ip_address'] = $this->input->ip_address(); 									// retrieve ip_address value if set
		}
		
		if ($this->input->post() && $this->_validatePayment() === FALSE) { 						// check if post data and validate checkout is successful
			redirect('payments');				
		}
		
		$regions = array(
			'main/header',
			'main/content_right',
			'main/footer'
		);
		
		$this->template->regions($regions);
		$this->template->load('main/payments', $data);
	}

	public function paypal() {
		
		if ($this->customer->islogged()) { 														// if customer is logged in
			$customer_id = $this->customer->getId(); 											// retrieve customer id
		}

		if ($this->input->get('token') && $this->input->get('PayerID')) { 						// check if token and PayerID is in $_GET data

			$token 			= $this->input->get('token'); 												// retrieve token from $_GET data
			$payer_id 		= $this->input->get('PayerID'); 											// retrieve PayerID from $_GET data
			$order_info 	= $this->session->userdata('order_details'); 						// retrieve order details from session userdata

			$transaction_id = $this->Payments_model->doExpressCheckout($token, $payer_id);
			
			if ($transaction_id) {
				
				$order_info['payment'] = 'paypal';
				$order_id = $this->Orders_model->addOrder($order_info, $this->cart->contents());
				
				$this->Payments_model->saveTransactionDetails($transaction_id, $order_id, $customer_id);
				
				$this->session->set_userdata('order_id', $order_id);
				redirect('checkout/success');
			}
		}

		redirect('payments');
	}

	public function _validatePayment() {

		$this->form_validation->set_rules('payment', 'Payment Method', 'trim|required');
		
		if ($this->form_validation->run() === TRUE) {
			
			$order_details = $this->session->userdata('order_details'); 							// retrieve order details from session userdata
			$cart_details = $this->cart->contents(); 												// retrieve cart contents
		
			if ($this->input->post('payment') === 'cod') { 											// else if payment method is cash on delivery
			
				$order_details['payment'] = 'cod';
				$order_id = $this->Orders_model->addOrder($order_details, $cart_details);
				$this->session->set_userdata('order_id', $order_id);
			
				redirect('checkout/success');									// redirect to checkout success page with returned order id

			}
		
			if ($this->input->post('payment') === 'paypal') { 								// check if payment method is equal to paypal
			
				$result = $this->Payments_model->setExpressCheckout();
				
				$this->session->set_userdata('order_id', $result);
			}
	
			return FALSE;
		}
	}
}