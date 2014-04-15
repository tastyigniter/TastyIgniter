<?php
class Restore extends CI_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
	}

	public function index() {
			
		if (!file_exists(APPPATH .'views/admin/restore.php')) {
			show_404();
		}
			
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/restore')) {
  			redirect('admin/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available			
		} else {
			$data['alert'] = '';
		}

		$data['heading'] 			= 'Restore';
		$data['sub_menu_save'] 		= 'Restore';
		
		if ($this->_restore() === TRUE) {
			redirect('admin/restore');
		}
		
		$regions = array(
			'admin/header',
			'admin/footer'
		);
		
		$this->template->regions($regions);
		$this->template->load('admin/restore', $data);
	}

	public function _restore() {

    	if (!$this->user->hasPermissions('modify', 'admin/restore')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have the right permission to edit!</p>');
  			return TRUE;
    	
    	} else { 
		
			if (isset($_FILES['restore']) && !empty($_FILES['restore']['name'])) {
				if (is_uploaded_file($_FILES['restore']['tmp_name'])) {
					$content = file_get_contents($_FILES['restore']['tmp_name']);
				} else {
					$content =  '';
				}
		
				if ($this->Settings_model->restoreDatabase($content)) { // calls model to save data to SQL
					$this->session->set_flashdata('alert', '<p class="success">Database Restored Sucessfully!</p>');
				} else {
					$this->session->set_flashdata('alert', '<p class="warning">Nothing Updated!</p>');
				}
	
				return TRUE;
			}
		}
	}	
}