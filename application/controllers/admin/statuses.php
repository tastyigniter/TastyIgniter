<?php
class Statuses extends CI_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
		$this->load->model('Statuses_model');
	}

	public function index() {
			
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/statuses')) {
  			redirect('admin/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		if ($this->input->get('filter_type')) {
			$filter_type = $this->input->get('filter_type');
			$data['filter_type'] = $filter_type;
		} else {
			$filter_type = '';
			$data['filter_type'] = '';
		}
		
		$data['heading'] 			= 'Statuses';
		$data['button_add'] 		= 'New';
		$data['button_delete'] 		= 'Delete';
		$data['text_empty'] 		= 'There is no status available.';

		//load ratings data into array
		$data['statuses'] = array();
		$results = $this->Statuses_model->getStatuses($filter_type);
		foreach ($results as $result) {					
			
			$data['statuses'][] = array(
				'status_id'			=> $result['status_id'],
				'status_name'		=> $result['status_name'],
				'status_comment'	=> $result['status_comment'],
				'status_for'		=> ucwords($result['status_for']),
				'notify_customer' 	=> ($result['notify_customer'] === '1') ? 'Yes' : 'No',
				'edit' 				=> site_url('admin/statuses/edit?id=' . $result['status_id'])				
			);
		}

		if ($this->input->post('delete') && $this->_deleteStatus() === TRUE) {
			
			redirect('admin/statuses');  			
		}	

		$regions = array('header', 'footer');
		if (file_exists(APPPATH .'views/themes/admin/'.$this->config->item('admin_theme').'statuses.php')) {
			$this->template->render('themes/admin/'.$this->config->item('admin_theme'), 'statuses', $regions, $data);
		} else {
			$this->template->render('themes/admin/default/', 'statuses', $regions, $data);
		}
	}

	public function edit() {
			
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/statuses')) {
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
			$data['action']	= site_url('admin/statuses/edit?id='. $status_id);
		} else {
		    $status_id = 0;
			$data['action']	= site_url('admin/statuses/edit');
		}
		
		$status_info = $this->Statuses_model->getStatus($status_id);
		
		$data['heading'] 			= 'Status - '. $status_info['status_name'];
		$data['button_save'] 		= 'Save';
		$data['button_save_close'] 	= 'Save & Close';
		$data['sub_menu_back'] 		= site_url('admin/statuses');

		$data['status_id'] 			= $status_info['status_id'];
		$data['status_name'] 		= $status_info['status_name'];
		$data['status_comment'] 	= $status_info['status_comment'];
		$data['status_for'] 		= $status_info['status_for'];
		$data['notify_customer'] 	= $status_info['notify_customer'];

		if ($this->input->post() && $this->_addStatus() === TRUE) {
		
			redirect('admin/statuses');  			
		}

		if ($this->input->post() && $this->_updateStatus() === TRUE) {
			if ($this->input->post('save_close') === '1') {
				redirect('admin/statuses');
			}
			
			redirect('admin/statuses/edit?id='. $status_id);
		}
				
		$regions = array('header', 'footer');
		if (file_exists(APPPATH .'views/themes/admin/'.$this->config->item('admin_theme').'statuses_edit.php')) {
			$this->template->render('themes/admin/'.$this->config->item('admin_theme'), 'statuses_edit', $regions, $data);
		} else {
			$this->template->render('themes/admin/default/', 'statuses_edit', $regions, $data);
		}
	}

	public function comment() {
		if ($this->input->get('status_id')) {
			$comment = $this->Statuses_model->getStatusComment($this->input->get('status_id'));
			$this->output->set_output(json_encode($comment));
		}
	}
	
	public function _addStatus() {
									
    	if (!$this->user->hasPermissions('modify', 'admin/statuses')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to add!</p>');
			return TRUE;
    	
    	} else if ( ! $this->input->get('id') AND $this->validateForm() === TRUE) { 
			$add = array();
			
			$add['status_name'] 		= $this->input->post('status_name');
			$add['status_comment'] 		= $this->input->post('status_comment');
			$add['notify_customer'] 	= $this->input->post('notify_customer');

			if ($this->Statuses_model->addStatus('order', $add)) {	
				$this->session->set_flashdata('alert', '<p class="success">Order Status Added Sucessfully!</p>');
			} else {
				$this->session->set_flashdata('alert', '<p class="warning">Nothing Updated!</p>');				
			}
		
			return TRUE;
		}
	}
	
	public function _updateStatus() {
    	
    	if (!$this->user->hasPermissions('modify', 'admin/statuses')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to update!</p>');
			return TRUE;
    	
    	} else if ($this->input->get('id') AND $this->validateForm() === TRUE) { 
			$update = array();
		
			//Sanitizing the POST values
			$update['status_id'] 		= $this->input->get('id');
			$update['status_name'] 		= $this->input->post('status_name');
			$update['status_comment'] 	= $this->input->post('status_comment');
			$update['notify_customer'] 	= $this->input->post('notify_customer');

			if ($this->Statuses_model->updateStatus('order', $update)) {	
				$this->session->set_flashdata('alert', '<p class="success">Order Status Updated Sucessfully!</p>');
			} else {
				$this->session->set_flashdata('alert', '<p class="warning">Nothing Updated!</p>');				
			}
		
			return TRUE;
		}
	}	

	public function _deleteStatus() {
    	if (!$this->user->hasPermissions('modify', 'admin/statuses')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to delete!</p>');
    	
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

	public function validateForm() {
		$this->form_validation->set_rules('status_name', 'Status Name', 'xss_clean|trim|required|min_length[2]|max_length[32]');
		$this->form_validation->set_rules('status_comment', 'Status Comment', 'xss_clean|trim|max_length[1028]');
		$this->form_validation->set_rules('notify_customer', 'Notify Customer', 'xss_clean|trim|integer');

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}		
	}
}

/* End of file statuses.php */
/* Location: ./application/controllers/admin/statuses.php */