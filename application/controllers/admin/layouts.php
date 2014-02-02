<?php
class Layouts extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('user');
		$this->load->model('Design_model');
		$this->load->model('Settings_model');
	}

	public function index() {
			
		//check if file exists in views
		if ( !file_exists(APPPATH .'/views/admin/layouts.php')) {
			// Whoops, we don't have a page for that!
			show_404();
		}

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
		$data['sub_menu_add'] 		= 'Add';
		$data['sub_menu_delete'] 	= 'Delete';
		$data['sub_menu_list'] 		= '<li><a id="menu-add">Add new layout</a></li>';
		$data['text_no_layouts'] 	= 'There are no layout(s).';

		$data['layouts'] = array();
		$results = $this->Design_model->getLayouts();
		foreach ($results as $result) {					
			$data['layouts'][] = array(
				'layout_id'		=> $result['layout_id'],
				'name'			=> $result['name'],
				'edit' 			=> $this->config->site_url('admin/layouts/edit/' . $result['layout_id'])
			);
		}
		
		$data['uri_routes'] = array();
		$results = $this->Design_model->getRoutes(1);
		foreach ($results as $result) {					
			$data['uri_routes'][] = array(
				'uri_route_id'		=> $result['uri_route_id'],
				'route'				=> $result['route']
			);
		}
	
		if ($this->input->post() && $this->_addLayout() === TRUE) {
		
			redirect('/admin/layouts');
		}

		if ($this->input->post('delete') && $this->_deleteLayout() === TRUE) {
			
			redirect('admin/layouts');  			
		}	

		//load home page content
		$this->load->view('admin/header', $data);
		$this->load->view('admin/layouts', $data);
		$this->load->view('admin/footer');
	}
	
	public function edit() {
		
		if ( !file_exists(APPPATH .'/views/admin/layouts_edit.php')) { //check if file exists in views folder
			show_404(); // Whoops, show 404 error page!
		}
		
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

		if (is_numeric($this->uri->segment(4))) {
			$layout_id = (int)$this->uri->segment(4);
		} else {
		    redirect('admin/layouts');
		}
		
		$result = $this->Design_model->getLayout($layout_id);
		
		if ($result) {
			$data['heading'] 			= 'Layouts';
			$data['sub_menu_update'] 	= 'Update';
			$data['sub_menu_back'] 		= $this->config->site_url('admin/layouts');

			$data['layout_id'] 			= $result['layout_id'];
			$data['name'] 				= $result['name'];
			$data['routes'] 			= $this->Design_model->getLayoutRoutes($result['layout_id']);

			$data['uri_routes'] = array();
			$results = $this->Design_model->getRoutes(1);
			foreach ($results as $result) {					
				$data['uri_routes'][] = array(
					'uri_route_id'		=> $result['uri_route_id'],
					'route'				=> $result['route']
				);
			}
		
			if ($this->input->post() && $this->_updateLayout($layout_id) === TRUE) {
						
				redirect('admin/layouts');
			}
		}
		
		$this->load->view('admin/header', $data);
		$this->load->view('admin/layouts_edit', $data);
		$this->load->view('admin/footer');
	}

	public function _addLayout() {
    	if ( ! $this->user->hasPermissions('modify', 'admin/layouts')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
  			return TRUE;
  	
    	} else if ( ! $this->input->get('delete')) { 
    	
 			$this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[2]|max_length[45]');

			if ($this->input->post('routes')) {
			foreach ($this->input->post('routes') as $key => $value) {
				$this->form_validation->set_rules('routes['.$key.'][uri_route_id]', 'Route', 'trim|integer');
			}
			}

			if ($this->form_validation->run() === TRUE) {
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
	}
	
	public function _updateLayout($layout_id) {
    	if ( ! $this->user->hasPermissions('modify', 'admin/layouts')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
  			return TRUE;
  	
    	} else { 

  			$this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[2]|max_length[45]');

			if ($this->input->post('routes')) {
			foreach ($this->input->post('routes') as $key => $value) {
				$this->form_validation->set_rules('routes['.$key.'][uri_route_id]', 'Route', 'trim|integer');
			}
			}

			if ($this->form_validation->run() === TRUE) {
				$update = array();
				
				//Sanitizing the POST values
				$update['layout_id'] 	= $layout_id;
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
	}	

	public function _deleteLayout() {
    	if (!$this->user->hasPermissions('modify', 'admin/layouts')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
    	
    	} else { 
		
			if (is_array($this->input->post('delete'))) {

				//sorting the post[quantity] array to rowid and qty.
				foreach ($this->input->post('delete') as $key => $value) {
					$layout_id = $value;
				
					$this->Design_model->deleteLayout($layout_id);
			
				}			
			
				$this->session->set_flashdata('alert', '<p class="success">Layout Deleted Sucessfully!</p>');

			}
		}
				
		return TRUE;
	}
}