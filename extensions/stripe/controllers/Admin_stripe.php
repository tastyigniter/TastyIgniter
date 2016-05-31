<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Admin_stripe extends Admin_Controller {

	public function index($module = array()) {
		$this->lang->load('stripe/stripe');

		$this->user->restrict('Payment.Stripe');

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

		if (isset($this->input->post['description'])) {
			$data['description'] = $this->input->post('description');
		} else if (isset($ext_data['description'])) {
			$data['description'] = $ext_data['description'];
		} else {
			$data['description'] = $this->lang->line('text_description');
		}

		if (isset($this->input->post['transaction_mode'])) {
			$data['transaction_mode'] = $this->input->post('transaction_mode');
		} else if (isset($ext_data['transaction_mode'])) {
			$data['transaction_mode'] = $ext_data['transaction_mode'];
		} else {
			$data['transaction_mode'] = 'test';
		}

		if (isset($this->input->post['test_secret_key'])) {
			$data['test_secret_key'] = $this->input->post('test_secret_key');
		} else if (isset($ext_data['test_secret_key'])) {
			$data['test_secret_key'] = $ext_data['test_secret_key'];
		} else {
			$data['test_secret_key'] = '';
		}

		if (isset($this->input->post['test_publishable_key'])) {
			$data['test_publishable_key'] = $this->input->post('test_publishable_key');
		} else if (isset($ext_data['test_publishable_key'])) {
			$data['test_publishable_key'] = $ext_data['test_publishable_key'];
		} else {
			$data['test_publishable_key'] = '';
		}

		if (isset($this->input->post['live_secret_key'])) {
			$data['live_secret_key'] = $this->input->post('live_secret_key');
		} else if (isset($ext_data['live_secret_key'])) {
			$data['live_secret_key'] = $ext_data['live_secret_key'];
		} else {
			$data['live_secret_key'] = '';
		}

		if (isset($this->input->post['live_publishable_key'])) {
			$data['live_publishable_key'] = $this->input->post('live_publishable_key');
		} else if (isset($ext_data['live_publishable_key'])) {
			$data['live_publishable_key'] = $ext_data['live_publishable_key'];
		} else {
			$data['live_publishable_key'] = '';
		}

		if (isset($this->input->post['force_ssl'])) {
			$data['force_ssl'] = $this->input->post('force_ssl');
		} else if (isset($ext_data['force_ssl'])) {
			$data['force_ssl'] = $ext_data['force_ssl'];
		} else {
			$data['force_ssl'] = '1';
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

		if ($this->input->post() AND $this->_updateStripe() === TRUE) {
			if ($this->input->post('save_close') === '1') {
				redirect('extensions');
			}

			redirect('extensions/edit/payment/stripe');
		}

		return $this->load->view('stripe/admin_stripe', $data, TRUE);
	}

	private function _updateStripe() {
		if ($this->input->post() AND $this->validateForm() === TRUE) {

			if ($this->Extensions_model->updateExtension('payment', 'stripe', $this->input->post())) {
				$this->alert->set('success', sprintf($this->lang->line('alert_success'), $this->lang->line('_text_title') . ' payment ' . $this->lang->line('text_updated')));
			} else {
				$this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $this->lang->line('text_updated')));
			}

			return TRUE;
		}
	}

	private function validateForm() {
		$this->form_validation->set_rules('title', 'lang:label_title', 'xss_clean|trim|required|min_length[2]|max_length[128]');
		$this->form_validation->set_rules('description', 'lang:label_description', 'xss_clean|trim|required|max_length[128]');
		$this->form_validation->set_rules('transaction_mode', 'lang:label_transaction_mode', 'xss_clean|trim|required');
		$this->form_validation->set_rules('test_secret_key', 'lang:label_test_secret_key', 'xss_clean|trim|required');
		$this->form_validation->set_rules('test_publishable_key', 'lang:label_test_publishable_key', 'xss_clean|trim|required');
		$this->form_validation->set_rules('live_secret_key', 'lang:label_live_secret_key', 'xss_clean|trim|required');
		$this->form_validation->set_rules('live_publishable_key', 'lang:label_live_publishable_key', 'xss_clean|trim|required');
		$this->form_validation->set_rules('force_ssl', 'lang:label_force_ssl', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('order_total', 'lang:label_order_total', 'xss_clean|trim|required|numeric');
		$this->form_validation->set_rules('order_status', 'lang:label_order_status', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('priority', 'lang:label_priority', 'xss_clean|trim|required|integer|integer');
		$this->form_validation->set_rules('status', 'lang:label_status', 'xss_clean|trim|required|integer|integer');

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

/* End of file stripe.php */
/* Location: ./extensions/stripe/controllers/stripe.php */