<?php
class Uri_routes extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('user');
		$this->load->model('Design_model');	    
	}

	public function index() {
			
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/uri_routes')) {
  			redirect('admin/permission');
		}
			
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');
		} else { 
			$data['alert'] = '';
		}		
				
		$data['heading'] 		= 'URI Routes';
		$data['button_save'] 	= 'Save';

		if ($this->input->post('routes')) {
			$routes = $this->input->post('routes');
		} else {
			$routes = $this->Design_model->getRoutes();
		}
		
		$data['routes'] = array();
		foreach ($routes as $route) {
	
			$data['routes'][] = array(
				'uri_route'		=> $route['uri_route'],
				'controller' 	=> $route['controller'],
			);
		}

		if ($this->input->post() && $this->_updateRoute() === TRUE){
			redirect('admin/uri_routes');
		}
		
		$regions = array('header', 'footer');
		if (file_exists(APPPATH .'views/themes/admin/'.$this->config->item('admin_theme').'uri_routes.php')) {
			$this->template->render('themes/admin/'.$this->config->item('admin_theme'), 'uri_routes', $regions, $data);
		} else {
			$this->template->render('themes/admin/default/', 'uri_routes', $regions, $data);
		}
	}

	public function _updateRoute() {
    	if (!$this->user->hasPermissions('modify', 'admin/uri_routes')) {
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to update!</p>');
			return TRUE;
    	} else if ($this->input->post('routes') AND $this->validateForm() === TRUE) { 
			$update = array();
		
			$update = $this->input->post('routes');

			if ($this->Design_model->updateRoutes($update)) {
				$this->session->set_flashdata('alert', '<p class="success">URI Routes Updated Sucessfully!</p>');
			} else {
				$this->session->set_flashdata('alert', '<p class="warning">Nothing Updated!</p>');				
			}
	
			return TRUE;
		}
	}

	public function validateForm() {
		if ($this->input->post('routes')) {
			foreach ($this->input->post('routes') as $key => $value) {
				$this->form_validation->set_rules('routes['.$key.'][uri_route]', 'URI Route', 'xss_clean|trim|required');
				$this->form_validation->set_rules('routes['.$key.'][controller]', 'Controller', 'xss_clean|trim|required');
			}
		}

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

/* End of file uri_routes.php */
/* Location: ./application/controllers/admin/uri_routes.php */