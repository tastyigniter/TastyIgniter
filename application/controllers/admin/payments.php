<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Payments extends MX_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('user');
		$this->load->model('Extensions_model');
	}

	public function index() {
		if (!$this->user->islogged()) {  
  			redirect(ADMIN_URI.'/login');
		}

    	if (!$this->user->hasPermissions('access', ADMIN_URI.'/payments')) {
  			redirect(ADMIN_URI.'/permission');
		}
		
		if ($this->input->get('name')) { 
			if ($this->input->get('action') === 'install' AND $this->_install() === TRUE) { 
				redirect(ADMIN_URI.'/payments');
			}
		
			if ($this->input->get('action') === 'uninstall' AND $this->_uninstall() === TRUE) { 
				redirect(ADMIN_URI.'/payments');
			}
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');
		} else {
			$data['alert'] = '';
		}

		$this->template->setTitle('Payment Methods');
		$this->template->setHeading('Payment Methods');

		$payments = array();
		$results = $this->Extensions_model->getList('payment');
		foreach ($results as $result) {
			if (!empty($result['name']) AND ! file_exists(EXTPATH .'payments/'. $result['name'])) {
				$this->Extensions_model->uninstall('payment', $result['name']);
			} else {
				$payments[$result['name']] = $result;
			}
		}
		
		$data['payments'] = array();
		$files = glob(EXTPATH .'payments/*');
		foreach ($files as $file) {
			if (!is_dir($file)) {
				continue;
			}
			
			$name = basename($file);
		
			if (array_key_exists($name, $payments)) {
				$extension_id = $payments[$name]['extension_id'];
				$edit = site_url(ADMIN_URI.'/payments/edit?name='.$name.'&action=edit&id='.$extension_id);
				$manage = site_url(ADMIN_URI.'/payments?name='.$name.'&action=uninstall&id='. $extension_id);
			} else {
				$extension_id = '-';
				$edit = '';
				$manage = site_url(ADMIN_URI.'/payments?name='.$name.'&action=install');
			}

			$data['payments'][] = array(
				'extension_id' 	=> $extension_id,
				'name' 			=> ucwords(str_replace('_', ' ', $name)),
				'edit' 			=> $edit,
				'action' 		=> ($edit === '') ? 'install' : 'uninstall',
				'manage'		=> $manage
			);		
		}

		$this->template->regions(array('header', 'footer'));
		if (file_exists(APPPATH .'views/themes/'.ADMIN_URI.'/'.$this->config->item('admin_theme').'payments.php')) {
			$this->template->render('themes/'.ADMIN_URI.'/'.$this->config->item('admin_theme'), 'payments', $data);
		} else {
			$this->template->render('themes/'.ADMIN_URI.'/default/', 'payments', $data);
		}
	}
	
	public function edit() {
		if (!$this->user->islogged()) {  
  			redirect(ADMIN_URI.'/login');
		}

    	if (!$this->user->hasPermissions('access', ADMIN_URI.'/payments')) {
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

		if (file_exists(EXTPATH .'payments/'.$extension_name.'/controllers/admin/'.$extension_name.'.php') AND $action === 'edit') {
			$title = ucwords(str_replace('_', ' ', $extension_name));	
			$this->template->setTitle('Payment: '. $title);
			$this->template->setHeading('Payment: '. $title);
			$this->template->setButton('Save', array('class' => 'btn btn-success', 'onclick' => '$(\'#edit-form\').submit();'));
			$this->template->setButton('Save & Close', array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
			$this->template->setBackButton('btn-back', site_url(ADMIN_URI.'/payments'));

			$data['module_path'] = $extension_name.'/admin/'.$extension_name.'/index';
		} else {
  			redirect(ADMIN_URI.'/payments');
		}
				
		$this->template->regions(array('header', 'footer'));
		if (file_exists(APPPATH .'views/themes/'.ADMIN_URI.'/'.$this->config->item('admin_theme').'payments_edit.php')) {
			$this->template->render('themes/'.ADMIN_URI.'/'.$this->config->item('admin_theme'), 'payments_edit', $data);
		} else {
			$this->template->render('themes/'.ADMIN_URI.'/default/', 'payments_edit', $data);
		}
	}
	
	public function _install() {
    	if ( ! $this->user->hasPermissions('modify', ADMIN_URI.'/payments')) {
			$this->session->set_flashdata('alert', '<p class="alert-warning">Warning: You do not have permission to install!</p>');
    	} else if ($this->input->get('action') === 'install') { 
    		$name = $this->input->get('name');
    		
    		$this->Extensions_model->install('payment', $name);
    		
			$this->load->model('Staff_groups_model');
    		$this->Staff_groups_model->addPermission($this->user->getStaffGroupId(), 'access', ADMIN_URI .'/'. $name);
    		$this->Staff_groups_model->addPermission($this->user->getStaffGroupId(), 'modify', ADMIN_URI .'/'. $name);
				
			$this->session->set_flashdata('alert', '<p class="alert-success">Payment Installed Sucessfully!</p>');

			return TRUE;
		}	
	}
	
	public function _uninstall() {
    	if ( ! $this->user->hasPermissions('modify', ADMIN_URI.'/payments')) {
			$this->session->set_flashdata('alert', '<p class="alert-warning">Warning: You do not have permission to uninstall!</p>');
    	} else if ($this->input->get('action') === 'uninstall') { 
    		$name = $this->input->get('name');
    		
    		$this->Extensions_model->uninstall('payment', $name);
			
			$this->session->set_flashdata('alert', '<p class="alert-success">Payment Uninstalled Sucessfully!</p>');				

			return TRUE;
		}
	}	
}

/* End of file payments.php */
/* Location: ./application/controllers/admin/payments.php */