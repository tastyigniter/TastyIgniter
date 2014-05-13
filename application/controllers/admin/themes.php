<?php
class Themes extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('user');
		$this->load->model('Extensions_model');
		$this->load->model('Settings_model');
	}

	public function index() {
			
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/themes')) {
  			redirect('admin/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');
		} else {
			$data['alert'] = '';
		}

		$data['heading'] 			= 'Themes';
		$data['text_empty'] 		= 'There are no themes available.';

		$admin_default = $this->config->item('admin_theme');
		$main_default = $this->config->item('main_theme');
		
		$themes = array();
		$main_themes = glob(APPPATH .'/views/themes/main/*', GLOB_ONLYDIR);
		foreach ($main_themes as $theme) {
			$themes[] = array('location' => 'main', 'name' => $theme);
		}
		
		$admin_themes = glob(APPPATH .'/views/themes/admin/*', GLOB_ONLYDIR);
		foreach ($admin_themes as $theme) {
			$themes[] = array('location' => 'admin', 'name' => $theme);
		}
		
		$data['themes'] = array();
		foreach ($themes as $theme) {
			$theme_name = basename($theme['name']).'/';
			
			if ($theme_name === $admin_default AND $theme['location'] === 'admin') {
				$default = '1';
			} else if ($theme_name === $main_default AND $theme['location'] === 'main') {
				$default = '1';
			} else {
				$default = site_url('admin/themes/edit?name='). basename($theme['name']) .'&location='. $theme['location'] .'&default=1';
			}
			
			$data['themes'][] = array(
				'name' 			=> ucwords(basename($theme['name'])),
				'location' 		=> ucwords($theme['location']),
				'default'		=> $default,
				'edit' 			=> site_url('admin/themes/edit?name='. basename($theme['name']) .'&location='. $theme['location'])
			);		
		}

		$regions = array('header', 'footer');
		if (file_exists(APPPATH .'views/themes/admin/'.$this->config->item('admin_theme').'themes.php')) {
			$this->template->render('themes/admin/'.$this->config->item('admin_theme'), 'themes', $regions, $data);
		} else {
			$this->template->render('themes/admin/default/', 'themes', $regions, $data);
		}
	}

	public function edit() {
			
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/themes')) {
  			redirect('admin/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else { 
			$data['alert'] = '';
		}		
		
		$url = '?';
		if ($this->input->get('name') AND $this->input->get('location')) {
			if (!file_exists(APPPATH .'views/themes/'.$this->input->get('location').'/'. $this->input->get('name'))) {
				redirect('admin/themes');
			}
			
			$theme_name = $this->input->get('name');
			$theme_location = $this->input->get('location');
			$url .= 'name='. $theme_name .'&location='. $theme_location;
			
			if ($this->input->get('default') === '1') {
				$this->Settings_model->addSetting('themes', $theme_location.'_theme', $theme_name.'/', '0');
				$this->session->set_flashdata('alert', '<p class="success">Theme set as default sucessfully!</p>');
				redirect('admin/themes');
			}
			
		} else {
			redirect('admin/themes');
		}
		
		$data['heading'] 			= 'Themes - '. ucwords($theme_name);
		$data['button_save'] 		= 'Save';
		$data['button_save_close'] 	= 'Save & Close';
		$data['sub_menu_back'] 		= site_url('admin/themes');

		$data['name'] 				= ucwords($theme_name);
		
		$allowed_img = ($this->config->item('themes_allowed_img')) ? explode('|', $this->config->item('themes_allowed_img')) : array();
		$allowed_file = ($this->config->item('themes_allowed_file')) ? explode('|', $this->config->item('themes_allowed_file')) : array();

		$data['theme_files'] = array();
		if (file_exists(APPPATH .'views/themes/'. $theme_location .'/'. $theme_name .'/')) {
			$theme_path = $theme_folder = APPPATH .'views/themes/'. $theme_location .'/'. $theme_name .'/';
			$tree_link = site_url('admin/themes/edit?name='). $theme_name .'&location='. $theme_location .'&file={link}';
			$data['theme_files'] = $this->themeTree($theme_path, $tree_link);
		}
		
		
		$data['text_file_heading'] = '';
		$data['file_content'] = '';
		if ($this->input->get('file')) {
			$url .= '&file='. $this->input->get('file');
			$file_path = APPPATH .'views/themes/'. $theme_location .'/'. $theme_name. $this->input->get('file');
			if (is_file($file_path) AND file_exists($file_path)) {
				$file_name = basename($file_path);
				$file_ext = substr(strrchr($file_path, '.'), 1);
				$file_ext = strtolower($file_ext);
				if (in_array($file_ext, $allowed_img)) {
					$data['text_file_heading'] 	= 'Viewing image "'. $this->input->get('file') .'" in theme "'.$theme_name.'".';
					$data['file_content'] = '<img alt="'. $file_name .'" src="'. base_url($file_path) .'" />';
				} else if (in_array($file_ext, $allowed_file)) {
					$file_content = file_get_contents($file_path);
					$data['text_file_heading'] 	= 'Editing file "'. $this->input->get('file') .'" in theme "'.$theme_name.'".';
					$data['file_content'] = '<textarea name="editor" id="editor" rows="30" cols="">'. htmlspecialchars($file_content) .'</textarea>';
				} else {
					$data['file_content'] = '<p>File is not supported</p>';
				}
			}
		}
		
		if (isset($file_path) AND !is_writeable($file_path)) {
			$data['alert'] = '<p class="warning">Warning: The theme file is not writable. File must be writable to allow editing!</p>';
		} else if (!is_writeable(APPPATH .'views/themes/'. $theme_location .'/'. $theme_name .'/')) {
			$data['alert'] = '<p class="warning">Warning: The theme directory is not writable. Directory must be writable to allow editing!</p>';
		}
		
		$data['action']	= site_url('admin/themes/edit'. $url);

		if ($this->input->post() AND $this->_updateThemeFile() === TRUE) {
			if ($this->input->post('save_close') === '1') {
				redirect('admin/themes/edit'.'?name='. $theme_name .'&location='. $theme_location);
			}
			
			redirect('admin/themes/edit'. $url);
		}

		$regions = array('header', 'footer');
		if (file_exists(APPPATH .'views/themes/admin/'.$this->config->item('admin_theme').'themes_edit.php')) {
			$this->template->render('themes/admin/'.$this->config->item('admin_theme'), 'themes_edit', $regions, $data);
		} else {
			$this->template->render('themes/admin/default/', 'themes_edit', $regions, $data);
		}
	}

	public function themeTree($directory, $return_link) {
		$code = '';
		if ( substr($directory, -1) == "/" ) {
			$directory = substr($directory, 0, strlen($directory) - 1);
		}
		
		$code .= $this->_themeTree($directory, $return_link);
		return $code;
	}

	
	public function _updateThemeFile() {
    	if ( ! $this->user->hasPermissions('modify', 'admin/themes')) {
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to update!</p>');
			return TRUE;
    	} else if ($this->input->post('editor') AND $this->input->get('name') AND $this->input->get('location') AND $this->input->get('file')) { 
			$theme_name = $this->input->get('name');
			$theme_location = $this->input->get('location');
			$theme_file = $this->input->get('file');
			$file_path = APPPATH .'views/themes/'. $theme_location .'/'. $theme_name. $theme_file;
			
			if (!is_writable($file_path)) {
				$this->session->set_flashdata('alert', '<p class="error">The theme file is not writeable!</p>');				
			} else {		
				if ($fp = @fopen($file_path, FOPEN_READ_WRITE_CREATE_DESTRUCTIVE)) {
					$editor = $this->input->post('editor');
					flock($fp, LOCK_EX);
					fwrite($fp, $editor);
					flock($fp, LOCK_UN);
					fclose($fp);

					@chmod($filepath, FILE_WRITE_MODE);
				}

				$this->session->set_flashdata('alert', '<p class="success">Theme File ('.basename($theme_file).') Saved Sucessfully!</p>');				
			}
		
			return TRUE;
		}
	}	

	public function _themeTree($directory, $return_link, $parent = '') {
		$allowed_img = ($this->config->item('themes_allowed_img')) ? explode('|', $this->config->item('themes_allowed_img')) : array();
		$allowed_file = ($this->config->item('themes_allowed_file')) ? explode('|', $this->config->item('themes_allowed_file')) : array();
		$hidden_files = ($this->config->item('themes_hidden_files')) ? explode('|', $this->config->item('themes_hidden_files')) : array();
		$hidden_folders = ($this->config->item('themes_hidden_folders')) ? explode('|', $this->config->item('themes_hidden_folders')) : array();

		$theme_files = glob($directory .'/*');
		natcasesort($theme_files);

		$files = $dirs = array();
		foreach ($theme_files as $file) {
			$file_name = basename($file);
			if (is_dir($directory. '/'. $file_name) AND !in_array($file_name, $hidden_folders)) {
				$dirs[] = $file_name; 
			} else if (!in_array($file, $hidden_files)) {
				$files[] = $file_name;
			}
		}
		
		$theme_files = array_merge($dirs, $files);
	
		$current_path = ($this->input->get('file')) ? explode('/', $this->input->get('file')) : array();

		$theme_tree = '<ul>';
		
		foreach ($theme_files as $file) {
			if (is_dir($directory .'/'. $file)) {
				$parent_dir = $parent.'/'.$file;
				$active = (in_array($file, $current_path)) ? ' active' : '';
				$theme_tree .= '<li class="directory'. $active .'"><a>'. htmlspecialchars($file) .'</a>';
				$theme_tree .= $this->_themeTree($directory .'/'. $file, $return_link, $parent_dir);
				$theme_tree .= '</li>';
			} else {
				$file_ext = substr(strrchr($file, '.'), 1);
				$file_ext = strtolower($file_ext);
				if (in_array($file_ext, $allowed_img)) {
					$link = str_replace('{link}', $parent .'/'. urlencode($file), $return_link);
					$theme_tree .= '<li class="img"><a href="'. $link .'">'. htmlspecialchars($file) .'</a></li>';
				} else if (in_array($file_ext, $allowed_file)) {
					$link = str_replace('{link}', $parent .'/'. urlencode($file), $return_link);
					$theme_tree .= '<li class="file"><a href="'. $link .'">'. htmlspecialchars($file) .'</a></li>';
				}
			}
		}
		
		$theme_tree .= '</ul>';
		
		return $theme_tree;
	}
}

/* End of file themes.php */
/* Location: ./application/controllers/admin/themes.php */