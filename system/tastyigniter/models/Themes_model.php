<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Themes_model extends TI_Model {

	public function getList() {
		$themes = $this->getThemes();
		$themes_list = list_themes();

		$results = array();

		if ( ! empty($themes) AND ! empty($themes_list)) {
			foreach ($themes_list as $theme) {
				if ($theme['location'] === ADMINDIR) continue;

				$db_theme = (isset($themes[$theme['basename']]) AND ! empty($themes[$theme['basename']])) ? $themes[$theme['basename']] : array();

				$extension_id = ( ! empty($db_theme['extension_id'])) ? $db_theme['extension_id'] : 0;
				$theme_name = ( ! empty($db_theme['name'])) ? $db_theme['name'] : $theme['basename'];

				$results[$theme['basename']] = array(
					'extension_id' => $extension_id,
					'name'         => $theme_name,
					'title'        => isset($theme['config']['title']) ? $theme['config']['title'] : $theme_name,
					'version'      => isset($theme['config']['version']) ? $theme['config']['version'] : '',
					'description'  => isset($theme['config']['description']) ? $theme['config']['description'] : '',
					'author'       => isset($theme['config']['author']) ? $theme['config']['author'] : '',
					'screenshot'   => root_url($theme['path'] . '/screenshot.png'),
					'path'         => $theme['path'],
					'is_writable'  => is_writable($theme['path']),
					'config'       => $theme['config'],
					'data'         => ! empty($db_theme['data']) ? $db_theme['data'] : array(),
					'customize'    => (isset($theme['config']['customize']) AND ! empty($theme['config']['customize'])) ? TRUE : FALSE,
				);
			}
		}

		return $results;
	}

	public function getThemes() {
		$this->db->from('extensions');
		$this->db->where('type', 'theme');
		$query = $this->db->get();

		$results = array();

		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$row['data'] = ($row['serialized'] === '1' AND ! empty($row['data'])) ? unserialize($row['data']) : array();
				$results[$row['name']] = $row;
			}
		}

		return $results;
	}

	public function getTheme($name = '') {
		$results = array();

		if ( ! empty($name)) {
			$themes_list = $this->getList();

			if ( ! empty($themes_list) AND is_array($themes_list)) {
				if (isset($themes_list[$name]) AND is_array($themes_list[$name])) {
					$results = $themes_list[$name];
				}
			}
		}

		return $results;
	}

	public function activateTheme($name) {
		$query = FALSE;

		if ( ! empty($name) AND $theme = $this->getTheme($name)) {
			$default_themes = $this->config->item('default_themes');
			$default_themes[MAINDIR] = $name . '/';

			$this->load->model('Settings_model');
			if ($this->Settings_model->addSetting('prefs', 'default_themes', $default_themes, '1')) {
				$query = $theme['title'];
			}
		}

		return $query;
	}

	public function updateTheme($update = array()) {
		if (empty($update)) return FALSE;

		if ($this->config->item(MAINDIR, 'default_themes') === $update['name'] . '/') {
			$this->db->set('status', '1');
		} else {
			$this->db->set('status', '0');
		}

		if ( ! empty($update['data'])) {
			$this->db->set('data', serialize($update['data']));
			$this->db->set('serialized', '1');
		} else {
			$update['data'] = array();
		}

		if (isset($update['title'])) {
			$this->db->set('title', $update['title']);
		}

		if ( ! empty($update['extension_id']) AND ! empty($update['name'])) {
			$this->db->where('type', 'theme');
			$this->db->where('name', $update['name']);
			$this->db->where('extension_id', $update['extension_id']);
			$query = $this->db->update('extensions');
		} else if ( ! empty($update['name'])) {
			$this->db->set('type', 'theme');
			$this->db->set('name', $update['name']);
			$query = $this->db->insert('extensions');
		}

		if ($query === TRUE) {
			$active_theme_options = $this->config->item('active_theme_options');
			$active_theme_options[MAINDIR] = array($update['name'], $update['data']);

			if ($this->config->item(MAINDIR, 'default_themes') === $update['name'] . '/') {
				$this->Settings_model->deleteSettings('prefs', 'customizer_active_style');  //@to-do remove in next version release
				$this->Settings_model->addSetting('prefs', 'active_theme_options', $active_theme_options, '1');
			}
		}

		return $query;
	}
}

