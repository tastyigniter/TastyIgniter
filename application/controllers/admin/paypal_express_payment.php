<?php
class Paypal_express_payment extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('user');
		$this->load->model('Statuses_model');	    
	}

	public function index() {
			
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/paypal_express_payment')) {
  			redirect('admin/permission');
		}
			
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');
		} else { 
			$data['alert'] = '';
		}		
				
		$this->template->setTitle('Payment: PayPal Express Checkout');
		$this->template->setHeading('Payment: PayPal Express Checkout');
		$this->template->setButton('Save', array('class' => 'save_button', 'onclick' => '$(\'form\').submit();'));
		$this->template->setButton('Save & Close', array('class' => 'save_close_button', 'onclick' => 'saveClose();'));
		$this->template->setBackButton('back_button', site_url('admin/payments'));

		$result = $this->config->item('paypal_express_payment');
		
		if (isset($this->input->post['paypal_status'])) {
			$data['paypal_status'] = $this->input->post('paypal_status');
		} else if (isset($result['paypal_status'])) {
			$data['paypal_status'] = $result['paypal_status'];
		} else {
			$data['paypal_status'] = '';
		}		

		if (isset($this->input->post['paypal_mode'])) {
			$data['paypal_mode'] = $this->input->post['paypal_mode'];
		} else if (isset($result['paypal_mode'])) {
			$data['paypal_mode'] = $result['paypal_mode'];
		} else {
			$data['paypal_mode'] = '';
		}				

		if (isset($this->input->post['paypal_user'])) {
			$data['paypal_user'] = $this->input->post['paypal_user'];
		} else if (isset($result['paypal_user'])) {
			$data['paypal_user'] = $result['paypal_user'];
		} else {
			$data['paypal_user'] = '';
		}				

		if (isset($this->input->post['paypal_pass'])) {
			$data['paypal_pass'] = $this->input->post['paypal_pass'];
		} else if (isset($result['paypal_pass'])) {
			$data['paypal_pass'] = $result['paypal_pass'];
		} else {
			$data['paypal_pass'] = '';
		}				

		if (isset($this->input->post['paypal_sign'])) {
			$data['paypal_sign'] = $this->input->post['paypal_sign'];
		} else if (isset($result['paypal_sign'])) {
			$data['paypal_sign'] = $result['paypal_sign'];
		} else {
			$data['paypal_sign'] = '';
		}				

		if (isset($this->input->post['paypal_action'])) {
			$data['paypal_action'] = $this->input->post['paypal_action'];
		} else if (isset($result['paypal_action'])) {
			$data['paypal_action'] = $result['paypal_action'];
		} else {
			$data['paypal_action'] = '';
		}				

		if (isset($this->input->post['paypal_total'])) {
			$data['paypal_total'] = $this->input->post['paypal_total'];
		} else if (isset($result['paypal_total'])) {
			$data['paypal_total'] = $result['paypal_total'];
		} else {
			$data['paypal_total'] = '';
		}				

		if (isset($this->input->post['paypal_order_status'])) {
			$data['paypal_order_status'] = $this->input->post['paypal_order_status'];
		} else if (isset($result['paypal_order_status'])) {
			$data['paypal_order_status'] = $result['paypal_order_status'];
		} else {
			$data['paypal_order_status'] = '';
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
				redirect('admin/payments');
			}
			
			redirect('admin/paypal_express_payment');
		}
		
		$this->template->regions(array('header', 'footer'));
		if (file_exists(APPPATH .'views/themes/admin/'.$this->config->item('admin_theme').'paypal_express_payment.php')) {
			$this->template->render('themes/admin/'.$this->config->item('admin_theme'), 'paypal_express_payment', $data);
		} else {
			$this->template->render('themes/admin/default/', 'paypal_express_payment', $data);
		}
	}

	public function _updatePayPalExpress() {
    	if (!$this->user->hasPermissions('modify', 'admin/paypal_express_payment')) {
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to update!</p>');
			return TRUE;
    	} else if (!$this->input->post('delete') AND $this->validateForm() === TRUE) { 
			$update = array(
				'paypal_status' 		=> $this->input->post('paypal_status'),
				'paypal_mode' 			=> $this->input->post('paypal_mode'),
				'paypal_user' 			=> $this->input->post('paypal_user'),
				'paypal_pass' 			=> $this->input->post('paypal_pass'),
				'paypal_sign' 			=> $this->input->post('paypal_sign'),
				'paypal_action' 		=> $this->input->post('paypal_action'),
				'paypal_total' 			=> $this->input->post('paypal_total'),
				'paypal_order_status' 	=> $this->input->post('paypal_order_status')
			);

			if ($this->Settings_model->addSetting('payment', 'paypal_express_payment', $update, '1')) {
				$this->session->set_flashdata('alert', '<p class="success">PayPal Express Checkout updated sucessfully.</p>');
			} else {
				$this->session->set_flashdata('alert', '<p class="warning">An error occured, nothing updated.</p>');				
			}
		
			return TRUE;
		}
	}

	public function validateForm() {
		$this->form_validation->set_rules('paypal_status', 'PayPal Status', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('paypal_mode', 'PayPal Mode', 'xss_clean|trim|required');
		$this->form_validation->set_rules('paypal_user', 'PayPal Username', 'xss_clean|trim|required');
		$this->form_validation->set_rules('paypal_pass', 'PayPal Password', 'xss_clean|trim|required');
		$this->form_validation->set_rules('paypal_sign', 'PayPal Signature', 'xss_clean|trim|required');
		$this->form_validation->set_rules('paypal_action', 'Payment Action', 'xss_clean|trim|required');
		$this->form_validation->set_rules('paypal_total', 'Order Total', 'xss_clean|trim|required|numeric');
		$this->form_validation->set_rules('paypal_order_status', 'Order Status', 'xss_clean|trim|required|integer');

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}		
	}
}

/* End of file paypal_express_payment.php */
/* Location: ./application/controllers/admin/paypal_express_payment.php */