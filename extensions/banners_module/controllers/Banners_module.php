<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Banners_module extends Main_Controller {

	public function __construct() {
		parent::__construct(); 																	// calls the constructor
		$this->load->model('Layouts_model'); 													// load the menus model
		$this->load->model('Banners_model'); 													// load the menus model
		$this->load->model('Image_tool_model'); 													// load the menus model
		$this->lang->load('banners_module/banners_module');
	}

	public function index($data = array()) {
		if ( ! file_exists(EXTPATH .'banners_module/views/banners_module.php')) { 				//check if file exists in views folder
			show_404(); 																		// Whoops, show 404 error page!
		}

        isset($data['banners'][1]) OR $data['banners'][1] = array();

        $banner_id = (!empty($data['banners'][1]['banner_id'])) ? $data['banners'][1]['banner_id'] : 0 ;
        $image_width = (!empty($data['banners'][1]['width'])) ? $data['banners'][1]['width'] : 250 ;
        $image_height = (!empty($data['banners'][1]['height'])) ? $data['banners'][1]['height'] : 250 ;

        $banner_info = $this->Banners_model->getBanner($banner_id);

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
        $data['type']               = (isset($banner_info['type'])) ? $banner_info['type'] : '' ;

        $data['image_height'] = $data['image_width'] = $data['carousel_height'] = $data['carousel_width'] = '';

        $data['images'] = array();
        if (!empty($banner_info['image_code'])) {
            $image = unserialize($banner_info['image_code']);

            $image_paths = array();
            if (!empty($image['path'])) {
                $image_paths = array($image['path']);
            } else if (!empty($image['paths'])) {
                $image_paths = $image['paths'];
            }

            foreach ($image_paths as $path) {
                $name = basename($path);
                $this->load->model('Image_tool_model');
                $data['images'][] = array(
                    'name'		=> $name,
                    'url'		=> $this->Image_tool_model->resize($path, $image_height, $image_width)
                );
            }

            $data['image_height'] 	= $image_height;
            $data['image_width'] 	= $image_width;
        }

		$data['types'] = array(
			'image'		=> 'Image',
			'carousel'	=> 'Carousel',
			'custom'	=> 'Custom'
		);

		// pass array $data and load view files
		return $this->load->view('banners_module/banners_module', $data, TRUE);
	}
}

/* End of file banners_module.php */
/* Location: ./extensions/banners_module/controllers/banners_module.php */