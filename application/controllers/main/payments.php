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
			$order_id 		= (is_numeric($this->input->cookie('last_order_id'))) ? $this->input->cookie('last_order_id') : FALSE;
			$order_data 	= $this->session->userdata('order_data'); 						// retrieve order details from session userdata

			$transaction_id = $this->Payments_model->doExpressCheckout($token, $payer_id);
			
			if ($transaction_id) {
				$paypal_order = $this->Payments_model->getTransactionDetails($transaction_id, $order_id, $order_data['customer_id']);
				$this->Payments_model->addPaypalOrder($transaction_id, $order_id, $order_data['customer_id'], $paypal_order);

				$this->Orders_model->completeOrder($order_id, $order_data);
				redirect('checkout/success');
			}
		}

		//redirect('checkout');
	}
}

/* End of file payments.php */
/* Location: ./application/controllers/main/payments.php */