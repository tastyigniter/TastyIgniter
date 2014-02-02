<?php
class Backup extends CI_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
		$this->output->enable_profiler(TRUE); // for debugging profiler... remove later
	}

	public function index() {
			
		if ( !file_exists(APPPATH .'/views/admin/backup.php')) { //check if file exists in views folder
			show_404(); // Whoops, show 404 error page!
		}

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
		$data['text_empty'] 		= 'There are no department(s) added in your database.';

		$data['db_tables'] = $this->Settings_model->getdbTables();

		if ($this->input->post('backup') && $this->_backup() === TRUE) {

		    redirect('admin/backup');
		}

		if ($this->input->post('restore') && $this->_restore() === TRUE) {
		
		     //redirect('admin/backup');
		}

		//load home page content
		$this->load->view('admin/header', $data);
		$this->load->view('admin/backup', $data);
		$this->load->view('admin/footer');
	}

	public function restore() {

    	if (!$this->user->hasPermissions('modify', 'admin/backup')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
    	
    	} else if (isset($_FILES['restore']) && !empty($_FILES['restore']['name'])) { 
 			
			//loading upload library
			$this->load->library('upload');

			//setting upload preference
			$this->upload->set_upload_path('./assets/download/');
			$this->upload->set_allowed_types('sql|txt');
			$this->upload->set_max_filesize('2048');
			$this->upload->set_max_width($this->config->item('config_max_width'));
			$this->upload->set_max_height($this->config->item('config_max_height'));

    		if ($this->upload->do_upload('restore')) {
        		$upload_data    = print_r($this->upload->data());
      		} else {
        		$upload_data = $this->upload->display_errors();
     		}
 
 			//if (is_uploaded_file($_FILES['restore']['name'])) {
				//$content = file_get_contents($_FILES['restore']['name']);
			//} else {
			//	$content = 'EMPTY';
			//}

			$this->session->set_flashdata('alert', $upload_data); //'<p class="success">Database Restored Sucessfully!</p>');
    	} else {
    	
			$this->session->set_flashdata('alert', '<p class="warning">Nothing Restored!</p>');
    	}

		redirect('admin/backup');   	
	}
	
	public function _backup() {

    	if (!$this->user->hasPermissions('modify', 'admin/backup')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
  			return TRUE;
    	
    	} else if ($this->input->post('backup')) { 
								
			$this->form_validation->set_rules('backup[]', 'Backup', 'trim|required|alpha_dash');

			if ($this->form_validation->run() === TRUE) {

				if ($this->Settings_model->backupDatabase($this->input->post('backup'))) {
					$this->session->set_flashdata('alert', '<p class="success">Database Backup Sucessfully!</p>');
				} else {
					$this->session->set_flashdata('alert', '<p class="warning">Nothing Updated!</p>');
				}
				
				return TRUE;
			}	
		}
	}	
	
	public function _restore() {
    	if (!$this->user->hasPermissions('modify', 'admin/backup')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
  			return TRUE;
    	
    	} else if ($this->input->post('restore')) { 
			
			$this->form_validation->set_rules('restore', 'Restore', 'required');

			if ($this->form_validation->run() === TRUE) {

				//if (is_uploaded_file($_FILES['restore']['name'])) {
				//	$content = file_get_contents($_FILES['restore']['name']);
				//} else {
				//	$content = FALSE;
				//}
			
				if ($this->Settings_model->restoreDatabase($content)) { // calls model to save data to SQL
			
					$this->session->set_flashdata('alert', '<p class="success">Database Restored Sucessfully!</p>');
		
				} else {
		
					$this->session->set_flashdata('alert', '<p class="warning">Nothing Updated!</p>');
		
				}
		
				return TRUE;
			}
		}
	}	

 	/*public function handle_upload() {
		//loading upload library
		$this->load->library('upload');

		//setting upload preference
		$this->upload->set_upload_path($this->config->item('config_upload_path'));
		$this->upload->set_allowed_types($this->config->item('config_allowed_types'));
		$this->upload->set_max_filesize($this->config->item('config_max_size'));
		$this->upload->set_max_width($this->config->item('config_max_width'));
		$this->upload->set_max_height($this->config->item('config_max_height'));

		if (isset($_FILES['restore']) && !empty($_FILES['restore']['name'])) {
      		
      		if ($this->upload->do_upload('restore')) {

        		// set a $_POST value for 'menu_photo' that we can use later
        		$upload_data    = $this->upload->data();
        		if ($upload_data) {
        			$_POST['restore'] = $this->security->sanitize_filename($upload_data['restore']);
        		}
        		return TRUE;        
      		} else {
        		
        		// possibly do some clean up ... then throw an error
        		$this->form_validation->set_message('handle_upload', $this->upload->display_errors());
        		return FALSE;
     		}
    	} else {
      	
        	// set an empty $_POST value for 'menu_photo' to be used on database queries
        	$_POST['restore'] = '';
      		//return TRUE;
      	}
    }*/
}