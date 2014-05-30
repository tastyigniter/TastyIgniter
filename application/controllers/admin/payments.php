<?php
class Payments extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('user');
		$this->load->model('Extensions_model');
	}

	public function index() {
			
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/payments')) {
  			redirect('admin/permission');
		}
		
		if ($this->input->get('install') AND $this->_install() === TRUE) { 
			redirect('admin/payments');
		}
		
		if ($this->input->get('uninstall') AND $this->_uninstall() === TRUE) { 
			redirect('admin/payments');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');
		} else {
			$data['alert'] = '';
		}

		$this->template->setTitle('Payment Methods');
		$this->template->setHeading('Payment Methods');

		$payments = $this->Extensions_model->getList('payment');
		
		foreach ($payments as $key => $code) {
			if ( ! file_exists(APPPATH .'/controllers/admin/'. $code .'.php')) {
				$this->Extensions_model->uninstall('payment', $code);
				$this->Settings_model->deleteSettings('payment', $code);	
			}
		}
		
		$files = glob(APPPATH .'/controllers/admin/*_payment.php');
	
		$data['payments'] = array();
		foreach ($files as $file) {
			$file_name = basename($file, '.php');
			
			if (in_array($file_name, $payments)) {
				$data['payments'][] = array(
					'name' 		=> ucwords(str_replace('_', ' ', $file_name)),
					'edit' 		=> site_url('admin/'. $file_name),
					'uninstall'	=> site_url('admin/payments?uninstall='. $file_name)
				);		
			} else {
				$data['payments'][] = array(
					'code' 		=> $file_name,
					'name' 		=> $file_name,
					'install'	=> site_url('admin/payments?install='. $file_name)
				);		
			}
		}

		$this->template->regions(array('header', 'footer'));
		if (file_exists(APPPATH .'views/themes/admin/'.$this->config->item('admin_theme').'payments.php')) {
			$this->template->render('themes/admin/'.$this->config->item('admin_theme'), 'payments', $data);
		} else {
			$this->template->render('themes/admin/default/', 'payments', $data);
		}
	}
	
	public function _install() {
    	if ( ! $this->user->hasPermissions('modify', 'admin/payments')) {
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to add!</p>');
    	} else if ($this->input->get('install')) { 
    		$extension = $this->input->get('install');
    		
    		$this->Extensions_model->install('payment', $extension);
    		
			$this->load->model('Staff_groups_model');
    		$this->Staff_groups_model->addPermission($this->user->getStaffGroupId(), 'access', 'admin/'. $extension);
    		$this->Staff_groups_model->addPermission($this->user->getStaffGroupId(), 'modify', 'admin/'. $extension);
				
			$this->session->set_flashdata('alert', '<p class="success">Payment Installed Sucessfully!</p>');

			return TRUE;
		}	
	}
	
	public function _uninstall() {
    	if ( ! $this->user->hasPermissions('modify', 'admin/payments')) {
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to delete!</p>');
    	} else if ($this->input->get('uninstall')) { 
    		$extension = $this->input->get('uninstall');
    		
    		$this->Extensions_model->uninstall('payment', $extension);
			$this->Settings_model->deleteSettings('payment', $extension);
			
			$this->session->set_flashdata('alert', '<p class="success">Payment Uninstalled Sucessfully!</p>');				

			return TRUE;
		}
	}	
}

/* End of file payments.php */
/* Location: ./application/controllers/admin/payments.php */