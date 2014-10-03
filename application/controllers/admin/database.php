<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Database extends CI_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
	}

	public function index() {
		if (!$this->user->islogged()) {  
  			redirect(ADMIN_URI.'/login');
		}

    	if (!$this->user->hasPermissions('access', ADMIN_URI.'/database')) {
  			redirect(ADMIN_URI.'/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available			
		} else if (file_exists('assets/download/tastyigniter.sql')) {
			$data['alert'] = '<p class="alert-success">Database Backup Sucessfully! <a href="'.site_url(ADMIN_URI.'/database/download').'">Download</a></p>';
		} else {
			$data['alert'] = '';
		}

		$this->template->setTitle('Database');
		$this->template->setHeading('Database');
		$this->template->setButton('Backup', array('class' => 'btn btn-success', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton('Restore', array('class' => 'btn btn-default', 'onclick' => '$(\'#edit-form\').submit();'));

		$data['db_tables'] = $this->Settings_model->getdbTables();
		
		if ($this->input->post() AND $this->_backup() === TRUE) {
			redirect(ADMIN_URI.'/database');		
		}
		
		if (!empty($_FILES['restore']['name']) AND $this->_restore() === TRUE) {
			redirect(ADMIN_URI.'/database');
		}
		
		$this->template->regions(array('header', 'footer'));
		if (file_exists(APPPATH .'views/themes/'.ADMIN_URI.'/'.$this->config->item('admin_theme').'database.php')) {
			$this->template->render('themes/'.ADMIN_URI.'/'.$this->config->item('admin_theme'), 'database', $data);
		} else {
			$this->template->render('themes/'.ADMIN_URI.'/default/', 'database', $data);
		}
	}

	public function download() {
    	if (!$this->user->hasPermissions('modify', ADMIN_URI.'/database')) {
			$this->session->set_flashdata('alert', '<p class="alert-warning">Warning: You do not have permission to download!</p>');
    	} else if (file_exists('assets/download/tastyigniter.sql')) {
			$name = 'tastyigniter.sql';
			$backup_sql = file_get_contents("assets/download/tastyigniter.sql");
			unlink('assets/download/tastyigniter.sql');
			
			$this->load->helper('download');
			force_download($name, $backup_sql); 
		} else {
		    redirect(ADMIN_URI.'/database');
		}
	}
	
	public function _backup() {
    	if (!$this->user->hasPermissions('modify', ADMIN_URI.'/database')) {
			$this->session->set_flashdata('alert', '<p class="alert-warning">Warning: You do not have permission to backup!</p>');
			return TRUE;		
    	} else if ($this->input->post('backup')) { 
					
			$this->form_validation->set_rules('backup[]', 'Backup', 'xss_clean|trim|required|alpha_dash');

			if ($this->form_validation->run() === TRUE) {
				$this->Settings_model->backupDatabase($this->input->post('backup'));
				return TRUE;
			} else {
				return FALSE;
			}	
		}
	}	

	public function _restore() {
    	if (!$this->user->hasPermissions('modify', ADMIN_URI.'/database')) {
			$this->session->set_flashdata('alert', '<p class="alert-warning">Warning: You do not have permission to restore!</p>');
  			return TRUE;
    	} else if (isset($_FILES['restore']) AND !empty($_FILES['restore']['name'])) {
			if (is_uploaded_file($_FILES['restore']['tmp_name'])) {
				$content = file_get_contents($_FILES['restore']['tmp_name']);
				$temp = explode('.', $_FILES['restore']['name']);
				$extension = end($temp);			
				if ($extension === 'sql') {
					if ($this->Settings_model->restoreDatabase($content)) { // calls model to save data to SQL
						$this->session->set_flashdata('alert', '<p class="alert-success">Database Restored Sucessfully!</p>');
					}
				} else {
					$this->session->set_flashdata('alert', '<p class="alert-warning">Nothing Restored!</p>');
				}
			} else {
				$content =  '';
			}

			return TRUE;
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

/* End of file database.php */
/* Location: ./application/controllers/admin/database.php */