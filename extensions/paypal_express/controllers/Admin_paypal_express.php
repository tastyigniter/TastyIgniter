<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Admin_paypal_express extends Admin_Controller {

	public function index($module = array()) {
		$this->lang->load('paypal_express/paypal_express');

		$this->user->restrict('Payment.PaypalExpress');

		$this->load->model('Statuses_model');

		$title = (isset($module['title'])) ? $module['title'] : $this->lang->line('_text_title');

		$this->template->setTitle('Payment: ' . $title);
		$this->template->setHeading('Payment: ' . $title);
		$this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton($this->lang->line('button_save_close'), array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		$this->template->setButton($this->lang->line('button_icon_back'), array('class' => 'btn btn-default', 'href' => site_url('extensions')));

		$ext_data = array();
		if ( ! empty($module['ext_data']) AND is_array($module['ext_data'])) {
			$ext_data = $module['ext_data'];
		}

		if (isset($this->input->post['title'])) {
			$data['title'] = $this->input->post('title');
		} else if (isset($ext_data['title'])) {
			$data['title'] = $ext_data['title'];
		} else {
			$data['title'] = $title;
		}

		if (isset($this->input->post['api_user'])) {
			$data['api_user'] = $this->input->post('api_user');
		} else if (isset($ext_data['api_user'])) {
			$data['api_user'] = $ext_data['api_user'];
		} else {
			$data['api_user'] = '';
		}

		if (isset($this->input->post['api_pass'])) {
			$data['api_pass'] = $this->input->post('api_pass');
		} else if (isset($ext_data['api_pass'])) {
			$data['api_pass'] = $ext_data['api_pass'];
		} else {
			$data['api_pass'] = '';
		}

		if (isset($this->input->post['api_signature'])) {
			$data['api_signature'] = $this->input->post('api_signature');
		} else if (isset($ext_data['api_signature'])) {
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
				'status_id'   => $result['status_id'],
				'status_name' => $result['status_name'],
			);
		}

		if ($this->input->post() AND $this->_updatePayPalExpress() === TRUE) {
			if ($this->input->post('save_close') === '1') {
				redirect('extensions');
			}

			redirect('extensions/edit/payment/paypal_express');
		}

		return $this->load->view('paypal_express/admin_paypal_express', $data, TRUE);
	}

	private function _updatePayPalExpress() {
		$this->user->restrict('Payment.PaypalExpress.Manage');

		if ($this->input->post() AND $this->validateForm() === TRUE) {

			if ($this->Extensions_model->updateExtension('payment', 'paypal_express', $this->input->post())) {
				$this->alert->set('success', sprintf($this->lang->line('alert_success'), $this->lang->line('_text_title') . ' payment ' . $this->lang->line('text_updated')));
			} else {
				$this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $this->lang->line('text_updated')));
			}

			return TRUE;
		}
	}

	private function validateForm() {
		$this->form_validation->set_rules('title', 'lang:label_title', 'xss_clean|trim|required|min_length[2]|max_length[128]');
		$this->form_validation->set_rules('api_user', 'lang:label_api_user', 'xss_clean|trim|required');
		$this->form_validation->set_rules('api_pass', 'lang:label_api_pass', 'xss_clean|trim|required');
		$this->form_validation->set_rules('api_signature', 'lang:label_api_signature', 'xss_clean|trim|required');
		$this->form_validation->set_rules('api_mode', 'lang:label_api_mode', 'xss_clean|trim|required');
		$this->form_validation->set_rules('api_action', 'lang:label_api_action', 'xss_clean|trim|required');
		$this->form_validation->set_rules('order_total', 'lang:label_order_total', 'xss_clean|trim|required|numeric');
		$this->form_validation->set_rules('order_status', 'lang:label_order_status', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('status', 'lang:label_status', 'xss_clean|trim|required|integer');

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

/* End of file paypal_express.php */
/* Location: ./extensions/paypal_express/controllers/paypal_express.php */