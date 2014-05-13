<?php
class Extensions extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('user');
		$this->load->model('Extensions_model');
		$this->load->model('Settings_model');
	}

	public function index() {
			
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/extensions')) {
  			redirect('admin/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');
		} else {
			$data['alert'] = '';
		}

		$data['heading'] 			= 'Extensions';
		$data['text_empty'] 		= 'There are no extensions available.';

		$extensions = $this->Extensions_model->getList();
		foreach ($extensions as $code => $name) {
			if ( ! file_exists(APPPATH .'/controllers/admin/'. $code .'_module.php')) {
				$this->Extensions_model->uninstall('module', $code);
				$this->Settings_model->deleteSettings($code);	
			}
		}
		
		$files = glob(APPPATH .'/controllers/admin/*_module.php');
	
		$data['extensions'] = array();
		foreach ($files as $file) {
			$file_name = basename($file, '_module.php');
		
			if (array_key_exists($file_name, $extensions)) {
				$data['extensions'][] = array(
					'name' 		=> $extensions[$file_name],
					'edit' 		=> site_url('admin/'. $file_name .'_module'),
					'uninstall'	=> site_url('admin/extensions/uninstall?extension='. $file_name .'_module')
				);		

			} else {
				$data['extensions'][] = array(
					'code' 		=> $file_name .'_module',
					'name' 		=> ucwords($file_name),
					'install'	=> site_url('admin/extensions/install?extension='. $file_name .'_module')
				);		
			
			}
		}

		$regions = array('header', 'footer');
		if (file_exists(APPPATH .'views/themes/admin/'.$this->config->item('admin_theme').'extensions.php')) {
			$this->template->render('themes/admin/'.$this->config->item('admin_theme'), 'extensions', $regions, $data);
		} else {
			$this->template->render('themes/admin/default/', 'extensions', $regions, $data);
		}
	}
	
	public function install() {
    	if ( ! $this->user->hasPermissions('modify', 'admin/extensions')) {
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to add!</p>');
    	} else if ($this->input->get('extension')) { 
    		$extension = $this->input->get('extension');
    		$split = explode('_', $extension);
    		
    		$this->Extensions_model->install($split[1], $split[0]);
    		
			$this->load->model('Staff_groups_model');
    		$this->Staff_groups_model->addPermission($this->user->getStaffGroupId(), 'access', 'admin/'. $extension);
    		$this->Staff_groups_model->addPermission($this->user->getStaffGroupId(), 'modify', 'admin/'. $extension);
				
			$this->session->set_flashdata('alert', '<p class="success">Extension Installed Sucessfully!</p>');
		}	

		redirect('admin/extensions');
	}
	
	public function uninstall() {
    	if ( ! $this->user->hasPermissions('modify', 'admin/extensions')) {
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to delete!</p>');
    	} else if ($this->input->get('extension')) { 
    		$extension = $this->input->get('extension');
    		$split = explode('_', $extension);
    		
    		$this->Extensions_model->uninstall($split[1], $split[0]);
			$this->Settings_model->deleteSettings($split[0]);
			
			$this->session->set_flashdata('alert', '<p class="success">Extension Uninstalled Sucessfully!</p>');				
		}
		
		redirect('admin/extensions');
	}	
}

/* End of file extensions.php */
/* Location: ./application/controllers/admin/extensions.php */