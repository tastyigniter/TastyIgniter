<?php
class Cod_payment extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('user');
		$this->load->model('Statuses_model');	    
	}

	public function index() {
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/cod_payment')) {
  			redirect('admin/permission');
		}
			
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');
		} else { 
			$data['alert'] = '';
		}		
				
		$this->template->setTitle('Payment: Cash On Delivery');
		$this->template->setHeading('Payment: Cash On Delivery');
		$this->template->setButton('Save', array('class' => 'save_button', 'onclick' => '$(\'form\').submit();'));
		$this->template->setButton('Save & Close', array('class' => 'save_close_button', 'onclick' => 'saveClose();'));
		$this->template->setBackButton('back_button', site_url('admin/payments'));

		$result = $this->config->item('cod_payment');
		
		if (isset($this->input->post['cod_total'])) {
			$data['cod_total'] = $this->input->post['cod_total'];
		} else if (isset($result['cod_total'])) {
			$data['cod_total'] = $result['cod_total'];
		} else {
			$data['cod_total'] = '';
		}				

		if (isset($this->input->post['cod_order_status'])) {
			$data['cod_order_status'] = $this->input->post['cod_order_status'];
		} else if (isset($result['cod_order_status'])) {
			$data['cod_order_status'] = $result['cod_order_status'];
		} else {
			$data['cod_order_status'] = '';
		}				

		if (isset($this->input->post['cod_status'])) {
			$data['cod_status'] = $this->input->post['cod_status'];
		} else if (isset($result['cod_status'])) {
			$data['cod_status'] = $result['cod_status'];
		} else {
			$data['cod_status'] = '';
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
				redirect('admin/payments');
			}
			
			redirect('admin/cod_payment');
		}
		
		$this->template->regions(array('header', 'footer'));
		if (file_exists(APPPATH .'views/themes/admin/'.$this->config->item('admin_theme').'cod_payment.php')) {
			$this->template->render('themes/admin/'.$this->config->item('admin_theme'), 'cod_payment', $data);
		} else {
			$this->template->render('themes/admin/default/', 'cod_payment', $data);
		}
	}

	public function _updateCod() {
    	if (!$this->user->hasPermissions('modify', 'admin/cod_payment')) {
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to update!</p>');
			return TRUE;
    	} else if (!$this->input->post('delete') AND $this->validateForm() === TRUE) { 
			$update = array(
				'cod_total' 		=> $this->input->post('cod_total'),
				'cod_order_status' 	=> $this->input->post('cod_order_status'),
				'cod_status' 		=> $this->input->post('cod_status')
			);

			if ($this->Settings_model->addSetting('payment', 'cod_payment', $update, '1')) {
				$this->session->set_flashdata('alert', '<p class="success">COD updated sucessfully.</p>');
			} else {
				$this->session->set_flashdata('alert', '<p class="warning">An error occured, nothing updated.</p>');				
			}
		
			return TRUE;
		}
	}

	public function validateForm() {
		$this->form_validation->set_rules('cod_total', 'Minimum Total', 'xss_clean|trim|required|numeric');
		$this->form_validation->set_rules('cod_order_status', 'Order Status', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('cod_status', 'Status', 'xss_clean|trim|required|integer');

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}		
	}
}

/* End of file cod_payment.php */
/* Location: ./application/controllers/admin/cod_payment.php */