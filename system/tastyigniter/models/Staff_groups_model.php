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
class Staff_groups_model extends TI_Model {

	public function getCount($filter = array()) {
		$this->db->from('staff_groups');

		return $this->db->count_all_results();
	}

	public function getList($filter = array()) {
		if ( ! empty($filter['page']) AND $filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}

		if ($this->db->limit($filter['limit'], $filter['page'])) {
			$this->db->from('staff_groups');

			if ( ! empty($filter['sort_by']) AND ! empty($filter['order_by'])) {
				$this->db->order_by($filter['sort_by'], $filter['order_by']);
			}

			$query = $this->db->get();
			$result = array();

			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}

			return $result;
		}
	}

	public function getStaffGroups() {
		$this->db->from('staff_groups');

		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function getStaffGroup($staff_group_id) {
		$this->db->from('staff_groups');

		$this->db->where('staff_group_id', $staff_group_id);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			$row = $query->row_array();

			return array(
				'staff_group_id'          => $row['staff_group_id'],
				'staff_group_name'        => $row['staff_group_name'],
				'customer_account_access' => $row['customer_account_access'],
				'location_access'         => $row['location_access'],
				'permissions'             => $row['permissions'],
			);
		}
	}

	public function getUsersCount($staff_group_id) {
		if ($staff_group_id) {
			$this->db->from('staffs');

			$this->db->where('staff_group_id', $staff_group_id);

			return $this->db->count_all_results();
		}
	}

	public function saveStaffGroup($staff_group_id, $save = array()) {
		if (empty($save)) return FALSE;

		if (isset($save['staff_group_name'])) {
			$this->db->set('staff_group_name', $save['staff_group_name']);
		}

		if (isset($save['location_access']) AND $save['location_access'] === '1') {
			$this->db->set('location_access', $save['location_access']);
		} else {
			$this->db->set('location_access', '0');
		}

		if (isset($save['customer_account_access']) AND $save['customer_account_access'] === '1') {
			$this->db->set('customer_account_access', $save['customer_account_access']);
		} else {
			$this->db->set('customer_account_access', '0');
		}

		if (isset($save['permissions'])) {
			$this->db->set('permissions', serialize($save['permissions']));
		} else {
			$this->db->set('permissions', serialize(array()));
		}

		if (is_numeric($staff_group_id)) {
			$this->db->where('staff_group_id', $staff_group_id);
			$query = $this->db->update('staff_groups');
		} else {
			$query = $this->db->insert('staff_groups');
			$staff_group_id = $this->db->insert_id();
		}

		return ($query === TRUE AND is_numeric($staff_group_id)) ? $staff_group_id : FALSE;
	}

	public function assignPermissionRule($staff_group_id, $permission_rule) {
		$query = FALSE;

		if (isset($permission_rule['name']) AND ! ($permission = $this->Permissions_model->getPermissionByName($permission_rule['name']))) {
			return $query;
		}

		$permission_id = isset($permission['permission_id']) ? $permission['permission_id'] : NULL;

		$staff_group = $this->db->get_where('staff_groups', array('staff_group_id' => $staff_group_id));

		if ($staff_group->num_rows() > 0) {
			$row = $staff_group->row_array();
			$group_permissions = ( ! empty($row['permissions'])) ? unserialize($row['permissions']) : array();

			is_array($permission_rule['action']) OR (array) $permission_rule['action'];

			$group_permissions[$permission_id] = $permission_rule['action'];

			$this->db->set('permissions', serialize($group_permissions));
			$this->db->where('staff_group_id', $staff_group_id);
			$query = $this->db->update('staff_groups');
		}

		return $query;
	}

	public function deleteStaffGroup($staff_group_id) {
		if (is_numeric($staff_group_id)) $staff_group_id = array($staff_group_id);

		if ( ! empty($staff_group_id) AND ctype_digit(implode('', $staff_group_id))) {
			$this->db->where_in('staff_group_id', $staff_group_id);
			$this->db->where('staff_group_id !=', '11');
			$this->db->delete('staff_groups');

			return $this->db->affected_rows();
		}
	}
}

/* End of file staff_groups_model.php */
/* Location: ./system/tastyigniter/models/staff_groups_model.php */