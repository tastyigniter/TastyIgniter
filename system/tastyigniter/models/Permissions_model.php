<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package       TastyIgniter
 * @author        SamPoyigi
 * @copyright (c) 2013 - 2016. TastyIgniter
 * @link          http://tastyigniter.com
 * @license       http://opensource.org/licenses/GPL-3.0 The GNU GENERAL PUBLIC LICENSE
 * @since         File available since Release 1.0
 */
defined('BASEPATH') or exit('No direct script access allowed');

use TastyIgniter\Database\Model;

/**
 * Permissions Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Permissions_model.php
 * @link           http://docs.tastyigniter.com
 */
class Permissions_model extends Model
{
	/**
	 * @var string The database table name
	 */
	protected $table = 'permissions';

	/**
	 * @var string The database table primary key
	 */
	protected $primaryKey = 'permission_id';

	public function getActionAttribute($value)
	{
		return $value ? unserialize($value) : [];
	}

	public function setActionAttribute($value)
	{
		$this->attributes['action'] = serialize($value ? $value : []);
	}

	public function scopeIsEnabled($query)
	{
		return $query->where('status', '1');
	}

	/**
	 * Filter database records
	 *
	 * @param $query
	 * @param array $filter an associative array of field/value pairs
	 *
	 * @return $this
	 */
	public function scopeFilter($query, $filter = [])
	{
		if (!empty($filter['filter_search'])) {
			$query->search($filter['filter_search'], ['name']);
		}

		if (is_numeric($filter['filter_status'])) {
			$query->where('status', $filter['filter_status']);
		}

		return $query;
	}

	/**
	 * Return all permissions
	 *
	 * @return array
	 */
	public function getPermissions()
	{
		$this->load->helper('string');

		$result = [];
		$rows = $this->isEnabled()->getAsArray();
		foreach ($rows as $row) {
			$permission = explode('.', $row['name']);
			$domain = isset($permission[0]) ? $permission[0] : 'Admin';
			$controller = isset($permission[1]) ? $permission[1] : '';
			$result[$domain][] = array_merge($row, [
				'domain'     => $domain,
				'controller' => convert_camelcase_to_underscore($controller, TRUE),
			]);
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
	public function getPermission($permission_id)
	{
		return $this->findOrNew($permission_id)->toArray();
	}

	/**
	 * Find a single permission by permission_name
	 *
	 * @param string $permission_name
	 *
	 * @return mixed
	 */
	public function getPermissionByName($permission_name = null)
	{
		return $this->where('name', $permission_name)->firstAsArray();
	}

	/**
	 * Find a single permission by multiple permission_id
	 *
	 * @param array $permission_id
	 *
	 * @return array
	 */
	public function getPermissionsByIds($permission_id = null)
	{
		$permissions_list = $this->getPermissions();

		$results = [];
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
	 * @param int $permission_id
	 * @param array $save
	 *
	 * @return bool|int The $menu_id of the affected row, or FALSE on failure
	 */
	public function savePermission($permission_id, $save = [])
	{
		if (empty($save) OR empty($save['name'])) return FALSE;

		if (isset($save['name'])) {
			if ($permission = $this->getPermissionByName($save['name'])) {
				$permission_id = $permission['permission_id'];
			}
		}

		$save['action'] = empty($save['action']) ? [] : $save['action'];

		$permissionModel = $this->findOrNew($permission_id);

		$saved = $permissionModel->fill($save)->save();

		return $saved ? $permissionModel->getKey() : $saved;
	}

	/**
	 * Delete a single permission by permission_name
	 *
	 * @param string $permission_name
	 *
	 * @return int The number of deleted row
	 */
	public function deletePermissionByName($permission_name)
	{
		if (is_string($permission_name) AND !ctype_space($permission_name)) {
			return $this->where('name', $permission_name)->delete();
		}
	}

	/**
	 * Delete a single or multiple permission by permission_id
	 *
	 * @param string|array $permission_id
	 *
	 * @return int The number of deleted rows
	 */
	public function deletePermission($permission_id)
	{
		if (is_numeric($permission_id)) $permission_id = [$permission_id];

		if (!empty($permission_id) AND ctype_digit(implode('', $permission_id))) {
			return $this->whereIn('permission_id', $permission_id)->delete();
		}
	}
}

/* End of file Permissions_model.php */
/* Location: ./system/tastyigniter/models/Permissions_model.php */