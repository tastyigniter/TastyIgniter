<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

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
 * Extensions Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Extensions_model.php
 * @link           http://docs.tastyigniter.com
 */
class Extensions_model extends TI_Model {

	private $extensions = array();

	private function extensions() {
		$extensions = array();

		$installed_extensions = $this->getInstalledExtensions(NULL, FALSE);
		$extension_paths = $this->fetchExtensionsPath();

		foreach ($extension_paths as $extension_path) {
			$extension = array();

			$basename = basename($extension_path);

			$installed_ext = isset($installed_extensions[$basename]) ? $installed_extensions[$basename] : array();

			$config = $this->extension->loadConfig($basename, FALSE, TRUE);

			$extension['extension_id'] = isset($installed_ext['extension_id']) ? $installed_ext['extension_id'] : 0;
			$extension['name'] = $basename;
			$extension['title'] = ( ! empty($installed_ext['title'])) ? $installed_ext['title'] : ucwords(str_replace('_module', '', $basename));

			$extension_meta = $this->extension->getMeta($basename, $config);
			$extension = array_merge($extension, $extension_meta);

			$extension['ext_data'] = isset($installed_ext['ext_data']) ? $installed_ext['ext_data'] : '';

			$extension['settings'] = ! empty($extension_meta['settings'])
			AND file_exists($extension_path . '/controllers/admin_' . $basename . '.php') ? TRUE : FALSE;

			$extension['config'] = $config;

			$extension['meta'] = ( ! empty($extension_meta) AND is_array($extension_meta)) ? $extension_meta : array();

			$extension['installed'] = ( ! empty($installed_ext) AND $installed_ext['extension_id'] > 0) ? TRUE : FALSE;

			$extension['status'] = (isset($installed_ext['status']) AND $installed_ext['status'] === '1') ? '1' : '0';

			$extension_type = ! empty($extension_meta['type']) ? $extension_meta['type'] : 'module';
			$extensions[$extension_type][$basename] = $extension;
		}

		return $extensions;
	}

	public function getList($filter = array()) {
		$result = array();

		foreach ($this->extensions() as $type => $extensions) {

			if ( ! empty($filter['filter_type']) AND $type !== $filter['filter_type']) continue;

			foreach ($extensions as $name => $ext) {
				// filter extensions by enabled only
				if ( ! empty($filter['filter_status']) AND $ext['status'] !== $filter['filter_status']) continue;

				if ( ! empty($filter['filter_installed']) AND $ext['installed'] !== TRUE) continue;

				$result[$name] = $ext;
			}
		}

		if ( ! empty($filter['sort_by'])) {
			switch ($filter['sort_by']) {
				case 'name':
					usort($result, function ($x, $y) {
						return $x['name'] > $y['name'];
					});
					break;
				case 'type':
					usort($result, function ($x, $y) {
						return $x['type'] > $y['type'];
					});
					break;
			}

			if ( ! empty($filter['order_by']) AND $filter['order_by'] === 'DESC') {
				$result = array_reverse($result);

				return $result;
			}
		}

		return $result;
	}

	public function getExtension($name = '', $filter = array('filter_status' => '1')) {
		$result = array();

		if ( ! empty($name)) {
			$extensions = $this->getList($filter);

			if ($extensions AND is_array($extensions)) {
				if (isset($extensions[$name]) AND is_array($extensions[$name])) {
					$result = $extensions[$name];
				}
			}
		}

		return $result;
	}

	public function getInstalledExtensions($type = '', $is_enabled = TRUE) {

		if (empty($this->extensions)) {
			$this->db->from('extensions');

			$query = $this->db->get();
			$this->extensions = $query->result_array();
		}

		$type = empty($type) ? array('module', 'payment', 'widget') : array($type);

		$result = array();

		if (!empty($this->extensions)) {
			foreach ($this->extensions as $name => $row) {
				if (preg_match('/\s/', $row['name']) > 0 OR ! $this->extensionExists($row['name'])) {
					$this->uninstall($row['type'], $row['name']);
					continue;
				}

				if ( ! in_array($row['type'], $type)) continue;

				if ($is_enabled === TRUE AND $row['status'] !== '1') continue;

				$row['ext_data'] = ($row['serialized'] === '1' AND ! empty($row['data'])) ? unserialize($row['data']) : array();
				unset($row['data']);
				$row['title'] = ! empty($row['title']) ? $row['title'] : ucwords(str_replace('_module', '',
																							 $row['name']));
				$result[$row['name']] = $row;
			}
		}

		return $result;
	}

