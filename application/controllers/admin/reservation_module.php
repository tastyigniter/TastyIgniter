<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reservation_module extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('user');
		$this->load->model('Extensions_model');	    
		$this->load->model('Design_model');	    
	}

	public function index() {
			
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/reservation_module')) {
  			redirect('admin/permission');
		}
			
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');
		} else { 
			$data['alert'] = '';
		}		
				
		$extension = $this->Extensions_model->getExtension('module', 'reservation');

		$this->template->setTitle('Extension: Reservation Module');
		$this->template->setHeading('Extension: Reservation Module');
		$this->template->setButton('Save', array('class' => 'save_button', 'onclick' => '$(\'form\').submit();'));
		$this->template->setButton('Save & Close', array('class' => 'save_close_button', 'onclick' => 'saveClose();'));
		$this->template->setBackButton('back_button', site_url('admin/extensions'));

		$data['name'] 				= 'Reservation Module';

		if ($this->config->item('reservation_module')) {
			$result = $this->config->item('reservation_module');
		} else {
			$result = array();
		}

		if (isset($result['dimension_h'])) {
			$data['dimension_h'] = $result['dimension_h'];
		} else {
			$data['dimension_h'] = '360';
		}
		
		if ($this->input->post('modules')) {
			$result['modules'] = $this->input->post('modules');
		}

		$data['modules'] = array();
		if (!empty($result['modules'])) {
			foreach ($result['modules'] as $module) {
	
				$data['modules'][] = array(
					'layout_id'		=> $module['layout_id'],
					'position' 		=> $module['position'],
					'priority' 		=> $module['priority'],
					'status' 		=> $module['status']
				);
			}
		}

		$data['layouts'] = array();
		$results = $this->Design_model->getLayouts();
		foreach ($results as $result) {					
			$data['layouts'][] = array(
				'layout_id'		=> $result['layout_id'],
				'name'			=> $result['name']
			);
		}
		
		if ($this->input->post() AND $this->_updateModule() === TRUE){
			if ($this->input->post('save_close') === '1') {
				redirect('admin/extensions');
			}
			
			redirect('admin/reservation_module');
		}
		
		$this->template->regions(array('header', 'footer'));
		if (file_exists(APPPATH .'views/themes/admin/'.$this->config->item('admin_theme').'reservation_module.php')) {
			$this->template->render('themes/admin/'.$this->config->item('admin_theme'), 'reservation_module', $data);
		} else {
			$this->template->render('themes/admin/default/', 'reservation_module', $data);
		}
	}

	public function _updateModule() {
						
    	if (!$this->user->hasPermissions('modify', 'admin/reservation_module')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to update!</p>');
			return TRUE;
    	
    	} else if ($this->validateForm() === TRUE) { 
			$update = array();
		
			$update['dimension_h'] 	= $this->input->post('dimension_h');
			$update['modules'] 		= $this->input->post('modules');

			if ($this->Settings_model->addSetting('module', 'reservation_module', $update, '1')) {
				$this->session->set_flashdata('alert', '<p class="success">Reservation Module updated sucessfully.</p>');
			} else {
				$this->session->set_flashdata('alert', '<p class="warning">An error occured, nothing updated.</p>');				
			}
	
			return TRUE;
		}
	}

 	public function validateForm() {
		$this->form_validation->set_rules('name', 'Name', 'xss_clean|trim|required|min_length[2]|max_length[32]');

		foreach ($this->input->post('modules') as $key => $value) {
			$this->form_validation->set_rules('modules['.$key.'][layout_id]', 'Layout', 'xss_clean|trim|required');
			$this->form_validation->set_rules('modules['.$key.'][position]', 'Position', 'xss_clean|trim|required');
			$this->form_validation->set_rules('modules['.$key.'][priority]', 'Priority', 'xss_clean|trim|integer');
			$this->form_validation->set_rules('modules['.$key.'][status]', 'Status', 'xss_clean|trim|required|integer');
		}
		
		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

/* End of file reservation_module.php */
/* Location: ./application/extensions/admin/controllers/reservation_module.php */