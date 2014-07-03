<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Cod extends MX_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('user');
		$this->load->model('Statuses_model');	    
	}

	public function index() {
		if (!$this->user->islogged()) {  
  			redirect(ADMIN_URI.'/login');
		}

    	if (!$this->user->hasPermissions('access', ADMIN_URI.'/cod')) {
  			redirect(ADMIN_URI.'/permission');
		}
			
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');
		} else { 
			$data['alert'] = '';
		}		
				
		$extension = $this->Extensions_model->getExtension('payment', 'cod');
		
		if (!$this->input->get('id') AND !$this->input->get('name') AND $this->input->get('action') !== 'edit') {
			redirect(ADMIN_URI.'/extensions/edit?name=cod&action=edit&id='.$extension['extension_id']);
		}

		$data['name'] = ucwords(str_replace('_', ' ', $this->input->get('name')));

		if (!empty($extension['data'])) {
			$result = unserialize($extension['data']);
		} else {
			$result = array();
		}
		
		if (isset($this->input->post['total'])) {
			$data['total'] = $this->input->post['total'];
		} else if (isset($result['total'])) {
			$data['total'] = $result['total'];
		} else {
			$data['total'] = '';
		}				

		if (isset($this->input->post['order_status'])) {
			$data['order_status'] = $this->input->post['order_status'];
		} else if (isset($result['order_status'])) {
			$data['order_status'] = $result['order_status'];
		} else {
			$data['order_status'] = '';
		}				

		if (isset($this->input->post['status'])) {
			$data['status'] = $this->input->post['status'];
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

		if ($this->input->post() AND $this->_updateCod() === TRUE){
			if ($this->input->post('save_close') === '1') {
				redirect(ADMIN_URI.'/payments');
			}
			
			redirect(ADMIN_URI.'/payments/edit?name=cod&action=edit&id='.$extension['extension_id']);
		}

		if (file_exists(EXTPATH .'payments/cod/views/admin/cod.php')) { 								//check if file exists in views folder
			$this->load->view('cod/admin/cod', $data);
		} else {
			show_404(); 																		// Whoops, show 404 error page!
		}
	}

	public function _updateCod() {
    	if (!$this->user->hasPermissions('modify', ADMIN_URI.'/cod')) {
			$this->session->set_flashdata('alert', '<p class="alert-warning">Warning: You do not have permission to update!</p>');
			return TRUE;
    	} else if (!$this->input->post('delete') AND $this->validateForm() === TRUE) { 
			$update = array();
		
			$update['type'] 				= 'payment';
			$update['name'] 				= $this->input->get('name');
			$update['extension_id'] 		= (int) $this->input->get('id');
			$update['data']['total'] 		= $this->input->post('total');
			$update['data']['order_status'] = $this->input->post('order_status');
			$update['data']['status'] 		= $this->input->post('status');

			if ($this->Extensions_model->updateExtension($update, '1')) {
				$this->session->set_flashdata('alert', '<p class="alert-success">COD Payment updated sucessfully.</p>');
			} else {
				$this->session->set_flashdata('alert', '<p class="alert-warning">An error occured, nothing updated.</p>');				
			}
		
			return TRUE;
		}
	}

	public function validateForm() {
		$this->form_validation->set_rules('total', 'Minimum Total', 'xss_clean|trim|required|numeric');
		$this->form_validation->set_rules('order_status', 'Order Status', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('status', 'Status', 'xss_clean|trim|required|integer');

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}		
	}
}

/* End of file cod.php */
/* Location: ./application/extensions/payments/cod/controllers/admin/cod.php */