<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Design_model extends CI_Model {

    private $db_themes = array();
    private $themes = array();
    private $theme = array();
    private $theme_config = array();

	public function getThemeList() {
		$this->load->model('Extensions_model');

		$result = $temp_themes = array();

		if (!is_dir(ROOTPATH . MAINDIR . '/views/themes') OR !is_dir(ROOTPATH . ADMINDIR . '/views/themes')) {
			return $temp_themes;
		}

		$main_themes = glob(ROOTPATH . MAINDIR . '/views/themes/*', GLOB_ONLYDIR);
		foreach ($main_themes as $theme_path) {
			$theme_folder = basename($theme_path);
			$temp_themes[] = array('location' => 'main', 'folder' => $theme_folder, 'path' => 'main/views/themes/'.$theme_folder);
		}

		$admin_themes = glob(ROOTPATH . ADMINDIR . '/views/themes/*', GLOB_ONLYDIR);
		foreach ($admin_themes as $theme_path) {
			$theme_folder = basename($theme_path);
			$temp_themes[] = array('location' => 'admin', 'folder' => $theme_folder, 'path' => 'admin/views/themes/'.$theme_folder);
		}

		foreach ($temp_themes as $theme) {
			$theme_config = $this->getThemeConfig($theme['path'].'/');
			if (empty($theme_config) AND !is_array($theme_config)) {
				continue;
			}

			$themes = empty($this->db_themes) ? $this->getThemes() : $this->db_themes;
			$theme_db_config = (isset($themes[$theme['folder']]) AND is_array($themes[$theme['folder']])) ? $themes[$theme['folder']] : array();

			$theme_name 		= !empty($theme_db_config['name']) ? $theme_db_config['name'] : $theme['folder'];
			$theme_title 		= !empty($theme_db_config['title']) ? $theme_db_config['title'] : str_replace('-', ' ', str_replace('_', ' ', $theme['folder']));

			$result[$theme['folder']] = array(
				'extension_id'	=> !empty($theme_db_config['extension_id']) ? $theme_db_config['extension_id'] : 0,
				'name'			=> isset($theme_config['basename']) ? $theme_config['basename'] : $theme_name,
				'title' 		=> isset($theme_config['theme_name']) ? $theme_config['theme_name'] : $theme_title,
				'desc'			=> isset($theme_config['theme_desc']) ? $theme_config['theme_desc'] : '',
				'directory'		=> $theme['location'],
				'location' 		=> ($theme['location'] === 'main') ? 'Main' : 'Administrator Panel',
				'thumbnail'		=> root_url($theme['path'] .'/images/theme_thumb.png'),
				'preview'		=> root_url($theme['path'] .'/images/theme_preview.png'),
				'path'			=> ROOTPATH . $theme['path'],
				'config'		=> $theme_config,
				'customization'	=> !empty($theme_db_config['data']) ? $theme_db_config['data'] : array()
			);
		}

		return $result;
	}

	public function getThemes() {
		$this->db->from('extensions');

		$query = $this->db->get();

		$result = array();

		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$row['data'] = ($row['serialized'] === '1' AND !empty($row['data'])) ? unserialize($row['data']) : array();
				$result[$row['name']] = $row;
			}

			$this->db_themes = $result;
		}

		return $result;
	}

	public function getTheme($name = '') {
		$result = array();

		if (!empty($name) AND empty($this->theme)) {
			$themes = $this->getThemeList();
			if ($themes AND is_array($themes)) {
				if (isset($themes[$name]) AND is_array($themes[$name])) {
					$result = $themes[$name];
					$this->theme = $result;
				}
			}
		}

		return $result;
	}

    /**
     * Fetch Theme Config File options
     *
     * @param string $theme_path
     * @param string $option
     * @param bool $return
     * @return bool TRUE if the file was loaded correctly or FALSE on failure
     * @internal param string $path Theme directory path from root directory
     */
	public function getThemeConfig($theme_path = '', $option = '', $return = FALSE) {
		$found = $loaded = FALSE;

		$file_path = $theme_path.'theme_config.php';

		if (array_key_exists($file_path, $this->themes)) {
			$loaded = TRUE;
			log_message('debug', 'Theme configuration file has already been loaded. Second attempt aborted.');
		}

		if ( ! file_exists(ROOTPATH.$file_path)) {
			$this->alert->warning_now('The theme configuration file <b>./'.$file_path.'</b> does not exist.');
			return FALSE;
		}

		if ($loaded === FALSE) {
		 	include(ROOTPATH.$file_path);

			if ( ! isset($theme) OR ! is_array($theme)) {
				$this->alert->warning_now('The <b>./'.$file_path.'</b> theme configuration file does not appear to contain a valid array.');
				return FALSE;
			}

			$this->themes[$file_path] = $theme;
			unset($theme);
			$loaded = TRUE;
			log_message('debug', 'Theme Config file loaded: <b>'.$file_path. '</b>');
		}

		if ($loaded === TRUE) {
			if ($option !== '') {
				return $this->themes[$file_path][$option];
			}

			return $this->themes[$file_path];
		}

		return FALSE;
	}

	public function getLayouts() {
		$this->db->from('layouts');

		$query = $this->db->get();

		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}

    /**
     * @return array
     */
    public function getBanners() {
		$this->db->from('banners');

		$query = $this->db->get();

		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function getRoutes() {
		$this->db->from('uri_routes');

		$this->db->order_by('priority', 'ASC');

		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function getLayout($layout_id) {
		$this->db->from('layouts');

		$this->db->where('layout_id', $layout_id);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
	}

	public function getBanner($banner_id) {
		$this->db->from('banners');

		$this->db->where('banner_id', $banner_id);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
	}

	public function getLayoutRoutes($layout_id) {
		$this->db->from('layout_routes');

		$this->db->where('layout_id', $layout_id);

		$query = $this->db->get();

		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function updateRoutes($routes = array()) {
		if (!empty($routes)) {
			$write_routes = array();

			$this->db->truncate('uri_routes');
			$priority = 1;
			foreach ($routes as $key => $value) {
				if (!empty($value['uri_route']) AND !empty($value['controller'])) {
					$write_routes[$priority] = $value;

					$this->db->set('uri_route', $value['uri_route']);
					$this->db->set('controller', $value['controller']);
					$this->db->set('priority', $priority);

					$this->db->insert('uri_routes');
					$priority++;
				}
			}

			$this->writeRoutesFile($write_routes);

			if ($this->db->affected_rows() > 0) {
				return TRUE;
			}
		}
	}

	public function writeRoutesFile($write_routes = array()) {

		$filepath = IGNITEPATH . 'config/routes.php';
		$line = '';

		if ($fp = @fopen($filepath, FOPEN_READ_WRITE_CREATE_DESTRUCTIVE)) {

			$line .= "<"."?php  if ( ! defined('BASEPATH')) exit('No direct access allowed');\n\n";

			$line .= "$"."route['default_controller'] = 'home';\n";

	        if (!empty($write_routes) AND is_array($write_routes)) {
				foreach ($write_routes as $key => $value) {
					$line .= "$"."route['". $value['uri_route'] ."'] = '". $value['controller'] ."';\n";
				}
        	}

			//$line .= "$"."route['(:any)'] = 'slug';\n\n";
			$line .= "$"."route['404_override'] = '';\n\n";

			$line .= "/* End of file routes.php */\n";
			$line .= "/* Location: ./system/tastyigniter/config/routes.php */";

			flock($fp, LOCK_EX);
			fwrite($fp, $line);
			flock($fp, LOCK_UN);
			fclose($fp);

			@chmod($filepath, FILE_WRITE_MODE);
		}
	}

	public function updateThemeConfig($update = array(), $config_items = array()) {
		$query = FALSE;
		$data = array();

		if (!empty($update['data']) AND !empty($config_items)) {
			foreach ($config_items as $item) {
				if (isset($update['data'][$item])) {
					$data[$item] = $update['data'][$item];
				}
			}
		}

		if ($this->config->item($update['location'], 'default_themes') === $update['name'].'/') {
			$this->db->set('status', '1');
		} else {
			$this->db->set('status', '0');
		}

		$this->db->set('data', serialize($data));
		$this->db->set('serialized', '1');
		$this->db->set('title', $update['title']);

		if (!empty($update['extension_id'])) {
			$this->db->where('type', 'theme');
			$this->db->where('name', $update['name']);
			$this->db->where('extension_id', $update['extension_id']);
			$query = $this->db->update('extensions');
		} else {
			$this->db->set('type', 'theme');
			$this->db->set('name', $update['name']);
			$query = $this->db->insert('extensions');
		}

		if ($this->config->item($update['location'], 'default_themes') === $update['name'].'/') {
			$this->Settings_model->addSetting('prefs', $update['location'].'_active_style', $update, '1');
		}

		return $query;
	}

	public function updateLayout($update = array()) {
		$query = FALSE;

		if (!empty($update['name'])) {
			$this->db->set('name', $update['name']);
		}

		if (!empty($update['layout_id'])) {
			$this->db->where('layout_id', $update['layout_id']);
			$query = $this->db->update('layouts');
		}

		$this->db->where('layout_id', $update['layout_id']);
		$this->db->delete('layout_routes');

		if (is_array($update['routes'])) {
			foreach ($update['routes'] as $route) {
				$this->db->set('layout_id', $update['layout_id']);
				$this->db->set('uri_route', $route['uri_route']);
				$query = $this->db->insert('layout_routes');
			}
		}

		return $query;
	}

	public function updateBanner($update = array()) {
		$query = FALSE;

		if (!empty($update['name'])) {
			$this->db->set('name', $update['name']);
		}

		if (!empty($update['type'])) {
			$this->db->set('type', $update['type']);
		}

		if (!empty($update['click_url'])) {
			$this->db->set('click_url', $update['click_url']);
		}

		if (!empty($update['language_id'])) {
			$this->db->set('language_id', $update['language_id']);
		}

		if (!empty($update['alt_text'])) {
			$this->db->set('alt_text', $update['alt_text']);
		}

		if (!empty($update['custom_code'])) {
			$this->db->set('custom_code', $update['custom_code']);
		}

		if (!empty($update['image_code'])) {
			$this->db->set('image_code', serialize($update['image_code']));
		}

		if (!empty($update['status'])) {
			$this->db->set('status', $update['status']);
		}

		if (!empty($update['banner_id'])) {
			$this->db->where('banner_id', $update['banner_id']);
			$query = $this->db->update('banners');
		}

		return $query;
	}

	public function addLayout($add = array()) {
		$query = FALSE;

		if (!empty($add['name'])) {
			$this->db->set('name', $add['name']);
		}

		if ($this->db->insert('layouts')) {
			$layout_id = $this->db->insert_id();

			$this->db->where('layout_id', $layout_id);
			$this->db->delete('layout_routes');

			if (is_array($add['routes'])) {
				foreach ($add['routes'] as $route) {
					$this->db->set('layout_id', $layout_id);
					$this->db->set('uri_route', $route['uri_route']);
					$query = $this->db->insert('layout_routes');
				}
			}

			$query = $layout_id;
		}

		return $query;
	}

	public function addBanner($add = array()) {
		$query = FALSE;

		if (!empty($add['name'])) {
			$this->db->set('name', $add['name']);
		}

		if (!empty($add['type'])) {
			$this->db->set('type', $add['type']);
		}

		if (!empty($add['click_url'])) {
			$this->db->set('click_url', $add['click_url']);
		}

		if (!empty($add['language_id'])) {
			$this->db->set('language_id', $add['language_id']);
		}

		if (!empty($add['alt_text'])) {
			$this->db->set('alt_text', $add['alt_text']);
		}

		if (!empty($add['custom_code'])) {
			$this->db->set('custom_code', $add['custom_code']);
		}

		if (!empty($add['image_code'])) {
			$this->db->set('image_code', serialize($add['image_code']));
		}

		if (!empty($add['status'])) {
			$this->db->set('status', $add['status']);
		}
		if ($this->db->insert('banners')) {
			$banner_id = $this->db->insert_id();

			$query = $banner_id;
		}

		return $query;
	}

	public function deleteLayout($layout_id) {
		$this->db->where('layout_id', $layout_id);
		$this->db->delete('layouts');

		$this->db->where('layout_id', $layout_id);
		$this->db->delete('layout_routes');

		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}

	public function deleteBanner($banner_id) {
		$this->db->where('banner_id', $banner_id);
		$this->db->delete('banners');

		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}
}

/* End of file design_model.php */
/* Location: ./admin/models/design_model.php */