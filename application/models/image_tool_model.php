<?php
class Image_tool_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}

	public function resize($img_path, $width, $height) {
		$setting = $this->config->item('image_tool');
		if (strpos($setting['root_folder'], '/') !== 0 OR strpos($setting['root_folder'], './') === FALSE) {
			$root_folder = $setting['root_folder'] .'/';
		} else {
			$root_folder = 'data/';
		}
		
		if (strpos($img_path, $root_folder) === 0) {
			$img_path = str_replace($root_folder, '', $img_path);
		}
		
		if (strpos($img_path, '/') === 0 OR ! file_exists(IMAGEPATH . $root_folder . $img_path) OR ! is_file(IMAGEPATH . $root_folder . $img_path)) {
			return;
		}

		$info = pathinfo($img_path);
		$extension = $info['extension'];
		
		$old_image = $root_folder . $img_path;
		$new_image = 'thumbs/'. substr($img_path, 0, strrpos($img_path, '.')) .'-'. $width .'x'. $height .'.'. $extension;
		
		if ( ! file_exists(IMAGEPATH . $new_image)) {
			$this->load->library('image_lib'); 
			$this->image_lib->clear();
			$config['image_library'] 	= 'gd2';
			$config['source_image']		= IMAGEPATH . $old_image;
			$config['new_image'] 		= IMAGEPATH . $new_image;
			$config['width']	 		= $width;
			$config['height']			= $height;

			$this->image_lib->initialize($config); 
			if ( ! $this->image_lib->resize()) {
				return FALSE;
			}
		}

		return base_url() .'assets/img/'. $new_image;
	}
}
