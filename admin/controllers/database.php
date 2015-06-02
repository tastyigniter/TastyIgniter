<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Database extends Admin_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
        $this->user->restrict('Admin.Database');
        $this->load->model('Settings_model');
	}

	public function index() {
        $this->load->helper('number');

		$this->template->setTitle('Database');
		$this->template->setHeading('Database');
		$this->template->setButton('Backup', array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton('Restore', array('class' => 'btn btn-success', 'onclick' => '$(\'#edit-form\').submit();'));

		$data['db_tables'] = array();
		$db_tables = $this->Settings_model->getdbTables();
		foreach ($db_tables as $db_table) {
			$data['db_tables'][] = array(
				'name'	        => $db_table['table_name'],
				'records'	    => $db_table['table_rows'],
				'data_length'	=> byte_format($db_table['data_length']),
				'index_length'	=> byte_format($db_table['index_length']),
				'data_free'	    => byte_format($db_table['data_free']),
				'engine'	    => $db_table['engine'],
			);
		}

        $data['backup_files'] = array();
        $backup_files = glob(ROOTPATH.'assets/downloads/*.sql');
        if (count($backup_files) > 0) {
            foreach ($backup_files as $backup_file) {
                $basename = basename($backup_file);
                $data['backup_files'][] = array(
                    'filename'      => $basename,
                    'size'          => filesize($backup_file),
                    'download'      => site_url('database/backup?download='. $basename),
                    'delete'        => site_url('database/backup?delete='. $basename)
                );
            }
        }

        if ($this->input->post() AND $this->_backup() === TRUE) {
			redirect('database');
		} else if (!empty($_FILES['restore']['name']) AND $this->_restore() === TRUE) {
			redirect('database');
		}

		$this->template->setPartials(array('header', 'footer'));
		$this->template->render('database', $data);
	}

	public function backup() {
        if (!$this->user->hasPermission('Admin.Database.Manage')) {
            $this->alert->set('warning', 'Warning: You do not have permission to backup or restore database!');
            redirect('database');
        } else {
            if ($this->input->get('download')) {
                $download = pathinfo($this->input->get('download'));
                $file_path = ROOTPATH . "assets/downloads/" . $download['filename'] . ".sql";

                if ($download['extension'] === 'sql' AND file_exists($file_path)) {
                    $file_data = file_get_contents($file_path);
                    $this->load->helper('download');
                    force_download($download['basename'], $file_data);
                }

            } else if ($this->input->get('delete')) {
                $delete = pathinfo($this->input->get('delete'));
                $file_path = ROOTPATH . "assets/downloads/" . $delete['filename'] . ".sql";

                if ($delete['extension'] === 'sql' AND file_exists($file_path)) {
                    unlink($file_path);
                    $this->alert->set('success', 'Database Backup deleted successfully.');
                }

                redirect('database');
            } else {
                redirect('database');
            }
        }
	}

	private function _backup() {
    	if ($this->input->post('backup')) {
            $this->form_validation->set_rules('backup[]', 'Backup', 'xss_clean|trim|required|alpha_dash');

            if ($this->form_validation->run() === TRUE) {
				if ($this->Settings_model->backupDatabase($this->input->post('backup'))) {
                    $this->alert->set('success', 'Database backed up successfully.');
                    return TRUE;
                }
			} else {
				return FALSE;
			}
		}
	}

	private function _restore() {
    	if (isset($_FILES['restore']) AND !empty($_FILES['restore']['name'])) {
			if (is_uploaded_file($_FILES['restore']['tmp_name'])) {
				$content = file_get_contents($_FILES['restore']['tmp_name']);
				$temp = explode('.', $_FILES['restore']['name']);
				$extension = end($temp);
				if ($extension === 'sql') {
					if ($this->Settings_model->restoreDatabase($content)) { // calls model to save data to SQL
						$this->alert->set('success', 'Database Restored successfully.');
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

	private function validateForm() {
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