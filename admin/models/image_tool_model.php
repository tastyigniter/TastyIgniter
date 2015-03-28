<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Image_tool_model extends CI_Model {

	public function resize($img_path, $width = '', $height = '') {
		$thumbs_path = IMAGEPATH . 'thumbs';

		if ( ! is_dir($thumbs_path)) {
			$this->_createFolder($thumbs_path);
		}

		$setting = $this->config->item('image_tool');

		if (isset($setting['root_folder']) AND (strpos($setting['root_folder'], '/') !== 0 OR strpos($setting['root_folder'], './') === FALSE)) {
			$root_folder = $setting['root_folder'] .'/';
		} else {
			$root_folder = 'data/';
		}

		if (strpos($img_path, $root_folder) === 0) {
			$img_path = str_replace($root_folder, '', $img_path);
		}

		if ( ! file_exists(IMAGEPATH . $root_folder . $img_path) OR ! is_file(IMAGEPATH . $root_folder . $img_path) OR strpos($img_path, '/') === 0) {
			return;
		}

		if (is_dir(IMAGEPATH . $root_folder . $img_path) AND ! is_dir($thumbs_path .'/'. $img_path)) {
			$this->_createFolder($thumbs_path .'/'. $img_path);
		}

		$info = pathinfo($img_path);
		$extension = $info['extension'];
		$img_name = $info['basename'];

		$old_path = IMAGEPATH . $root_folder . $img_path;
		list ($img_width, $img_height, $img_type, $attr) = getimagesize($old_path);
		$width = ($width === '') ? $img_width : $width;
		$height = ($height === '') ? $img_height : $height;

		$new_path = IMAGEPATH . 'thumbs/'. substr($img_path, 0, strrpos($img_path, '.')) .'-'. $width .'x'. $height .'.'. $extension;
		$new_image = 'thumbs/'. substr($img_path, 0, strrpos($img_path, '.')) .'-'. $width .'x'. $height .'.'. $extension;

		if (file_exists($old_path) AND ! file_exists($new_path)) {
			$this->load->library('image_lib');
			$this->image_lib->clear();
			$config['image_library'] 	= 'gd2';
			$config['source_image']		= $old_path;
			$config['new_image'] 		= $new_path;
			$config['width']	 		= $width;
			$config['height']			= $height;

			$this->image_lib->initialize($config);
			if ( ! $this->image_lib->resize()) {
				return FALSE;
			}
		}

		return root_url() .'assets/images/'. $new_image;
	}

	public function _createFolder($thumb_path = FALSE) {
		$oldumask = umask(0);

		if ($thumb_path AND !file_exists($thumb_path)) {
			mkdir($thumb_path, 0777, TRUE);
		}

		umask($oldumask);
	}
}

/* End of file image_tool_model.php */
/* Location: ./admin/models/image_tool_model.php */