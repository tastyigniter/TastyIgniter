<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Staff_groups_model extends TI_Model {

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

			return array (
				'staff_group_id' 	=> $row['staff_group_id'],
				'staff_group_name' 	=> $row['staff_group_name'],
				'location_access' 	=> $row['location_access'],
				'permission' 		=> $row['permission']
			);
		}
	}

	public function updateStaffGroup($update = array()) {
		$query = FALSE;

		if (!empty($update['staff_group_name'])) {
			$this->db->set('staff_group_name', $update['staff_group_name']);
		}

		if ($update['location_access'] === '1') {
			$this->db->set('location_access', $update['location_access']);
		} else {
			$this->db->set('location_access', '0');
		}


		if (!empty($update['permission'])) {
			$this->db->set('permission', $update['permission']);
		}

		if (!empty($update['staff_group_id'])) {
			$this->db->where('staff_group_id', $update['staff_group_id']);
			$query = $this->db->update('staff_groups');
		}

		return $query;
	}

	public function addStaffGroup($add = array()) {
		$query = FALSE;

		if (!empty($add['staff_group_name'])) {
			$this->db->set('staff_group_name', $add['staff_group_name']);
		}

		if ($add['location_access'] === '1') {
			$this->db->set('location_access', $add['location_access']);
		} else {
			$this->db->set('location_access', '0');
		}

		if (!empty($add['permission'])) {
			$this->db->set('permission', $add['permission']);
		}

		if (!empty($add)) {
			if ($this->db->insert('staff_groups')) {
				$query = $this->db->insert_id();
			}
		}

		return $query;
	}

	public function addPermission($staff_group_id, $type, $page) {
		$query = FALSE;

		$department_query = $this->db->get_where('staff_groups', array('staff_group_id' => $staff_group_id));

		if ($department_query->num_rows() > 0) {
			$row = $department_query->row_array();
			$permission = array();
			if (!empty($row['permission'])) {
				$permission = unserialize($row['permission']);
			}

			$permission[$type][] = $page;

			$this->db->set('permission', serialize($permission));
			$this->db->where('staff_group_id', $staff_group_id);
			$query = $this->db->update('staff_groups');
		}

		return $query;
	}

	public function deleteStaffGroup($staff_group_id) {
		if (is_numeric($staff_group_id)) {
			$this->db->where('staff_group_id', $staff_group_id);
			$this->db->delete('staff_groups');

			if ($this->db->affected_rows() > 0) {
				return TRUE;
			}
		}
	}
}

/* End of file staff_groups_model.php */
/* Location: ./system/tastyigniter/models/staff_groups_model.php */