<?php
class Backup extends CI_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
	}

	public function index() {
			
		if (!file_exists(APPPATH .'views/admin/backup.php')) {
			show_404();
		}
			
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/backup')) {
  			redirect('admin/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available			
		} else if ($this->session->flashdata('download')) {
			$data['download'] = $this->session->flashdata('download');  // retrieve session flashdata variable if available			
		} else {
			$data['alert'] = '';
			$data['download'] = '';
		}

		$data['heading'] 			= 'Backup';
		$data['sub_menu_save'] 		= 'Backup';

		$data['db_tables'] = $this->Settings_model->getdbTables();

		if ($this->_backup() === TRUE) {
			redirect('admin/backup');		
		}
		
		$regions = array(
			'admin/header',
			'admin/footer'
		);
		
		$this->template->regions($regions);
		$this->template->load('admin/backup', $data);
	}

	public function download() {

    	if (!$this->user->hasPermissions('modify', 'admin/backup')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have the right permission to edit!</p>');
    	
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
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have the right permission to edit!</p>');
    	
    	} else if ($this->input->post('backup')) { 
								
			$this->form_validation->set_rules('backup[]', 'Backup', 'trim|required|alpha_dash');

			if ($this->form_validation->run() === TRUE) {

				if ($this->Settings_model->backupDatabase($this->input->post('backup'))) {
					$this->session->set_flashdata('download', '<h2>Database Backup Sucessfully!</h2><a href="'.site_url('admin/backup/download').'"></a><br /> Download');
				} else {
					$this->session->set_flashdata('download', '<p class="warning">Nothing Backup!</p>');
				}
	
				return TRUE;
			}	
		}
	}	
}