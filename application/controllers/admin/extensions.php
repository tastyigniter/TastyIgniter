<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Extensions extends MX_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('user');
		$this->load->model('Extensions_model');
		$this->load->model('Settings_model');
	}

	public function index() {
		if (!$this->user->islogged()) {  
  			redirect(ADMIN_URI.'/login');
		}

    	if (!$this->user->hasPermissions('access', ADMIN_URI.'/extensions')) {
  			redirect(ADMIN_URI.'/permission');
		}
		
		if ($this->input->get('name')) { 
			if ($this->input->get('action') === 'install' AND $this->_install() === TRUE) { 
				redirect(ADMIN_URI.'/extensions');
			}
		
			if ($this->input->get('action') === 'uninstall' AND $this->_uninstall() === TRUE) { 
				redirect(ADMIN_URI.'/extensions');
			}
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');
		} else {
			$data['alert'] = '';
		}

		$this->template->setTitle('Modules');
		$this->template->setHeading('Modules');

		$data['text_empty'] 		= 'There are no extensions available.';

		$extensions = array();
		$results = $this->Extensions_model->getList('module');
		foreach ($results as $result) {
			if (!empty($result['name']) AND ! file_exists(EXTPATH .'modules/'. $result['name'])) {
				$this->Extensions_model->uninstall('module', $result['name']);
			} else {
				$extensions[$result['name']] = $result;
			}
		}
		
		$data['extensions'] = array();
		$files = glob(EXTPATH .'modules/*');
		foreach ($files as $file) {
			if (!is_dir($file)) {
				continue;
			}
			
			$name = basename($file);
		
			if (array_key_exists($name, $extensions)) {
				$extension_id = $extensions[$name]['extension_id'];
				$edit = site_url(ADMIN_URI.'/extensions/edit?name='.$name.'&action=edit&id='.$extension_id);
				$manage = site_url(ADMIN_URI.'/extensions?name='.$name.'&action=uninstall&id='. $extension_id);
			} else {
				$extension_id = '-';
				$edit = '';
				$manage = site_url(ADMIN_URI.'/extensions?name='.$name.'&action=install');
			}

			$data['extensions'][] = array(
				'extension_id' 	=> $extension_id,
				'name' 			=> ucwords(str_replace('_module', '', $name)),
				'edit' 			=> $edit,
				'action' 		=> ($edit === '') ? 'install' : 'uninstall',
				'manage'		=> $manage
			);		
		}

		$this->template->regions(array('header', 'footer'));
		if (file_exists(APPPATH .'views/themes/'.ADMIN_URI.'/'.$this->config->item('admin_theme').'extensions.php')) {
			$this->template->render('themes/'.ADMIN_URI.'/'.$this->config->item('admin_theme'), 'extensions', $data);
		} else {
			$this->template->render('themes/'.ADMIN_URI.'/default/', 'extensions', $data);
		}
	}
	
	public function edit() {
		if (!$this->user->islogged()) {  
  			redirect(ADMIN_URI.'/login');
		}

    	if (!$this->user->hasPermissions('access', ADMIN_URI.'/extensions')) {
  			redirect(ADMIN_URI.'/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else { 
			$data['alert'] = '';
		}		

		$extension_id = (int) $this->input->get('id');
		$extension_name = $this->input->get('name');
		$action = $this->input->get('action');

		if (file_exists(EXTPATH .'modules/'.$extension_name.'/controllers/admin/'.$extension_name.'.php') AND $action === 'edit') {
			$title = ucwords(str_replace('_module', '', $extension_name));	
			$this->template->setTitle('Module: '. $title);
			$this->template->setHeading('Module: '. $title);
			$this->template->setButton('Save', array('class' => 'btn btn-success', 'onclick' => '$(\'#edit-form\').submit();'));
			$this->template->setButton('Save & Close', array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
			$this->template->setBackButton('btn-back', site_url(ADMIN_URI.'/extensions'));

			$data['module_path'] = $extension_name.'/admin/'.$extension_name.'/index';
		} else {
  			redirect(ADMIN_URI.'/extensions');
		}
				
		$this->template->regions(array('header', 'footer'));
		if (file_exists(APPPATH .'views/themes/'.ADMIN_URI.'/'.$this->config->item('admin_theme').'extensions_edit.php')) {
			$this->template->render('themes/'.ADMIN_URI.'/'.$this->config->item('admin_theme'), 'extensions_edit', $data);
		} else {
			$this->template->render('themes/'.ADMIN_URI.'/default/', 'extensions_edit', $data);
		}
	}
	
	public function _install() {
    	if ( ! $this->user->hasPermissions('modify', ADMIN_URI.'/extensions')) {
			$this->session->set_flashdata('alert', '<p class="alert-warning">Warning: You do not have permission to install!</p>');
    	} else if ($this->input->get('action') === 'install') { 
    		$name = $this->input->get('name');
    		
    		$this->Extensions_model->install('module', $name);
    		
			$this->load->model('Staff_groups_model');
    		$this->Staff_groups_model->addPermission($this->user->getStaffGroupId(), 'access', ADMIN_URI .'/'. $name);
    		$this->Staff_groups_model->addPermission($this->user->getStaffGroupId(), 'modify', ADMIN_URI .'/'. $name);
				
			$this->session->set_flashdata('alert', '<p class="alert-success">Extension Installed Sucessfully!</p>');

			return TRUE;
		}	
	}
	
	public function _uninstall() {
    	if ( ! $this->user->hasPermissions('modify', ADMIN_URI.'/extensions')) {
			$this->session->set_flashdata('alert', '<p class="alert-warning">Warning: You do not have permission to uninstall!</p>');
    	} else if ($this->input->get('action') === 'uninstall') { 
    		$name = $this->input->get('name');
    		
    		$this->Extensions_model->uninstall('module', $name);
			//$this->Settings_model->deleteSettings('module', $name);
			
			$this->session->set_flashdata('alert', '<p class="alert-success">Extension Uninstalled Sucessfully!</p>');				

			return TRUE;
		}
	}	
}

/* End of file extensions.php */
/* Location: ./application/controllers/admin/extensions.php */