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
		} else {
			$data['alert'] = '';
		}

		$data['heading'] 			= 'Backup/Restore';
		$data['sub_menu_list'] 		= '<li><a class="update_button" onclick="$(\'#backup\').submit();">Backup</a></li><li><a class="update_button" onclick="$(\'#restore\').submit();">Restore</a></li>';

		$data['db_tables'] = $this->Settings_model->getdbTables();

		$regions = array(
			'admin/header',
			'admin/footer'
		);
		
		$this->template->regions($regions);
		$this->template->load('admin/backup', $data);
	}

	public function download() {

    	if (!$this->user->hasPermissions('modify', 'admin/backup')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
    	
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
	
	public function export() {

    	if (!$this->user->hasPermissions('modify', 'admin/backup')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
    	
    	} else if ($this->input->post('backup')) { 
								
			$this->form_validation->set_rules('backup[]', 'Backup', 'trim|required|alpha_dash');

			if ($this->form_validation->run() === TRUE) {

				if ($this->Settings_model->backupDatabase($this->input->post('backup'))) {
					$this->session->set_flashdata('alert', '<p class="success">Database Backup Sucessfully! <br /><a href="'.site_url('admin/backup/download').'">Download</a></p>');
				} else {
					$this->session->set_flashdata('alert', '<p class="warning">Nothing Backup!</p>');
				}
			}	
		}

		redirect('admin/backup');
	}	
	
	public function import() {

    	if (!$this->user->hasPermissions('modify', 'admin/backup')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
  			return TRUE;
    	
    	} else { 
			
			$this->form_validation->set_rules('import', 'Restore', 'trim|callback_handle_upload');

			if ($this->form_validation->run() === TRUE) {
		redirect('admin/backup');

				//if (is_uploaded_file($_FILES['restore']['name'])) {
				//	$content = file_get_contents($_FILES['restore']['name']);
				//} else {
				//	$content = FALSE;
				//}
			
				/*if ($this->Settings_model->restoreDatabase($content)) { // calls model to save data to SQL
			
					$this->session->set_flashdata('alert', '<p class="success">Database Restored Sucessfully!</p>');
		
				} else {
		
					$this->session->set_flashdata('alert', '<p class="warning">Nothing Updated!</p>');
		
				}*/
		
				return TRUE;
			}
		}

		//redirect('admin/backup');
	}	

 	public function handle_upload() {
		//loading upload library
		$this->load->library('upload');

		//setting upload preference
		$this->upload->set_upload_path($this->config->item('upload_path'));
		$this->upload->set_allowed_types($this->config->item('allowed_types'));
		$this->upload->set_max_filesize($this->config->item('max_size'));
		$this->upload->set_max_width($this->config->item('max_width'));
		$this->upload->set_max_height($this->config->item('max_height'));

		if (isset($_FILES['import']) && !empty($_FILES['site_logo']['name'])) {
      		
      		if ($this->upload->do_upload('import')) {

        		// set a $_POST value for 'menu_photo' that we can use later
        		if ($upload_data = $this->upload->data()) {
        			$_POST['import'] = $this->security->sanitize_filename($upload_data['file_name']);
        		}
        		return TRUE;        
      		} else {
        		
        		// possibly do some clean up ... then throw an error
        		$this->form_validation->set_message('handle_upload', $this->upload->display_errors());
        		return FALSE;
     		}
    	} else {
      	
        	// set an empty $_POST value for 'menu_photo' to be used on database queries
        	$_POST['import'] = '';
      		return TRUE;
      	}
    }
}