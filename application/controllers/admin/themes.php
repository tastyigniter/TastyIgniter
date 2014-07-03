<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Themes extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('user');
		$this->load->model('Extensions_model');
		$this->load->model('Settings_model');
		$this->load->model('Image_tool_model');
	}

	public function index() {
		if (!$this->user->islogged()) {  
  			redirect(ADMIN_URI.'/login');
		}

    	if (!$this->user->hasPermissions('access', ADMIN_URI.'/themes')) {
  			redirect(ADMIN_URI.'/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');
		} else {
			$data['alert'] = '';
		}

		if ($this->input->get('name') AND $this->input->get('location') AND $this->input->get('default')) {
			if (!file_exists(APPPATH .'views/themes/'.$this->input->get('location').'/'. $this->input->get('name'))) {
				$this->session->set_flashdata('alert', '<p class="alert-warning">Theme location can not be found!</p>');
			}
			
			$theme_name = $this->input->get('name');
			$theme_location = $this->input->get('location');
		
			if ($this->Settings_model->addSetting('themes', $theme_location.'_theme', $theme_name.'/', '0')) {
				$this->session->set_flashdata('alert', '<p class="alert-success">Theme set as default sucessfully!</p>');
			}
			
			redirect(ADMIN_URI.'/themes');
		}

		$this->template->setTitle('Themes');
		$this->template->setHeading('Themes');
		$this->template->setButton('Options', array('class' => 'btn btn-default pull-right', 'href' => site_url(ADMIN_URI.'/settings#themes')));

		$data['text_empty'] 		= 'There are no themes available.';

		$admin_default = $this->config->item('admin_theme');
		$main_default = $this->config->item('main_theme');
		
		$themes = array();
		$main_themes = glob(APPPATH .'views/themes/main/*', GLOB_ONLYDIR);
		foreach ($main_themes as $theme) {
			$themes[] = array('location' => 'main', 'name' => $theme);
		}
		
		$admin_themes = glob(APPPATH .'views/themes/'.ADMIN_URI.'/*', GLOB_ONLYDIR);
		foreach ($admin_themes as $theme) {
			$themes[] = array('location' => 'admin', 'name' => $theme);
		}
		
		$data['themes'] = array();
		foreach ($themes as $theme) {
			$theme_name = basename($theme['name']).'/';
			
			if ($theme_name === $admin_default AND $theme['location'] === ADMIN_URI) {
				$default = '1';
			} else if ($theme_name === $main_default AND $theme['location'] === 'main') {
				$default = '1';
			} else {
				$default = site_url(ADMIN_URI.'/themes?default=1&name='. basename($theme['name']) .'&location='. $theme['location']);
			}

			$data['themes'][] = array(
				'name' 			=> ucwords(basename($theme['name'])),
				'location' 		=> ($theme['location'] === 'main') ? 'Main' : 'Administrator Panel',
				'default'		=> $default,
				'thumbnail'		=> base_url(APPPATH .'views/themes/'.$theme['location'].'/'.basename($theme['name']).'/images/theme_thumb.png'),
				'preview'		=> base_url(APPPATH .'views/themes/'.$theme['location'].'/'.basename($theme['name']).'/images/theme_preview.png'),
				'edit' 			=> site_url(ADMIN_URI.'/themes/edit?name='. basename($theme['name']) .'&location='. $theme['location'])
			);		
		}

		$this->template->regions(array('header', 'footer'));
		if (file_exists(APPPATH .'views/themes/'.ADMIN_URI.'/'.$this->config->item('admin_theme').'themes.php')) {
			$this->template->render('themes/'.ADMIN_URI.'/'.$this->config->item('admin_theme'), 'themes', $data);
		} else {
			$this->template->render('themes/'.ADMIN_URI.'/default/', 'themes', $data);
		}
	}

	public function edit() {
		if (!$this->user->islogged()) {  
  			redirect(ADMIN_URI.'/login');
		}

    	if (!$this->user->hasPermissions('access', ADMIN_URI.'/themes')) {
  			redirect(ADMIN_URI.'/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else { 
			$data['alert'] = '';
		}		
		
		$allowed_img = ($this->config->item('themes_allowed_img')) ? explode('|', $this->config->item('themes_allowed_img')) : array();
		$allowed_file = ($this->config->item('themes_allowed_file')) ? explode('|', $this->config->item('themes_allowed_file')) : array();

		$theme_name = $this->input->get('name');
		$theme_location = $this->input->get('location');
		$theme_folder = APPPATH .'views/themes/'. $theme_location .'/'. $theme_name .'/';

		$url = '?';
		if (file_exists($theme_folder)) {
			$url .= 'name='. $theme_name .'&location='. $theme_location;
			$tree_link = site_url(ADMIN_URI.'/themes/edit'. $url .'&file={link}');
			$theme_file_tree = $this->themeTree($theme_folder, $tree_link);
		} else {
			redirect(ADMIN_URI.'/themes');
		}
		
		if (!is_writeable($theme_folder)) {
			$data['alert'] = '<p class="alert-warning">Warning: The theme directory is not writable. Directory must be writable to allow editing!</p>';
		}
		
		if (file_exists($theme_folder . '/theme.xml')) {
			$xml = simplexml_load_file($theme_folder . '/theme.xml');
		}

		$this->template->setTitle('Theme: '. ucwords($theme_name));
		$this->template->setHeading('Theme: '. ucwords($theme_name));
		$this->template->setButton('Save', array('class' => 'btn btn-success', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton('Save & Close', array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		$this->template->setButton('Options', array('class' => 'btn btn-default pull-right', 'href' => site_url(ADMIN_URI.'/settings#themes')));
		$this->template->setBackButton('btn-back', site_url(ADMIN_URI.'/themes'));

		$data['name'] 				= ucwords($theme_name);
		$data['theme_files'] 		= $theme_file_tree;
		$data['text_file_heading'] 	= $data['file_content'] = '';


		if ($this->input->get('file')) {
			$url .= '&file='. $this->input->get('file');
			$theme_file_path = rtrim($theme_folder) . $this->input->get('file');
			
			if (is_file($theme_file_path) AND file_exists($theme_file_path)) {
				if (!is_writeable($theme_file_path)) {
					$data['alert'] = '<p class="alert-warning">Warning: The theme file is not writable. File must be writable to allow editing!</p>';
				}
		
				$file_name = basename($theme_file_path);
				$file_ext = strtolower(substr(strrchr($theme_file_path, '.'), 1));
				$type = $heading = $content = '';
				
				if (in_array($file_ext, $allowed_img)) {
					$type = 'img';
					$heading = 'Viewing image "'. $this->input->get('file') .'" in theme "'.$theme_name.'".';
					$content = base_url($theme_file_path);
				} else if (in_array($file_ext, $allowed_file)) {
					$type = 'file';
					$heading = 'Editing file "'. $this->input->get('file') .'" in "'.$theme_name.'" theme.';
					$content = htmlspecialchars(file_get_contents($theme_file_path));
				} else {
					$heading = 'File is not supported';
				}

				$data['file'] = array(
					'heading'	=> $heading,
					'name'		=> $file_name,
					'ext'		=> $file_ext,
					'type'		=> $type,
					'content'	=> $content
				);
			}
		}
		
		$data['action']	= site_url(ADMIN_URI.'/themes/edit'. $url);
		$data['mode'] = '';
		if (!empty($data['file']['ext'])) {
			if ($data['file']['ext'] === 'php') {
				$data['mode'] = 'htmlmixed';
			} else if ($data['file']['ext'] === 'css') {
				$data['mode'] = 'css';
			} else {
				$data['mode'] = 'javascript';
			}
		}
		
		if ($this->input->post() AND $this->_updateThemeFile() === TRUE) {
			if ($this->input->post('save_close') === '1') {
				redirect(ADMIN_URI.'/themes/edit'.'?name='. $theme_name .'&location='. $theme_location);
			}
			
			redirect(ADMIN_URI.'/themes/edit'. $url);
		}

		$this->template->regions(array('header', 'footer'));
		if (file_exists(APPPATH .'views/themes/'.ADMIN_URI.'/'.$this->config->item('admin_theme').'themes_edit.php')) {
			$this->template->render('themes/'.ADMIN_URI.'/'.$this->config->item('admin_theme'), 'themes_edit', $data);
		} else {
			$this->template->render('themes/'.ADMIN_URI.'/default/', 'themes_edit', $data);
		}
	}

	public function themeTree($directory, $return_link) {
		$code = '';
		if (substr($directory, -1) == "/") {
			$directory = substr($directory, 0, strlen($directory) - 1);
		}
		
		$code .= $this->_themeTree($directory, $return_link);
		return $code;
	}

	
	public function _updateThemeFile() {
    	if ( ! $this->user->hasPermissions('modify', ADMIN_URI.'/themes')) {
			$this->session->set_flashdata('alert', '<p class="alert-warning">Warning: You do not have permission to update!</p>');
			return TRUE;
    	} else if ($this->input->post('editor_area') AND $this->input->get('name') AND $this->input->get('location') AND $this->input->get('file')) { 
			$theme_name = $this->input->get('name');
			$theme_location = $this->input->get('location');
			$theme_file = $this->input->get('file');
			$file_path = APPPATH .'views/themes/'. $theme_location .'/'. $theme_name. $theme_file;
			
			if (!is_writable($file_path)) {
				$this->session->set_flashdata('alert', '<p class="error">The theme file is not writeable!</p>');				
			} else {		
				if ($fp = @fopen($file_path, FOPEN_READ_WRITE_CREATE_DESTRUCTIVE)) {
					$editor_area = $this->input->post('editor_area');
					flock($fp, LOCK_EX);
					fwrite($fp, $editor_area);
					flock($fp, LOCK_UN);
					fclose($fp);

					@chmod($filepath, FILE_WRITE_MODE);
				}

				$this->session->set_flashdata('alert', '<p class="alert-success">Theme File ('.basename($theme_file).') Saved Sucessfully!</p>');				
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
			$active = (in_array($file, $current_path)) ? ' active' : '';
			if (is_dir($directory .'/'. $file)) {
				$parent_dir = $parent.'/'.$file;
				$theme_tree .= '<li class="directory'. $active .'"><a><i class="fa fa-folder-open"></i>&nbsp;&nbsp;'. htmlspecialchars($file) .'</a>';
				$theme_tree .= $this->_themeTree($directory .'/'. $file, $return_link, $parent_dir);
				$theme_tree .= '</li>';
			} else {
				$file_ext = substr(strrchr($file, '.'), 1);
				$file_ext = strtolower($file_ext);
				if (in_array($file_ext, $allowed_img)) {
					$link = str_replace('{link}', $parent .'/'. urlencode($file), $return_link);
					$theme_tree .= '<li class="img'. $active .'"><a href="'. $link .'"><i class="fa fa-file-image-o"></i>&nbsp;&nbsp;'. htmlspecialchars($file) .'</a></li>';
				} else if (in_array($file_ext, $allowed_file)) {
					$link = str_replace('{link}', $parent .'/'. urlencode($file), $return_link);
					$theme_tree .= '<li class="file'. $active .'"><a href="'. $link .'"><i class="fa fa-file-code-o"></i>&nbsp;&nbsp;'. htmlspecialchars($file) .'</a></li>';
				}
			}
		}
		
		$theme_tree .= '</ul>';
		
		return $theme_tree;
	}
}

/* End of file themes.php */
/* Location: ./application/controllers/admin/themes.php */