<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Themes extends Admin_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('user');
		$this->load->model('Design_model');
		$this->load->model('Settings_model');
		$this->load->model('Image_tool_model');
	}

	public function index() {
		if (!$this->user->islogged()) {
  			redirect('login');
		}

    	if (!$this->user->hasPermissions('access', 'themes')) {
  			redirect('permission');
		}

		if ($this->input->get('action') === 'activate' AND $this->_activateTheme()) {
			redirect('themes');
		}

		$this->template->setTitle('Themes');
		$this->template->setHeading('Themes');
		$this->template->setButton('Options', array('class' => 'btn btn-default pull-right', 'href' => site_url('settings#theme')));

		$data['text_empty'] 		= 'There are no themes available.';

		$data['themes'] = array();
		$themes = $this->Design_model->getThemeList();
		foreach ($themes as $theme) {
			if ($theme['name'] === trim($this->config->item($theme['directory'], 'default_themes'), '/')) {
				$active = '1';
			} else {
				$active = FALSE;
			}

			$data['themes'][] = array(
				'name' 			=> $theme['name'],
				'title' 		=> $theme['title'],
				'desc'			=> $theme['desc'],
				'location' 		=> $theme['location'],
				'active'		=> $active,
				'thumbnail'		=> $theme['thumbnail'],
				'preview'		=> $theme['preview'],
				'activate'		=> site_url('themes?action=activate&name='. $theme['name'] .'&location='. $theme['directory']),
				'edit' 			=> site_url('themes/edit?name='. $theme['name'] .'&location='. $theme['directory'])
			);
		}

		$this->template->setPartials(array('header', 'footer'));
		$this->template->render('themes', $data);
	}

	public function edit() {
		if (!$this->user->islogged()) {
  			redirect('login');
		}

    	if (!$this->user->hasPermissions('access', 'themes')) {
  			redirect('permission');
		}

		$allowed_img = ($this->config->item('themes_allowed_img')) ? explode('|', $this->config->item('themes_allowed_img')) : array();
		$allowed_file = ($this->config->item('themes_allowed_file')) ? explode('|', $this->config->item('themes_allowed_file')) : array();

		$theme_name = $this->input->get('name');
		$theme_location = $this->input->get('location');
		$theme_folder = $theme_location .'/views/themes/'. $theme_name .'/';

		$theme = $this->Design_model->getTheme($theme_name);
		$theme_path = $theme['path'];
		$theme_config = $theme['config'];

		$this->template->setTitle('Theme: '. $theme['title']);
		$this->template->setHeading('Theme: '. $theme['title']);
		$this->template->setButton('Save', array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton('Save & Close', array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		$this->template->setButton('Options', array('class' => 'btn btn-default pull-right', 'href' => site_url('settings#theme')));
		$this->template->setBackButton('btn btn-back', site_url('themes'));

		$url = '?';
		if (file_exists($theme_path)) {
			$url .= 'name='. $theme_name .'&location='. $theme_location;
			$tree_link = site_url('themes/edit'. $url .'&file={link}');
		} else {
			$this->alert->set('danger', 'An error occured, theme can not be found or loaded.');
			redirect('themes');
		}

		if (!is_writeable($theme_path)) {
			$this->alert->warning_now('Warning: The theme directory is not writable. Directory must be writable to allow editing!', 'warning');
		}

		$_GET['extension_id'] = $theme['extension_id'];
		if ($this->input->post() AND $this->_updateTheme($theme_config) === TRUE) {
			if ($this->input->post('save_close') === '1') {
				redirect('themes/edit'.'?name='. $theme_name .'&location='. $theme_location);
			}

			redirect('themes/edit'. $url);
		}

		$theme_files = '';
		$theme_files .= $this->_themeTree($theme_path, $tree_link);

		$data['name'] 				= $theme['name'];
		$data['theme_files'] 		= $theme_files;
		$data['text_file_heading'] 	= $data['file_content'] = '';

		$data['sections'] = $data['error_fields'] = array();
		if (!empty($theme_config)) {
			if (isset($theme_config['sections'])) {
				foreach ($theme_config['sections'] as $key => $section) {
					$fields = array();
					if (isset($section['fields']) AND is_array($section['fields'])) {
						$fields = $section['fields'];
					}

					$table = '';
					if (isset($section['table']) AND is_array($section['table'])) {
						$table = $section['table'];
					}

					$data['sections'][$key] = array(
						'title'		=> $section['title'],
						'desc'		=> $section['desc'],
						'icon'		=> $section['icon'],
						'fields'	=> $fields,
						'table'		=> $table
					);
				}
			}

			if (isset($theme_config['error_fields']) AND is_array($theme_config['error_fields'])) {
				foreach ($theme_config['error_fields'] as $error_field) {
					if (isset($error_field['field']) AND isset($error_field['error'])) {
						$data['error_fields'][$error_field['field']] = $error_field['error'];
					}
				}
			}
		}

		$data['file'] = array();
		if ($this->input->get('file')) {
			$url .= '&file='. $this->input->get('file');
			$theme_file_path = rtrim($theme_folder) . $this->input->get('file');

			if (is_file(ROOTPATH . $theme_file_path) AND file_exists(ROOTPATH . $theme_file_path)) {
				if (!is_writeable($theme_file_path)) {
					$this->alert->warning_now('Warning: The theme file is not writable. File must be writable to allow editing!', 'warning');
				}

				$file_name = basename($theme_file_path);
				$file_ext = strtolower(substr(strrchr($theme_file_path, '.'), 1));
				$type = $heading = $content = '';

				if (in_array($file_ext, $allowed_img)) {
					$type = 'img';
					$heading = 'Viewing image "'. $this->input->get('file') .'" in theme "'.$theme_name.'".';
					$content = root_url($theme_file_path);
				} else if (in_array($file_ext, $allowed_file)) {
					$type = 'file';
					$heading = 'Editing file "'. $this->input->get('file') .'" in "'.$theme_name.'" theme.';
					$content = htmlspecialchars(file_get_contents(ROOTPATH . $theme_file_path));
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

		$data['action']	= site_url('themes/edit'. $url);
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

		$this->template->setPartials(array('header', 'footer'));
		$this->template->render('themes_edit', $data);
	}

	public function _activateTheme() {
    	if ( ! $this->user->hasPermissions('modify', 'themes')) {
			$this->alert->set('warning', 'Warning: You do not have permission to activate theme!');
    	} else {

    		if ($this->input->get('action') === 'activate' AND $this->input->get('name') AND $this->input->get('location')) {
				$theme_name = $this->input->get('name');
				$theme_location = $this->input->get('location');

				if (!file_exists(ROOTPATH . $this->input->get('location').'/' .'views/themes/'. $this->input->get('name'))) {
					$this->alert->set('warning', 'Theme location can not be found!');
				} else {
					$default_themes = $this->config->item('default_themes');
					$default_themes[$theme_location] = $theme_name.'/';

					if ($this->Settings_model->addSetting('prefs', 'default_themes', $default_themes, '1')) {
						$this->alert->set('success', 'Theme ({$theme_name}) set as default sucessfully!');
					}
				}
			}

			return TRUE;
		}
	}

	public function _updateTheme($theme_config = array()) {
    	if ( ! $this->user->hasPermissions('modify', 'themes')) {
			$this->alert->set('warning', 'Warning: You do not have permission to update!');
			return TRUE;
    	}

    	$loaded = $success = FALSE;
    	if ($this->input->get('name') AND $this->input->get('location')) {
			if ( ! isset($theme_config['validate_fields'])) {
				$this->alert->set('danger', 'The theme configuration file does not contain a validate_fields array');
				return TRUE;
			}

			$theme_folder = $this->input->get('location') .'/views/themes/'. $this->input->get('name') .'/';
    		$loaded = TRUE;
    	}

    	if ($loaded === TRUE) {
			$theme_name = $this->input->get('name');
			$theme_location = $this->input->get('location');

			if (isset($theme_config['error_fields']) AND $theme_config['error_fields'] === FALSE) {
				$update = array();

				$update['extension_id'] 	= $this->input->get('extension_id');
				$update['name'] 			= $theme_config['basename'];
				$update['title'] 			= $theme_config['theme_name'];
				$update['location'] 		= $this->input->get('location');
				$update['data'] 			= $this->input->post();

				if ($this->Design_model->updateThemeConfig($update, $theme_config['config_items'])) {
					$this->alert->set('success', 'Theme saved sucessfully!');
					$success = TRUE;
				} else {
					$this->alert->danger_now('Theme saved failed!');
				}
			}

    		if ($this->input->post('editor_area') AND $this->input->get('file') AND $this->validateForm() === TRUE) {
				$theme_file = $this->input->get('file');
				$file_path = ROOTPATH. $theme_location .'views/themes/'. $theme_name. $theme_file;

				if (!is_writable($file_path)) {
					$this->alert->set('danger', 'The theme file is not writeable!');
				} else {
					if ($fp = @fopen($file_path, FOPEN_READ_WRITE_CREATE_DESTRUCTIVE)) {
						$editor_area = $this->input->post('editor_area');
						flock($fp, LOCK_EX);
						fwrite($fp, $editor_area);
						flock($fp, LOCK_UN);
						fclose($fp);
						@chmod($filepath, FILE_WRITE_MODE);
					}

					$this->alert->set('success', 'Theme File ('.basename($theme_file).') saved sucessfully!');
					$success = TRUE;
				}
			}
		}

		return $success;
	}

	public function validateForm() {
		$this->form_validation->set_rules('editor_area', 'Editor area', '');

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
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

		$theme_tree = '';
		if ($parent === '') {
			$theme_tree .= '<nav class="nav">';
			$theme_tree .= '<ul class="metisFolder">';
		} else {
			$theme_tree .= '<ul>';
		}

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
		if ($parent === '') {
			$theme_tree .= '</nav>';
		}

		return $theme_tree;
	}
}

/* End of file themes.php */
/* Location: ./admin/controllers/themes.php */