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
	public function find_all_by_path() {
		$result = $db_extensions = array();
		foreach ($this->find_all() as $row) {
			if (preg_match('/\s/', $row['name']) > 0 OR !$this->extensionExists($row['name'])) {
				$this->uninstall($row['name']);
				continue;
			}

			$row['title'] = !empty($row['title']) ? $row['title'] : '';
			$row['ext_data'] = ($row['serialized'] === '1' AND !empty($row['data'])) ? unserialize($row['data']) : array();
			unset($row['data']);

			$db_extensions[$row['name']] = $row;
		}

		foreach (Modules::paths() as $code => $path) {
			if (!($_extension = Modules::find_extension($code))) continue;

			$db_extension = isset($db_extensions[$code]) ? $db_extensions[$code] : array();

			$extension = $_extension->extensionMeta();
			$result[$code] = array_merge($extension, array(
				'code'         => $code,
				'extension_id' => isset($db_extension['extension_id']) ? $db_extension['extension_id'] : 0,
				'ext_data'     => isset($db_extension['ext_data']) ? $db_extension['ext_data'] : '',
				'settings'     => $_extension->registerSettings(),
				'installed'    => (!empty($db_extension) AND !Modules::is_disabled($code)) ? TRUE : FALSE,
				'status'       => (isset($db_extension['status']) AND $db_extension['status'] === '1') ? '1' : '0',
			));
		}

		return $result;
	}

	/**
	 * List all extensions matching the filter
	 *
	 * @param array $filter
	 *
	 * @return array
	 */
	public function getList($filter = array()) {
		$result = array();

		if (empty($this->extensions)) {
			$this->extensions = $this->filter($filter)->find_all_by_path();
		}

		foreach ($this->extensions as $code => $extension) {
			// filter extensions by enabled only
			if (isset($filter['filter_status']) AND $filter['filter_status'] !== '' AND $extension['status'] !== $filter['filter_status']) continue;

			if (!empty($filter['filter_installed']) AND $extension['installed'] !== TRUE) continue;

			$result[$code] = $extension;
		}

		if (!empty($filter['sort_by'])) {
			switch ($filter['sort_by']) {
				case 'name':
					usort($result, function ($x, $y) {
						return $x['name'] > $y['name'];
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

	public function paginate($filter = array(), $base_url = NULL) {
		$result = new stdClass;
		$result->pagination = $result->list = array();

		$result->list = $this->getList($filter);

		if (isset($filter['limit']) AND isset($filter['page'])) {
			$result->list = array_slice($result->list, ($filter['page'] - 1) * $filter['page'], $filter['limit']);
		}

		$config['base_url'] = $this->get_paginate_url();
		$config['total_rows'] = count($result->list);
		$config['per_page'] = isset($filter['limit']) ? $filter['limit'] : $this->config->item('page_limit');

		$result->pagination = $this->paginate_list($config);

		return $result;
	}

	/**
	 * Return all extensions MATCHING filter
	 *
	 * @param array $filter
	 *
	 * @return array
	 */
	public function getExtensions($filter = array()) {
		return $this->getList($filter);
	}

	/**
	 * Find a single extension by code
	 *
	 * @param string $code
	 * @param array  $filter
	 *
	 * @return array
	 */
	public function getExtension($code = '', $filter = array('filter_status' => '1')) {
		$result = array();

		if (!empty($code)) {
			$extensions = $this->getList($filter);
			if (!empty($extensions[$code]) AND is_array($extensions[$code])) {
				$result = $extensions[$code];
			}
		}

		return $result;
	}

	/**
	 * Find a single extension by code
	 *
	 * @param string $code
	 *
	 * @return array
	 */
	public function getSettings($code = '') {
		$result = array();

		if (!empty($code)) {
			$extensions = $this->getList();
			if (!empty($extensions[$code]['ext_data']) AND is_array($extensions[$code]['ext_data'])) {
				$result = $extensions[$code]['ext_data'];
			}
		}

		return $result;
	}

	/**
	 * Return all files within an extension folder
	 *
	 * @param string $code
	 * @param array  $files
	 *
	 * @return array|null
	 */
	public function getExtensionFiles($code = NULL, $files = array()) {
		if (!is_dir(ROOTPATH . EXTPATH . $code)) {
			return NULL;
		}

		foreach (glob(ROOTPATH . EXTPATH . $code . '/*') as $filepath) {
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
	 * Save extension permission to database
	 *
	 * @param array $permissions
	 *
	 * @return bool TRUE on success, FALSE on failure
	 */
	public function savePermissions($permissions) {
		if (empty($permissions)) return FALSE;

		$this->load->model('Permissions_model');
		$permissions = isset($permissions[0]) ? $permissions : array($permissions);

		foreach ($permissions as $name => $permission) {
			if (strstr($name, '.') AND !empty($permission['action'])) {
				$permission['name'] = $name;
				$permission['status'] = '1';
				$this->Permissions_model->savePermission(NULL, $permission);

				$this->load->model('Staff_groups_model');
				$this->Staff_groups_model->assignPermissionRule($this->user->getStaffGroupId(), $permission);
			}
		}
	}

	/**
	 * Delete extension permission from database
	 *
	 * @param array $permissions
	 *
	 * @return bool TRUE on success, FALSE on failure
	 */
	public function deletePermissions($permissions) {
		if (empty($permissions)) return FALSE;

		$this->load->model('Permissions_model');
		$permissions = isset($permissions[0]) ? $permissions : array($permissions);
		foreach ($permissions as $name => $permission) {
			if (strstr($name, '.') AND !empty($permission['action'])) {
				$this->Permissions_model->deletePermissionByName($permission['name']);
			}
		}
	}

	/**
	 * Create a new or update existing extension
	 *
	 * @param null  $code
	 * @param array $data
	 * @param bool  $log_activity
	 *
	 * @return bool TRUE on success, FALSE on failure
	 */
	public function saveExtensionData($code = NULL, $data = array(), $log_activity = FALSE) {
		if (empty($data)) return FALSE;

		!isset($data['ext_data']) OR $data = $data['ext_data'];

		return $this->updateSettings($code, $data, $log_activity);
	}

	/**
	 * Update existing extension
	 *
	 * @deprecated method, use updateSettings instead
	 *
	 * @param string $type
	 * @param null   $code
	 * @param array  $data
	 * @param bool   $log_activity
	 *
	 * @return bool TRUE on success, FALSE on failure
	 */
	public function updateExtension($type = 'module', $code = NULL, $data = array(), $log_activity = TRUE) {
		return $this->updateSettings($code, $data, $log_activity);
	}

	/**
	 * Update extension settings
	 *
	 * @param null  $code
	 * @param array $data
	 * @param bool  $log_activity
	 *
	 * @return bool TRUE on success, FALSE on failure
	 */
	public function updateSettings($code = NULL, $data = array(), $log_activity = TRUE) {
		$code = Modules::check_name($code);

		if ($code === NULL) return FALSE;

		!isset($data['data']) OR $data = $data['data'];
		unset($data['save_close']);

		$query = FALSE;

		if ($this->extensionExists($code)) {
			$extension = Modules::find_extension($code);

			if (!$extension instanceof Base_Extension) {
				return $query;
			}

			$this->where_in('type', array('module', 'payment'));
			$query = $this->update(array('name' => $code), array(
				'data'       => (is_array($data)) ? serialize($data) : $data,
				'serialized' => '1',
				'type'       => 'module',
			));

			if ($log_activity) {
				$meta = $extension->extensionMeta();
				log_activity($this->user->getStaffId(), 'updated', 'extensions', get_activity_message('activity_custom_no_link',
					array('{staff}', '{action}', '{context}', '{item}'),
					array($this->user->getStaffName(), 'updated', 'extension', $meta['name'])
				));
			}
		}

		return $query;
	}

	/**
	 * Update installed extensions config value
	 *
	 * @param string $extension
	 * @param bool $install
	 *
	 * @return bool TRUE on success, FALSE on failure
	 */
	public function updateInstalledExtensions($extension = NULL, $install = TRUE) {
		$installed_extensions = $this->config->item('installed_extensions');

		if (empty($installed_extensions) OR !is_array($installed_extensions)) {
			$this->load->model('Extensions_model');
			$this->Extensions_model->select('name')->where_in('type', array('module', 'payment'))->where('status', '1');
			if ($installed_extensions = $this->Extensions_model->find_all()) {
				$installed_extensions = array_flip(array_column($installed_extensions, 'name'));
				$installed_extensions = array_fill_keys(array_keys($installed_extensions), TRUE);
			}
		}

		if (!is_null($extension) AND $this->extensionExists($extension)) {
			if ($install) {
				$installed_extensions[$extension] = TRUE;
			} else {
				unset($installed_extensions[$extension]);
			}
		}

		$this->load->model('Settings_model');
		$this->Settings_model->addSetting('prefs', 'installed_extensions', $installed_extensions, '1');

	}

	/**
	 * Find an existing extension in filesystem by folder name
	 *
	 * @param string $code
	 *
	 * @return bool TRUE on success, FALSE on failure
	 */
	public function extensionExists($code) {
		return Modules::has_extension($code);
	}

	/**
	 * Install a new or existing extension by code
	 *
	 * @param string $code
	 * @param object $extension Extension
	 *
	 * @return bool|null
	 */
	public function install($code = '', $extension) {
		$code = url_title(strtolower($code), '-');

		if ($this->extensionExists($code) AND $extension instanceof Base_Extension) {
			$extension_id = NULL;
			$meta = $extension->extensionMeta();
			$title = !empty($meta['title']) ? $meta['title'] : NULL;

			$this->where_in('type', array('module', 'payment'));
			if ($row = $this->find('name', $code)) {
				$this->where_in('type', array('module', 'payment'));
				$query = $this->update(
					array('name' => $code),
					array('type' => 'module', 'title' => $title, 'status' => '1')
				);
				if ($query) $extension_id = $row['extension_id'];
			} else {
				$extension_id = $this->insert(
					array('title' => $title, 'status' => '1', 'type' => 'module', 'name' => $code)
				);
			}

			if (is_numeric($extension_id)) {
				$this->updateInstalledExtensions($code);

				$permissions = $extension->registerPermissions();
				$this->savePermissions($permissions);

				// set extension migration to the latest version
				Modules::run_migration($code);
			}

			return $extension_id;
		}

		return FALSE;
	}

	/**
	 * Uninstall a new or existing extension by code
	 *
	 * @param string $code
	 * @param object $extension Extension
	 *
	 * @return bool|null
	 */
	public function uninstall($code = '', $extension = NULL) {
		$query = FALSE;

		if ($this->extensionExists($code)) {
			if (preg_match('/\s/', $code) > 0) {
				$this->where_in('type', array('module', 'payment'));
				$query = $this->delete(array('name' => $code));
			} else {
				$this->where_in('type', array('module', 'payment'));
				$query = $this->update(array('name' => $code), array('status' => '0'));

				$this->updateInstalledExtensions($code, FALSE);

				if ($query AND $extension instanceof Base_Extension) {
					$permissions = $extension->registerPermissions();

					$this->deletePermissions($permissions);

					$query = TRUE;
				}
			}
		}

		return $query;
	}

	/**
	 * Delete a single extension by code
	 *
	 * @param string $code
	 * @param bool   $delete_data whether to delete extension data
	 *
	 * @return bool
	 */
	public function delete($code = '', $delete_data = TRUE) {
		$query = FALSE;

		if ($this->extensionExists($code)) {

			$this->where_in('type', array('module', 'payment'));
			$get_installed = $this->find(array('name' => $code, 'status' => '1'));
			if (empty($get_installed)) {
				$this->load->helper('file');
				delete_files(ROOTPATH . EXTPATH . $code, TRUE);
				rmdir(ROOTPATH . EXTPATH . $code);
				$query = TRUE;
			}

			if ($delete_data) {
				$this->where_in('type', array('module', 'payment'));
				$affected_rows = parent::delete(array('name' => $code, 'status' => '0'));
				if ($affected_rows > 0) {

					// downgrade extension migration
					Modules::run_migration($code);
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

		foreach (Modules::paths() as $code => $path) {
			if (!Modules::has_extension($code)) {
				$results[] = $path;
			}
		}

		return $results;
	}
}

/* End of file Extensions_model.php */
/* Location: ./system/tastyigniter/models/Extensions_model.php */