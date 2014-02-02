<?php
class Paypal_express extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('user');
		$this->load->model('Statuses_model');	    
	}

	public function index() {
			
		//check if file exists in views
		if ( !file_exists(APPPATH .'/views/admin/paypal_express.php')) {
			// Whoops, we don't have a page for that!
			show_404();
		}

		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/paypal_express')) {
  			redirect('admin/permission');
		}
			
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');
		} else { 
			$data['alert'] = '';
		}		
				
		$data['heading'] 			= 'PayPal Express Checkout';
		$data['sub_menu_update'] 	= 'Update';
		$data['sub_menu_back'] 		= $this->config->site_url('admin/payments');

		if (isset($this->input->post['config_paypal_status'])) {
			$data['config_paypal_status'] = $this->input->post['config_paypal_status'];
		} else {
			$data['config_paypal_status'] = $this->config->item('config_paypal_status');
		}				

		if (isset($this->input->post['config_paypal_mode'])) {
			$data['config_paypal_mode'] = $this->input->post['config_paypal_mode'];
		} else {
			$data['config_paypal_mode'] = $this->config->item('config_paypal_mode');
		}				

		if (isset($this->input->post['config_paypal_user'])) {
			$data['config_paypal_user'] = $this->input->post['config_paypal_user'];
		} else {
			$data['config_paypal_user'] = $this->config->item('config_paypal_user');
		}				

		if (isset($this->input->post['config_paypal_pass'])) {
			$data['config_paypal_pass'] = $this->input->post['config_paypal_pass'];
		} else {
			$data['config_paypal_pass'] = $this->config->item('config_paypal_pass');
		}				

		if (isset($this->input->post['config_paypal_sign'])) {
			$data['config_paypal_sign'] = $this->input->post['config_paypal_sign'];
		} else {
			$data['config_paypal_sign'] = $this->config->item('config_paypal_sign');
		}				

		if (isset($this->input->post['config_paypal_action'])) {
			$data['config_paypal_action'] = $this->input->post['config_paypal_action'];
		} else {
			$data['config_paypal_action'] = $this->config->item('config_paypal_action');
		}				

		if (isset($this->input->post['config_paypal_order_status'])) {
			$data['config_paypal_order_status'] = $this->input->post['config_paypal_order_status'];
		} else {
			$data['config_paypal_order_status'] = $this->config->item('config_paypal_order_status');
		}				

		$data['statuses'] = array();
		$results = $this->Statuses_model->getStatuses('order');
		foreach ($results as $result) {					
			$data['statuses'][] = array(
				'status_id'		=> $result['status_id'],
				'status_name'		=> $result['status_name']
			);
		}

		if ($this->input->post() && $this->_updatePayPalExpress() === TRUE){
						
			redirect('admin/payments');
		}
		
		$this->load->view('admin/header', $data);
		$this->load->view('admin/paypal_express', $data);
		$this->load->view('admin/footer');
	}

	public function _updatePayPalExpress() {
						
    	if (!$this->user->hasPermissions('modify', 'admin/paypal_express')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
			return TRUE;
    	
    	} else if (!$this->input->post('delete')) { 
		
			$this->form_validation->set_rules('config_paypal_status', 'PayPal Status', 'trim|required|integer');
			$this->form_validation->set_rules('config_paypal_mode', 'PayPal Mode', 'trim|required');
			$this->form_validation->set_rules('config_paypal_user', 'PayPal Username', 'trim|required');
			$this->form_validation->set_rules('config_paypal_pass', 'PayPal Password', 'trim|required');
			$this->form_validation->set_rules('config_paypal_sign', 'PayPal Signature', 'trim|required');
			$this->form_validation->set_rules('config_paypal_action', 'Payment Action', 'trim|required');
			$this->form_validation->set_rules('config_paypal_order_status', 'Order Status', 'trim|required|integer');

			if ($this->form_validation->run() === TRUE) {

				$update = array(
					'config_paypal_status' 			=> $this->input->post('config_paypal_status'),
					'config_paypal_mode' 			=> $this->input->post('config_paypal_mode'),
					'config_paypal_user' 			=> $this->input->post('config_paypal_user'),
					'config_paypal_pass' 			=> $this->input->post('config_paypal_pass'),
					'config_paypal_sign' 			=> $this->input->post('config_paypal_sign'),
					'config_paypal_action' 			=> $this->input->post('config_paypal_action'),
					'config_paypal_order_status' 	=> $this->input->post('config_paypal_order_status')
				);
	
				if ($this->Settings_model->updateSettings('paypal_express', $update)) {
			
					$this->session->set_flashdata('alert', '<p class="success">PayPal Express Checkout Updated Sucessfully!</p>');
				} else {
			
					$this->session->set_flashdata('alert', '<p class="warning">Nothing Updated!</p>');				
				}
			
				return TRUE;
			}
		}
	}
}