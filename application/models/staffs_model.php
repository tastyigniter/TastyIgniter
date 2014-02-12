<?php
class Staffs_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}

    public function record_count() {
        return $this->db->count_all('staffs');
    }
	
	public function getList($filter = array()) {
		if ($filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}
		
        if ($this->db->limit($filter['limit'], $filter['page'])) {	
			$this->db->select('staffs.staff_id, staff_name, staff_email, departments.department_name, locations.location_name, date_added, staff_status');
			$this->db->from('staffs');
			$this->db->join('users', 'users.staff_id = staffs.staff_id', 'left');
			$this->db->join('departments', 'departments.department_id = staffs.staff_department', 'left');
			$this->db->join('locations', 'locations.location_id = staffs.staff_location', 'left');

			$query = $this->db->get();
			$result = array();
		
			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}
		
			return $result;
		}
	}

	public function getStaffs() {
		$this->db->from('staffs');
		$this->db->join('users', 'users.staff_id = staffs.staff_id', 'left');
		$this->db->join('departments', 'departments.department_id = staffs.staff_department', 'left');
		$this->db->join('locations', 'locations.location_id = staffs.staff_location', 'left');

		$this->db->where('staff_status', '1');

		$query = $this->db->get();
		$result = array();
	
		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}
	
		return $result;
	}

	public function getStaff($staff_id = FALSE) {
		$this->db->from('staffs');		
		
		$this->db->where('staff_id', $staff_id);
		
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
	}

	public function getStaffUser($staff_id = FALSE) {
		$this->db->from('users');		
		
		$this->db->where('staff_id', $staff_id);
		
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
	}


	public function updateStaff($update = array()) {
		$query = FALSE;

		if (!empty($update['staff_name'])) {
			$this->db->set('staff_name', $update['staff_name']);
		}

		if (!empty($update['staff_email'])) {
			$this->db->set('staff_email', strtolower($update['staff_email']));
		}

		if (!empty($update['staff_department'])) {
			$this->db->set('staff_department', $update['staff_department']);
		}

		if (!empty($update['staff_location'])) {
			$this->db->set('staff_location', $update['staff_location']);
		}

		if ($update['staff_status'] === '1') {
			$this->db->set('staff_status', $update['staff_status']);
		} else {
			$this->db->set('staff_status', '0');
		}

		if (!empty($update['staff_id'])) {
			$this->db->where('staff_id', $update['staff_id']);
			$this->db->update('staffs');
		}
			
		if ($this->db->affected_rows() > 0) {
			$query = TRUE;
		}

		if (!empty($update['password'])) {
			$this->db->set('salt', $salt = substr(md5(uniqid(rand(), TRUE)), 0, 9));
			$this->db->set('password', sha1($salt . sha1($salt . sha1($update['password']))));
		}

		if (!empty($update['username'])) {
			$this->db->set('username', strtolower($update['username']));

			$this->db->where('staff_id', $update['staff_id']);
			$this->db->update('users'); 
		}
			
		if ($this->db->affected_rows() > 0) {
			$query = TRUE;
		}

		return $query;
	}	

	public function addStaff($add = array()) {

		if (!empty($add['staff_name'])) {
			$this->db->set('staff_name', $add['staff_name']);
		}

		if (!empty($add['staff_email'])) {
			$this->db->set('staff_email', strtolower($add['staff_email']));
		}

		if (!empty($add['staff_department'])) {
			$this->db->set('staff_department', $add['staff_department']);
		}

		if (!empty($add['staff_location'])) {
			$this->db->set('staff_location', $add['staff_location']);
		}

		if ($add['staff_status'] === '1') {
			$this->db->set('staff_status', $add['staff_status']);
		} else {
			$this->db->set('staff_status', '0');
		}

		$this->db->set('date_added', mdate('%Y-%m-%d', time()));
			
		$this->db->insert('staffs');

		if ($this->db->affected_rows() > 0 && $this->db->insert_id()) {
			$staff_id = $this->db->insert_id();

			if (!empty($add['username'])) {
				$this->db->set('username', $add['username']);
				$this->db->set('staff_id', $staff_id);
			}

			if (!empty($add['password'])) {
				$this->db->set('salt', $salt = substr(md5(uniqid(rand(), TRUE)), 0, 9));
				$this->db->set('password', sha1($salt . sha1($salt . sha1($add['password']))));
			}
		
			$this->db->insert('users'); 

			return TRUE;
		}
	}

	public function deleteStaff($staff_id) {

		$this->db->where('staff_id', $staff_id);
		$this->db->delete('staffs');

		$this->db->where('staff_id', $staff_id);
		$this->db->delete('users'); 

		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}
}