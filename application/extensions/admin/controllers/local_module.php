<?php
class Local_module extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('user');
		$this->load->model('Extensions_model');	    
		$this->load->model('Design_model');	    
		$this->output->enable_profiler(TRUE); // for debugging profiler... remove later
	}

	public function index() {
			
		//check if file exists in views
		if ( !file_exists(APPPATH .'/extensions/admin/views/local_module.php')) {
			// Whoops, we don't have a page for that!
			show_404();
		}

		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/local_module')) {
  			redirect('admin/permission');
		}
			
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');
		} else { 
			$data['alert'] = '';
		}		
				
		$data['heading'] 			= 'Local';
		$data['sub_menu_update'] 	= 'Update';
		$data['sub_menu_back'] 		= $this->config->site_url('admin/extensions');

		if ($this->input->post('modules')) {
			$modules = $this->input->post('modules');
		} else if ($this->config->item('local_module')) {
			$modules = $this->config->item('local_module');
		} else {
			$modules = array();
		}
		
		$extension = $this->Extensions_model->getExtension('module', 'local');
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
		
		$this->load->view('admin/header', $data);
		$this->load->view('admin/local_module', $data);
		$this->load->view('admin/footer');
	}

	public function _updateModule() {
						
    	if (!$this->user->hasPermissions('modify', 'admin/local_module')) {
		
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
			
				$update['local_module'] = $this->input->post('modules');

				if ($this->Settings_model->updateSettings('local', $update)) {
		
					$this->session->set_flashdata('alert', '<p class="success">Local Module Updated Sucessfully!</p>');
				} else {
		
					$this->session->set_flashdata('alert', '<p class="warning">Nothing Updated!</p>');				
				}
		
				return TRUE;
			}
		}
	}
}