<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Authorize_net_aim_model extends TI_Model {

    public function __construct() {
        parent::__construct();

        $this->load->library('cart');
        $this->load->library('currency');
    }

	public function authorizeAndCapture($order_data = array()) {
		if (empty($order_data)) {
			return FALSE;
		}

		$data = array();
		$data['x_first_name']       = $order_data['first_name'];
		$data['x_last_name']        = $order_data['last_name'];
		$data['x_email']            = $order_data['email'];
		$data['x_phone']            = $order_data['telephone'];
		$data['x_customer_ip']      = $this->input->ip_address();

		if ($order_data['order_type'] === '1' AND (!empty($order_data['address_id']) OR !empty($order_data['customer_id']))) {

			$this->load->model('Addresses_model');
			$address = $this->Addresses_model->getAddress($order_data['customer_id'], $order_data['address_id']);

			$data['x_address']  = $address['address_1'];
			$data['x_city']     = $address['city'];
			$data['x_state']    = $address['state'];
			$data['x_zip']      = $address['postcode'];
			$data['x_country']  = $address['country'];

			$data['x_ship_to_first_name']   = $order_data['first_name'];
			$data['x_ship_to_last_name']    = $order_data['last_name'];
			$data['x_ship_to_address']      = $address['address_1'];
			$data['x_ship_to_city']         = $address['city'];
			$data['x_ship_to_state']        = $address['state'];
			$data['x_ship_to_zip']          = $address['postcode'];
			$data['x_ship_to_country']      = $address['country'];
		}

		$data['x_amount'] = $this->currency->format($this->cart->order_total());
		$data['x_card_num'] = str_replace(' ', '', $this->input->post('authorize_cc_number'));
		$data['x_exp_date'] = $this->input->post('authorize_cc_exp_month') . $this->input->post('authorize_cc_exp_year');
		$data['x_card_code'] = $this->input->post('authorize_cc_cvc');
		$data['x_invoice_num'] = $order_data['order_id'];

		$response = $this->sendToAuthorizeNet($data);

		if (isset($response[1]) AND $response[1] !== '1') {
			log_message('error', 'Authorize.Net Error -> ' . $order_data['order_id'] . ': '  . $response[3] . ' :  ' . $response[8] . ' :  ' . $response[4]);
		}

		return $response;
	}

	private function sendToAuthorizeNet($data = array()) {
		$payment = $this->extension->getPayment('authorize_net_aim');
		$settings = $payment['ext_data'];

		$data['x_login']            = (isset($settings['api_login_id'])) ? $settings['api_login_id'] : '';
		$data['x_tran_key']         = (isset($settings['transaction_key'])) ? $settings['transaction_key'] : '';
		$data['x_version']          = '3.1';
		$data['x_delim_char']       = '|';
		$data['x_delim_data']       = 'TRUE';
		$data['x_type']             = (isset($settings['transaction_type']) AND $settings['transaction_type'] === 'auth_capture') ? 'AUTH_CAPTURE' : 'AUTH_ONLY';
		$data['x_method']           = 'CC';
		$data['x_currency_code']    = $this->currency->getCurrencyCode();
		$data['x_encap_char']       = '"';
		$data['x_relay_response']   = 'FALSE';
		$data['x_description']      = $this->config->item('site_name');

		if (isset($settings['transaction_mode']) AND $settings['transaction_mode'] === 'test') {
			$api_end_point = 'https://test.authorize.net/gateway/transact.dll';
		} else {
			$api_end_point = 'https://secure2.authorize.net/gateway/transact.dll';
		}

		if (isset($settings['transaction_mode']) AND $settings['transaction_mode'] === 'test_live') {
			$data['x_test_request'] = 'true';
		}

		// Set the curl parameters.
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_PORT, 443);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_VERBOSE, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		curl_setopt($curl, CURLOPT_URL, $api_end_point);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data, '', '&'));

		// Get response from the server.
		$response = curl_exec($curl);
		$response_data = FALSE;

		if (curl_error($curl)) {
			log_message('error', 'Authorize.Net cURL Error -> ' . curl_errno($curl) . ':' . curl_error($curl));
		} else if (is_string($response) AND strpos($response, '|') !== FALSE) {
			$results = explode('|', $response);

			$i = 1;
			foreach ($results as $result) {
				$response_data[$i] = trim($result, '"');
				$i ++;
			}
		} else {
			log_message('error', "Authorize.Net Error ->  {$data['x_invoice_num']}: There was a problem while contacting the payment gateway. Please try again.");
		}

		curl_close($curl);

		return $response_data;
	}

	public function parseResponse($response = array()) {
		$message = '';

		if (isset($response['5'])) {
			$message .= 'Authorization Code: ' . $response['5'] . "\n";
		}
		if (isset($response['6'])) {
			$message .= 'AVS Response: ' . $response['6'] . "\n";
		}
		if (isset($response['7'])) {
			$message .= 'Transaction ID: ' . $response['7'] . "\n";
		}
		if (isset($response['39'])) {
			$message .= 'Card Code Response: ' . $response['39'] . "\n";
		}
		if (isset($response['40'])) {
			$message .= 'Cardholder Authentication Verification Response: ' . $response['40'] . "\n";
		}

		return $message;
	}
}

/* End of file Authorize_net_aim_model.php */
/* Location: ./extensions/authorize_net_aim/models/Authorize_net_aim_model.php */