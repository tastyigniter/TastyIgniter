<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Cod extends Main_Controller {

    public function index() {
        $this->lang->load('cod/cod');

        if ( ! file_exists(EXTPATH .'cod/views/cod.php')) { 								//check if file exists in views folder
            show_404(); 																		// Whoops, show 404 error page!
        }

        $payment = $this->extension->getPayment('cod');

        // START of retrieving lines from language file to pass to view.
        $data['code'] 			= $payment['name'];
        $data['title'] 			= !empty($payment['ext_data']['title']) ? $payment['ext_data']['title'] : $payment['title'];
        // END of retrieving lines from language file to send to view.

        $order_data = $this->session->userdata('order_data');                           // retrieve order details from session userdata
        $data['payment'] = !empty($order_data['payment']) ? $order_data['payment'] : '';
        $data['minimum_order_total'] = is_numeric($payment['ext_data']['order_total']) ? $payment['ext_data']['order_total'] : 0;
        $data['order_total'] = $this->cart->total();

        // pass array $data and load view files
        return $this->load->view('cod/cod', $data, TRUE);
    }

    public function confirm() {
        $this->lang->load('cod/cod');

        $order_data = $this->session->userdata('order_data'); 						// retrieve order details from session userdata
        $cart_contents = $this->session->userdata('cart_contents'); 												// retrieve cart contents

        if (empty($order_data) AND empty($cart_contents)) {
            return FALSE;
        }

        if (!empty($order_data['ext_payment']) AND !empty($order_data['payment']) AND $order_data['payment'] == 'cod') { 											// else if payment method is cash on delivery

            $ext_payment_data = !empty($order_data['ext_payment']['ext_data']) ? $order_data['ext_payment']['ext_data'] : array();

            if (!empty($ext_payment_data['order_total']) AND $cart_contents['order_total'] < $ext_payment_data['order_total']) {
                $this->alert->set('danger', $this->lang->line('alert_min_total'));
                return FALSE;
            }

            if (isset($ext_payment_data['order_status']) AND is_numeric($ext_payment_data['order_status'])) {
                $order_data['status_id'] = $ext_payment_data['order_status'];
            }

            $this->load->model('Orders_model');

            if ($this->Orders_model->completeOrder($order_data['order_id'], $order_data, $cart_contents)) {
                redirect('checkout/success');									// redirect to checkout success page with returned order id
            }
        }
    }
}

/* End of file cod.php */
/* Location: ./extensions/cod/controllers/cod.php */