<?php
class Payments_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}

	public function getPayments() {
		$this->db->from('payments');
		
		$query = $this->db->get();
		
		$result = array();
	
		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}
	
		return $result;
	}

	public function getPayment($payment_id) {
		$this->db->from('payments');
		
		$this->db->where('payment_id', $payment_id);
		$query = $this->db->get();
		
		return $query->row_array();
	}

	public function getPaypalDetails($order_id, $customer_id) {
		$this->db->from('pp_payments');
		$this->db->where('order_id', $order_id);
		$this->db->where('customer_id', $customer_id);
			
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$row = $query->row_array();
			
			return unserialize($row['serialized']);
		}	
	}
	
	public function updatePayment($update = array()) {
		
		if (!empty($update['payment_name'])) {
			$this->db->set('payment_name', $update['payment_name']);
		}

		if (!empty($update['payment_desc'])) {
			$this->db->set('payment_desc', $update['payment_desc']);
		}

		if (!empty($update['payment_id'])) {
			$this->db->where('payment_id', $update['payment_id']);
			$this->db->update('payments'); 
		}
				
		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}

	public function addPayment($add = array()) {
		
		if (!empty($add['payment_name'])) {
			$this->db->set('payment_name', $add['payment_name']);
		}

		if (!empty($add['payment_desc'])) {
			$this->db->set('payment_desc', $add['payment_desc']);
		}

		$this->db->insert('payments'); 
		
		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}

	public function deletePayment($payment_id) {

		$this->db->where('payment_id', $payment_id);
		
		$this->db->delete('payments');

		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}
	
	public function setExpressCheckout() {
		
		$order_info = $this->session->userdata('order_details');
		$cart_items = $this->cart->contents();
		
		if ($cart_items) {
			
			if ($this->cart->order_total() > 0) {
				$nvp_data  = '&PAYMENTREQUEST_0_AMT='. urlencode($this->cart->order_total());
			//} else {
			//	$nvp_data  = '&PAYMENTREQUEST_0_AMT='. urlencode($this->cart->total());
			}
			
			if (!empty($order_info['order_address_id']) OR !empty($order_info['order_customer_id'])) {
				
				$this->load->model('Customers_model');
				$address = $this->Customers_model->getCustomerAddress($order_info['order_customer_id'], $order_info['order_address_id']);
				
				$nvp_data .= '&PAYMENTREQUEST_0_SHIPTONAME='. urlencode($order_info['first_name'] .' '. $order_info['last_name']);
				$nvp_data .= '&PAYMENTREQUEST_0_SHIPTOSTREET='. urlencode($address['address_1']);
				$nvp_data .= '&PAYMENTREQUEST_0_SHIPTOSTREET2='. urlencode($address['address_2']);
				$nvp_data .= '&PAYMENTREQUEST_0_SHIPTOCITY='. urlencode($address['city']);
				$nvp_data .= '&PAYMENTREQUEST_0_SHIPTOZIP='. urlencode($address['postcode']);
				$nvp_data .= '&PAYMENTREQUEST_0_SHIPTOCOUNTRYCODE='. urlencode($address['iso_code_2']);
			
			}
			
			foreach (array_keys($cart_items) as $key => $rowid) {							// loop through cart items to create items name-value pairs data to be sent to paypal

				foreach ($cart_items as $cart_item) {

					if (!empty($cart_item['options']['With'])) {
						$options = $cart_item['options']['With'];
					} else {
						$options = '';
					}

					if ($rowid === $cart_item['rowid']) {
						$nvp_data .= '&L_PAYMENTREQUEST_0_NUMBER'. $key .'='. urlencode($cart_item['id']);
						$nvp_data .= '&L_PAYMENTREQUEST_0_NAME'. $key .'='. urlencode($cart_item['name']);
						$nvp_data .= '&L_PAYMENTREQUEST_0_DESC'. $key .'='. urlencode($options);
						$nvp_data .= '&L_PAYMENTREQUEST_0_QTY'. $key .'='. urlencode($cart_item['qty']);
						$nvp_data .= '&L_PAYMENTREQUEST_0_AMT'. $key .'='. urlencode($cart_item['price']);
					}
				}
			}

			$nvp_data .= '&PAYMENTREQUEST_0_ITEMAMT='. urlencode($this->cart->total());
			
			if ($this->cart->delivery()) {
				$nvp_data .= '&PAYMENTREQUEST_0_SHIPPINGAMT='. urlencode($this->cart->delivery());			
			}
			
			if ($this->cart->coupon()) {
				//$nvp_data .= '&PAYMENTREQUEST_0_SHIPDISCAMT='. urlencode($this->cart->coupon());			
			}
			
			$response = $this->Payments_model->sendPaypal('SetExpressCheckout', $nvp_data);
			
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
	
			//return $response;
		}		
	}

	public function doExpressCheckout($token, $payer_id) {
			
		$nvp_data  = '&TOKEN='. urlencode($token);
		$nvp_data .= '&PAYERID='. urlencode($payer_id);
		$nvp_data .= '&PAYMENTREQUEST_0_AMT='. urlencode($this->cart->order_total());
		$nvp_data .= '&PAYMENTREQUEST_0_ITEMAMT='. urlencode($this->cart->total());

		if ($this->cart->delivery()) {
			$nvp_data .= '&PAYMENTREQUEST_0_SHIPPINGAMT='. urlencode($this->cart->delivery());			
		}
			
		$response = $this->Payments_model->sendPaypal('DoExpressCheckoutPayment', $nvp_data);

		if (strtoupper($response['ACK']) === 'SUCCESS' OR strtoupper($response['ACK']) === 'SUCCESSWITHWARNING') {

			return $response['PAYMENTINFO_0_TRANSACTIONID'];
		
		} else {
			log_message('error', $response['L_ERRORCODE0'] .' --> '. $response['L_LONGMESSAGE0'] .' --> '. $response['CORRELATIONID']);			
			return FALSE;
		}
	}
	
	public function saveTransactionDetails($transaction_id, $order_id, $customer_id) {
	
		$nvp_data = '&TRANSACTIONID='. urlencode($transaction_id);
		
		$response = $this->Payments_model->sendPaypal('GetTransactionDetails', $nvp_data);

		if (strtoupper($response['ACK']) === 'SUCCESS' OR strtoupper($response['ACK']) === 'SUCCESSWITHWARNING') {

			$this->addPaypalOrder($response['PAYMENTINFO_0_TRANSACTIONID'], $order_id, $customer_id, $response);
		} else {
			log_message('error', $response['L_ERRORCODE0'] .' --> '. $response['L_LONGMESSAGE0'] .' --> '. $response['CORRELATIONID']);			
		}
	}
	
	public function sendPaypal($method, $nvp_data) {

		if ($this->config->item('paypal_mode') === 'sandbox') {
			$api_mode = '.sandbox';
		} else {
			$api_mode = '';
		}

		$api_end_point = 'https://api-3t'. $api_mode .'.paypal.com/nvp';
		
		// Set the API operation, version, and API signature in the request.
		$nvp_string  = 'VERSION=76.0';
		$nvp_string .= '&METHOD='. urlencode($method);
		$nvp_string .= '&USER='. urlencode($this->config->item('paypal_user'));
		$nvp_string .= '&PWD='. urlencode($this->config->item('paypal_pass'));
		$nvp_string .= '&SIGNATURE='. urlencode($this->config->item('paypal_sign'));
		$nvp_string .= '&RETURNURL='. urlencode($this->config->site_url('payments/paypal'));
		$nvp_string .= '&CANCELURL='. urlencode($this->config->site_url('payments/cancel'));	

		if ($this->config->item('paypal_action') === 'sale') {
			$nvp_string .= '&PAYMENTREQUEST_0_PAYMENTACTION=SALE';
		} else {
			$nvp_string .= '&PAYMENTREQUEST_0_PAYMENTACTION=AUTHORIZATION';		
		}
	
		$nvp_string .= '&PAYMENTREQUEST_0_CURRENCYCODE='. urlencode($this->currency->getCurrencyCode());
		$nvp_string .= $nvp_data;

		// Set the curl parameters.
		$curl = curl_init();
			curl_setopt($curl, CURLOPT_VERBOSE, 1);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
			curl_setopt($curl, CURLOPT_TIMEOUT, 30);
			curl_setopt($curl, CURLOPT_URL, $api_end_point);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $nvp_string);
	
		// Get response from the server.
		$output = curl_exec($curl);
		curl_close($curl);

		$result = array();
		$parse_str = parse_str($output, $result);
		
		return $result;
	}
	
	public function addPaypalOrder($transaction_id, $order_id, $customer_id, $response_data) {
		if (!empty($order_id)) {
			$this->db->set('order_id', $order_id);
		}

		if (!empty($customer_id)) {
			$this->db->set('customer_id', $customer_id);
		}
		
		if (!empty($response_data)) {
			$this->db->set('serialized', serialize($response_data));
		}
		
		if (!empty($transaction_id)) {
			$this->db->set('transaction_id', $transaction_id);
			$this->db->insert('pp_payments'); 
		}

		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}
}