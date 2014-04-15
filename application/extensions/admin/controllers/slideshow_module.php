<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Slideshow_module extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('user');
		$this->load->model('Extensions_model');	    
		$this->load->model('Design_model');	    
	}

	public function index() {
			
		if (!file_exists(EXTPATH .'admin/views/slideshow_module.php')) {
			show_404();
		}
			
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/slideshow_module')) {
  			redirect('admin/permission');
		}
			
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');
		} else { 
			$data['alert'] = '';
		}		
				
		$extension = $this->Extensions_model->getExtension('module', 'slideshow');

		$data['heading'] 			= 'Slideshow';
		$data['sub_menu_save'] 		= 'Save';
		$data['sub_menu_back'] 		= $this->config->site_url('admin/extensions');
		$data['name'] 				= $extension['name'];

		if ($this->config->item('slideshow_module')) {
			$result = $this->config->item('slideshow_module');
		} else {
			$result = array();
		}

		if (isset($result['dimension_h'])) {
			$data['dimension_h'] = $result['dimension_h'];
		} else {
			$data['dimension_h'] = '360';
		}
		
		if (isset($result['dimension_w'])) {
			$data['dimension_w'] = $result['dimension_w'];
		} else {
			$data['dimension_w'] = '960';
		}

		if (isset($result['effect'])) {
			$data['effect'] = $result['effect'];
		} else {
			$data['effect'] = 'ease';
		}

		if (isset($result['speed'])) {
			$data['speed'] = $result['speed'];
		} else {
			$data['speed'] = '500';
		}

		if ($this->input->post('images')) {
			$result['images'] = $this->input->post('images');
		}
		
		$data['images'] = array();
		if (!empty($result['images'])) {
			foreach ($result['images'] as $key => $value) {
				if (!empty($value)) {
					$this->load->model('Image_tool_model');
					$data['images'][] = array(
						'name'		=> basename($value),
						'preview'	=> $this->Image_tool_model->resize($value, 120, 120),
						'input'		=> $value
					);
				} else {
					$data['images'][] = array(
						'name'		=> 'no_photo.png',
						'preview'	=> $this->Image_tool_model->resize('data/no_photo.png', 120, 120),
						'input'		=> 'data/no_photo.png'
					);
				}
			}
		}
	
		$data['no_photo'] = $this->Image_tool_model->resize('data/no_photo.png', 120, 120);
		
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
		
		$data['effects'] = array('sliceDown', 'sliceDownLeft', 'sliceUp', 'sliceUpLeft', 'sliceUpDown', 'sliceUpDownLeft', 'fold', 'fade', 'random', 'slideInRight', 'slideInLeft', 'boxRandom', 'boxRain', 'boxRainReverse', 'boxRainGrow', 'boxRainGrowReverse');
		
		if ($this->input->post() && $this->_updateModule() === TRUE){
			redirect('admin/extensions');
		}
		
		$regions = array(
			'admin/header',
			'admin/footer'
		);
		
		$this->template->regions($regions);
		$this->template->load('admin/slideshow_module', $data);
	}

	public function _updateModule() {
						
    	if (!$this->user->hasPermissions('modify', 'admin/slideshow_module')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
			return TRUE;
    	
    	} else if ($this->validateForm() === TRUE) { 
			$update = array();
		
			$update['slideshow_module']['dimension_h'] 	= $this->input->post('dimension_h');
			$update['slideshow_module']['dimension_w']	= $this->input->post('dimension_w');
			$update['slideshow_module']['effect'] 		= ($this->input->post('effect')) ? $this->input->post('effect') : 'random';
			$update['slideshow_module']['speed'] 		= ($this->input->post('speed')) ? $this->input->post('speed') : '500';
			$update['slideshow_module']['modules'] 		= $this->input->post('modules');
			$update['slideshow_module']['images'] 		= $this->input->post('images');

			if ($this->Settings_model->updateSettings('slideshow', $update)) {
				$this->session->set_flashdata('alert', '<p class="success">Slideshow Module Updated Sucessfully!</p>');
			} else {
				$this->session->set_flashdata('alert', '<p class="warning">Nothing Updated!</p>');				
			}
	
			return TRUE;
		}
	}

 	public function validateForm() {
		$this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[2]|max_length[45]');
		$this->form_validation->set_rules('dimension_h', 'Dimension Height', 'trim|required|integer');
		$this->form_validation->set_rules('dimension_w', 'Dimension Width', 'trim|required|integer');
		$this->form_validation->set_rules('effect', 'Effects', 'trim|required');
		$this->form_validation->set_rules('speed', 'Transition Speed', 'trim|integer');

		foreach ($this->input->post('images') as $key => $value) {
			$this->form_validation->set_rules('images['.$key.']', 'Images', 'trim|required');
		}
		
		foreach ($this->input->post('modules') as $key => $value) {
			$this->form_validation->set_rules('modules['.$key.'][layout_id]', 'Layout', 'trim|required');
			$this->form_validation->set_rules('modules['.$key.'][position]', 'Position', 'trim|required');
			$this->form_validation->set_rules('modules['.$key.'][priority]', 'Priority', 'trim|integer');
			$this->form_validation->set_rules('modules['.$key.'][status]', 'Status', 'trim|required|integer');
		}
		
		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}