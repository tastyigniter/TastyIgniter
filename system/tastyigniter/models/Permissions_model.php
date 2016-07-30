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
 * Permissions Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Permissions_model.php
 * @link           http://docs.tastyigniter.com
 */
class Permissions_model extends TI_Model
{
	/**
	 * @var string The database table name
	 */
	protected $table_name = 'permissions';

	/**
	 * @var string The database table primary key
	 */
	protected $primary_key = 'permission_id';

	/**
	 * Count the number of records
	 *
	 * @param array $filter
	 *
	 * @return int
	 */
	public function getCount($filter) {
		return $this->filter($filter)->count();
	}

	/**
	 * List all permissions matching the filter
	 *
	 * @param array $filter
	 *
	 * @return array
	 */
	public function getList($filter = array()) {
		return $this->filter($filter)->find_all();
	}

	/**
	 * Filter database records
	 *
	 * @param array $filter an associative array of field/value pairs
	 *
	 * @return $this
	 */
	public function filter($filter = array()) {
		if (!empty($filter['filter_search'])) {
			$this->like('name', $filter['filter_search']);
		}

		if (is_numeric($filter['filter_status'])) {
			$this->where('status', $filter['filter_status']);
		}

		return $this;
	}

	/**
	 * Return all permissions
	 *
	 * @return array
	 */
	public function getPermissions() {
		$this->load->helper('string');

		$result = array();
		$rows = $this->find_all('status', '1');
		foreach ($rows as $row) {
			$permission = explode('.', $row['name']);
			$domain = isset($permission[0]) ? $permission[0] : 'Admin';
			$controller = isset($permission[1]) ? $permission[1] : '';
			$result[$domain][] = array_merge($row, array(
				'domain'     => $domain,
				'controller' => convert_camelcase_to_underscore($controller, TRUE),
				'action'     => unserialize($row['action']),
			));
		}

		return $result;
	}

	/**
	 * Find a single permission by permission_id
	 *
	 * @param int $permission_id
	 *
	 * @return mixed
	 */
	public function getPermission($permission_id) {
		return $this->find($permission_id);
	}

	/**
	 * Find a single permission by permission_name
	 *
	 * @param string $permission_name
	 *
	 * @return mixed
	 */
	public function getPermissionByName($permission_name = NULL) {
		return $this->find('name', $permission_name);
	}

	/**
	 * Find a single permission by multiple permission_id
	 *
	 * @param array $permission_id
	 *
	 * @return array
	 */
	public function getPermissionsByIds($permission_id = NULL) {
		$permissions_list = $this->getPermissions();

		$results = array();
		foreach ($permissions_list as $domain => $permissions) {
			foreach ($permissions as $permission) {
				$results[$permission['permission_id']] = $permission;
			}
		}

		return (is_numeric($permission_id) AND isset($results[$permission_id])) ? $results[$permission_id] : $results;
	}

	/**
	 * Create a new or update existing permission
	 *
	 * @param int   $permission_id
	 * @param array $save
	 *
	 * @return bool|int The $menu_id of the affected row, or FALSE on failure
	 */
	public function savePermission($permission_id, $save = array()) {
		if (empty($save) OR empty($save['name'])) return FALSE;

		if (isset($save['name'])) {
			if ($permission = $this->getPermissionByName($save['name'])) {
				$permission_id = $permission['permission_id'];
			}

			$name = explode('.', $save['name']);
			if (!isset($name[0]) OR !in_array(strtolower($name[0]), array('admin', 'site', 'module', 'payment'))) {
				return FALSE;
			}
		}

		if (isset($save['action'])) {
			if (!is_array($save['action'])) $save['action'] = array($save['action']);
			$save['action'] = serialize($save['action']);
		}

		return $this->skip_validation(TRUE)->save($save, $permission_id);
	}

	/**
	 * Delete a single permission by permission_name
	 *
	 * @param string $permission_name
	 *
	 * @return int The number of deleted row
	 */
	public function deletePermissionByName($permission_name) {
		if (is_string($permission_name) AND !ctype_space($permission_name)) {
			return $this->delete('name', $permission_name);
		}
	}

	/**
	 * Delete a single or multiple permission by permission_id
	 *
	 * @param string|array $permission_id
	 *
	 * @return int The number of deleted rows
	 */
	public function deletePermission($permission_id) {
		if (is_numeric($permission_id)) $permission_id = array($permission_id);

		if (!empty($permission_id) AND ctype_digit(implode('', $permission_id))) {
			return $this->delete('permission_id', $permission_id);
		}
	}
}

/* End of file Permissions_model.php */
/* Location: ./system/tastyigniter/models/Permissions_model.php */