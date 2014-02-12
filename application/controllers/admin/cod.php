<?php
class Cod extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('user');
		$this->load->model('Statuses_model');	    
	}

	public function index() {
			
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/cod')) {
  			redirect('admin/permission');
		}
			
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');
		} else { 
			$data['alert'] = '';
		}		
				
		$data['heading'] 			= 'Cash On Delivery';
		$data['sub_menu_save'] 		= 'Save';
		$data['sub_menu_back'] 		= $this->config->site_url('admin/payments');

		if (isset($this->input->post['cod_total'])) {
			$data['cod_total'] = $this->input->post['cod_total'];
		} else {
			$data['cod_total'] = $this->config->item('cod_total');
		}				

		if (isset($this->input->post['cod_order_status'])) {
			$data['cod_order_status'] = $this->input->post['cod_order_status'];
		} else {
			$data['cod_order_status'] = $this->config->item('cod_order_status');
		}				

		if (isset($this->input->post['cod_status'])) {
			$data['cod_status'] = $this->input->post['cod_status'];
		} else {
			$data['cod_status'] = $this->config->item('cod_status');
		}				

		$data['statuses'] = array();
		$results = $this->Statuses_model->getStatuses('order');
		foreach ($results as $result) {					
			$data['statuses'][] = array(
				'status_id'		=> $result['status_id'],
				'status_name'		=> $result['status_name']
			);
		}

		if ($this->input->post() && $this->_updateCod() === TRUE){
						
			redirect('admin/payments');
		}
		
		$regions = array(
			'admin/header',
			'admin/footer'
		);
		
		$this->template->regions($regions);
		$this->template->load('admin/cod', $data);
	}

	public function _updateCod() {
						
    	if (!$this->user->hasPermissions('modify', 'admin/cod')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
			return TRUE;
    	
    	} else if (!$this->input->post('delete')) { 
		
			$this->form_validation->set_rules('cod_total', 'Minimum Total', 'trim|required|numeric');
			$this->form_validation->set_rules('cod_order_status', 'Order Status', 'trim|required|integer');
			$this->form_validation->set_rules('cod_status', 'Status', 'trim|required|integer');

			if ($this->form_validation->run() === TRUE) {
				
				$update = array(
					'cod_total' 		=> $this->input->post('cod_total'),
					'cod_order_status' 	=> $this->input->post('cod_order_status'),
					'cod_status' 		=> $this->input->post('cod_status')
				);
	
				if ($this->Settings_model->updateSettings('cod', $update)) {
			
					$this->session->set_flashdata('alert', '<p class="success">COD Updated Sucessfully!</p>');
				} else {
			
					$this->session->set_flashdata('alert', '<p class="warning">Nothing Updated!</p>');				
				}
			
				return TRUE;
			}
		}
	}
}