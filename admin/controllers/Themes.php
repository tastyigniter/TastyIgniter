<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Themes extends Admin_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->model('Themes_model');
		$this->load->model('Settings_model');
		$this->load->model('Image_tool_model');

		$this->load->helper('template');

		$this->lang->load('themes');
	}

	public function index() {
		$this->user->restrict('Site.Themes.Access');

		if ($this->uri->rsegment(2) === 'activate' AND $this->_activateTheme()) {
			redirect('themes');
		}

		$this->template->setTitle($this->lang->line('text_title'));
		$this->template->setHeading($this->lang->line('text_heading'));

		$data['themes'] = array();
		$themes = $this->Themes_model->getList();
		foreach ($themes as $theme) {
			if ($theme['name'] === trim($this->config->item($theme['location'], 'default_themes'), '/')) {
				$active = '1';
			} else {
				$active = FALSE;
			}

			$data['themes'][] = array(
				'name'        => $theme['name'],
				'title'       => $theme['title'],
				'version'     => $theme['version'],
				'description' => $theme['description'],
				'location'    => ($theme['location'] === 'main') ? $this->lang->line('text_main') : $this->lang->line('text_admin'),
				'active'      => $active,
				'screenshot'  => $theme['screenshot'],
				'activate'    => site_url('themes/activate/' . $theme['location'] . '/' . $theme['name']),
				'edit'        => site_url('themes/edit/' . $theme['location'] . '/' . $theme['name']),
			);
		}

		$this->template->render('themes', $data);
	}

	public function edit() {
		$this->user->restrict('Site.Themes.Access');

		$theme_name = $this->uri->rsegment(4);
		$theme_location = $this->uri->rsegment(3);

		$url = '?';
//		$url .= 'name=' . $theme_name . '&location=' . $theme_location;

		if ( ! $theme = $this->Themes_model->getTheme($theme_name)) {
			$this->alert->set('danger', $this->lang->line('error_theme_not_found'));
			redirect('themes');
		}

		$_GET['extension_id'] = $theme['extension_id'];
		$theme_config = (isset($theme['config'])) ? $theme['config'] : FALSE;

		$this->load->library('customizer');
		$this->customizer->initialize($theme);

		if ($this->input->post() AND $this->_updateTheme($theme) === TRUE) {
			if ($this->input->post('save_close') === '1') {
				redirect("themes/edit/{$theme_location}/{$theme_name}");
			}

			redirect(current_url());
		}

		$this->template->setTitle(sprintf($this->lang->line('text_edit_heading'), $theme['title']));
		$this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), $theme['title']));

		$this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton($this->lang->line('button_save_close'), array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		$this->template->setButton($this->lang->line('button_icon_back'), array('class' => 'btn btn-default', 'href' => site_url('themes')));

		$this->template->setStyleTag(root_url('assets/js/colorpicker/css/bootstrap-colorpicker.min.css'), 'bootstrap-colorpicker-css');
		$this->template->setStyleTag(root_url('assets/js/codemirror/codemirror.css'), 'codemirror-css');
		$this->template->setScriptTag(root_url('assets/js/colorpicker/js/bootstrap-colorpicker.min.js'), 'bootstrap-colorpicker-js');
		$this->template->setScriptTag(root_url('assets/js/codemirror/codemirror.js'), 'codemirror-js', '300');
		$this->template->setScriptTag(root_url('assets/js/codemirror/xml/xml.js'), 'codemirror-xml-js', '301');
		$this->template->setScriptTag(root_url('assets/js/codemirror/css/css.js'), 'codemirror-css-js', '302');
		$this->template->setScriptTag(root_url('assets/js/codemirror/javascript/javascript.js'), 'codemirror-javascript-js', '303');
		$this->template->setScriptTag(root_url('assets/js/codemirror/php/php.js'), 'codemirror-php-js', '304');
		$this->template->setScriptTag(root_url('assets/js/codemirror/htmlmixed/htmlmixed.js'), 'codemirror-htmlmixed-js', '305');
		$this->template->setScriptTag(root_url('assets/js/codemirror/clike/clike.js'), 'codemirror-clike-js', '306');
		$this->template->setScriptTag(root_url('assets/js/jquery-sortable.js'), 'jquery-sortable-js');

		$data['file'] = array();
		if ($this->input->get('file')) {
			$url .= 'file=' . $this->input->get('file');

			$theme_file = load_theme_file($this->input->get('file'), $theme_name, $theme_location);

			if (isset($theme_file['type']) AND $theme_file['type'] === 'img') {
				$theme_file['heading'] = sprintf($this->lang->line('text_viewing'), $this->input->get('file'), $theme_name);
			} else if (isset($theme_file['type']) AND $theme_file['type'] === 'file') {
				$theme_file['heading'] = sprintf($this->lang->line('text_editing'), $this->input->get('file'), $theme_name);
			} else {
				$this->alert->set('danger', $this->lang->line('error_file_not_supported'));
			}

			$data['file'] = $theme_file;
		}

		$theme_files = '';
		$tree_link = site_url("themes/edit/{$theme_location}/{$theme_name}?file={link}");
		$theme_files .= $this->_themeTree($theme_name, $theme_location, $tree_link);

		$data['name'] = $theme['name'];
		$data['theme_files'] = $theme_files;
		$data['theme_config'] = $theme_config;
		$data['is_customizable'] = (isset($theme['customize']) AND $theme['customize']) ? TRUE : FALSE;

		$data['customizer_nav'] = $this->customizer->getNavView();
		$data['customizer_sections'] = $this->customizer->getSectionsView();
		$data['error_fields'] = array();

		if ( ! empty($data['is_customizable'])) {
			if (isset($theme_config['error_fields']) AND is_array($theme_config['error_fields'])) {
				foreach ($theme_config['error_fields'] as $error_field) {
					if (isset($error_field['field']) AND isset($error_field['error'])) {
						$data['error_fields'][$error_field['field']] = $error_field['error'];
					}
				}
			}
		}

		$data['_action'] = site_url("themes/edit/{$theme_location}/{$theme_name}{$url}");

		$data['mode'] = '';
		if ( ! empty($data['file']['ext'])) {
			if ($data['file']['ext'] === 'php') {
				$data['mode'] = 'application/x-httpd-php';
			} else if ($data['file']['ext'] === 'css') {
				$data['mode'] = 'css';
			} else {
				$data['mode'] = 'javascript';
			}
		}

		$this->template->render('themes_edit', $data);
	}

	private function _themeTree($directory, $location, $return_link, $parent = '') {
		$current_path = ($this->input->get('file')) ? explode('/', $this->input->get('file')) : array();

		$theme_tree = '';
		$theme_tree .= ($parent === '') ? '<nav class="nav"><ul class="metisFolder">' : '<ul>';

		$theme_files = find_theme_files($directory, $location);

		if ( ! empty($theme_files)) {
			foreach ($theme_files as $file) {
				$active = (in_array($file['name'], $current_path)) ? ' active' : '';

				if ($file['type'] === 'dir') {
					$parent_dir = $parent . '/' . $file['name'];
					$theme_tree .= '<li class="directory' . $active . '"><a><i class="fa fa-folder-open"></i>&nbsp;&nbsp;' . htmlspecialchars($file['name']) . '</a>';
					$theme_tree .= $this->_themeTree($directory . '/' . $file['name'], $location, $return_link, $parent_dir);
					$theme_tree .= '</li>';
				} else if ($file['type'] === 'img') {
					$link = str_replace('{link}', $parent . '/' . urlencode($file['name']), $return_link);
					$theme_tree .= '<li class="img' . $active . '"><a href="' . $link . '"><i class="fa fa-file-image-o"></i>&nbsp;&nbsp;' . htmlspecialchars($file['name']) . '</a></li>';
				} else if ($file['type'] === 'file') {
					$link = str_replace('{link}', $parent . '/' . urlencode($file['name']), $return_link);
					$theme_tree .= '<li class="file' . $active . '"><a href="' . $link . '"><i class="fa fa-file-code-o"></i>&nbsp;&nbsp;' . htmlspecialchars($file['name']) . '</a></li>';
				}
			}
		}

		$theme_tree .= '</ul>';
		if ($parent === '') {
			$theme_tree .= '</nav>';
		}

		return $theme_tree;
	}

	private function _activateTheme() {
		$this->user->restrict('Site.Themes.Manage');

		if ($this->uri->rsegment(2) === 'activate' AND $this->uri->rsegment(4) AND $this->uri->rsegment(3)) {
			$theme_name = $this->uri->rsegment(4);
			$theme_location = $this->uri->rsegment(3);

			if ($theme_name = $this->Themes_model->activateTheme($theme_name, $theme_location)) {
				$this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Theme [' . $theme_name . '] set as default '));
			}
		}

		return TRUE;
	}

	private function _updateTheme($theme = array()) {
		$this->user->restrict('Site.Themes.Manage');

		if ($this->uri->rsegment(4) AND $this->uri->rsegment(3) AND $this->validateForm($theme['customize']) === TRUE) {
			if ($this->input->post('editor_area') AND $this->input->get('file')) {
				$theme_file = $this->input->get('file');
				if (save_theme_file($theme_file, $theme['name'], $theme['location'], $this->input->post('editor_area'))) {
					$this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Theme File (' . $theme_file . ') saved '));
				} else {
					$this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), 'saved'));
				}
			}

			$update['extension_id'] = $this->input->get('extension_id') ? $this->input->get('extension_id') : $theme['extension_id'];
			$update['name'] = $theme['name'];
			$update['title'] = $theme['title'];
			$update['location'] = $theme['location'];

			if (isset($theme['customize'])) {
				$update['data'] = $this->customizer->getPostData();
			}

			if ($this->Themes_model->updateTheme($update)) {
				$this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Theme updated'));
			} else {
				$this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), 'updated'));
			}

			return TRUE;
		}
	}

	private function validateForm($is_customizable = FALSE) {
		$this->form_validation->set_rules('editor_area', 'Editor area');

		if ($is_customizable) {
			$rules = $this->customizer->getRules();
			$this->form_validation->set_rules($rules);
		}

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

/* End of file themes.php */
/* Location: ./admin/controllers/themes.php */