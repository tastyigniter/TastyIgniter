<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Banners extends Ext_Controller {

	public function __construct() {
		parent::__construct(); 																	// calls the constructor
		$this->load->model('Design_model'); 													// load the menus model
		$this->lang->load('banners/banners');
	}

	public function index($setting) {
		if ( ! file_exists(EXTPATH .'banners/views/banners.php')) { 				//check if file exists in views folder
			show_404(); 																		// Whoops, show 404 error page!
		}

		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  								// retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		$banner_info = $this->Design_model->getBanner($setting['banner_id']); 										// retrieve all menu categories from getCategories method in Menus model

		// START of retrieving lines from language file to pass to view.
		$data['text_heading'] 			= (isset($banner_info['name'])) ? $banner_info['name'] : $this->lang->line('text_heading');
		// END of retrieving lines from language file to send to view.

		$data['banner_id'] 			= $banner_info['banner_id'];
		$data['name'] 				= $banner_info['name'];
		$data['type'] 				= $banner_info['type'];
		$data['click_url'] 			= $banner_info['click_url'];
		$data['language_id'] 		= $banner_info['language_id'];
		$data['alt_text'] 			= $banner_info['alt_text'];
		$data['custom_code'] 		= $banner_info['custom_code'];
		$data['status'] 			= $banner_info['status'];
		$data['no_photo'] 			= $this->Image_tool_model->resize('data/no_photo.png');

		$data['image_height'] = $data['image_width'] = $data['carousel_height'] = $data['carousel_width'] = '';
		$data['image'] = array('name' => 'no_photo.png', 'path' => 'data/no_photo.png', 'url' => $data['no_photo']);
		if (!empty($banner_info['image_code']) AND $banner_info['type'] === 'image') {
			$image = unserialize($banner_info['image_code']);
			if (!empty($image['path'])) {
				$name = basename($image['path']);
				$data['image'] = array(
					'name'		=> $name,
					'url'		=> $this->Image_tool_model->resize($image['path'], $image['height'], $image['width'])
				);
			}

			$data['image_height'] 	= $image['height'];
			$data['image_width'] 	= $image['width'];
		}

		$data['carousels'] = array();
		if (!empty($banner_info['image_code']) AND $banner_info['type'] === 'carousel') {
			$carousels = unserialize($banner_info['image_code']);
			if (!empty($carousels['paths']) AND is_array($carousels['paths'])) {
				foreach ($carousels['paths'] as $path) {
					$name = basename($path);
					$this->load->model('Image_tool_model');
					$data['carousels'][] = array(
						'name'		=> $name,
						'url'		=> $this->Image_tool_model->resize($path, $carousels['height'], $carousels['width'])
					);
				}
			}

			$data['carousel_height'] 	= $carousels['height'];
			$data['carousel_width'] 	= $carousels['width'];
		}

		$data['types'] = array(
			'image'		=> 'Image',
			'carousel'	=> 'Carousel',
			'custom'	=> 'Custom'
		);

		// pass array $data and load view files
		$this->load->view('banners/banners', $data);
	}
}

/* End of file banners.php */
/* Location: ./extensions/banners/controllers/banners.php */