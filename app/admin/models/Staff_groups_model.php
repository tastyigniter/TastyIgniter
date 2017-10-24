<?php namespace Admin\Models;

use Model;

/**
 * StaffGroups Model Class
 *
 * @package Admin
 */
class Staff_groups_model extends Model
{
	/**
	 * @var string The database table name
	 */
	protected $table = 'staff_groups';

	/**
	 * @var string The database table primary key
	 */
	protected $primaryKey = 'staff_group_id';

    public $casts = [
		'permissions' => 'serialize',
	];

    public function getStaffCountAttribute($value)
    {
        return $this->getUsersCount($this->staff_group_id);
    }

    //
    // Helpers
    //

    /**
	 * Return all staff groups
	 *
	 * @return array
	 */
	public function getStaffGroups()
	{
		return $this->get();
	}

	/**
	 * Find a single staff_group by staff_group_id
	 *
	 * @param int $staff_group_id
	 *
	 * @return array
	 */
	public function getStaffGroup($staff_group_id)
	{
		if ($row = $this->findOrNew($staff_group_id)->toArray()) {
			return [
				'staff_group_id'          => $row['staff_group_id'],
				'staff_group_name'        => $row['staff_group_name'],
				'customer_account_access' => $row['customer_account_access'],
				'location_access'         => $row['location_access'],
				'permissions'             => $row['permissions'],
			];
		}
	}

	/**
	 * Return total number of staff in group
	 *
	 * @param $staff_group_id
	 *
	 * @return int
	 */
	public function getUsersCount($staff_group_id)
	{
		if ($staff_group_id) {
			return Staffs_model::where('staff_group_id', $staff_group_id)->count();
		}
	}

	/**
	 * Create a new or update existing staff group
	 *
	 * @param int $staff_group_id
	 * @param array $save
	 *
	 * @return bool|int The $staff_group_id of the affected row, or FALSE on failure
	 */
	public function saveStaffGroup($staff_group_id, $save = [])
	{
		if (empty($save)) return FALSE;

		$save['permissions'] = isset($save['permissions']) ? $save['permissions'] : [];

		$groupModel = $this->findOrNew($staff_group_id);

		$saved = $groupModel->fill($save)->save();

		return $saved ? $groupModel->getKey() : $saved;
	}

	/**
	 * Assign permission rule to staff group
	 *
	 * @param int $staff_group_id
	 * @param array $permission_rule
	 *
	 * @return bool
	 */
	public function assignPermissionRule($staff_group_id, $permission_rule)
	{
		$query = FALSE;

		if (isset($permission_rule['name']) AND !($permission = Permissions_model::getPermissionByName($permission_rule['name']))) {
			return $query;
		}

		$permission_name = isset($permission['name']) ? $permission['name'] : null;

		if ($groupModel = $this->find($staff_group_id)) {
			$row = $groupModel->toArray();
			$group_permissions = (!empty($row['permissions'])) ? $row['permissions'] : [];

			is_array($permission_rule['action']) OR (array)$permission_rule['action'];

			// Add new permission to group_permissions, Add new permission by name instead of id
			$group_permissions[$permission_name] = $permission_rule['action'];

			$query = $groupModel->update(['permissions' => $group_permissions]);
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
	public function deleteStaffGroup($staff_group_id)
	{
		if (is_numeric($staff_group_id)) $staff_group_id = [$staff_group_id];

		if (!empty($staff_group_id) AND ctype_digit(implode('', $staff_group_id))) {
			return $this->where('staff_group_id', '!=', '11')->whereIn('staff_group_id', $staff_group_id)->delete();
		}
	}
}