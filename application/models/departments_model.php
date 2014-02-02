<?php
class Departments_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}

	public function getDepartments($departments = FALSE) {
		if ($departments === FALSE) {
			$this->db->from('departments');

			$query = $this->db->get();
			return $query->result_array();
		}
	}

	public function getDepartment($department_id) {
		$this->db->from('departments');

		$this->db->where('department_id', $department_id);

		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			$row = $query->row_array();
				
			return array (
				'department_id' 	=> $row['department_id'],
				'department_name' 	=> $row['department_name'],
				'permission' 		=> unserialize($row['permission'])
			);
		}
	}

	public function updateDepartment($update_data = array()) {

		if (!empty($update_data['department_name'])) {
			$this->db->set('department_name', $update_data['department_name']);
		}
		
		if (!empty($update_data['permission'])) {
			$this->db->set('permission', serialize($update_data['permission']));
		}
		
		if (!empty($update_data['department_id'])) {
			$this->db->where('department_id', $update_data['department_id']);
			$this->db->update('departments');
		}		
	
		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}

	public function addPermission($department_id, $type, $page) {
		
		$department_query = $this->db->get_where('departments', array('department_id' => $department_id));
		if ($department_query->num_rows() > 0) {
			
			$row = $department_query->row_array();
			
			if (!empty($row['permission'])) {
				$permission = unserialize($row['permission']);
		
				$permission[$type][] = $page;
		
				$this->db->set('permission', serialize($permission));
				$this->db->where('department_id', $department_id);
				$this->db->update('departments');
			}
		}

		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}
	
	public function addDepartment($add_data = array()) {

		if (!empty($add_data['department_name'])) {
			$this->db->set('department_name', $add_data['department_name']);
		}
		
		if (!empty($add_data['permission'])) {
			$this->db->set('permission', serialize($add_data['permission']));
		}
		
		$this->db->insert('departments');

		if ($this->db->affected_rows() > 0) {
			
			return TRUE;
		}
	}

	public function deleteDepartment($department_id) {

		$this->db->where('department_id', $department_id);

		$this->db->delete('departments');

		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}
}