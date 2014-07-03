<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Statuses extends CI_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
		$this->load->model('Statuses_model');
	}

	public function index() {
		if (!$this->user->islogged()) {  
  			redirect(ADMIN_URI.'/login');
		}

    	if (!$this->user->hasPermissions('access', ADMIN_URI.'/statuses')) {
  			redirect(ADMIN_URI.'/permission');
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
		
		$this->template->setTitle('Statuses');
		$this->template->setHeading('Statuses');
		$this->template->setButton('+ New', array('class' => 'btn btn-success', 'href' => page_url() .'/edit'));
		$this->template->setButton('Delete', array('class' => 'btn btn-default', 'onclick' => '$(\'#list-form\').submit();'));

		$data['text_empty'] 		= 'There is no status available.';

		$data['statuses'] = array();
		$results = $this->Statuses_model->getStatuses($filter_type);
		foreach ($results as $result) {					
			
			$data['statuses'][] = array(
				'status_id'			=> $result['status_id'],
				'status_name'		=> $result['status_name'],
				'status_comment'	=> $result['status_comment'],
				'status_for'		=> ($result['status_for'] === 'reserve') ? 'Reservations' : ucwords($result['status_for']),
				'notify_customer' 	=> ($result['notify_customer'] === '1') ? 'Yes' : 'No',
				'edit' 				=> site_url(ADMIN_URI.'/statuses/edit?id=' . $result['status_id'])				
			);
		}

		if ($this->input->post('delete') AND $this->_deleteStatus() === TRUE) {
			redirect(ADMIN_URI.'/statuses');  			
		}	

		$this->template->regions(array('header', 'footer'));
		if (file_exists(APPPATH .'views/themes/'.ADMIN_URI.'/'.$this->config->item('admin_theme').'statuses.php')) {
			$this->template->render('themes/'.ADMIN_URI.'/'.$this->config->item('admin_theme'), 'statuses', $data);
		} else {
			$this->template->render('themes/'.ADMIN_URI.'/default/', 'statuses', $data);
		}
	}

	public function edit() {
		if (!$this->user->islogged()) {  
  			redirect(ADMIN_URI.'/login');
		}

    	if (!$this->user->hasPermissions('access', ADMIN_URI.'/statuses')) {
  			redirect(ADMIN_URI.'/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else { 
			$data['alert'] = '';
		}		
		
		$status_info = $this->Statuses_model->getStatus((int) $this->input->get('id'));
		
		if ($status_info) {
			$status_id = $status_info['status_id'];
			$data['action']	= site_url(ADMIN_URI.'/statuses/edit?id='. $status_id);
		} else {
		    $status_id = 0;
			$data['action']	= site_url(ADMIN_URI.'/statuses/edit');
		}
		
		$title = (isset($status_info['status_name'])) ? $status_info['status_name'] : 'New';	
		$this->template->setTitle('Status:'. $title);
		$this->template->setHeading('Status: '. $title);
		$this->template->setButton('Save', array('class' => 'btn btn-success', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton('Save & Close', array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		$this->template->setBackButton('btn-back', site_url(ADMIN_URI.'/statuses'));

		$data['status_id'] 			= $status_info['status_id'];
		$data['status_name'] 		= $status_info['status_name'];
		$data['status_comment'] 	= $status_info['status_comment'];
		$data['status_for'] 		= $status_info['status_for'];
		$data['notify_customer'] 	= $status_info['notify_customer'];

		if ($this->input->post() AND $this->_addStatus() === TRUE) {
			if ($this->input->post('save_close') !== '1' AND is_numeric($this->input->post('insert_id'))) {	
				redirect(ADMIN_URI.'/statuses/edit?id='. $this->input->post('insert_id'));
			} else {
				redirect(ADMIN_URI.'/statuses');
			}
		}

		if ($this->input->post() AND $this->_updateStatus() === TRUE) {
			if ($this->input->post('save_close') === '1') {
				redirect(ADMIN_URI.'/statuses');
			}
			
			redirect(ADMIN_URI.'/statuses/edit?id='. $status_id);
		}
				
		$this->template->regions(array('header', 'footer'));
		if (file_exists(APPPATH .'views/themes/'.ADMIN_URI.'/'.$this->config->item('admin_theme').'statuses_edit.php')) {
			$this->template->render('themes/'.ADMIN_URI.'/'.$this->config->item('admin_theme'), 'statuses_edit', $data);
		} else {
			$this->template->render('themes/'.ADMIN_URI.'/default/', 'statuses_edit', $data);
		}
	}

	public function comment() {
		if ($this->input->get('status_id')) {
			$comment = $this->Statuses_model->getStatusComment($this->input->get('status_id'));
			$this->output->set_output(json_encode($comment));
		}
	}
	
	public function _addStatus() {
    	if (!$this->user->hasPermissions('modify', ADMIN_URI.'/statuses')) {
			$this->session->set_flashdata('alert', '<p class="alert-warning">Warning: You do not have permission to add!</p>');
			return TRUE;
    	} else if ( ! is_numeric($this->input->get('id')) AND $this->validateForm() === TRUE) { 
			$add = array();
			
			$add['status_name'] 		= $this->input->post('status_name');
			$add['status_comment'] 		= $this->input->post('status_comment');
			$add['status_for'] 			= $this->input->post('status_for');
			$add['notify_customer'] 	= $this->input->post('notify_customer');

			if ($_POST['insert_id'] = $this->Statuses_model->addStatus($add)) {	
				$this->session->set_flashdata('alert', '<p class="alert-success">Order Status added sucessfully.</p>');
			} else {
				$this->session->set_flashdata('alert', '<p class="alert-warning">An error occured, nothing updated.</p>');				
			}
		
			return TRUE;
		}
	}
	
	public function _updateStatus() {
    	if (!$this->user->hasPermissions('modify', ADMIN_URI.'/statuses')) {
			$this->session->set_flashdata('alert', '<p class="alert-warning">Warning: You do not have permission to update!</p>');
			return TRUE;
    	} else if (is_numeric($this->input->get('id')) AND $this->validateForm() === TRUE) { 
			$update = array();
		
			$update['status_id'] 		= $this->input->get('id');
			$update['status_name'] 		= $this->input->post('status_name');
			$update['status_comment'] 	= $this->input->post('status_comment');
			$update['status_for'] 		= $this->input->post('status_for');
			$update['notify_customer'] 	= $this->input->post('notify_customer');

			if ($this->Statuses_model->updateStatus($update)) {	
				$this->session->set_flashdata('alert', '<p class="alert-success">Order Status updated sucessfully.</p>');
			} else {
				$this->session->set_flashdata('alert', '<p class="alert-warning">An error occured, nothing updated.</p>');				
			}
		
			return TRUE;
		}
	}	

	public function _deleteStatus() {
    	if (!$this->user->hasPermissions('modify', ADMIN_URI.'/statuses')) {
			$this->session->set_flashdata('alert', '<p class="alert-warning">Warning: You do not have permission to delete!</p>');
    	} else if (is_array($this->input->post('delete'))) {
			foreach ($this->input->post('delete') as $key => $value) {
				$this->Statuses_model->deleteStatus($value);
			}			
	
			$this->session->set_flashdata('alert', '<p class="alert-success">Order Status(es) deleted sucessfully!</p>');
		}
				
		return TRUE;
	}

	public function validateForm() {
		$this->form_validation->set_rules('status_name', 'Name', 'xss_clean|trim|required|min_length[2]|max_length[32]');
		$this->form_validation->set_rules('status_for', 'Status For', 'xss_clean|trim|required|aplha');
		$this->form_validation->set_rules('status_comment', 'Comment', 'xss_clean|trim|max_length[1028]');
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