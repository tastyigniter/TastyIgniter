<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Extensions extends Admin_Controller {

   	public function __construct() {
		parent::__construct();
		$this->load->library('user');
		$this->load->library('extension');
		$this->load->model('Extensions_model');
	}

	public function index() {
		if (!$this->user->islogged()) {
  			redirect('login');
		}

    	if (!$this->user->hasPermissions('access', 'extensions')) {
  			redirect('permission');
		}

		if ($this->input->get('name') AND $this->input->get('action')) {
			if ($this->input->get('action') === 'install' AND $this->_installExtension()) {
				redirect('extensions');
			}

			if ($this->input->get('action') === 'uninstall' AND $this->_uninstallExtension()) {
				redirect('extensions');
			}
		}

		$this->template->setTitle('Modules');
		$this->template->setHeading('Modules');
		$this->template->setButton('+ New', array('class' => 'btn btn-info', 'href' => page_url() .'/add'));
		$this->template->setButton('Uninstall', array('class' => 'btn btn-danger', 'onclick' => 'uninstallExtension()'));

		$data['text_empty'] 		= 'There are no extensions available.';

		$data['extensions'] = array();
		$results = $this->Extensions_model->getList('module');
		foreach ($results as $result) {
			if ($result['installed'] === TRUE) {
				$extension_id = $result['extension_id'];
				$manage = site_url('extensions?action=uninstall&name='.$result['name']);
			} else {
				$extension_id = '-';
				$manage = site_url('extensions?action=install&name='.$result['name']);
			}

			$data['extensions'][] = array(
				'extension_id' 	=> $extension_id,
				'name' 			=> $result['title'],
				'installed' 	=> $result['installed'],
				'type' 			=> $result['type'],
				'options' 		=> $result['options'],
				'edit' 			=> site_url('extensions/edit?action=edit&name='.$result['name']),
				'manage'		=> $manage
			);
		}

		$this->template->setPartials(array('header', 'footer'));
		$this->template->render('extensions', $data);
	}

	public function edit() {
		if (!$this->user->islogged()) {
  			redirect('login');
		}

    	if (!$this->user->hasPermissions('access', 'extensions')) {
  			redirect('permission');
		}

		$extension_name = $this->input->get('name');
		$action = $this->input->get('action');
		$loaded = FALSE;

		if ($extension = $this->Extensions_model->getExtension('module', $extension_name)) {

			if (isset($extension['installed']) AND $extension['installed'] === TRUE)  {
				$loaded = TRUE;
			}

			if (isset($extension['config']) AND $extension['config'] === TRUE)  {
				$loaded = TRUE;
			}

			if ($loaded === TRUE AND $action === 'edit') {
				$this->template->setTitle('Module: '. $extension['title']);
				$this->template->setHeading('Module: '. $extension['title']);
				$this->template->setButton('Save', array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
				$this->template->setButton('Save & Close', array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
				$this->template->setBackButton('btn btn-back', site_url('extensions'));

				$data['extension_name'] 	= $extension['name'];
				$data['extension_options'] 	= $extension;
			}
		}

		$this->template->setPartials(array('header', 'footer'));
		$this->template->render('extensions_edit', $data);
	}

	public function _installExtension() {
    	if ( ! $this->user->hasPermissions('modify', 'extensions')) {
			$this->alert->set('warning', 'Warning: You do not have permission to install!');
    	} else if ($this->input->get('action') === 'install') {

 			if ($this->Extensions_model->findExtension($this->input->get('name'))) {

	    		if ($this->Extensions_model->install('module', $this->input->get('name'))) {
					$this->alert->set('success', 'Extension Installed Sucessfully!');
					return TRUE;
	    		}
	    	}
		}

		return FALSE;
	}

	public function _uninstallExtension() {
    	if ( ! $this->user->hasPermissions('modify', 'extensions')) {
			$this->alert->set('warning', 'Warning: You do not have permission to uninstall!');
    	} else if ($this->input->get('action') === 'uninstall') {

    		if ($this->Extensions_model->findExtension($this->input->get('name'))) {

    			if ($this->Extensions_model->uninstall('module', $this->input->get('name'))) {
					$this->alert->set('success', 'Extension Uninstalled Sucessfully!');
					return TRUE;
    			}
    		}
		}

		return FALSE;
	}
}

/* End of file extensions.php */
/* Location: ./admin/controllers/extensions.php */