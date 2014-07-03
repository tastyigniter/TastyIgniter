<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Backup extends CI_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
	}

	public function index() {
		if (!$this->user->islogged()) {  
  			redirect(ADMIN_URI.'/login');
		}

    	if (!$this->user->hasPermissions('access', ADMIN_URI.'/backup')) {
  			redirect(ADMIN_URI.'/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available			
		} else if (file_exists('assets/download/tastyigniter.sql')) {
			$data['alert'] = '<p class="alert-success">Database Backup Sucessfully! <a href="'.site_url(ADMIN_URI.'/backup/download').'">Download</a></p>';
		} else {
			$data['alert'] = '';
		}

		$this->template->setTitle('Backup');
		$this->template->setHeading('Backup');
		$this->template->setButton('Backup', array('class' => 'btn btn-success', 'onclick' => '$(\'#edit-form\').submit();'));

		$data['db_tables'] = $this->Settings_model->getdbTables();
		
		if ($this->input->post() AND $this->_backup() === TRUE) {
			redirect(ADMIN_URI.'/backup');		
		}
		
		$this->template->regions(array('header', 'footer'));
		if (file_exists(APPPATH .'views/themes/'.ADMIN_URI.'/'.$this->config->item('admin_theme').'backup.php')) {
			$this->template->render('themes/'.ADMIN_URI.'/'.$this->config->item('admin_theme'), 'backup', $data);
		} else {
			$this->template->render('themes/'.ADMIN_URI.'/default/', 'backup', $data);
		}
	}

	public function download() {
    	if (!$this->user->hasPermissions('modify', ADMIN_URI.'/backup')) {
			$this->session->set_flashdata('alert', '<p class="alert-warning">Warning: You do not have permission to download!</p>');
    	} else if (file_exists('assets/download/tastyigniter.sql')) {
			$name = 'tastyigniter.sql';
			$backup = file_get_contents("assets/download/tastyigniter.sql");
			unlink('assets/download/tastyigniter.sql');
			
			$this->load->helper('download');
			force_download($name, $backup); 
		} else {
		    redirect(ADMIN_URI.'/backup');
		}
	}
	
	public function _backup() {
    	if (!$this->user->hasPermissions('modify', ADMIN_URI.'/backup')) {
			$this->session->set_flashdata('alert', '<p class="alert-warning">Warning: You do not have permission to backup!</p>');
			redirect(ADMIN_URI.'/backup');		
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