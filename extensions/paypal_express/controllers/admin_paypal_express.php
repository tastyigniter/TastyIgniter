<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Admin_paypal_express extends Ext_Controller {

	public function index($data = array()) {
		$this->load->model('Statuses_model');

        $data['title'] = (isset($data['title'])) ? $data['title'] : 'PayPal Express';

        $this->template->setTitle('Payment: ' . $data['title']);
        $this->template->setHeading('Payment: ' . $data['title']);
        $this->template->setButton('Save', array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
        $this->template->setButton('Save & Close', array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
        $this->template->setBackButton('btn btn-back', site_url('payments'));

        $ext_data = array();
        if (!empty($data['ext_data']) AND is_array($data['ext_data'])) {
            $ext_data = $data['ext_data'];
        }

        if (isset($ext_data['api_user'])) {
			$data['api_user'] = $ext_data['api_user'];
		} else {
			$data['api_user'] = '';
		}

		if (isset($ext_data['api_pass'])) {
			$data['api_pass'] = $ext_data['api_pass'];
		} else {
			$data['api_pass'] = '';
		}

		if (isset($ext_data['api_signature'])) {
			$data['api_signature'] = $ext_data['api_signature'];
		} else {
			$data['api_signature'] = '';
		}

		if (isset($this->input->post['api_mode'])) {
			$data['api_mode'] = $this->input->post('api_mode');
		} else if (isset($ext_data['api_mode'])) {
			$data['api_mode'] = $ext_data['api_mode'];
		} else {
			$data['api_mode'] = '';
		}

		if (isset($this->input->post['api_action'])) {
			$data['api_action'] = $this->input->post('api_action');
		} else if (isset($ext_data['api_action'])) {
			$data['api_action'] = $ext_data['api_action'];
		} else {
			$data['api_action'] = '';
		}

		if (isset($ext_data['order_total'])) {
			$data['order_total'] = $ext_data['order_total'];
		} else {
			$data['order_total'] = '';
		}

		if (isset($this->input->post['order_status'])) {
			$data['order_status'] = $this->input->post('order_status');
		} else if (isset($ext_data['order_status'])) {
			$data['order_status'] = $ext_data['order_status'];
		} else {
			$data['order_status'] = '';
		}

		if (isset($ext_data['return_uri'])) {
			$data['return_uri'] = $ext_data['return_uri'];
		} else {
			$data['return_uri'] = '';
		}

		if (isset($ext_data['cancel_uri'])) {
			$data['cancel_uri'] = $ext_data['cancel_uri'];
		} else {
			$data['cancel_uri'] = '';
		}

		if (isset($this->input->post['priority'])) {
			$data['priority'] = $this->input->post('priority');
		} else if (isset($ext_data['priority'])) {
			$data['priority'] = $ext_data['priority'];
		} else {
			$data['priority'] = '';
		}

		if (isset($this->input->post['status'])) {
			$data['status'] = $this->input->post('status');
		} else if (isset($ext_data['status'])) {
			$data['status'] = $ext_data['status'];
		} else {
			$data['status'] = '';
		}

		$data['statuses'] = array();
		$results = $this->Statuses_model->getStatuses('order');
		foreach ($results as $result) {
			$data['statuses'][] = array(
				'status_id'		=> $result['status_id'],
				'status_name'		=> $result['status_name']
			);
		}

		if ($this->input->post() AND $this->_updatePayPalExpress() === TRUE){
			if ($this->input->post('save_close') === '1') {
				redirect('payments');
			}

			redirect('payments/edit?&action=edit&name=paypal_express');
		}

        return $this->load->view('paypal_express/admin_paypal_express', $data, TRUE);
	}

	public function _updatePayPalExpress() {
    	if ($this->input->post() AND $this->validateForm() === TRUE) {
			$update['type'] 		= 'payment';
			$update['name'] 		= $this->input->get('name');
			$update['title'] 		= $this->input->post('title');
			$update['extension_id'] = (int) $this->input->get('extension_id');

			$update['data'] = array(
				'priority' 			=> $this->input->post('priority'),
				'status' 			=> $this->input->post('status'),
				'api_mode' 			=> $this->input->post('api_mode'),
				'api_user' 			=> $this->input->post('api_user'),
				'api_pass' 			=> $this->input->post('api_pass'),
				'api_signature' 	=> $this->input->post('api_signature'),
				'api_action' 		=> $this->input->post('api_action'),
				'return_uri' 		=> $this->input->post('return_uri'),
				'cancel_uri' 		=> $this->input->post('cancel_uri'),
				'order_total' 		=> $this->input->post('order_total'),
				'order_status' 		=> $this->input->post('order_status')
			);

			if ($this->Extensions_model->updateExtension($update, '1')) {
				$this->alert->set('success', 'PayPal Express Checkout updated successfully.');
			} else {
				$this->alert->set('warning', 'An error occurred, nothing updated.');
			}

			return TRUE;
		}
	}

	public function validateForm() {
		$this->form_validation->set_rules('title', 'Title', 'xss_clean|trim|required|min_length[2]|max_length[128]');
		$this->form_validation->set_rules('api_user', 'API Username', 'xss_clean|trim|required');
		$this->form_validation->set_rules('api_pass', 'API Password', 'xss_clean|trim|required');
		$this->form_validation->set_rules('api_signature', 'API Signature', 'xss_clean|trim|required');
		$this->form_validation->set_rules('api_action', 'Payment Action', 'xss_clean|trim|required');
		$this->form_validation->set_rules('order_total', 'Order Total', 'xss_clean|trim|required|numeric');
		$this->form_validation->set_rules('order_status', 'Order Status', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('status', 'Status', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('api_mode', 'Mode', 'xss_clean|trim|required');
		$this->form_validation->set_rules('return_uri', 'Return URI', 'xss_clean|trim|required');
		$this->form_validation->set_rules('cancel_uri', 'Cancel URI', 'xss_clean|trim|required');

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

/* End of file paypal_express.php */
/* Location: ./extensions/payments/paypal_express/controllers/paypal_express.php */