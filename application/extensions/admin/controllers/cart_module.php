<?php
class Cart_module extends CI_Controller {

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

    	if (!$this->user->hasPermissions('access', 'admin/cart_module')) {
  			redirect('admin/permission');
		}
			
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');
		} else { 
			$data['alert'] = '';
		}		
				
		$data['heading'] 			= 'Cart';
		$data['sub_menu_save'] 	= 'Save';
		$data['sub_menu_back'] 		= $this->config->site_url('admin/extensions');
		
		if ($this->input->post('modules')) {
			$modules = $this->input->post('modules');
		} else if ($this->config->item('cart_module')) {
			$modules = $this->config->item('cart_module');
		} else {
			$modules = array();
		}
		
		$extension = $this->Extensions_model->getExtension('module', 'cart');
		$data['name'] = $extension['name'];
		
		$data['modules'] = array();
		foreach ($modules as $module) {
	
			$data['modules'][] = array(
				'layout_id'		=> $module['layout_id'],
				'position' 		=> $module['position'],
				'priority' 		=> $module['priority'],
				'status' 		=> $module['status']
			);
		}

		$data['layouts'] = array();
		$results = $this->Design_model->getLayouts();
		foreach ($results as $result) {					
			$data['layouts'][] = array(
				'layout_id'		=> $result['layout_id'],
				'name'			=> $result['name']
			);
		}
		
		if ($this->input->post() && $this->_updateModule() === TRUE){
						
			redirect('admin/extensions');
		}
		
		$regions = array(
			'admin/header',
			'admin/footer'
		);
		
		$this->template->regions($regions);
		$this->template->load('admin/cart_module', $data);
	}

	public function _updateModule() {
						
    	if (!$this->user->hasPermissions('modify', 'admin/cart_module')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
			return TRUE;
    	
    	} else { 
			
 			$this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[2]|max_length[45]');

			foreach ($this->input->post('modules') as $key => $value) {
				$this->form_validation->set_rules('modules['.$key.'][layout_id]', 'Layout', 'trim|required');
				$this->form_validation->set_rules('modules['.$key.'][position]', 'Position', 'trim|required');
				$this->form_validation->set_rules('modules['.$key.'][priority]', 'Priority', 'trim|integer');
				$this->form_validation->set_rules('modules['.$key.'][status]', 'Status', 'trim|required|integer');
			}
			
			//if validation is true
			if ($this->form_validation->run() === TRUE) {
				$update = array();
			
				$update['cart_module'] = $this->input->post('modules');

				if ($this->Settings_model->updateSettings('cart', $update)) {
		
					$this->session->set_flashdata('alert', '<p class="success">Cart Module Updated Sucessfully!</p>');
				} else {
		
					$this->session->set_flashdata('alert', '<p class="warning">Nothing Updated!</p>');				
				}
		
				return TRUE;
			}
		}
	}
}