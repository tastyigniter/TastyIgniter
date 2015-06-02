<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Admin_slideshow extends Admin_Controller {

	public function index($data = array()) {
        $this->user->restrict('Module.Slideshow');

        if (empty($data)) return;

        $data['title'] = (isset($data['title'])) ? $data['title'] : 'Slideshow Module';

        $this->template->setTitle('Module: ' . $data['title']);
        $this->template->setHeading('Module: ' . $data['title']);
        $this->template->setButton('Save', array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
        $this->template->setButton('Save & Close', array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
        $this->template->setBackButton('btn btn-back', site_url('extensions'));

        $this->template->setStyleTag(root_url('assets/js/fancybox/jquery.fancybox.css'), 'jquery-fancybox-css');
        $this->template->setScriptTag(root_url("assets/js/fancybox/jquery.fancybox.js"), 'jquery-fancybox-js');

        $data['effects'] 	= array('sliceDown', 'sliceDownLeft', 'sliceUp', 'sliceUpLeft', 'sliceUpDown', 'sliceUpDownLeft', 'fold', 'fade', 'random', 'slideInRight', 'slideInLeft', 'boxRandom', 'boxRain', 'boxRainReverse', 'boxRainGrow', 'boxRainGrowReverse');

        $ext_data = array();
        if (!empty($data['ext_data']) AND is_array($data['ext_data'])) {
            $ext_data = $data['ext_data'];
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

		if ($this->input->post() AND $this->_updateModule() === TRUE) {
			if ($this->input->post('save_close') === '1') {
				redirect('extensions');
			}

			redirect('extensions/edit?action=edit&name=slideshow');
		}

        return $this->load->view('slideshow/admin_slideshow', $data, TRUE);
	}

	private function _updateModule() {
    	if ($this->validateForm() === TRUE) {
			$update = array();

			$update['type'] 				= 'module';
			$update['name'] 				= $this->input->get('name');
			$update['title'] 				= $this->input->post('title');
			$update['extension_id'] 		= (int) $this->input->get('extension_id');
			$update['data']['dimension_h'] 	= $this->input->post('dimension_h');
			$update['data']['dimension_w']	= $this->input->post('dimension_w');
			$update['data']['effect'] 		= ($this->input->post('effect')) ? $this->input->post('effect') : 'random';
			$update['data']['speed'] 		= ($this->input->post('speed')) ? $this->input->post('speed') : '500';
			$update['data']['slides'] 		= $this->input->post('slides');

			if ($this->Extensions_model->updateExtension($update, '1')) {
				$this->alert->set('success', 'Slideshow Module updated successfully.');
			} else {
				$this->alert->set('warning', 'An error occurred, nothing updated.');
			}

			return TRUE;
		}
	}

 	private function validateForm() {
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

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

/* End of file slideshow.php */
/* Location: ./extensions/slideshow/controllers/slideshow.php */