	public function getModules() {
		return $this->getInstalledExtensions('module', TRUE);
	}

	public function getPayments() {
		return $this->getInstalledExtensions('payment', TRUE);
	}

	public function getModule($name = '') {
		$result = array();

		if ( ! empty($name) AND is_string($name)) {
			$extensions = $this->getInstalledExtensions('module', TRUE);

			if ($extensions AND is_array($extensions)) {
				if (isset($extensions[$name]) AND is_array($extensions[$name])) {
					$result = $extensions[$name];
				}
			}
		}

		return $result;
	}

	public function getPayment($name = '') {
		$result = array();

		if ( ! empty($name) AND is_string($name)) {
			$extensions = $this->getInstalledExtensions('payment', TRUE);

			if ($extensions AND is_array($extensions)) {
				if (isset($extensions[$name]) AND is_array($extensions[$name])) {
					$result = $extensions[$name];
				}
			}
		}

		return $result;
	}

	public function saveExtensionData($name = NULL, $data = array(), $log_activity = FALSE) {
		if (empty($data)) return FALSE;

		! isset($data['ext_data']) OR $data = $data['ext_data'];

		return $this->updateExtension(FALSE, $name, $data, $log_activity);
	}

	public function updateExtension($type = 'module', $name = NULL, $data = array(), $log_activity = TRUE) {
		if ($name === NULL) return FALSE;

		$name = url_title(strtolower($name), '-');

		! isset($data['data']) OR $data = $data['data'];
		unset($data['save_close']);

		$query = FALSE;

		if ($this->extensionExists($name)) {
			$config = $this->extension->loadConfig($name, FALSE, TRUE);
			$meta = $this->extension->getMeta($name, $config);

			if ($type === FALSE) $type = $meta['type'];

			if (isset($meta['type'], $meta['title']) AND $type === $meta['type']) {
				$this->db->set('data', (is_array($data)) ? serialize($data) : $data);

				$this->db->set('serialized', '1');

				$this->db->where('type', $meta['type']);
				$this->db->where('name', $name);

				$query = $this->db->update('extensions');

				if ($log_activity) {
					log_activity($this->user->getStaffId(), 'updated', 'extensions', get_activity_message('activity_custom_no_link', array('{staff}', '{action}', '{context}',
						'{item}'), array($this->user->getStaffName(), 'updated', $meta['type'].' extension', $meta['title'])
					));
				}
			}
		}

		return $query;
	}

	public function extensionExists($extension_name) {

		if ( ! empty($extension_name) AND $modules_locations = $this->config->item('modules_locations')) {
			foreach ($modules_locations as $location => $offset) {
				if (is_dir($location . $extension_name)) {
					return TRUE;
				}
			}
		}

		return FALSE;
	}

	public function extractExtension($file = array(), $module = NULL) {
		if (isset($file['tmp_name']) AND class_exists('ZipArchive')) {

			$zip = new ZipArchive;

			chmod($file['tmp_name'], DIR_READ_MODE);

			$EXTPATH = ROOTPATH . EXTPATH;

			if ($zip->open($file['tmp_name']) === TRUE) {
				$extension_dir = $zip->getNameIndex(0);

				if (preg_match('/\s/', $extension_dir) OR file_exists($EXTPATH .'/'. $extension_dir)) {
					return $this->lang->line('error_extension_exists');
				}

				$zip->extractTo($EXTPATH);
				$zip->close();

				return TRUE;
			}
		}

		return FALSE;
	}

