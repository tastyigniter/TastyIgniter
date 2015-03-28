<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Database extends Admin_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
		$this->load->model('Settings_model');
	}

	public function index() {
		if (!$this->user->islogged()) {
  			redirect('login');
		}

    	if (!$this->user->hasPermissions('access', 'database')) {
  			redirect('permission');
		}

		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else if (file_exists('assets/download/tastyigniter.sql')) {
			$data['alert'] = '<p class="alert-success">Database Backup Sucessfully! <a href="'.site_url('database/download').'">Download</a></p>';
		} else {
			$data['alert'] = '';
		}

		$this->template->setTitle('Database');
		$this->template->setHeading('Database');
		$this->template->setButton('Backup', array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton('Restore', array('class' => 'btn btn-success', 'onclick' => '$(\'#edit-form\').submit();'));

		$data['db_tables'] = array();
		$db_tables = $this->Settings_model->getdbTables();
		foreach ($db_tables as $db_table) {
			$data['db_tables'][] = array(
				'name'		=> $db_table['name'],
				'num_rows'	=> $db_table['num_rows']
			);
		}

		if ($this->input->post() AND $this->_backup() === TRUE) {
			redirect('database');
		}

		if (!empty($_FILES['restore']['name']) AND $this->_restore() === TRUE) {
			redirect('database');
		}

		$this->template->setPartials(array('header', 'footer'));
		$this->template->render('database', $data);
	}

	public function download() {
    	if (!$this->user->hasPermissions('modify', 'database')) {
			$this->alert->set('warning', 'Warning: You do not have permission to download!');
    	} else if (file_exists('assets/download/tastyigniter.sql')) {
			$name = 'tastyigniter.sql';
			$backup_sql = file_get_contents("assets/download/tastyigniter.sql");
			unlink('assets/download/tastyigniter.sql');

			$this->load->helper('download');
			force_download($name, $backup_sql);
		} else {
		    redirect('database');
		}
	}

	public function _backup() {
    	if (!$this->user->hasPermissions('modify', 'database')) {
			$this->alert->set('warning', 'Warning: You do not have permission to backup!');
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
    	if (!$this->user->hasPermissions('modify', 'database')) {
			$this->alert->set('warning', 'Warning: You do not have permission to restore!');
  			return TRUE;
    	} else if (isset($_FILES['restore']) AND !empty($_FILES['restore']['name'])) {
			if (is_uploaded_file($_FILES['restore']['tmp_name'])) {
				$content = file_get_contents($_FILES['restore']['tmp_name']);
				$temp = explode('.', $_FILES['restore']['name']);
				$extension = end($temp);
				if ($extension === 'sql') {
					if ($this->Settings_model->restoreDatabase($content)) { // calls model to save data to SQL
						$this->alert->set('success', 'Database Restored Sucessfully!');
					}
				} else {
					$this->alert->set('warning', 'Nothing Restored!');
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
/* Location: ./admin/controllers/database.php */