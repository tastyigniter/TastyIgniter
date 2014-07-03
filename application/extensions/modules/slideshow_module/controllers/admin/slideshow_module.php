<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Slideshow_module extends MX_Controller {

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

    	if (!$this->user->hasPermissions('access', ADMIN_URI.'/slideshow_module')) {
  			redirect(ADMIN_URI.'/permission');
		}
			
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');
		} else { 
			$data['alert'] = '';
		}		
				
		$extension = $this->Extensions_model->getExtension('module', 'slideshow_module');
		
		if (!$this->input->get('id') AND !$this->input->get('name') AND $this->input->get('action') !== 'edit') {
			redirect(ADMIN_URI.'/extensions/edit?name=slideshow_module&action=edit&id='.$extension['extension_id']);
		}

		$data['name'] = ucwords(str_replace('_module', '', $extension['name']));

		if (!empty($extension['data'])) {
			$result = unserialize($extension['data']);
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
		
		$this->load->model('Image_tool_model');

		$data['images'] = array();
		if (!empty($result['images'])) {
			foreach ($result['images'] as $key => $value) {
				if (!empty($value)) {
					$data['images'][] = array(
						'name'		=> basename($value),
						'preview'	=> $this->Image_tool_model->resize($value),
						'input'		=> $value
					);
				} else {
					$data['images'][] = array(
						'name'		=> 'no_photo.png',
						'preview'	=> $this->Image_tool_model->resize('data/no_photo.png'),
						'input'		=> 'data/no_photo.png'
					);
				}
			}
		}
	
		$data['no_photo'] = $this->Image_tool_model->resize('data/no_photo.png');
		
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
		
		$data['effects'] = array('sliceDown', 'sliceDownLeft', 'sliceUp', 'sliceUpLeft', 'sliceUpDown', 'sliceUpDownLeft', 'fold', 'fade', 'random', 'slideInRight', 'slideInLeft', 'boxRandom', 'boxRain', 'boxRainReverse', 'boxRainGrow', 'boxRainGrowReverse');
		
		if ($this->input->post() AND $this->_updateModule() === TRUE){
			if ($this->input->post('save_close') === '1') {
				redirect(ADMIN_URI.'/extensions');
			}
			
			redirect(ADMIN_URI.'/extensions/edit?name='.$extension['name'].'&action=edit&id='.$extension['extension_id']);
		}

		if (file_exists(EXTPATH .'modules/slideshow_module/views/admin/slideshow_module.php')) { 								//check if file exists in views folder
			$this->load->view('slideshow_module/admin/slideshow_module', $data);
		} else {
			show_404(); 																		// Whoops, show 404 error page!
		}
	}

	public function _updateModule() {
    	if (!$this->user->hasPermissions('modify', ADMIN_URI.'/slideshow_module')) {
			$this->session->set_flashdata('alert', '<p class="alert-warning">Warning: You do not have permission to update!</p>');
			return TRUE;
    	} else if ($this->validateForm() === TRUE) { 
			$update = array();
		
			$update['type'] 				= 'module';
			$update['name'] 				= $this->input->get('name');
			$update['extension_id'] 		= (int) $this->input->get('id');
			$update['data']['dimension_h'] 	= $this->input->post('dimension_h');
			$update['data']['dimension_w']	= $this->input->post('dimension_w');
			$update['data']['effect'] 		= ($this->input->post('effect')) ? $this->input->post('effect') : 'random';
			$update['data']['speed'] 		= ($this->input->post('speed')) ? $this->input->post('speed') : '500';
			$update['data']['layouts'] 		= $this->input->post('layouts');
			$update['data']['images'] 		= $this->input->post('images');

			if ($this->Extensions_model->updateExtension($update, '1')) {
				$this->session->set_flashdata('alert', '<p class="alert-success">Slideshow Module updated sucessfully.</p>');
			} else {
				$this->session->set_flashdata('alert', '<p class="alert-warning">An error occured, nothing updated.</p>');				
			}
	
			return TRUE;
		}
	}

 	public function validateForm() {
		$this->form_validation->set_rules('name', 'Name', 'xss_clean|trim|required|min_length[2]|max_length[32]');
		$this->form_validation->set_rules('dimension_h', 'Dimension Height', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('dimension_w', 'Dimension Width', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('effect', 'Effects', 'xss_clean|trim|required');
		$this->form_validation->set_rules('speed', 'Transition Speed', 'xss_clean|trim|integer');

		foreach ($this->input->post('images') as $key => $value) {
			$this->form_validation->set_rules('images['.$key.']', 'Images', 'xss_clean|trim|required');
		}
		
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

/* End of file slideshow_module.php */
/* Location: ./application/extensions/modules/slideshow_module/controllers/admin/slideshow_module.php */