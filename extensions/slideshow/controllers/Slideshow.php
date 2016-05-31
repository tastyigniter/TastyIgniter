<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Slideshow extends Main_Controller {

	public function index($module = array()) {
		if ( ! file_exists(EXTPATH .'slideshow/views/slideshow.php')) { 			//check if file exists in views folder
			show_404(); 																		// Whoops, show 404 error page!
		}

		$result = (!empty($module['data']) AND is_array($module['data'])) ? $module['data'] : array();

		$this->template->setStyleTag(extension_url('slideshow/views/assets/flexslider/flexslider.css'), 'flexslider-css', '155000');
		$this->template->setStyleTag(extension_url('slideshow/views/css/stylesheet.css'), 'slideshow-css', '155600');
		$this->template->setScriptTag(extension_url('slideshow/views/assets/flexslider/jquery.flexslider.js'), 'flexslider-js', '155000');

		$data['dimension_h'] 		= (isset($result['dimension_h'])) ? $result['dimension_h'] : '360';
		$data['dimension_w'] 		= (isset($result['dimension_w'])) ? $result['dimension_w'] : '960';
		$data['effect'] 			= (isset($result['effect'])) ? $result['effect'] : 'ease';
		$data['speed'] 				= (isset($result['speed'])) ? $result['speed'] : '500';
		$data['display_slides'] 	= (isset($result['display'])) ? $result['display'] : '1';

		$this->load->model('Image_tool_model');

		$data['slides'] = array();
		if (!empty($result['slides'])) {
			foreach ($result['slides'] as $slide) {

				$image_src = (isset($slide['image_src'])) ? $slide['image_src'] : 'data/no_photo.png';
				$caption = (isset($slide['caption'])) ? $slide['caption'] : '';

				$data['slides'][] = array(
					'image_src' => $this->Image_tool_model->resize($image_src, $data['dimension_w'], $data['dimension_h']),
					'caption'	=> $caption
				);
			}
		}

		// pass array $data and load view files
		return $this->load->view('slideshow/slideshow', $data, TRUE);
	}
}

/* End of file slideshow.php */
/* Location: ./extensions/slideshow/controllers/slideshow.php */