<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Authorize_net_aim_model extends TI_Model {

	public $avsResponse = array();

	public $ccvResponse = array();

	public $cavvResponse = array();

	public function __construct() {
		parent::__construct();

		$this->load->library('cart');
		$this->load->library('currency');

		$this->lang->load('authorize_net_aim/authorize_net_aim');

		$this->avsResponse = array(
			'A' => $this->lang->line('text_avs_response_A'),
			'B' => $this->lang->line('text_avs_response_B'),
			'E' => $this->lang->line('text_avs_response_E'),
			'G' => $this->lang->line('text_avs_response_G'),
			'N' => $this->lang->line('text_avs_response_N'),
			'P' => $this->lang->line('text_avs_response_P'),
			'R' => $this->lang->line('text_avs_response_R'),
			'S' => $this->lang->line('text_avs_response_S'),
			'U' => $this->lang->line('text_avs_response_U'),
			'W' => $this->lang->line('text_avs_response_W'),
			'X' => $this->lang->line('text_avs_response_X'),
			'Y' => $this->lang->line('text_avs_response_Y'),
			'Z' => $this->lang->line('text_avs_response_Z')
		);

		$this->ccvResponse = array(
			'M' => $this->lang->line('text_ccv_response_M'),
			'N' => $this->lang->line('text_ccv_response_N'),
			'P' => $this->lang->line('text_ccv_response_P'),
			'S' => $this->lang->line('text_ccv_response_S'),
			'U' => $this->lang->line('text_ccv_response_U')
		);

		$this->cavvResponse = array(
			'0' => $this->lang->line('text_cavv_response_0'),
			'1' => $this->lang->line('text_cavv_response_1'),
			'2' => $this->lang->line('text_cavv_response_2'),
			'3' => $this->lang->line('text_cavv_response_3'),
			'4' => $this->lang->line('text_cavv_response_4'),
			'5' => $this->lang->line('text_cavv_response_5'),
			'6' => $this->lang->line('text_cavv_response_6'),
			'7' => $this->lang->line('text_cavv_response_7'),
			'8' => $this->lang->line('text_cavv_response_8'),
			'9' => $this->lang->line('text_cavv_response_9'),
			'A' => $this->lang->line('text_cavv_response_A'),
			'B' => $this->lang->line('text_cavv_response_B')
		);
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

		$this->load->model('Addresses_model');

		if ($order_data['order_type'] === '1' AND (!empty($order_data['address_id']) OR !empty($order_data['customer_id']))) {
			$address = $this->Addresses_model->getAddress($order_data['customer_id'], $order_data['address_id']);

			$data['x_ship_to_first_name'] = $order_data['first_name'];
			$data['x_ship_to_last_name'] = $order_data['last_name'];
			$data['x_ship_to_address'] = $address['address_1'];
			$data['x_ship_to_city'] = $address['city'];
			$data['x_ship_to_state'] = $address['state'];
			$data['x_ship_to_zip'] = $address['postcode'];
			$data['x_ship_to_country'] = $address['country'];
		}

		if (!$this->input->post('authorize_same_address') AND is_numeric($this->input->post('authorize_address_id'))) {
			$billing_address = $this->Addresses_model->getAddress($order_data['customer_id'], $this->input->post('authorize_address_id'));
		} else if ($this->input->post('authorize_same_address') AND !empty($address)) {
			$billing_address = $address;
		}

		if (!empty($billing_address)) {
			$data['x_address']  = $billing_address['address_1'] . ' ' . $billing_address['address_2'];
			$data['x_city']     = $billing_address['city'];
			$data['x_state']    = $billing_address['state'];
			$data['x_zip']      = $billing_address['postcode'];
			$data['x_country']  = $billing_address['country'];
		} else if ($this->input->post('authorize_address_id') === 'new') {
			$data['x_address']  = $this->input->post('authorize_address_1') . ' ' . $this->input->post('authorize_address_2');
			$data['x_city']     = $this->input->post('authorize_city');
			$data['x_state']    = $this->input->post('authorize_state');
			$data['x_zip']      = $this->input->post('authorize_postcode');

			$country = $this->Countries_model->getCountry($this->input->post('authorize_country_id'));
			$data['x_country']  = !empty($country['country_name']) ? $country['country_name'] : '';
		}

		$data['x_amount'] = $this->currency->format($this->cart->order_total());
		$data['x_card_num'] = str_replace(' ', '', $this->input->post('authorize_cc_number'));
		$data['x_exp_date'] = $this->input->post('authorize_cc_exp_month') . $this->input->post('authorize_cc_exp_year');
		$data['x_card_code'] = $this->input->post('authorize_cc_cvc');
		$data['x_invoice_num'] = $order_data['order_id'];

		$response = $this->sendToAuthorizeNet($data);

		if (isset($response[1]) AND $response[1] !== '1') {
			log_message('debug', 'Authorize.Net Debug -> ' . $order_data['order_id'] . ': '  . $response[3] . ' :  ' . $response[8] . ' :  ' . $response[4]);
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

		if (isset($response['4'])) {
			$message .= 'Transaction Response: ' . $response['4'] . "\n";
		}

		if (isset($response['7'])) {
			$message .= 'Transaction ID: ' . $response['7'] . "\n";
		}

		if (isset($response['5'])) {
			$message .= 'Authorization Code: ' . $response['5'] . "\n";
		}

		if (isset($response['6'])) {
			$avs_response = isset($this->avsResponse[$response['6']]) ? $this->avsResponse[$response['6']] : $response['6'];
			$message .= 'AVS Response: ' . $avs_response . "\n";
		}

		if (isset($response['39'])) {
			$ccv_response = isset($this->ccvResponse[$response['39']]) ? $this->ccvResponse[$response['39']] : $response['39'];
			$message .= 'Card Code Response: ' . $ccv_response . "\n";
		}

		if (isset($response['40'])) {
			$cavv_response = isset($this->cavvResponse[$response['40']]) ? $this->cavvResponse[$response['40']] : $response['40'];
			$message .= 'Cardholder Authentication Verification Response: ' . $cavv_response . "\n";
		}

		return $message;
	}
}

/* End of file Authorize_net_aim_model.php */
/* Location: ./extensions/authorize_net_aim/models/Authorize_net_aim_model.php */