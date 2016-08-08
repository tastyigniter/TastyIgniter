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
 * Staff_groups Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Staff_groups_model.php
 * @link           http://docs.tastyigniter.com
 */
class Staff_groups_model extends TI_Model
{
	/**
	 * @var string The database table name
	 */
	protected $table_name = 'staff_groups';

	/**
	 * @var string The database table primary key
	 */
	protected $primary_key = 'staff_group_id';

	/**
	 * Return all staff groups
	 *
	 * @return array
	 */
	public function getStaffGroups() {
		return $this->find_all();
	}

	/**
	 * Find a single staff_group by staff_group_id
	 *
	 * @param int $staff_group_id
	 *
	 * @return array
	 */
	public function getStaffGroup($staff_group_id) {
		if ($row = $this->find($staff_group_id)) {
			return array(
				'staff_group_id'          => $row['staff_group_id'],
				'staff_group_name'        => $row['staff_group_name'],
				'customer_account_access' => $row['customer_account_access'],
				'location_access'         => $row['location_access'],
				'permissions'             => $row['permissions'],
			);
		}
	}

	/**
	 * Return total number of staff in group
	 *
	 * @param $staff_group_id
	 *
	 * @return int
	 */
	public function getUsersCount($staff_group_id) {
		if ($staff_group_id) {
			$this->load->model('Staffs_model');
			$this->Staffs_model->where('staff_group_id', $staff_group_id);

			return $this->Staffs_model->count();
		}
	}

	/**
	 * Create a new or update existing staff group
	 *
	 * @param int   $staff_group_id
	 * @param array $save
	 *
	 * @return bool|int The $staff_group_id of the affected row, or FALSE on failure
	 */
	public function saveStaffGroup($staff_group_id, $save = array()) {
		if (empty($save)) return FALSE;

		$save['permissions'] = isset($save['permissions']) ? serialize($save['permissions']) : serialize(array());

		return $this->skip_validation(TRUE)->save($save, $staff_group_id);
	}

	/**
	 * Assign permission rule to staff group
	 *
	 * @param int   $staff_group_id
	 * @param array $permission_rule
	 *
	 * @return bool
	 */
	public function assignPermissionRule($staff_group_id, $permission_rule) {
		$query = FALSE;

		if (isset($permission_rule['name']) AND !($permission = $this->Permissions_model->getPermissionByName($permission_rule['name']))) {
			return $query;
		}

		$permission_id = isset($permission['permission_id']) ? $permission['permission_id'] : NULL;

		if ($row = $this->find($staff_group_id)) {
			$group_permissions = (!empty($row['permissions'])) ? unserialize($row['permissions']) : array();

			is_array($permission_rule['action']) OR (array)$permission_rule['action'];

			$group_permissions[$permission_id] = $permission_rule['action'];

			$query = $this->update($staff_group_id, array('permissions' => serialize($group_permissions)));
		}

		return $query;
	}

	/**
	 * Delete a single or multiple staff group by staff_group_id
	 *
	 * @param string|array $staff_group_id
	 *
	 * @return int  The number of deleted rows
	 */
	public function deleteStaffGroup($staff_group_id) {
		if (is_numeric($staff_group_id)) $staff_group_id = array($staff_group_id);

		if (!empty($staff_group_id) AND ctype_digit(implode('', $staff_group_id))) {
			$this->where('staff_group_id !=', '11');

			return $this->delete(array('staff_group_id', $staff_group_id));
		}
	}
}

/* End of file Staff_groups_model.php */
/* Location: ./system/tastyigniter/models/Staff_groups_model.php */