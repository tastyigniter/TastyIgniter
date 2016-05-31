<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Admin_authorize_net_aim extends Admin_Controller {

	public function index($module = array()) {
		$this->lang->load('authorize_net_aim/authorize_net_aim');

		$this->user->restrict('Payment.AuthorizeNetAIM');

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

		if (isset($this->input->post['api_login_id'])) {
			$data['api_login_id'] = $this->input->post('api_login_id');
		} else if (isset($ext_data['api_login_id'])) {
			$data['api_login_id'] = $ext_data['api_login_id'];
		} else {
			$data['api_login_id'] = '';
		}

		if (isset($this->input->post['transaction_key'])) {
			$data['transaction_key'] = $this->input->post('transaction_key');
		} else if (isset($ext_data['transaction_key'])) {
			$data['transaction_key'] = $ext_data['transaction_key'];
		} else {
			$data['transaction_key'] = '';
		}

		if (isset($this->input->post['transaction_mode'])) {
			$data['transaction_mode'] = $this->input->post('transaction_mode');
		} else if (isset($ext_data['transaction_mode'])) {
			$data['transaction_mode'] = $ext_data['transaction_mode'];
		} else {
			$data['transaction_mode'] = '';
		}

		if (isset($this->input->post['transaction_type'])) {
			$data['transaction_type'] = $this->input->post('transaction_type');
		} else if (isset($ext_data['transaction_type'])) {
			$data['transaction_type'] = $ext_data['transaction_type'];
		} else {
			$data['transaction_type'] = '';
		}

		if (isset($this->input->post['accepted_cards']) AND is_array($this->input->post['accepted_cards'])) {
			$data['accepted_cards'] = $this->input->post('accepted_cards');
		} else if (isset($ext_data['accepted_cards']) AND is_array($ext_data['accepted_cards'])) {
			$data['accepted_cards'] = $ext_data['accepted_cards'];
		} else {
			$data['accepted_cards'] = array('visa', 'mastercard', 'american_express', 'diners_club', 'jcb');
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

		$data['list_accepted_cards'] = array(
			'visa'             => $this->lang->line('text_visa'),
			'mastercard'       => $this->lang->line('text_mastercard'),
			'american_express' => $this->lang->line('text_american_express'),
			'jcb'              => $this->lang->line('text_jcb'),
			'diners_club'      => $this->lang->line('text_diners_club'),
		);

		$data['statuses'] = array();
		$results = $this->Statuses_model->getStatuses('order');
		foreach ($results as $result) {
			$data['statuses'][] = array(
				'status_id'   => $result['status_id'],
				'status_name' => $result['status_name'],
			);
		}

		if ($this->input->post() AND $this->_updateAuthorizeNetAIM() === TRUE) {
			if ($this->input->post('save_close') === '1') {
				redirect('extensions');
			}

			redirect('extensions/edit/payment/authorize_net_aim');
		}

		return $this->load->view('authorize_net_aim/admin_authorize_net_aim', $data, TRUE);
	}

	private function _updateAuthorizeNetAIM() {
		$this->user->restrict('Payment.AuthorizeNetAIM.Manage');

		if ($this->input->post() AND $this->validateForm() === TRUE) {

			if ($this->Extensions_model->updateExtension('payment', 'authorize_net_aim', $this->input->post())) {
				$this->alert->set('success', sprintf($this->lang->line('alert_success'), $this->lang->line('_text_title') . ' payment ' . $this->lang->line('text_updated')));
			} else {
				$this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $this->lang->line('text_updated')));
			}

			return TRUE;
		}
	}

	private function validateForm() {
		$this->form_validation->set_rules('title', 'lang:label_title', 'xss_clean|trim|required|min_length[2]|max_length[128]');
		$this->form_validation->set_rules('api_login_id', 'lang:label_api_login_id', 'xss_clean|trim|required');
		$this->form_validation->set_rules('transaction_key', 'lang:label_transaction_key', 'xss_clean|trim|required');
		$this->form_validation->set_rules('transaction_mode', 'lang:label_transaction_mode', 'xss_clean|trim|required');
		$this->form_validation->set_rules('transaction_type', 'lang:label_transaction_type', 'xss_clean|trim|required');
		$this->form_validation->set_rules('accepted_cards[]', 'lang:label_accepted_cards', 'xss_clean|trim|required');
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

/* End of file authorize_net_aim.php */
/* Location: ./extensions/authorize_net_aim/controllers/authorize_net_aim.php */