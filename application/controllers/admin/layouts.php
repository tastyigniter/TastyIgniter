<?php
class Layouts extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('user');
		$this->load->model('Design_model');
		$this->load->model('Settings_model');
	}

	public function index() {

		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/layouts')) {
  			redirect('admin/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');
		} else {
			$data['alert'] = '';
		}

		$data['heading'] 			= 'Layouts';
		$data['button_add'] 		= 'New';
		$data['button_delete'] 		= 'Delete';
		$data['text_empty'] 		= 'There are no layouts available.';

		$data['layouts'] = array();
		$results = $this->Design_model->getLayouts();
		foreach ($results as $result) {					
			$data['layouts'][] = array(
				'layout_id'		=> $result['layout_id'],
				'name'			=> $result['name'],
				'edit' 			=> site_url('admin/layouts/edit?id=' . $result['layout_id'])
			);
		}
		
		$data['uri_routes'] = array();
		$results = $this->Design_model->getRoutes(1);
		foreach ($results as $result) {					
			$data['uri_routes'][] = array(
				'uri_route_id'		=> $result['uri_route_id'],
				'uri_route'			=> $result['uri_route']
			);
		}
	
		if ($this->input->post('delete') && $this->_deleteLayout() === TRUE) {
			
			redirect('admin/layouts');  			
		}	

		$regions = array('header', 'footer');
		if (file_exists(APPPATH .'views/themes/admin/'.$this->config->item('admin_theme').'layouts.php')) {
			$this->template->render('themes/admin/'.$this->config->item('admin_theme'), 'layouts', $regions, $data);
		} else {
			$this->template->render('themes/admin/default/', 'layouts', $regions, $data);
		}
	}
	
	public function edit() {
		
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/layouts')) {
  			redirect('admin/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else { 
			$data['alert'] = '';
		}		

		if (is_numeric($this->input->get('id'))) {
			$layout_id = (int)$this->input->get('id');
			$data['action']	= site_url('admin/layouts/edit?id='. $layout_id);
		} else {
		    $layout_id = 0;
			$data['action']	= site_url('admin/layouts/edit');
		}
		
		$result = $this->Design_model->getLayout($layout_id);
		
		$data['heading'] 			= 'Layouts - '. $result['name'];
		$data['button_save'] 		= 'Save';
		$data['button_save_close'] 	= 'Save & Close';
		$data['sub_menu_back'] 		= site_url('admin/layouts');

		$data['layout_id'] 			= $result['layout_id'];
		$data['name'] 				= $result['name'];
		
		if ($this->input->post('routes')) {
			$data['routes'] = $this->input->post('routes');
		} else {
			$data['routes'] = $this->Design_model->getLayoutRoutes($result['layout_id']);
		}

		$data['uri_routes'] = array();
		$results = $this->Design_model->getRoutes(1);
		foreach ($results as $result) {					
			$data['uri_routes'][] = array(
				'uri_route_id'		=> $result['uri_route_id'],
				'uri_route'			=> $result['uri_route']
			);
		}
	
		if ($this->input->post() && $this->_addLayout() === TRUE) {
		
			redirect('/admin/layouts');
		}

		if ($this->input->post() && $this->_updateLayout() === TRUE) {
			if ($this->input->post('save_close') === '1') {
				redirect('admin/layouts');
			}
			
			redirect('admin/layouts/edit?id='. $layout_id);
		}
		
		$regions = array('header', 'footer');
		if (file_exists(APPPATH .'views/themes/admin/'.$this->config->item('admin_theme').'layouts_edit.php')) {
			$this->template->render('themes/admin/'.$this->config->item('admin_theme'), 'layouts_edit', $regions, $data);
		} else {
			$this->template->render('themes/admin/default/', 'layouts_edit', $regions, $data);
		}
	}

	public function _addLayout() {
    	if ( ! $this->user->hasPermissions('modify', 'admin/layouts')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to add!</p>');
  			return TRUE;
  	
    	} else if ( ! $this->input->get('id') AND $this->validateForm() === TRUE) { 
			$add = array();
			
			//Sanitizing the POST values
			$add['name'] 		= $this->input->post('name');
			$add['routes'] 		= $this->input->post('routes');
			
			if ($this->Design_model->addLayout($add)) {
				$this->session->set_flashdata('alert', '<p class="success">Layout Added Sucessfully!</p>');
			} else {
				$this->session->set_flashdata('alert', '<p class="warning">Nothing Added!</p>');				
			}
							
			return TRUE;
		}	
	}
	
	public function _updateLayout() {
    	if ( ! $this->user->hasPermissions('modify', 'admin/layouts')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to update!</p>');
  			return TRUE;
  	
    	} else if ($this->input->get('id') AND $this->validateForm() === TRUE) { 
			$update = array();
			
			//Sanitizing the POST values
			$update['layout_id'] 	= $this->input->get('id');
			$update['name'] 		= $this->input->post('name');
			$update['routes'] 		= $this->input->post('routes');
			
			if ($this->Design_model->updateLayout($update)) {
				$this->session->set_flashdata('alert', '<p class="success">Layout Updated Sucessfully!</p>');
			} else {
				$this->session->set_flashdata('alert', '<p class="warning">Nothing Added!</p>');				
			}
							
			return TRUE;
		}	
	}	

	public function _deleteLayout() {
    	if (!$this->user->hasPermissions('modify', 'admin/layouts')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to delete!</p>');
    	
    	} else { 
			if (is_array($this->input->post('delete'))) {
				foreach ($this->input->post('delete') as $key => $value) {
					$layout_id = $value;
					$this->Design_model->deleteLayout($layout_id);
				}			
			
				$this->session->set_flashdata('alert', '<p class="success">Layout Deleted Sucessfully!</p>');
			}
		}
				
		return TRUE;
	}
	
	public function validateForm() {
		$this->form_validation->set_rules('name', 'Name', 'xss_clean|trim|required|min_length[2]|max_length[128]');

		if ($this->input->post('routes')) {
			foreach ($this->input->post('routes') as $key => $value) {
				$this->form_validation->set_rules('routes['.$key.'][uri_route]', 'Route', 'xss_clean|trim|required');
			}
		}

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}		
	}
}

/* End of file layouts.php */
/* Location: ./application/controllers/admin/layouts.php */