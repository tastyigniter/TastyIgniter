<?php if (!defined('BASEPATH')) exit('No direct access allowed');

class Slideshow extends Base_Component
{

	public function index() {
		$this->assets->setStyleTag(extension_url('slideshow/assets/flexslider/flexslider.css'), 'flexslider-css', '155000');
		$this->assets->setStyleTag(extension_url('slideshow/assets/css/stylesheet.css'), 'slideshow-css', '155600');
		$this->assets->setScriptTag(extension_url('slideshow/assets/flexslider/jquery.flexslider.js'), 'flexslider-js', '155000');

		$data['dimension_h'] = $this->setting('dimension_h', '360');
		$data['dimension_w'] = $this->setting('dimension_w', '960');
		$data['effect'] = $this->setting('effect', 'ease');
		$data['speed'] = $this->setting('speed', '500');
		$data['display_slides'] = $this->setting('display', '1');

		$this->load->model('Image_tool_model');

		$data['slides'] = array();
		if ($slides = $this->setting('slides')) {
			foreach ($slides as $slide) {

				$image_src = (isset($slide['image_src'])) ? $slide['image_src'] : 'data/no_photo.png';
				$caption = (isset($slide['caption'])) ? $slide['caption'] : '';

				$data['slides'][] = array(
					'image_src' => $this->Image_tool_model->resize($image_src, $data['dimension_w'], $data['dimension_h']),
					'caption'   => $caption,
				);
			}
		}

		// pass array $data and load view files
		return $this->load->view('slideshow/slideshow', $data, TRUE);
	}
}

/* End of file Slideshow.php */
/* Location: ./extensions/slideshow/components/Slideshow.php */