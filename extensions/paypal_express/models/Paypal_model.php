<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Paypal_model extends TI_Model {

    public function __construct() {
        parent::__construct();

        $this->load->library('cart');
        $this->load->library('currency');
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

	public function setExpressCheckout($order_info, $cart_items) {
		if ($cart_items) {

			$nvp_data = '';
			if ($order_info['order_type'] === '1' AND (!empty($order_info['address_id']) OR !empty($order_info['customer_id']))) {

				$this->load->model('Addresses_model');
				$address = $this->Addresses_model->getAddress($order_info['customer_id'], $order_info['address_id']);

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

			if ($this->cart->delivery() > 0) {
				$nvp_data .= '&PAYMENTREQUEST_0_SHIPPINGAMT='. urlencode($this->cart->delivery());
			}

            if ($this->cart->coupon_discount()) {
				$nvp_data .= '&PAYMENTREQUEST_0_SHIPDISCAMT='. urlencode('-'. $this->cart->coupon_discount());
			}

			if ($this->cart->order_total() > 0) {
				$nvp_data  .= '&PAYMENTREQUEST_0_AMT='. urlencode($this->cart->order_total());
			}

			$response = $this->callPayPal('SetExpressCheckout', $nvp_data);

			if (isset($response['ACK'])) {
				if (strtoupper($response['ACK']) !== 'SUCCESS' OR strtoupper($response['ACK']) !== 'SUCCESSWITHWARNING') {
					if (isset($response['L_ERRORCODE0'], $response['L_LONGMESSAGE0'], $order_info['order_id'])) {
						log_message('error', 'PayPalExpress::setExpressCheckout Error -->' . $order_info['order_id'] . ': ' . $response['L_ERRORCODE0'] . ': ' . $response['L_LONGMESSAGE0']);
					}
				}
			}

			return $response;
		}
	}

	public function doExpressCheckout($token, $payer_id, $order_info = array()) {

		$nvp_data  = '&TOKEN='. urlencode($token);
		$nvp_data .= '&PAYERID='. urlencode($payer_id);
		$nvp_data .= '&PAYMENTREQUEST_0_ITEMAMT='. urlencode($this->cart->total());

		if ($this->cart->delivery() > 0) {
			$nvp_data .= '&PAYMENTREQUEST_0_SHIPPINGAMT='. urlencode($this->cart->delivery());
		}

        if ($this->cart->coupon_discount()) {
			$nvp_data .= '&PAYMENTREQUEST_0_SHIPDISCAMT='. urlencode('-'. $this->cart->coupon_discount());
		}

		if ($this->cart->order_total() > 0) {
			$nvp_data  .= '&PAYMENTREQUEST_0_AMT='. urlencode($this->cart->order_total());
		}

		$response = $this->callPayPal('DoExpressCheckoutPayment', $nvp_data);

		if (isset($response['ACK'])) {
			if (strtoupper($response['ACK']) === 'SUCCESS' OR strtoupper($response['ACK']) === 'SUCCESSWITHWARNING') {
				return $response['PAYMENTINFO_0_TRANSACTIONID'];
			} else {
				if (isset($response['L_ERRORCODE0'], $response['L_LONGMESSAGE0'], $order_info['order_id'])) {
					log_message('error', 'PayPalExpress::doExpressCheckout Error -->' . $order_info['order_id'] . ': ' . $response['L_ERRORCODE0'] . ': ' . $response['L_LONGMESSAGE0']);
				}
			}
		}

		return FALSE;
	}

	public function getTransactionDetails($transaction_id, $order_info = array()) {

		$nvp_data = '&TRANSACTIONID='. urlencode($transaction_id);

		$response = $this->callPayPal('GetTransactionDetails', $nvp_data);

		if (isset($response['ACK'])) {
			if (strtoupper($response['ACK']) !== 'SUCCESS' OR strtoupper($response['ACK']) !== 'SUCCESSWITHWARNING') {
				if (isset($response['L_ERRORCODE0'], $response['L_LONGMESSAGE0'], $order_info['order_id'])) {
					log_message('error', 'PayPalExpress::getTransactionDetails Error -->' . $order_info['order_id'] . ': ' . $response['L_ERRORCODE0'] . ': ' . $response['L_LONGMESSAGE0']);
				}
			}
		}

		return $response;
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

	public function callPayPal($method, $nvp_data) {
		$payment = $this->extension->getPayment('paypal_express');
		$settings = $payment['ext_data'];
		$api_user = (isset($settings['api_user'])) ? $settings['api_user'] : '';
		$api_pass = (isset($settings['api_pass'])) ? $settings['api_pass'] : '';
		$api_signature = (isset($settings['api_signature'])) ? $settings['api_signature'] : '';
		$api_action = (isset($settings['api_action'])) ? $settings['api_action'] : '';
		$return_uri = 'paypal_express/authorize';
		$cancel_uri = 'paypal_express/cancel';

		if (isset($settings['api_mode']) AND $settings['api_mode'] === 'sandbox') {
			$api_mode = '.sandbox';
		} else {
			$api_mode = '';
		}

		$api_end_point = 'https://api-3t'. $api_mode .'.paypal.com/nvp';

		// Set the API operation, version, and API signature in the request.
		$nvp_string  = 'VERSION=76.0';
		$nvp_string .= '&METHOD='. urlencode($method);
		$nvp_string .= '&USER='. urlencode($api_user);
		$nvp_string .= '&PWD='. urlencode($api_pass);
		$nvp_string .= '&SIGNATURE='. urlencode($api_signature);
		$nvp_string .= '&RETURNURL='. urlencode(site_url($return_uri));
		$nvp_string .= '&CANCELURL='. urlencode(site_url($cancel_uri));

		if ($api_action === 'sale') {
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

		if (curl_error($curl)) {
			log_message('error', 'PayPalExpress cURL Error -> ' . curl_errno($curl) . ':' . curl_error($curl));
		}

		curl_close($curl);

		$result = array();
		$parse_str = parse_str($output, $result);

		return $result;
	}
}

/* End of file paypal_model.php */
/* Location: ./extensions/paypal_model/models/paypal_model.php */