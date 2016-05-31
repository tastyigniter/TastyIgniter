<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Banners_module extends Main_Controller {

	public function index($module = array(), $data = array()) {
        $this->load->model('Layouts_model'); 													// load the menus model
        $this->load->model('Banners_model'); 													// load the menus model
        $this->load->model('Image_tool_model'); 													// load the menus model
        $this->lang->load('banners_module/banners_module');

		if ( ! file_exists(EXTPATH .'banners_module/views/banners_module.php')) { 				//check if file exists in views folder
			show_404(); 																		// Whoops, show 404 error page!
		}

        !empty($module) OR $module = $this->extension->getModule('banners_module');

        $layout_id = (!empty($module['layout_id'])) ? $module['layout_id'] : 0;
        $partial = (!empty($module['partial'])) ? $module['partial'] : '';
        $ext_data = (!empty($module['data']) AND is_array($module['data'])) ? $module['data'] : array();

        $data['no_photo'] 			= $this->Image_tool_model->resize('data/no_photo.png');
        $data['image_height'] = $data['image_width'] = $data['carousel_height'] = $data['carousel_width'] = '';

        $data['banners'] = array();
        $banners = (!empty($ext_data['banners']) AND is_array($ext_data['banners'])) ? $ext_data['banners'] : array();
        foreach ($banners as $banner) {

            $layout_partial = (!empty($banner['layout_partial'])) ? explode('|', $banner['layout_partial']) : array('0', '');

            if (empty($banner['status'])) continue;

            if ($layout_id !== $layout_partial[0] OR $partial !== $layout_partial[1]) continue;

            $banner_id = (!empty($banner['banner_id'])) ? $banner['banner_id'] : 0;
            $image_width = (!empty($banner['width'])) ? $banner['width'] : '';
            $image_height = (!empty($banner['height'])) ? $banner['height'] : '';

            $banner_info = $this->Banners_model->getBanner($banner_id);

            if (empty($banner_info['status'])) continue;

            $images = array();
            if (!empty($banner_info['image_code'])) {
                $image = unserialize($banner_info['image_code']);

                $image_paths = array();
                if (!empty($image['path'])) {
                    $image_paths = array($image['path']);
                } else if (!empty($image['paths'])) {
                    $image_paths = $image['paths'];
                }

                foreach ($image_paths as $path) {
                    $images[] = array(
                        'name'		=> basename($path),
                        'height'	=> $image_height,
                        'width'		=> $image_width,
                        'url'		=> $this->Image_tool_model->resize($path, $image_height, $image_width)
                    );
                }
            }

            $click_url = $banner_info['click_url'];
            if ( ! preg_match('#^(\w+:)?//#i', $click_url)) {
                $click_url = site_url($click_url);
            }

            $data['banners'][] = array(
                'banner_id'   => $banner_info['banner_id'],
                'name'        => $banner_info['name'],
                'click_url'   => $click_url,
                'language_id' => $banner_info['language_id'],
                'alt_text'    => $banner_info['alt_text'],
                'custom_code' => $banner_info['custom_code'],
                'status'      => $banner_info['status'],
                'height'      => $image_height,
                'width'       => $image_width,
                'type'        => (isset($banner_info['type'])) ? $banner_info['type'] : '',
                'images'      => $images,
            );
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