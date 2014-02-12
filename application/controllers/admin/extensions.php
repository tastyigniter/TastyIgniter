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
			if ( ! file_exists(APPPATH .'/extensions/admin/controllers/'. $code .'_module.php')) {
				$this->Extensions_model->uninstall('module', $code);
				$this->Settings_model->deleteSettings($code);	
			}
		}
		
		$files = glob(APPPATH .'/extensions/admin/controllers/*_module.php');
	
		$data['extensions'] = array();
		foreach ($files as $file) {
			$file_name = basename($file, '_module.php');
		
			if (array_key_exists($file_name, $extensions)) {
				$data['extensions'][] = array(
					'name' 		=> $extensions[$file_name],
					'edit' 		=> $this->config->site_url('admin/'. $file_name .'_module'),
					'uninstall'	=> $this->config->site_url('admin/extensions/uninstall?extension='. $file_name .'_module')
				);		

			} else {
				$data['extensions'][] = array(
					'code' 		=> $file_name .'_module',
					'name' 		=> ucwords($file_name),
					'install'	=> $this->config->site_url('admin/extensions/install?extension='. $file_name .'_module')
				);		
			
			}
		}

		$regions = array(
			'admin/header',
			'admin/footer'
		);
		
		$this->template->regions($regions);
		$this->template->load('admin/extensions', $data);
	}
	
	public function install() {
    	if ( ! $this->user->hasPermissions('modify', 'admin/extensions')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
			redirect('admin/extensions');
  	
    	} else if ($this->input->get('extension')) { 
    	
    		$extension = $this->input->get('extension');
    		$split = explode('_', $extension);
    		
    		$this->Extensions_model->install($split[1], $split[0]);
    		
			$this->load->model('Departments_model');
    		$this->Departments_model->addPermission($this->user->getDepartmentId(), 'access', 'admin/'. $extension);
    		$this->Departments_model->addPermission($this->user->getDepartmentId(), 'modify', 'admin/'. $extension);
				
			$this->session->set_flashdata('alert', '<p class="success">Extension Installed Sucessfully!</p>');
				
			redirect('admin/extensions');
		}	
	}
	
	public function uninstall() {
    	if ( ! $this->user->hasPermissions('modify', 'admin/extensions')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
			redirect('admin/extensions');
  	
    	} else if ($this->input->get('extension')) { 
    	
    		$extension = $this->input->get('extension');
    		$split = explode('_', $extension);
    		
    		$this->Extensions_model->uninstall($split[1], $split[0]);
			$this->Settings_model->deleteSettings($split[0]);
			
			$this->session->set_flashdata('alert', '<p class="success">Extension Uninstalled Sucessfully!</p>');
				
			redirect('admin/extensions');
		}	
	}	
}