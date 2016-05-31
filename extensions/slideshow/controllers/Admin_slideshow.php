<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Admin_slideshow extends Admin_Controller {

	public function index($module = array()) {
		$this->lang->load('slideshow/slideshow');

		$this->user->restrict('Module.Slideshow');

        if (empty($module)) return;

		$title = (isset($module['title'])) ? $module['title'] : $this->lang->line('_text_title');

		$this->template->setTitle('Module: ' . $title);
		$this->template->setHeading('Module: ' . $title);
		$this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
        $this->template->setButton($this->lang->line('button_save_close'), array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
        $this->template->setButton($this->lang->line('button_icon_back'), array('class' => 'btn btn-default', 'href' => site_url('extensions')));

        $data['effects'] 	= array('sliceDown', 'sliceDownLeft', 'sliceUp', 'sliceUpLeft', 'sliceUpDown', 'sliceUpDownLeft', 'fold', 'fade', 'random', 'slideInRight', 'slideInLeft', 'boxRandom', 'boxRain', 'boxRainReverse', 'boxRainGrow', 'boxRainGrowReverse');

        $ext_data = array();
        if (!empty($module['ext_data']) AND is_array($module['ext_data'])) {
            $ext_data = $module['ext_data'];
        }

		if ($this->input->post('display')) {
			$data['display'] = $this->input->post('display');
		} else if (isset($ext_data['display'])) {
			$data['display'] = $ext_data['display'];
		} else {
			$data['display'] = '1';
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
				$image_src = (isset($slide['image_src'])) ? $slide['image_src'] : 'data/no_photo.png';
				$caption = (isset($slide['caption'])) ? $slide['caption'] : '';

				$data['slides'][] = array(
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

			redirect('extensions/edit/module/slideshow');
		}

        return $this->load->view('slideshow/admin_slideshow', $data, TRUE);
	}

	private function _updateModule() {
    	if ($this->validateForm() === TRUE) {

		    if ($this->Extensions_model->updateExtension('module', 'slideshow', $this->input->post())) {
			    $this->alert->set('success', sprintf($this->lang->line('alert_success'), $this->lang->line('_text_title') . ' module ' . $this->lang->line('text_updated')));
		    } else {
			    $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $this->lang->line('text_updated')));
		    }

			return TRUE;
		}
	}

 	private function validateForm() {
		$this->form_validation->set_rules('dimension_h', 'lang:label_dimension_h', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('dimension_w', 'lang:label_dimension_w', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('effect', 'lang:label_effect', 'xss_clean|trim|required');
		$this->form_validation->set_rules('speed', 'lang:label_speed', 'xss_clean|trim|integer');
	    $this->form_validation->set_rules('display', 'lang:label_display', 'xss_clean|trim|required|integer');

	    if ($this->input->post('slides')) {
		    foreach ($this->input->post('slides') as $key => $value) {
			    $this->form_validation->set_rules('slides[' . $key . '][image_src]', 'lang:label_slide_image', 'xss_clean|trim|required');
			    $this->form_validation->set_rules('slides[' . $key . '][caption]', 'lang:label_slide_caption');
		    }
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