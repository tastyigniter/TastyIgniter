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

		$this->template->setTitle('Layouts');
		$this->template->setHeading('Layouts');
		$this->template->setButton('+ New', array('class' => 'add_button', 'href' => page_url() .'/edit'));
		$this->template->setButton('Delete', array('class' => 'delete_button', 'onclick' => '$(\'form:not(#filter-form)\').submit();'));

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
	
		if ($this->input->post('delete') AND $this->_deleteLayout() === TRUE) {
			
			redirect('admin/layouts');  			
		}	

		$this->template->regions(array('header', 'footer'));
		if (file_exists(APPPATH .'views/themes/admin/'.$this->config->item('admin_theme').'layouts.php')) {
			$this->template->render('themes/admin/'.$this->config->item('admin_theme'), 'layouts', $data);
		} else {
			$this->template->render('themes/admin/default/', 'layouts', $data);
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
			$layout_id = $this->input->get('id');
			$data['action']	= site_url('admin/layouts/edit?id='. $layout_id);
		} else {
		    $layout_id = 0;
			$data['action']	= site_url('admin/layouts/edit');
		}
		
		$result = $this->Design_model->getLayout($layout_id);
		
		$title = (isset($result['name'])) ? 'Edit - '. $result['name'] : 'New';	
		$this->template->setTitle('Layout: '. $title);
		$this->template->setHeading('Layout: '. $title);
		$this->template->setButton('Save', array('class' => 'save_button', 'onclick' => '$(\'form\').submit();'));
		$this->template->setButton('Save & Close', array('class' => 'save_close_button', 'onclick' => 'saveClose();'));
		$this->template->setBackButton('back_button', site_url('admin/layouts'));

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
	
		if ($this->input->post() AND $this->_addLayout() === TRUE) {
			if ($this->input->post('save_close') !== '1' AND is_numeric($this->input->post('insert_id'))) {	
				redirect('admin/layouts/edit?id='. $this->input->post('insert_id'));
			} else {
				redirect('admin/layouts');
			}
		}

		if ($this->input->post() AND $this->_updateLayout() === TRUE) {
			if ($this->input->post('save_close') === '1') {
				redirect('admin/layouts');
			}
			
			redirect('admin/layouts/edit?id='. $layout_id);
		}
		
		$this->template->regions(array('header', 'footer'));
		if (file_exists(APPPATH .'views/themes/admin/'.$this->config->item('admin_theme').'layouts_edit.php')) {
			$this->template->render('themes/admin/'.$this->config->item('admin_theme'), 'layouts_edit', $data);
		} else {
			$this->template->render('themes/admin/default/', 'layouts_edit', $data);
		}
	}

	public function _addLayout() {
    	if ( ! $this->user->hasPermissions('modify', 'admin/layouts')) {
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to add!</p>');
  			return TRUE;
    	} else if ( ! is_numeric($this->input->get('id')) AND $this->validateForm() === TRUE) { 
			$add = array();
			
			$add['name'] 		= $this->input->post('name');
			$add['routes'] 		= $this->input->post('routes');
			
			if ($_POST['insert_id'] = $this->Design_model->addLayout($add)) {
				$this->session->set_flashdata('alert', '<p class="success">Layout added sucessfully.</p>');
			} else {
				$this->session->set_flashdata('alert', '<p class="warning">An error occured, nothing added.</p>');				
			}
							
			return TRUE;
		}	
	}
	
	public function _updateLayout() {
    	if ( ! $this->user->hasPermissions('modify', 'admin/layouts')) {
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to update!</p>');
  			return TRUE;
    	} else if (is_numeric($this->input->get('id')) AND $this->validateForm() === TRUE) { 
			$update = array();
			
			$update['layout_id'] 	= $this->input->get('id');
			$update['name'] 		= $this->input->post('name');
			$update['routes'] 		= $this->input->post('routes');
			
			if ($this->Design_model->updateLayout($update)) {
				$this->session->set_flashdata('alert', '<p class="success">Layout updated sucessfully.</p>');
			} else {
				$this->session->set_flashdata('alert', '<p class="warning">An error occured, nothing added.</p>');				
			}
							
			return TRUE;
		}	
	}	

	public function _deleteLayout() {
    	if (!$this->user->hasPermissions('modify', 'admin/layouts')) {
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to delete!</p>');
    	} else if (is_array($this->input->post('delete'))) {
			foreach ($this->input->post('delete') as $key => $value) {
				$this->Design_model->deleteLayout($value);
			}			
		
			$this->session->set_flashdata('alert', '<p class="success">Layout deleted sucessfully!</p>');
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