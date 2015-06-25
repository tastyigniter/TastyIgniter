<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Slideshow extends Main_Controller {

	public function index($ext_data = array()) {
		if ( ! file_exists(EXTPATH .'slideshow/views/slideshow.php')) { 			//check if file exists in views folder
			show_404(); 																		// Whoops, show 404 error page!
		}

		if (!empty($ext_data)) {
			$result = $ext_data;
		} else {
			$result = array();
		}

		$data['dimension_h'] 		= (isset($result['dimension_h'])) ? $result['dimension_h'] : '360';
		$data['dimension_w'] 		= (isset($result['dimension_w'])) ? $result['dimension_w'] : '960';
		$data['effect'] 			= (isset($result['effect'])) ? $result['effect'] : 'ease';
		$data['speed'] 				= (isset($result['speed'])) ? $result['speed'] : '500';

		$data['slides'] = array();
		if (!empty($result['slides'])) {
			foreach ($result['slides'] as $slide) {

				$slide_name = (isset($slide['name'])) ? $slide['name'] : 'no_photo.png';
				$image_src = (isset($slide['image_src'])) ? $slide['image_src'] : 'data/no_photo.png';
				$caption = (isset($slide['caption'])) ? $slide['caption'] : '';

				$this->load->model('Image_tool_model');
				$data['slides'][] = array(
					'name'		=> $slide_name,
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