<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Paypal_express extends Main_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Orders_model');
        $this->load->model('paypal_express/Paypal_model');
        $this->lang->load('paypal_express/paypal_express');
    }

    public function index() {
        if ( ! file_exists(EXTPATH .'paypal_express/views/paypal_express.php')) { 								//check if file exists in views folder
            show_404(); 																		// Whoops, show 404 error page!
        }

        $payment = $this->extension->getPayment('paypal_express');

        // START of retrieving lines from language file to pass to view.
        $data['code'] 			= $payment['name'];
        $data['title'] 			= !empty($payment['ext_data']['title']) ? $payment['ext_data']['title'] : $payment['title'];
        // END of retrieving lines from language file to send to view.

        $order_data = $this->session->userdata('order_data');                           // retrieve order details from session userdata
        $data['payment'] = !empty($order_data['payment']) ? $order_data['payment'] : '';
        $data['minimum_order_total'] = is_numeric($payment['ext_data']['order_total']) ? $payment['ext_data']['order_total'] : 0;
        $data['order_total'] = $this->cart->total();

        // pass array $data and load view files
        return $this->load->view('paypal_express/paypal_express', $data, TRUE);
    }

    public function confirm() {
        $order_data = $this->session->userdata('order_data'); 						// retrieve order details from session userdata
        $cart_contents = $this->session->userdata('cart_contents'); 												// retrieve cart contents

        if (empty($order_data) OR empty($cart_contents)) {
            return FALSE;
        }

        if (!empty($order_data['payment']) AND $order_data['payment'] == 'paypal_express') { 	// check if payment method is equal to paypal

            $ext_payment_data = !empty($order_data['ext_payment']['ext_data']) ? $order_data['ext_payment']['ext_data'] : array();

            if (!empty($ext_payment_data['order_total']) AND $cart_contents['order_total'] < $ext_payment_data['order_total']) {
                $this->alert->set('danger', $this->lang->line('alert_min_total'));
                return FALSE;
            }

            $this->load->model('paypal_express/Paypal_model');
            $response = $this->Paypal_model->setExpressCheckout($order_data, $this->cart->contents());

            if (isset($response['ACK']) AND (strtoupper($response['ACK']) === 'SUCCESS' OR strtoupper($response['ACK']) === 'SUCCESSWITHWARNING')) {
                $payment = isset($order_data['ext_payment']) ? $order_data['ext_payment'] : array();
                if (isset($payment['ext_data']['api_mode']) AND $payment['ext_data']['api_mode'] === 'sandbox') {
                    $api_mode = '.sandbox';
                } else {
                    $api_mode = '';
                }

                redirect('https://www' . $api_mode . '.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=' . $response['TOKEN'] . '');
            }
        }
    }

    public function authorize() {
        $order_data = $this->session->userdata('order_data'); 							// retrieve order details from session userdata
        $cart_contents = $this->session->userdata('cart_contents'); 												// retrieve cart contents

        if (!empty($order_data) AND $this->input->get('token') AND $this->input->get('PayerID')) { 						// check if token and PayerID is in $_GET data

            $token = $this->input->get('token'); 												// retrieve token from $_GET data
            $payer_id = $this->input->get('PayerID'); 											// retrieve PayerID from $_GET data

            $customer_id = (!$this->customer->islogged()) ? '' : $this->customer->getId();
            $order_id = (is_numeric($order_data['order_id'])) ? $order_data['order_id'] : FALSE;
            $order_info = $this->Orders_model->getOrder($order_id, $order_data['customer_id']);	// retrieve order details array from getMainOrder method in Orders model

            $transaction_id = $this->Paypal_model->doExpressCheckout($token, $payer_id, $order_info);

            if ($transaction_id AND $order_info) {

                $ext_payment_data = !empty($order_data['ext_payment']['ext_data']) ? $order_data['ext_payment']['ext_data'] : array();
                if (isset($ext_payment_data['order_status']) AND is_numeric($ext_payment_data['order_status'])) {
                    $order_data['status_id'] = $ext_payment_data['order_status'];
                }

                $transaction_details = $this->Paypal_model->getTransactionDetails($transaction_id, $order_info);
                $this->Paypal_model->addPaypalOrder($transaction_id, $order_id, $customer_id, $transaction_details);
                $this->Orders_model->completeOrder($order_id, $order_data, $cart_contents);

                redirect('checkout/success');
            }
        }

        $this->alert->set('danger', $this->lang->line('alert_error_server'));
        redirect('checkout');
    }

    public function cancel() {
        $order_data = $this->session->userdata('order_data'); 							// retrieve order details from session userdata

        if (!empty($order_data) AND $this->input->get('token')) { 						// check if token and PayerID is in $_GET data

            $this->load->model('Statuses_model');
            $status = $this->Statuses_model->getStatus($this->config->item('canceled_order_status'));

            $order_history = array(
                'object_id'  => $order_data['order_id'],
                'status_id'  => $status['status_id'],
                'notify'     => '0',
                'comment'    => $status['comment'],
                'date_added' => mdate('%Y-%m-%d %H:%i:%s', time()),
            );

            $this->Statuses_model->addStatusHistory('order', $order_history);

            $token = $this->input->get('token'); 												// retrieve token from $_GET data

            $this->alert->set('alert', $this->lang->line('alert_error_server'));
            redirect('checkout');
        }
    }
}

/* End of file paypal_express.php */
/* Location: ./extensions/paypal_express/controllers/paypal_express.php */