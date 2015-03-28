<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Admin_options extends Extension {

	public function options($options = array()) {
		$this->load->library('user');
		$this->load->model('Extensions_model');
		$this->load->model('Design_model');

		if (!$this->user->islogged()) {
  			redirect('login');
		}

    	if (!$this->user->hasPermissions('access', 'slideshow')) {
  			redirect('permission');
		}

		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');
		} else {
			$data['alert'] = '';
		}

		extract($options);

		$ext_name 			= strtolower($name);
		$data['title'] 		= $title;
		$data['effects'] 	= array('sliceDown', 'sliceDownLeft', 'sliceUp', 'sliceUpLeft', 'sliceUpDown', 'sliceUpDownLeft', 'fold', 'fade', 'random', 'slideInRight', 'slideInLeft', 'boxRandom', 'boxRain', 'boxRainReverse', 'boxRainGrow', 'boxRainGrowReverse');

		if (empty($ext_data) OR !is_array($ext_data)) {
			$ext_data = array();
		}

		if (isset($ext_data['dimension_h'])) {
			$data['dimension_h'] = $ext_data['dimension_h'];
		} else {
			$data['dimension_h'] = '360';
		}

		if (isset($ext_data['dimension_w'])) {
			$data['dimension_w'] = $ext_data['dimension_w'];
		} else {
			$data['dimension_w'] = '960';
		}

		if (isset($ext_data['effect'])) {
			$data['effect'] = $ext_data['effect'];
		} else {
			$data['effect'] = 'ease';
		}

		if (isset($ext_data['speed'])) {
			$data['speed'] = $ext_data['speed'];
		} else {
			$data['speed'] = '500';
		}

		if ($this->input->post('slides')) {
			$ext_data['slides'] = $this->input->post('slides');
		}

		$this->load->model('Image_tool_model');

		$data['slides'] = array();
		if (!empty($ext_data['slides'])) {
			foreach ($ext_data['slides'] as $slide) {
				$slide_name = (isset($slide['name'])) ? $slide['name'] : 'no_photo.png';
				$image_src = (isset($slide['image_src'])) ? $slide['image_src'] : 'data/no_photo.png';
				$caption = (isset($slide['caption'])) ? $slide['caption'] : '';

				$data['slides'][] = array(
					'name'		=> $slide_name,
					'preview'	=> $this->Image_tool_model->resize($image_src),
					'image_src'	=> $image_src,
					'caption'	=> $caption
				);
			}
		}

		$data['no_photo'] = $this->Image_tool_model->resize('data/no_photo.png');

		if ($this->input->post('layouts')) {
			$ext_data['layouts'] = $this->input->post('layouts');
		}

		$data['modules'] = array();
		if (!empty($ext_data['layouts'])) {
			foreach ($ext_data['layouts'] as $module) {

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

		$_GET['extension_id'] = $extension_id;
		if ($this->input->post() AND $this->_updateModule() === TRUE) {
			if ($this->input->post('save_close') === '1') {
				redirect('extensions');
			}

			redirect('extensions/edit?action=edit&name='.$ext_name);
		}

		$this->render($data);
	}

	public function _updateModule() {
    	if (!$this->user->hasPermissions('modify', 'slideshow')) {
			$this->alert->set('warning', 'Warning: You do not have permission to update!');
			return TRUE;
    	} else if ($this->validateForm() === TRUE) {
			$update = array();

			$update['type'] 				= 'module';
			$update['name'] 				= $this->input->get('name');
			$update['title'] 				= $this->input->post('title');
			$update['extension_id'] 		= (int) $this->input->get('extension_id');
			$update['data']['dimension_h'] 	= $this->input->post('dimension_h');
			$update['data']['dimension_w']	= $this->input->post('dimension_w');
			$update['data']['effect'] 		= ($this->input->post('effect')) ? $this->input->post('effect') : 'random';
			$update['data']['speed'] 		= ($this->input->post('speed')) ? $this->input->post('speed') : '500';
			$update['data']['layouts'] 		= $this->input->post('layouts');
			$update['data']['slides'] 		= $this->input->post('slides');

			if ($this->Extensions_model->updateExtension($update, '1')) {
				$this->alert->set('success', 'Slideshow Module updated sucessfully.');
			} else {
				$this->alert->set('warning', 'An error occured, nothing updated.');
			}

			return TRUE;
		}
	}

 	public function validateForm() {
		$this->form_validation->set_rules('title', 'Title', 'xss_clean|trim|required|min_length[2]|max_length[128]');
		$this->form_validation->set_rules('dimension_h', 'Dimension Height', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('dimension_w', 'Dimension Width', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('effect', 'Effects', 'xss_clean|trim|required');
		$this->form_validation->set_rules('speed', 'Transition Speed', 'xss_clean|trim|integer');

		foreach ($this->input->post('slides') as $key => $value) {
			$this->form_validation->set_rules('slides['.$key.'][name]', 'Slide Name', 'xss_clean|trim|required');
			$this->form_validation->set_rules('slides['.$key.'][image_src]', 'Slide', 'xss_clean|trim|required');
			$this->form_validation->set_rules('slides['.$key.'][caption]', 'Caption');
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

/* End of file slideshow.php */
/* Location: ./extensions/slideshow/controllers/slideshow.php */