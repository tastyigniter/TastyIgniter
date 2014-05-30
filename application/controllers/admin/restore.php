<?php
class Restore extends CI_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
	}

	public function index() {
			
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

		$this->template->setTitle('Restore');
		$this->template->setHeading('Restore');

		$this->template->setButton('Restore', array('class' => 'save_button', 'onclick' => '$(\'form\').submit();'));
		
		if (!empty($_FILES['restore']['name']) AND $this->_restore() === TRUE) {
			redirect('admin/restore');
		}
		
		$this->template->regions(array('header', 'footer'));
		if (file_exists(APPPATH .'views/themes/admin/'.$this->config->item('admin_theme').'restore.php')) {
			$this->template->render('themes/admin/'.$this->config->item('admin_theme'), 'restore', $data);
		} else {
			$this->template->render('themes/admin/default/', 'restore', $data);
		}
	}

	public function _restore() {
    	if (!$this->user->hasPermissions('modify', 'admin/restore')) {
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to update!</p>');
  			return TRUE;
    	} else if (isset($_FILES['restore']) AND !empty($_FILES['restore']['name'])) {
			if (is_uploaded_file($_FILES['restore']['tmp_name'])) {
				$content = file_get_contents($_FILES['restore']['tmp_name']);
				$temp = explode('.', $_FILES['restore']['name']);
				$extension = end($temp);			
				if ($extension === 'sql') {
					if ($this->Settings_model->restoreDatabase($content)) { // calls model to save data to SQL
						$this->session->set_flashdata('alert', '<p class="success">Database Restored Sucessfully!</p>');
					}
				} else {
					$this->session->set_flashdata('alert', '<p class="warning">Nothing Restored!</p>');
				}
			} else {
				$content =  '';
			}

			return TRUE;
		}
	}	
}

/* End of file restore.php */
/* Location: ./application/controllers/admin/restore.php */