	public function getExtensionFiles($extension_name = NULL, $files = array()) {
		if ( ! is_dir(ROOTPATH . EXTPATH . $extension_name)) {
			return NULL;
		}

		foreach (glob(ROOTPATH . EXTPATH . $extension_name . '/*') as $filepath) {
			$filename = str_replace(ROOTPATH . EXTPATH, '', $filepath);

			if (is_dir($filepath)) {
				$files = $this->getExtensionFiles($filename, $files);
			} else {
				$files[] = EXTPATH . $filename;
			}
		}

		return $files;
	}

	public function install($type = '', $name = '', $config = NULL) {

		if ( ! empty($type) AND ! empty($name)) {
			$name = url_title(strtolower($name), '-');

			if ($this->extensionExists($name) AND is_array($config)) {
				$extension_id = NULL;

				$title = !empty($config['extension_meta']['title']) ? $config['extension_meta']['title'] : NULL;

				$query = $this->db->where('type', $type)->where('name', $name)->get('extensions');

				if ($query->num_rows() === 1) {
					$row = $query->row_array();
					$this->db->set('title', $title);
					$this->db->set('status', '1');
					$this->db->where('type', $type);
					$this->db->where('name', $name);
					if ($query = $this->db->update('extensions')) $extension_id = $row['extension_id'];
				} else {
					$this->db->set('title', $title);
					$this->db->set('status', '1');
					$this->db->set('type', $type);
					$this->db->set('name', $name);
					if ($query = $this->db->insert('extensions')) $extension_id = $this->db->insert_id();
				}

				if ($query === TRUE) {
					if ( ! empty($config['extension_permission']) AND ! empty($config['extension_permission']['name'])) {
						$config['extension_permission']['status'] = '1';
						$this->Permissions_model->savePermission(NULL, $config['extension_permission']);

						$this->load->model('Staff_groups_model');
						$this->Staff_groups_model->assignPermissionRule($this->user->getStaffGroupId(), $config['extension_permission']);
					}

					// set extension migration to the latest version
					$this->extension->runMigration($name);
				}

				return $extension_id;
			}
		}

		return FALSE;
	}

	public function uninstall($type = '', $name = '', $config = NULL) {
		$query = FALSE;

		if ( ! empty($type) AND $this->extensionExists($name)) {

			$this->db->set('status', '0');
			$this->db->where('type', $type);
			$this->db->where('name', $name);

			if (preg_match('/\s/', $name) > 0) {
				$query = $this->delete($name);
			} else {
				$this->db->update('extensions');
				if ($this->db->affected_rows() > 0) {

					is_array($config) OR $config = $this->extension->loadConfig($name, FALSE, TRUE);

					if ( ! empty($config['extension_permission']['name'])) {
						$this->Permissions_model->deletePermissionByName($config['extension_permission']['name']);
					}

					$query = TRUE;
				}
			}
		}

		return $query;
	}

	public function delete($type = '', $name = '', $delete_data = TRUE) {
		$query = FALSE;

		if ( ! empty($type) AND $this->extensionExists($name)) {

			$get_installed = $this->db->where('status', '1')->where('type', $type)->where('name', $name)->get('extensions')->row();
			if (empty($get_installed)) {
				$this->load->helper('file');
				delete_files(ROOTPATH . EXTPATH . $name, TRUE);
				rmdir(ROOTPATH . EXTPATH . $name);

				$query = TRUE;
			}

			if ($delete_data) {
				$this->db->where('status', '0');
				$this->db->where('type', $type);
				$this->db->where('name', $name);

				$this->db->delete('extensions');
				if ($this->db->affected_rows() > 0) {

					// downgrade extension migration
					$this->extension->runMigration($name, TRUE);

					$query = TRUE;
				}
			}
		}

		return $query;
	}

	private function fetchExtensionsPath() {
		$results = array();

		if ($modules_locations = $this->config->item('modules_locations')) {
			foreach ($modules_locations as $location => $offset) {
				foreach (glob($location . '*', GLOB_ONLYDIR) as $extension_path) {
					if (is_dir($extension_path) OR is_file($extension_path . '/config/' . basename($extension_path) . '.php')) {
						$results[] = $extension_path;
					}
				}
			}
		}

		return $results;
	}
}

/* End of file extensions_model.php */
/* Location: ./system/tastyigniter/models/extensions_model.php */