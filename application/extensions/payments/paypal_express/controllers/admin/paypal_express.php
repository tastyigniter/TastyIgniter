<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Paypal_express extends MX_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('user');
		$this->load->model('Statuses_model');	    
	}

	public function index() {
		if (!$this->user->islogged()) {  
  			redirect(ADMIN_URI.'/login');
		}

    	if (!$this->user->hasPermissions('access', ADMIN_URI.'/paypal_express')) {
  			redirect(ADMIN_URI.'/permission');
		}
			
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');
		} else { 
			$data['alert'] = '';
		}		
				
		$extension = $this->Extensions_model->getExtension('payment', 'paypal_express');
		
		if (!$this->input->get('id') AND !$this->input->get('name') AND $this->input->get('action') !== 'edit') {
			redirect(ADMIN_URI.'/extensions/edit?name=paypal_express&action=edit&id='.$extension['extension_id']);
		}

		$data['name'] = ucwords(str_replace('_', ' ', $this->input->get('name')));

		if (!empty($extension['data'])) {
			$result = unserialize($extension['data']);
		} else {
			$result = array();
		}
		
		if (isset($result['api_user'])) {
			$data['api_user'] = $result['api_user'];
		} else {
			$data['api_user'] = '';
		}				

		if (isset($result['api_pass'])) {
			$data['api_pass'] = $result['api_pass'];
		} else {
			$data['api_pass'] = '';
		}				

		if (isset($result['api_signature'])) {
			$data['api_signature'] = $result['api_signature'];
		} else {
			$data['api_signature'] = '';
		}				

		if (isset($this->input->post['api_mode'])) {
			$data['api_mode'] = $this->input->post('api_mode');
		} else if (isset($result['api_mode'])) {
			$data['api_mode'] = $result['api_mode'];
		} else {
			$data['api_mode'] = '';
		}				

		if (isset($this->input->post['api_action'])) {
			$data['api_action'] = $this->input->post('api_action');
		} else if (isset($result['api_action'])) {
			$data['api_action'] = $result['api_action'];
		} else {
			$data['api_action'] = '';
		}				

		if (isset($result['order_total'])) {
			$data['order_total'] = $result['order_total'];
		} else {
			$data['order_total'] = '';
		}				

		if (isset($this->input->post['order_status'])) {
			$data['order_status'] = $this->input->post('order_status');
		} else if (isset($result['order_status'])) {
			$data['order_status'] = $result['order_status'];
		} else {
			$data['order_status'] = '';
		}				

		if (isset($result['return_uri'])) {
			$data['return_uri'] = $result['return_uri'];
		} else {
			$data['return_uri'] = '';
		}				

		if (isset($result['cancel_uri'])) {
			$data['cancel_uri'] = $result['cancel_uri'];
		} else {
			$data['cancel_uri'] = '';
		}				

		if (isset($this->input->post['status'])) {
			$data['status'] = $this->input->post('status');
		} else if (isset($result['status'])) {
			$data['status'] = $result['status'];
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
				redirect(ADMIN_URI.'/payments');
			}
			
			redirect(ADMIN_URI.'/payments/edit?name=paypal_express&action=edit&id='.$extension['extension_id']);
		}

		if (file_exists(EXTPATH .'payments/paypal_express/views/admin/paypal_express.php')) { 								//check if file exists in views folder
			$this->load->view('paypal_express/admin/paypal_express', $data);
		} else {
			show_404(); 																		// Whoops, show 404 error page!
		}
	}

	public function _updatePayPalExpress() {
    	if (!$this->user->hasPermissions('modify', ADMIN_URI.'/paypal_express')) {
			$this->session->set_flashdata('alert', '<p class="alert-warning">Warning: You do not have permission to update!</p>');
			return TRUE;
    	} else if (!$this->input->post('delete') AND $this->validateForm() === TRUE) { 
			$update['type'] 		= 'payment';
			$update['name'] 		= $this->input->get('name');
			$update['extension_id'] = (int) $this->input->get('id');
			
			$update['data'] = array(
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
				$this->session->set_flashdata('alert', '<p class="alert-success">PayPal Express Checkout updated sucessfully.</p>');
			} else {
				$this->session->set_flashdata('alert', '<p class="alert-warning">An error occured, nothing updated.</p>');				
			}
		
			return TRUE;
		}
	}

	public function validateForm() {
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
/* Location: ./application/extensions/payments/paypal_express/controllers/admin/paypal_express.php */