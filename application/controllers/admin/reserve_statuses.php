<?php
class Reserve_statuses extends CI_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
		$this->load->model('Statuses_model');
	}

	public function index() {
			
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/reserve_statuses')) {
  			redirect('admin/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		$data['heading'] 			= 'Reservation Statuses';
		$data['sub_menu_add'] 		= 'Add new status';
		$data['sub_menu_delete'] 	= 'Delete';
		$data['text_empty'] 		= 'There is no reservation status available.';

		//load ratings data into array
		$data['statuses'] = array();
		$results = $this->Statuses_model->getStatuses('reserve');
		foreach ($results as $result) {					
			
			$data['statuses'][] = array(
				'status_id'			=> $result['status_id'],
				'status_name'		=> $result['status_name'],
				'status_comment'	=> $result['status_comment'],
				'notify_customer' 	=> ($result['notify_customer'] === '1') ? 'Yes' : 'No',
				'edit' 				=> $this->config->site_url('admin/reserve_statuses/edit?id=' . $result['status_id'])				
			);
		}

		if ($this->input->post('delete') && $this->_deleteStatus() === TRUE) {
			
			redirect('admin/reserve_statuses');  			
		}	

		$regions = array(
			'admin/header',
			'admin/footer'
		);
		
		$this->template->regions($regions);
		$this->template->load('admin/reserve_statuses', $data);
	}

	public function edit() {
		
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/reserve_statuses')) {
  			redirect('admin/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else { 
			$data['alert'] = '';
		}		
		
		//check if /rating_id is set in uri string
		if (is_numeric($this->input->get('id'))) {
			$status_id = $this->input->get('id');
			$data['action']	= $this->config->site_url('admin/reserve_statuses/edit?id='. $status_id);
		} else {
		    $status_id = 0;
			$data['action']	= $this->config->site_url('admin/reserve_statuses/edit');
		}
		
		$status_info = $this->Statuses_model->getStatus($status_id);
		
		$data['heading'] 			= 'Reservation Status - '. $status_info['status_name'];
		$data['sub_menu_save'] 		= 'Save';
		$data['sub_menu_back'] 		= $this->config->site_url('admin/reserve_statuses');

		$data['status_id'] 			= $status_info['status_id'];
		$data['status_name'] 		= $status_info['status_name'];
		$data['status_comment'] 	= $status_info['status_comment'];
		$data['notify_customer'] 	= $status_info['notify_customer'];

		if ($this->input->post() && $this->_addStatus() === TRUE) {
		
			redirect('admin/reserve_statuses');  			
		}

		if ($this->input->post() && $this->_updateStatus() === TRUE) {
					
			redirect('admin/reserve_statuses');
		}
				
		$regions = array(
			'admin/header',
			'admin/footer'
		);
		
		$this->template->regions($regions);
		$this->template->load('admin/reserve_statuses_edit', $data);
	}

	public function _addStatus() {
									
    	if (!$this->user->hasPermissions('modify', 'admin/reserve_statuses')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
			return TRUE;
    	
    	} else if ( ! $this->input->get('id')) { 
			
			//validate category value
			$this->form_validation->set_rules('status_name', 'Status Name', 'trim|required|min_length[2]|max_length[32]');
			$this->form_validation->set_rules('status_comment', 'Status Comment', 'trim|min_length[2]|max_length[1028]');
			$this->form_validation->set_rules('notify_customer', 'Notify Customer', 'trim|integer');

			if ($this->form_validation->run() === TRUE) {
				$add = array();
				
				$add['status_name'] 		= $this->input->post('status_name');
				$add['status_comment'] 		= $this->input->post('status_comment');
				$add['notify_customer'] 	= $this->input->post('notify_customer');
	
				if ($this->Statuses_model->addStatus('reserve', $add)) {	
				
					$this->session->set_flashdata('alert', '<p class="success">Order Status Added Sucessfully!</p>');
				} else {
			
					$this->session->set_flashdata('alert', '<p class="warning">Nothing Updated!</p>');				
				}
			
				return TRUE;
			}
		}
	}
	
	public function _updateStatus() {
    	
    	if (!$this->user->hasPermissions('modify', 'admin/reserve_statuses')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
			return TRUE;
    	
    	} else if ($this->input->get('id')) { 
			
			$this->form_validation->set_rules('status_name', 'Status Name', 'trim|required|min_length[2]|max_length[32]');
			$this->form_validation->set_rules('status_comment', 'Status Comment', 'trim|max_length[1028]');
			$this->form_validation->set_rules('notify_customer', 'Notify Customer', 'trim|integer');

			if ($this->form_validation->run() === TRUE) {
				$update = array();
			
				//Sanitizing the POST values
				$update['status_id'] 		= $this->input->get('id');
				$update['status_name'] 		= $this->input->post('status_name');
				$update['status_comment'] 	= $this->input->post('status_comment');
				$update['notify_customer'] 	= $this->input->post('notify_customer');

				if ($this->Statuses_model->updateStatus('reserve', $update)) {	
			
					$this->session->set_flashdata('alert', '<p class="success">Order Status Updated Sucessfully!</p>');
				} else {
			
					$this->session->set_flashdata('alert', '<p class="warning">Nothing Updated!</p>');				
				}
			
				return TRUE;
			}	
		}
	}	

	public function _deleteStatus() {
    	if (!$this->user->hasPermissions('modify', 'admin/reserve_statuses')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
    	
    	} else { 
		
			if (is_array($this->input->post('delete'))) {

				foreach ($this->input->post('delete') as $key => $value) {
					$status_id = $value;
			
					$this->Statuses_model->deleteStatus($status_id);
				}			
		
				$this->session->set_flashdata('alert', '<p class="success">Order Status(es) Deleted Sucessfully!</p>');

			}
		}
				
		return TRUE;
	}
}