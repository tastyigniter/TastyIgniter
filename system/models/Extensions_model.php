<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package Igniter
 * @author Samuel Adepoyigi
 * @copyright (c) 2013 - 2016. Samuel Adepoyigi
 * @copyright (c) 2016 - 2017. TastyIgniter Dev Team
 * @link https://tastyigniter.com
 * @license http://opensource.org/licenses/MIT The MIT License
 * @since File available since Release 1.0
 */
if (!defined('BASEPATH')) exit('No direct access allowed');

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

use Igniter\Core\BaseExtension;
use Igniter\Database\Model;

/**
 * Extensions Model Class
 *
 * @category       Models
 * @package        Igniter\Models\Extensions_model.php
 * @link           http://docs.tastyigniter.com
 */
class Extensions_model extends Model
{
	/**
	 * @var string The database table name
	 */
	protected $table = 'extensions';

	/**
	 * @var string The database table primary key
	 */
	protected $primaryKey = 'extension_id';

	protected $fillable = ['extension_id', 'type', 'name', 'data', 'serialized', 'status', 'title', 'version'];

	/**
	 * @var array The database records
	 */
	protected $extensions = [];

	/**
	 * Return all extensions and build extension array
	 *
	 * @return array
	 */
	public function findAllByPath()
	{
		$result = $db_extensions = [];
		foreach ($this->getFilterQuery()->getAsArray() as $row) {
			if (preg_match('/\s/', $row['name']) > 0 OR !$this->extensionExists($row['name'])) {
				$this->uninstall($row['name']);
				continue;
			}

			$row['title'] = !empty($row['title']) ? $row['title'] : '';
			$row['ext_data'] = ($row['serialized'] == '1' AND !empty($row['data'])) ? unserialize($row['data']) : [];
			unset($row['data']);

			$db_extensions[$row['name']] = $row;
		}

		foreach (Modules::paths() as $code => $path) {
			if (!($extensionClass = Modules::find_extension($code))) continue;

			$db_extension = isset($db_extensions[$code]) ? $db_extensions[$code] : [];

			$extension = $extensionClass->extensionMeta();
			$result[$code] = array_merge($extension, [
				'code'         => $code,
				'extension_id' => isset($db_extension['extension_id']) ? $db_extension['extension_id'] : 0,
				'ext_data'     => isset($db_extension['ext_data']) ? $db_extension['ext_data'] : '',
				'settings'     => $extensionClass->registerSettings(),
				'installed'    => (!empty($db_extension)) ? TRUE : FALSE,
				'disabled'    	=> $extensionClass->disabled,
				'status'       => (isset($db_extension['status']) AND $db_extension['status'] == '1') ? '1' : '0',
			]);
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
	public function getList($filter = [])
	{
		$result = [];

		if (empty($this->extensions)) {
			$this->extensions = $this->setFilterQuery($this->filter($filter))->findAllByPath();
		}

		foreach ($this->extensions as $code => $extension) {
			// filter extensions by enabled only
			if (isset($filter['filter_status']) AND $filter['filter_status'] != '' AND $extension['status'] != $filter['filter_status']) continue;

			if (!empty($filter['filter_installed']) AND $extension['installed'] != TRUE) continue;

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

	public function scopeFilter($query, $filter = [])
	{
		if (!isset($filter['filter_type']) OR is_string($filter['filter_type'])) {
			$filter['filter_type'] = ['module', 'payment', 'widget'];
		}

		if (!empty($filter['filter_type']) AND is_array($filter['filter_type'])) {
			$query->whereIn('type', $filter['filter_type']);
		}

		return $query;
	}

	public function paginateWithFilter($filter = [])
	{
		$result = new stdClass;
		$result->pagination = $result->list = [];

		$result->list = $this->getList($filter);

		$config['base_url'] = $this->getCurrentUrl();
		$config['total_rows'] = count($result->list);
		$config['per_page'] = isset($filter['limit']) ? $filter['limit'] : $this->config->item('page_limit');

		if (isset($filter['limit']) AND isset($filter['page'])) {
			$result->list = array_slice($result->list, ($filter['page'] - 1) * $filter['page'], $filter['limit']);
		}

		$result->pagination = $this->buildPaginateHtml($config);

		return $result;
	}

	/**
	 * Return all extensions MATCHING filter
	 *
	 * @param array $filter
	 *
	 * @return array
	 */
	public function getExtensions($filter = [])
	{
		return $this->getList($filter);
	}

	/**
	 * Find a single extension by code
	 *
	 * @param string $code
	 * @param array $filter
	 *
	 * @return array
	 */
	public function getExtension($code = '', $filter = ['filter_status' => '1'])
	{
		$result = [];

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
	public function getSettings($code = '')
	{
		$result = [];

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
	 * @deprecated since 2.2.0 use Modules::files_path() instead
	 *
	 * @param string $code
	 * @param array $files
	 *
	 * @return array|null
	 */
	public function getExtensionFiles($code = null, $files = [])
	{
		return Modules::files_path($code);
	}

	/**
	 * Save extension permission to database
	 *
	 * @param array $permissions
	 *
	 * @return bool TRUE on success, FALSE on failure
	 */
	public function savePermissions($permissions)
	{
		if (empty($permissions)) return FALSE;

		$this->load->model('Staff_groups_model');
		$this->load->model('Permissions_model');
		$permissions = isset($permissions[0]) ? $permissions : [$permissions];

		foreach ($permissions as $name => $permission) {
			if (strstr($name, '.') AND !empty($permission['action'])) {
				$permission['name'] = $name;
				$permission['status'] = '1';
				$this->Permissions_model->savePermission(null, $permission);

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
	public function deletePermissions($permissions)
	{
		if (empty($permissions)) return FALSE;

		$this->load->model('Permissions_model');
		$permissions = isset($permissions[0]) ? $permissions : [$permissions];
		foreach ($permissions as $name => $permission) {
			if (strstr($name, '.') AND !empty($permission['action'])) {
				$this->Permissions_model->deletePermissionByName($permission['name']);
			}
		}
	}

	/**
	 * Create a new or update existing extension
	 *
	 * @param null $code
	 * @param array $data
	 * @param bool $log_activity
	 *
	 * @return bool TRUE on success, FALSE on failure
	 */
	public function saveExtensionData($code = null, $data = [], $log_activity = FALSE)
	{
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
	 * @param null $code
	 * @param array $data
	 * @param bool $log_activity
	 *
	 * @return bool TRUE on success, FALSE on failure
	 */
	public function updateExtension($type = 'module', $code = null, $data = [], $log_activity = TRUE)
	{
		return $this->updateSettings($code, $data, $log_activity);
	}

	/**
	 * Update extension settings
	 *
	 * @param null $code
	 * @param array $data
	 * @param bool $log_activity
	 *
	 * @return bool TRUE on success, FALSE on failure
	 */
	public function updateSettings($code = null, $data = [], $log_activity = TRUE)
	{
		$code = Modules::check_name($code);

		if ($code === null) return FALSE;

		!isset($data['data']) OR $data = $data['data'];
		unset($data['save_close']);

		$query = FALSE;

		if ($this->extensionExists($code)) {
			$extension = Modules::find_extension($code);

			if (!$extension instanceof BaseExtension) {
				return $query;
			}

			$extensionModel = $this->whereIn('type', ['module', 'payment'])->where('name', $code)->first();

			$saved = $extensionModel->fill([
				'data'       => (is_array($data)) ? serialize($data) : $data,
				'serialized' => '1',
				'type'       => 'module',
			])->save();

			$query = $saved ? $extensionModel->extension_id : $saved;

			if ($saved AND $log_activity) {
				$meta = $extension->extensionMeta();
				log_activity($this->user->getStaffId(), 'updated', 'extensions', get_activity_message('activity_custom_no_link',
					['{staff}', '{action}', '{context}', '{item}'],
					[$this->user->getStaffName(), 'updated', 'extension', $meta['name']]
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
	public function updateInstalledExtensions($extension = null, $install = TRUE)
	{
		$installed_extensions = $this->config->item('installed_extensions');

		if (empty($installed_extensions) OR !is_array($installed_extensions)) {
			$installed_extensions = $this->select('name')->whereIn('type', ['module', 'payment'])
										 ->where('status', '1')->getAsArray();
			if ($installed_extensions) {
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
		$this->config->set_item('installed_extensions', $installed_extensions);
	}

	/**
	 * Find an existing extension in filesystem by folder name
	 *
	 * @param string $code
	 *
	 * @return bool TRUE on success, FALSE on failure
	 */
	public function extensionExists($code)
	{
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
	public function install($code = '', $extension)
	{
		$code = url_title(strtolower($code), '-');

		if ($this->extensionExists($code) AND $extension instanceof BaseExtension) {
			$extension_id = null;
			$meta = $extension->extensionMeta();
			$title = !empty($meta['name']) ? $meta['name'] : null;

			$extensionModel = $this->whereIn('type', ['module', 'payment'])->firstOrCreate(['name' => $code]);

			if ($extensionModel) {
				$update = $extensionModel->fill(['type' => 'module', 'title' => $title, 'status' => '1', 'version' => $meta['version']])->save();
				if ($update) $extension_id = $extensionModel->extension_id;
			}

			if (is_numeric($extension_id)) {
				$this->updateInstalledExtensions($code);

				$permissions = $extension->registerPermissions();
				$this->savePermissions($permissions);

				$mailTemplates = $extension->registerMailTemplates();
				$this->load->model('Mail_templates_data_model');
				$this->Mail_templates_data_model->addMailTemplateData($mailTemplates);

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
	public function uninstall($code = '', $extension = null)
	{
		$query = FALSE;

		if ($this->extensionExists($code)) {
			if (preg_match('/\s/', $code) > 0) {
				$query = $this->whereIn('type', ['module', 'payment'])->where('name', $code)->delete();
			} else {
				$query = $this->whereIn('type', ['module', 'payment'])->where('name', $code)->update(['status' => '0']);

				$this->updateInstalledExtensions($code, FALSE);

				if ($query AND $extension instanceof BaseExtension) {
					$permissions = $extension->registerPermissions();
					$this->deletePermissions($permissions);

                    $mailTemplates = $extension->registerMailTemplates();
                    $this->load->model('Mail_templates_data_model');
                    $this->Mail_templates_data_model->removeMailTemplateData($mailTemplates);

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
	 * @param bool $delete_data whether to delete extension data
	 *
	 * @return bool
	 */
	public function deleteExtension($code = '', $delete_data = TRUE)
	{
		$query = FALSE;

		if ($this->extensionExists($code)) {

			$extensionModel = $this->whereIn('type', ['module', 'payment'])
								  ->where('name', $code)->first();

			if (isset($extensionModel->status) AND $extensionModel->status == 1)
				return FALSE;

			if ($delete_data) {
				$affected_rows = $extensionModel->delete();

				if ($affected_rows > 0) {
					// downgrade extension migration
					$query = Modules::run_migration($code, TRUE);
				}
			}

			$this->updateInstalledExtensions($code, FALSE);

			$query = Modules::remove_extension($code);
		}

		return $query;
	}

	/**
	 * Return all extension paths
	 *
	 * @return array
	 */
	protected function fetchExtensionsPath()
	{
		$results = [];

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