<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package   TastyIgniter
 * @author    SamPoyigi
 * @copyright TastyIgniter
 * @link      http://tastyigniter.com
 * @license   http://opensource.org/licenses/GPL-3.0 The GNU GENERAL PUBLIC LICENSE
 * @since     File available since Release 1.0
 */
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Themes Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Themes_model.php
 * @link           http://docs.tastyigniter.com
 */
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
					'child'        => ! empty($theme['config']['child']) ? $theme['config']['child'] : '',
					'parent'       => ! empty($theme['config']['parent']) ? $theme['config']['parent'] : '',
					'data'         => ! empty($db_theme['data']) ? $db_theme['data'] : array(),
					'config'       => $theme['config'],
					'customize'    => (isset($theme['config']['customize']) AND ! empty($theme['config']['customize'])) ? TRUE : FALSE,
				);
			}

			foreach ($results as $name => &$theme) {
				if (!empty($theme['parent'])) {
					$results[$theme['parent']]['child'] = array();
					$results[$theme['parent']]['child'][$name] = $theme;
				}
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

			unset($default_themes[MAINDIR.'_parent']);
			if (!empty($theme['parent'])) {
				$default_themes[MAINDIR.'_parent'] = $theme['parent'] . '/';
			}

			$this->load->model('Settings_model');
			if ($this->Settings_model->addSetting('prefs', 'default_themes', $default_themes, '1')) {
				$query = $theme['title'];
			}

			if ($query !== FALSE) {
				$active_theme_options = $this->config->item('active_theme_options');
				$active_theme_options[MAINDIR] = array($theme['name'], $theme['data']);

				$this->Settings_model->deleteSettings('prefs', 'customizer_active_style');  //@to-do remove in next version release
				$this->Settings_model->addSetting('prefs', 'active_theme_options', $active_theme_options, '1');
			}

		}

		return $query;
	}

	public function updateTheme($update = array()) {
		if (empty($update)) return FALSE;

		$this->db->set('status', '1');

		if ( ! empty($update['data'])) {
			$this->db->set('data', serialize($update['data']));
			$this->db->set('serialized', '1');
		} else {
			$update['data'] = array();
		}

		if (isset($update['title'])) {
			$this->db->set('title', $update['title']);
		}

		if (isset($update['version'])) {
			$this->db->set('version', $update['version']);
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

	public function extractTheme($file = array(), $domain = MAINDIR) {
		if (isset($file['tmp_name']) AND class_exists('ZipArchive')) {

			$zip = new ZipArchive;

			chmod($file['tmp_name'], DIR_READ_MODE);

			$THEMEPATH = ROOTPATH . $domain . '/views/themes';

			if ($zip->open($file['tmp_name']) === TRUE) {
				$theme_dir = $zip->getNameIndex(0);

				if (preg_match('/\s/', $theme_dir) OR file_exists($THEMEPATH .'/'. $theme_dir)) {
					return $this->lang->line('error_theme_exists');
				}

				$zip->extractTo($THEMEPATH);
				$zip->close();

				return TRUE;
			}
		}

		return FALSE;
	}

	public function copyTheme($theme_name = NULL, $files = array(), $copy_data = TRUE) {
		$query = FALSE;

		if ( ! empty($theme_name)) {

			$this->db->where('type', 'theme');
			$this->db->where('name', $theme_name);

			$query = $this->db->get('extensions');
			if ($query->num_rows() === 1) {
				$row = $query->row_array();

				unset($row['extension_id']);
				$row['name'] = $this->findThemeName("{$row['name']}-child");
				$row['old_title'] = $row['title'];
				$row['title'] = "{$row['title']} Child Theme";
				$row['data'] = ($copy_data AND $row['serialized'] === '1') ? unserialize($row['data']) : array();

				if ($query = $this->updateTheme($row)) {
					$query = create_child_theme_files($files, $theme_name, $row);
				}
			}
		}

		return $query;
	}

	protected function findThemeName($theme_name, $count = 0) {
		$tmp_name = ($count > 0) ? "{$theme_name}-{$count}" : $theme_name;
		$theme = $this->db->where('type', 'theme')->where('name', $tmp_name)->get('extensions')->num_rows();

		if (!empty($theme) OR is_dir(ROOTPATH . MAINDIR ."/views/themes/{$tmp_name}")) {
			$count++;
			return $this->findThemeName($theme_name, $count);
		}

		return $tmp_name;
	}

	public function deleteTheme($theme_name = NULL, $delete_data = TRUE) {
		$query = FALSE;

		if ( ! empty($theme_name)) {

			if ($delete_data) {
				$this->db->where('type', 'theme');
				$this->db->where('name', $theme_name);

				$this->db->delete('extensions');
				if ($this->db->affected_rows() > 0) {
					$query = TRUE;
				}
			}

			return delete_theme($theme_name);
		}

		return $query;
	}
}