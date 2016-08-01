<?php if (!defined('BASEPATH')) exit('No direct access allowed');

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
class Extensions_model extends TI_Model
{
	/**
	 * @var string The database table name
	 */
	protected $table_name = 'extensions';

	/**
	 * @var string The database table primary key
	 */
	protected $primary_key = 'extension_id';

	/**
	 * @var array The database records
	 */
	protected $extensions = array();

	/**
	 * Return all extensions and build extension array
	 *
	 * @return array
	 */
	protected function extensions() {
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
			$extension['title'] = (!empty($installed_ext['title'])) ? $installed_ext['title'] : ucwords(str_replace('_module', '', $basename));

			$extension_meta = $this->extension->getMeta($basename, $config);
			$extension = array_merge($extension, $extension_meta);

			$extension['ext_data'] = isset($installed_ext['ext_data']) ? $installed_ext['ext_data'] : '';

			$extension['settings'] = !empty($extension_meta['settings']) AND file_exists($extension_path . '/controllers/admin_' . $basename . '.php') ? TRUE : FALSE;

			$extension['config'] = $config;

			$extension['meta'] = (!empty($extension_meta) AND is_array($extension_meta)) ? $extension_meta : array();

			$extension['installed'] = (!empty($installed_ext) AND $installed_ext['extension_id'] > 0) ? TRUE : FALSE;

			$extension['status'] = (isset($installed_ext['status']) AND $installed_ext['status'] === '1') ? '1' : '0';

			$extension_type = !empty($extension_meta['type']) ? $extension_meta['type'] : 'module';
			$extensions[$extension_type][$basename] = $extension;
		}

