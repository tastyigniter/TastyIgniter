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
		
		if ($this->input->get('install') AND $this->_install() === TRUE) { 
			redirect('admin/extensions');
		}
		
		if ($this->input->get('uninstall') AND $this->_uninstall() === TRUE) { 
			redirect('admin/extensions');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');
		} else {
			$data['alert'] = '';
		}

		$this->template->setTitle('Extensions');
		$this->template->setHeading('Extensions');

		$data['text_empty'] 		= 'There are no extensions available.';

		$extensions = $this->Extensions_model->getList('module');
		foreach ($extensions as $key => $code) {
			if ( ! file_exists(APPPATH .'/controllers/admin/'. $code .'.php')) {
				$this->Extensions_model->uninstall('module', $code);
				$this->Settings_model->deleteSettings('module', $code);	
			}
		}
		
		$files = glob(APPPATH .'/controllers/admin/*_module.php');
	
		$data['extensions'] = array();
		foreach ($files as $file) {
			$file_name = basename($file, '.php');
		
			if (in_array($file_name, $extensions)) {
				$data['extensions'][] = array(
					'name' 		=> ucwords(str_replace('_', ' ', $file_name)),
					'edit' 		=> site_url('admin/'. $file_name),
					'uninstall'	=> site_url('admin/extensions?uninstall='. $file_name)
				);		

			} else {
				$data['extensions'][] = array(
					'code' 		=> $file_name,
					'name' 		=> $file_name,
					'install'	=> site_url('admin/extensions?install='. $file_name)
				);		
			
			}
		}

		$this->template->regions(array('header', 'footer'));
		if (file_exists(APPPATH .'views/themes/admin/'.$this->config->item('admin_theme').'extensions.php')) {
			$this->template->render('themes/admin/'.$this->config->item('admin_theme'), 'extensions', $data);
		} else {
			$this->template->render('themes/admin/default/', 'extensions', $data);
		}
	}
	
	public function _install() {
    	if ( ! $this->user->hasPermissions('modify', 'admin/extensions')) {
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to add!</p>');
    	} else if ($this->input->get('install')) { 
    		$extension = $this->input->get('install');
    		
    		$this->Extensions_model->install('module', $extension);
    		
			$this->load->model('Staff_groups_model');
    		$this->Staff_groups_model->addPermission($this->user->getStaffGroupId(), 'access', 'admin/'. $extension);
    		$this->Staff_groups_model->addPermission($this->user->getStaffGroupId(), 'modify', 'admin/'. $extension);
				
			$this->session->set_flashdata('alert', '<p class="success">Extension Installed Sucessfully!</p>');

			return TRUE;
		}	
	}
	
	public function _uninstall() {
    	if ( ! $this->user->hasPermissions('modify', 'admin/extensions')) {
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to delete!</p>');
    	} else if ($this->input->get('uninstall')) { 
    		$extension = $this->input->get('uninstall');
    		
    		$this->Extensions_model->uninstall('module', $extension);
			$this->Settings_model->deleteSettings('module', $extension);
			
			$this->session->set_flashdata('alert', '<p class="success">Extension Uninstalled Sucessfully!</p>');				

			return TRUE;
		}
	}	
}

/* End of file extensions.php */
/* Location: ./application/controllers/admin/extensions.php */