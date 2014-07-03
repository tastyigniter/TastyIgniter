<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Cart_module extends MX_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('user');
		$this->load->model('Extensions_model');	    
		$this->load->model('Design_model');	    
	}

	public function index() {
		if (!$this->user->islogged()) {  
  			redirect(ADMIN_URI.'/login');
		}

    	if (!$this->user->hasPermissions('access', ADMIN_URI.'/cart_module')) {
  			redirect(ADMIN_URI.'/permission');
		}
			
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');
		} else { 
			$data['alert'] = '';
		}		
				
		$extension = $this->Extensions_model->getExtension('module', 'cart_module');
		
		if (!$this->input->get('id') AND !$this->input->get('name') AND $this->input->get('action') !== 'edit') {
			redirect(ADMIN_URI.'/extensions/edit?name=account_module&action=edit&id='.$extension['extension_id']);
		}

		$data['name'] = ucwords(str_replace('_module', '', $this->input->get('name')));

		if (!empty($extension['data'])) {
			$result = unserialize($extension['data']);
		} else {
			$result = array();
		}
		
		if ($this->input->post('layouts')) {
			$result['layouts'] = $this->input->post('layouts');
		}

		$data['modules'] = array();
		if (!empty($result['layouts'])) {
			foreach ($result['layouts'] as $module) {
	
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
				redirect(ADMIN_URI.'/extensions');
			}
			
			redirect(ADMIN_URI.'/extensions/edit?name='.$extension['name'].'&action=edit&id='.$extension['extension_id']);
		}

		if (file_exists(EXTPATH .'modules/cart_module/views/admin/cart_module.php')) { 								//check if file exists in views folder
			$this->load->view('cart_module/admin/cart_module', $data);
		} else {
			show_404(); 																		// Whoops, show 404 error page!
		}
	}

	public function _updateModule() {
    	if (!$this->user->hasPermissions('modify', ADMIN_URI.'/cart_module')) {
			$this->session->set_flashdata('alert', '<p class="alert-warning">Warning: You do not have permission to update!</p>');
			return TRUE;
    	} else if ($this->validateForm() === TRUE) { 
			$update = array();
		
			$update['type'] 			= 'module';
			$update['name'] 			= $this->input->get('name');
			$update['extension_id'] 	= (int) $this->input->get('id');
			$update['data']['layouts'] 	= $this->input->post('layouts');

			if ($this->Extensions_model->updateExtension($update, '1')) {
				$this->session->set_flashdata('alert', '<p class="alert-success">Cart Module updated sucessfully.</p>');
			} else {
				$this->session->set_flashdata('alert', '<p class="alert-warning">An error occured, nothing updated.</p>');				
			}
	
			return TRUE;
		}
	}

 	public function validateForm() {
		$this->form_validation->set_rules('name', 'Name', 'xss_clean|trim|required|min_length[2]|max_length[32]');

		foreach ($this->input->post('layouts') as $key => $value) {
			$this->form_validation->set_rules('layouts['.$key.'][layout_id]', 'Layout', 'xss_clean|trim|required|integer');
			$this->form_validation->set_rules('layouts['.$key.'][position]', 'Position', 'xss_clean|trim|required');
			$this->form_validation->set_rules('layouts['.$key.'][priority]', 'Priority', 'xss_clean|trim|integer');
			$this->form_validation->set_rules('layouts['.$key.'][status]', 'Status', 'xss_clean|trim|required|integer');
		}
		
		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

/* End of file cart_module.php */
/* Location: ./application/extensions/modules/cart_module/controllers/admin/cart_module.php */