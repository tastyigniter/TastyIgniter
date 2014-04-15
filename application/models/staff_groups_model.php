<?php
class Staff_groups_model extends CI_Model {

	public function __construct() {
		$this->load->database();
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
				
			return array (
				'staff_group_id' 	=> $row['staff_group_id'],
				'staff_group_name' 	=> $row['staff_group_name'],
				'permission' 		=> $row['permission']
			);
		}
	}

	public function updateStaffGroup($update_data = array()) {

		if (!empty($update_data['staff_group_name'])) {
			$this->db->set('staff_group_name', $update_data['staff_group_name']);
		}
		
		if (!empty($update_data['permission'])) {
			$this->db->set('permission', $update_data['permission']);
		}
		
		if (!empty($update_data['staff_group_id'])) {
			$this->db->where('staff_group_id', $update_data['staff_group_id']);
			$this->db->update('staff_groups');
		}		
	
		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}

	public function addPermission($staff_group_id, $type, $page) {
		
		$department_query = $this->db->get_where('staff_groups', array('staff_group_id' => $staff_group_id));
		if ($department_query->num_rows() > 0) {
			$row = $department_query->row_array();
			$permission = array();
			if (!empty($row['permission'])) {
				$permission = unserialize($row['permission']);
			}

			$permission[$type][] = $page;
	
			$this->db->set('permission', $permission);
			$this->db->where('staff_group_id', $staff_group_id);
			$this->db->update('staff_groups');
		}

		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}
	
	public function addStaffGroup($add_data = array()) {

		if (!empty($add_data['staff_group_name'])) {
			$this->db->set('staff_group_name', $add_data['staff_group_name']);
		}
		
		if (!empty($add_data['permission'])) {
			$this->db->set('permission', $add_data['permission']);
		}
		
		$this->db->insert('staff_groups');

		if ($this->db->affected_rows() > 0) {
			
			return TRUE;
		}
	}

	public function deleteStaffGroup($staff_group_id) {

		$this->db->where('staff_group_id', $staff_group_id);

		$this->db->delete('staff_groups');

		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}
}