		return $extensions;
	}

	/**
	 * Count the number of records
	 *
	 * @param array $filter
	 *
	 * @return int
	 */
	public function getCount($filter = array()) {
		return $this->filter($filter)->count();
	}

	/**
	 * List all extensions matching the filter
	 *
	 * @param array $filter
	 *
	 * @return array
	 */
	public function getList($filter = array()) {
		$result = $this->extensions = array();

		foreach ($this->filter($filter)->extensions() as $type => $extensions) {

			if (!empty($filter['filter_type']) AND $type !== $filter['filter_type']) continue;

			foreach ($extensions as $name => $ext) {
				// filter extensions by enabled only
				if (!empty($filter['filter_status']) AND $ext['status'] !== $filter['filter_status']) continue;

				if (!empty($filter['filter_installed']) AND $ext['installed'] !== TRUE) continue;

				$result[$name] = $ext;
			}
		}

		if (!empty($filter['sort_by'])) {
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

			if (!empty($filter['order_by']) AND $filter['order_by'] === 'DESC') {
				$result = array_reverse($result);

				return $result;
			}
		}

		return $result;
	}

	public function filter($filter = array()) {
		if (!isset($filter['filter_type']) OR is_string($filter['filter_type'])) {
			$filter['filter_type'] = array('module', 'payment', 'widget');
		}

		if (!empty($filter['filter_type']) AND is_array($filter['filter_type'])) {
			$this->where_in('type', $filter['filter_type']);
		}

		return $this;
	}

	/**
	 * Return all extensions MATCHING filter
	 *
	 * @param array $filter
	 *
	 * @return array
	 */
	public function getExtensions($filter = array()) {
		return $this->filter($filter)->find_all();
	}

	/**
	 * Find a single extension by name
	 *
	 * @param string $name
	 * @param array  $filter
	 *
	 * @return array
	 */
	public function getExtension($name = '', $filter = array('filter_status' => '1')) {
		$result = array();

		if (!empty($name)) {
			$extensions = $this->getList($filter);

			if ($extensions AND is_array($extensions)) {
				if (isset($extensions[$name]) AND is_array($extensions[$name])) {
					$result = $extensions[$name];
				}
			}
		}

		return $result;
	}

	/**
	 * Return all installed extensions
	 *
	 * @param string $type       The extension type
	 * @param bool   $is_enabled The extension status
	 *
	 * @return array
	 */
	public function getInstalledExtensions($type = '', $is_enabled = TRUE) {

		if (empty($this->extensions)) {
			$this->extensions = $this->find_all();
		}

		$type = empty($type) ? array('module', 'payment', 'widget') : array($type);

		$result = array();

		if (!empty($this->extensions)) {
			foreach ($this->extensions as $name => $row) {
				if (preg_match('/\s/', $row['name']) > 0 OR !$this->extensionExists($row['name'])) {
					$this->uninstall($row['type'], $row['name']);
					continue;
				}

				if (!in_array($row['type'], $type)) continue;

				if ($is_enabled === TRUE AND $row['status'] !== '1') continue;

				$row['ext_data'] = ($row['serialized'] === '1' AND !empty($row['data'])) ? unserialize($row['data']) : array();
				unset($row['data']);
				$row['title'] = !empty($row['title']) ? $row['title'] : ucwords(str_replace('_module', '', $row['name']));
				$result[$row['name']] = $row;
			}
		}

		return $result;
	}

	/**
	 * Return all installed module extensions
	 *
	 * @return array
	 */
	public function getModules() {
		return $this->getInstalledExtensions('module', TRUE);
	}

	/**
	 * Return all installed payment extensions
	 *
	 * @return array
	 */
	public function getPayments() {
		return $this->getInstalledExtensions('payment', TRUE);
	}

	/**
	 * Find a single module extension by name
	 *
	 * @param string $name
	 *
	 * @return array
	 */
	public function getModule($name = '') {
		$result = array();

		if (!empty($name) AND is_string($name)) {
			$extensions = $this->getInstalledExtensions('module', TRUE);

			if ($extensions AND is_array($extensions)) {
				if (isset($extensions[$name]) AND is_array($extensions[$name])) {
					$result = $extensions[$name];
				}
			}
		}

		return $result;
	}

	/**
	 * Find a single payment extension by name
	 *
	 * @param string $name
	 *
	 * @return array
	 */
	public function getPayment($name = '') {
		$result = array();

		if (!empty($name) AND is_string($name)) {
			$extensions = $this->getInstalledExtensions('payment', TRUE);

			if ($extensions AND is_array($extensions)) {
				if (isset($extensions[$name]) AND is_array($extensions[$name])) {
					$result = $extensions[$name];
				}
			}
		}

		return $result;
	}

	/**
	 * Create a new or update existing extension
	 *
	 * @param null  $name
	 * @param array $data
	 * @param bool  $log_activity
	 *
	 * @return bool TRUE on success, FALSE on failure
	 */
	public function saveExtensionData($name = NULL, $data = array(), $log_activity = FALSE) {
		if (empty($data)) return FALSE;

		!isset($data['ext_data']) OR $data = $data['ext_data'];

		return $this->updateExtension(FALSE, $name, $data, $log_activity);
	}

	/**
	 * Update existing extension
	 *
	 * @param string $type
	 * @param null   $name
	 * @param array  $data
	 * @param bool   $log_activity
	 *
	 * @return bool TRUE on success, FALSE on failure
	 */
	public function updateExtension($type = 'module', $name = NULL, $data = array(), $log_activity = TRUE) {
		if ($name === NULL) return FALSE;

		$name = url_title(strtolower($name), '-');

		!isset($data['data']) OR $data = $data['data'];
		unset($data['save_close']);

		$query = FALSE;

		if ($this->extensionExists($name)) {
			$config = $this->extension->loadConfig($name, FALSE, TRUE);
			$meta = $this->extension->getMeta($name, $config);

			if ($type === FALSE) $type = $meta['type'];

			if (isset($meta['type'], $meta['title']) AND $type === $meta['type']) {

				$query = $this->update(array('type' => $meta['type'], 'name' => $name), array(
					'data'       => (is_array($data)) ? serialize($data) : $data,
					'serialized' => '1',
				));

				if ($log_activity) {
					log_activity($this->user->getStaffId(), 'updated', 'extensions', get_activity_message('activity_custom_no_link',
						array('{staff}', '{action}', '{context}', '{item}'),
						array($this->user->getStaffName(), 'updated', $meta['type'] . ' extension', $meta['title'])
					));
				}
			}
		}

		return $query;
	}

	/**
	 * Find an existing extension in filesystem by folder name
	 *
	 * @param string $extension_name
	 *
	 * @return bool TRUE on success, FALSE on failure
	 */
	public function extensionExists($extension_name) {

		if (!empty($extension_name) AND $modules_locations = $this->config->item('modules_locations')) {
			foreach ($modules_locations as $location => $offset) {
				if (is_dir($location . $extension_name)) {
					return TRUE;
				}
			}
		}

		return FALSE;
	}

	/**
	 * Extract uploaded extension zip folder
	 *
	 * @param array  $file $_FILES input
	 * @param string $module
	 *
	 * @return bool TRUE on success, FALSE on failure
	 */
	public function extractExtension($file = array(), $module = NULL) {
		if (isset($file['tmp_name']) AND class_exists('ZipArchive')) {

			$zip = new ZipArchive;

			chmod($file['tmp_name'], DIR_READ_MODE);

			$EXTPATH = ROOTPATH . EXTPATH;

			if ($zip->open($file['tmp_name']) === TRUE) {
				$extension_dir = $zip->getNameIndex(0);

				if (preg_match('/\s/', $extension_dir) OR file_exists($EXTPATH . '/' . $extension_dir)) {
					return $this->lang->line('error_extension_exists');
				}

				$zip->extractTo($EXTPATH);
				$zip->close();

				return TRUE;
			}
		}

		return FALSE;
	}

	/**
	 * Return all files within an extension folder
	 *
	 * @param string $extension_name
	 * @param array  $files
	 *
	 * @return array|null
	 */
	public function getExtensionFiles($extension_name = NULL, $files = array()) {
		if (!is_dir(ROOTPATH . EXTPATH . $extension_name)) {
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

	/**
	 * Install a new or existing extension by type and name
	 *
	 * @param string $type
	 * @param string $name
	 * @param string $config
	 *
	 * @return bool|null
	 */
	public function install($type = '', $name = '', $config = NULL) {

		if (!empty($type) AND !empty($name)) {
			$name = url_title(strtolower($name), '-');

			if ($this->extensionExists($name) AND is_array($config)) {
				$extension_id = NULL;

				$title = !empty($config['extension_meta']['title']) ? $config['extension_meta']['title'] : NULL;

				if ($row = $this->find(array('type' => $type, 'name' => $name))) {
					$query = $this->update(array('type' => $type, 'name' => $name), array('title' => $title, 'status' => '1'));
					if ($query) $extension_id = $row['extension_id'];
				} else {
					$extension_id = $this->insert(array('title' => $title, 'status' => '1', 'type' => $type, 'name' => $name));
				}

				if (is_numeric($extension_id)) {
					if (!empty($config['extension_permission']) AND !empty($config['extension_permission']['name'])) {
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

	/**
	 * Uninstall a new or existing extension by type and name
	 *
	 * @param string $type
	 * @param string $name
	 * @param null   $config
	 *
	 * @return bool
	 */
	public function uninstall($type = '', $name = '', $config = NULL) {
		$query = FALSE;

		if (!empty($type) AND $this->extensionExists($name)) {

			if (preg_match('/\s/', $name) > 0) {
				$query = $this->delete(array('type' => $type, 'name' => $name));
			} else {
				$query = $this->update(array('type' => $type, 'name' => $name), array('status' => '0'));

				if ($query) {
					is_array($config) OR $config = $this->extension->loadConfig($name, FALSE, TRUE);

					if (!empty($config['extension_permission']['name'])) {
						$this->Permissions_model->deletePermissionByName($config['extension_permission']['name']);
					}

					$query = TRUE;
				}
			}
		}

		return $query;
	}

	/**
	 * Delete a single extension by type and name
	 *
	 * @param string $type
	 * @param string $name
	 * @param bool   $delete_data
	 *
	 * @return bool
	 */
	public function delete($type = '', $name = '', $delete_data = TRUE) {
		$query = FALSE;

		if (!empty($type) AND $this->extensionExists($name)) {

			$get_installed = $this->find(array('type' => $type, 'name' => $name, 'status' => '1'));
			if (empty($get_installed)) {
				$this->load->helper('file');
				delete_files(ROOTPATH . EXTPATH . $name, TRUE);
				rmdir(ROOTPATH . EXTPATH . $name);
				$query = TRUE;
			}

			if ($delete_data) {
				$affected_rows = parent::delete(array('type' => $type, 'name' => $name, 'status' => '0'));
				if ($affected_rows > 0) {

					// downgrade extension migration
					$this->extension->runMigration($name, TRUE);
					$query = TRUE;
				}
			}
		}

		return $query;
	}

	/**
	 * Return all extension paths
	 *
	 * @return array
	 */
	protected function fetchExtensionsPath() {
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

/* End of file Extensions_model.php */
/* Location: ./system/tastyigniter/models/Extensions_model.php */