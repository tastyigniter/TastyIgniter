<?php
class Paypal_model extends CI_Model {
	
	public function setExpressCheckout($order_info, $cart_items) {
		if ($cart_items) {
			
			$nvp_data = '';
			if ($order_info['order_type'] === '1' AND (!empty($order_info['address_id']) OR !empty($order_info['customer_id']))) {
				
				$this->load->model('Customers_model');
				$address = $this->Customers_model->getCustomerAddress($order_info['customer_id'], $order_info['address_id']);
				
				$nvp_data .= '&PAYMENTREQUEST_0_SHIPTONAME='. urlencode($order_info['first_name'] .' '. $order_info['last_name']);
				$nvp_data .= '&PAYMENTREQUEST_0_SHIPTOSTREET='. urlencode($address['address_1']);
				$nvp_data .= '&PAYMENTREQUEST_0_SHIPTOSTREET2='. urlencode($address['address_2']);
				$nvp_data .= '&PAYMENTREQUEST_0_SHIPTOCITY='. urlencode($address['city']);
				$nvp_data .= '&PAYMENTREQUEST_0_SHIPTOZIP='. urlencode($address['postcode']);
				$nvp_data .= '&PAYMENTREQUEST_0_SHIPTOCOUNTRYCODE='. urlencode($address['iso_code_2']);
			
			}
			
			foreach (array_keys($cart_items) as $key => $rowid) {							// loop through cart items to create items name-value pairs data to be sent to paypal
				foreach ($cart_items as $cart_item) {
					if (isset($cart_item['rowid']) AND $rowid === $cart_item['rowid']) {
						if (!empty($cart_item['options']['option_id'])) {
							$cart_options = $cart_item['name'] .': '. $this->currency->format($cart_item['price']);
						} else {
							$cart_options = '';
						}

						$nvp_data .= '&L_PAYMENTREQUEST_0_NUMBER'. $key .'='. urlencode($cart_item['id']);
						$nvp_data .= '&L_PAYMENTREQUEST_0_NAME'. $key .'='. urlencode($cart_item['name']);
						$nvp_data .= '&L_PAYMENTREQUEST_0_DESC'. $key .'='. urlencode($cart_options);
						$nvp_data .= '&L_PAYMENTREQUEST_0_QTY'. $key .'='. urlencode($cart_item['qty']);
						$nvp_data .= '&L_PAYMENTREQUEST_0_AMT'. $key .'='. urlencode($cart_item['price']);
					}
				}
			}

			$nvp_data .= '&PAYMENTREQUEST_0_ITEMAMT='. urlencode($this->cart->total());
			
			if (!empty($this->cart->delivery())) {
				$nvp_data .= '&PAYMENTREQUEST_0_SHIPPINGAMT='. urlencode($this->cart->delivery());			
			}
			
			if (!empty($this->cart->coupon())) {
				$nvp_data .= '&PAYMENTREQUEST_0_SHIPDISCAMT='. urlencode('-'. $this->cart->coupon());			
			}
			
			if ($this->cart->order_total() > 0) {
				$nvp_data  .= '&PAYMENTREQUEST_0_AMT='. urlencode($this->cart->order_total());
			}
			
			$response = $this->sendPaypal('SetExpressCheckout', $nvp_data);
			
			return $response;
		}		
	}

	public function doExpressCheckout($token, $payer_id) {
			
		$nvp_data  = '&TOKEN='. urlencode($token);
		$nvp_data .= '&PAYERID='. urlencode($payer_id);
		$nvp_data .= '&PAYMENTREQUEST_0_ITEMAMT='. urlencode($this->cart->total());

		if (!empty($this->cart->delivery())) {
			$nvp_data .= '&PAYMENTREQUEST_0_SHIPPINGAMT='. urlencode($this->cart->delivery());			
		}
			
		if (!empty($this->cart->coupon())) {
			$nvp_data .= '&PAYMENTREQUEST_0_SHIPDISCAMT='. urlencode('-'. $this->cart->coupon());			
		}
		
		if ($this->cart->order_total() > 0) {
			$nvp_data  .= '&PAYMENTREQUEST_0_AMT='. urlencode($this->cart->order_total());
		}

		$response = $this->sendPaypal('DoExpressCheckoutPayment', $nvp_data);

		if (strtoupper($response['ACK']) === 'SUCCESS' OR strtoupper($response['ACK']) === 'SUCCESSWITHWARNING') {
			return $response['PAYMENTINFO_0_TRANSACTIONID'];
		} else {
			log_message('error', $response['L_ERRORCODE0'] .' --> '. $response['L_LONGMESSAGE0'] .' --> '. $response['CORRELATIONID']);			
			return FALSE;
		}
	}
	
	public function getTransactionDetails($transaction_id, $order_id, $customer_id) {
	
		$nvp_data = '&TRANSACTIONID='. urlencode($transaction_id);
		
		$response = $this->sendPaypal('GetTransactionDetails', $nvp_data);

		if (strtoupper($response['ACK']) === 'SUCCESS' OR strtoupper($response['ACK']) === 'SUCCESSWITHWARNING') {
			return $response;
		} else {
			log_message('error', $response['L_ERRORCODE0'] .' --> '. $response['L_LONGMESSAGE0'] .' --> '. $response['CORRELATIONID']);			
		}
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
	
	public function addPaypalOrder($transaction_id, $order_id, $customer_id, $response_data) {
		$query = FALSE;

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
			
			if ($this->db->insert('pp_payments')) {
				$query = $this->db->insert_id();
			}
		}

		return $query;
	}
	
	public function sendPaypal($method, $nvp_data) {
		$settings = $this->config->item('paypal_express_payment');
		$paypal_user = (isset($settings['paypal_user'])) ? $settings['paypal_user'] : '';
		$paypal_pass = (isset($settings['paypal_pass'])) ? $settings['paypal_pass'] : '';
		$paypal_sign = (isset($settings['paypal_sign'])) ? $settings['paypal_sign'] : '';
		$paypal_action = (isset($settings['paypal_action'])) ? $settings['paypal_action'] : '';
		
		if (isset($settings['paypal_mode']) AND $settings['paypal_mode'] === 'sandbox') {
			$api_mode = '.sandbox';
		} else {
			$api_mode = '';
		}

		$api_end_point = 'https://api-3t'. $api_mode .'.paypal.com/nvp';
		
		// Set the API operation, version, and API signature in the request.
		$nvp_string  = 'VERSION=76.0';
		$nvp_string .= '&METHOD='. urlencode($method);
		$nvp_string .= '&USER='. urlencode($paypal_user);
		$nvp_string .= '&PWD='. urlencode($paypal_pass);
		$nvp_string .= '&SIGNATURE='. urlencode($paypal_sign);
		$nvp_string .= '&RETURNURL='. urlencode(site_url('main/payments/paypal'));
		$nvp_string .= '&CANCELURL='. urlencode(site_url('main/checkout'));	

		if ($paypal_action === 'sale') {
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
}

/* End of file payments_model.php */
/* Location: ./application/models/payments_model.php */