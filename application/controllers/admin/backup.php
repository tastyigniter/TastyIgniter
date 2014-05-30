<?php
class Backup extends CI_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
	}

	public function index() {
			
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/backup')) {
  			redirect('admin/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available			
		} else if (file_exists('assets/download/tastyigniter.sql')) {
			$data['alert'] = '<span class="success">Database Backup Sucessfully! <a href="'.site_url('admin/backup/download').'">Download</a></span>';
		} else {
			$data['alert'] = '';
		}

		$this->template->setTitle('Backup');
		$this->template->setHeading('Backup');
		$this->template->setButton('Backup', array('class' => 'save_button', 'onclick' => '$(\'form\').submit();'));

		$data['db_tables'] = $this->Settings_model->getdbTables();
		
		if ($this->input->post() AND $this->_backup() === TRUE) {
			redirect('admin/backup');		
		}
		
		$this->template->regions(array('header', 'footer'));
		if (file_exists(APPPATH .'views/themes/admin/'.$this->config->item('admin_theme').'backup.php')) {
			$this->template->render('themes/admin/'.$this->config->item('admin_theme'), 'backup', $data);
		} else {
			$this->template->render('themes/admin/default/', 'backup', $data);
		}
	}

	public function download() {

    	if (!$this->user->hasPermissions('modify', 'admin/backup')) {
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to download!</p>');
    	} else if (file_exists('assets/download/tastyigniter.sql')) {
			$name = 'tastyigniter.sql';
			$backup = file_get_contents("assets/download/tastyigniter.sql");
			unlink('assets/download/tastyigniter.sql');
			
			$this->load->helper('download');
			force_download($name, $backup); 
		} else {
		    redirect('admin/backup');
		}
	}
	
	public function _backup() {
    	if (!$this->user->hasPermissions('modify', 'admin/backup')) {
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to backup!</p>');
			redirect('admin/backup');		
    	} else if ($this->input->post('backup')) { 
					
			if ($this->validateForm() === TRUE) {
				$this->Settings_model->backupDatabase($this->input->post('backup'));
				return TRUE;
			}	
		}
	}	

	public function validateForm() {
		$this->form_validation->set_rules('backup[]', 'Backup', 'xss_clean|trim|required|alpha_dash');

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

/* End of file backup.php */
/* Location: ./application/controllers/admin/backup.php */