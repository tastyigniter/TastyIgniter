<?php
class Staffs_model extends CI_Model {

    public function record_count($filter = array()) {
		if (!empty($filter['filter_search'])) {
			$this->db->like('staff_name', $filter['filter_search']);
			$this->db->or_like('location_name', $filter['filter_search']);
			$this->db->or_like('staff_email', $filter['filter_search']);
		}

		if (isset($filter['filter_group']) AND is_numeric($filter['filter_group'])) {
			$this->db->where('staff_group_id', $filter['filter_group']);
		}

		if (!empty($filter['filter_location'])) {
			$this->db->where('staffs.staff_location_id', $filter['filter_location']);
		}

		if (!empty($filter['filter_date'])) {
			$date = explode('-', $filter['filter_date']);
			$this->db->where('YEAR(date_added)', $date[0]);
			$this->db->where('MONTH(date_added)', $date[1]);
		}

		if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
			$this->db->where('staff_status', $filter['filter_status']);
		}

		$this->db->from('staffs');
		$this->db->join('locations', 'locations.location_id = staffs.staff_location_id', 'left');
		return $this->db->count_all_results();
    }
	
	public function getList($filter = array()) {
		if ($filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}
		
        if ($this->db->limit($filter['limit'], $filter['page'])) {	
			$this->db->select('staffs.staff_id, staff_name, staff_email, staff_group_name, location_name, date_added, staff_status');
			$this->db->from('staffs');
			$this->db->join('users', 'users.staff_id = staffs.staff_id', 'left');
			$this->db->join('staff_groups', 'staff_groups.staff_group_id = staffs.staff_group_id', 'left');
			$this->db->join('locations', 'locations.location_id = staffs.staff_location_id', 'left');

			if (!empty($filter['sort_by']) AND !empty($filter['order_by'])) {
				$this->db->order_by($filter['sort_by'], $filter['order_by']);
			}

			if (!empty($filter['filter_search'])) {
				$this->db->like('staff_name', $filter['filter_search']);
				$this->db->or_like('location_name', $filter['filter_search']);
				$this->db->or_like('staff_email', $filter['filter_search']);
			}

			if (isset($filter['filter_group']) AND is_numeric($filter['filter_group'])) {
				$this->db->where('staffs.staff_group_id', $filter['filter_group']);
			}

			if (!empty($filter['filter_location'])) {
				$this->db->where('staffs.staff_location_id', $filter['filter_location']);
			}

			if (!empty($filter['filter_date'])) {
				$date = explode('-', $filter['filter_date']);
				$this->db->where('YEAR(date_added)', $date[0]);
				$this->db->where('MONTH(date_added)', $date[1]);
			}

			if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
				$this->db->where('staff_status', $filter['filter_status']);
			}

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

	public function getStaffDates() {
		$this->db->select('date_added, MONTH(date_added) as month, YEAR(date_added) as year');
		$this->db->from('staffs');
		$this->db->group_by('MONTH(date_added)');
		$this->db->group_by('YEAR(date_added)');
		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}
	
	public function getStaffsByGroupId($staff_group_id = FALSE) {
		if ($staff_group_id) {
			$this->db->from('staffs');		
			$this->db->where('staff_group_id', $staff_group_id);
		
			$query = $this->db->get();
			$result = array();

			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}

			return $result;
		}
	}

	public function getAutoComplete($filter = array()) {
		if (is_array($filter) AND !empty($filter)) {
			$this->db->from('staffs');
	
			if (!empty($filter['staff_name'])) {
				$this->db->like('staff_name', $filter['staff_name']);		
			}
	
			$query = $this->db->get();
			$result = array();
		
			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}
		
			return $result;
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

		if (!empty($update['staff_group_id'])) {
			$this->db->set('staff_group_id', $update['staff_group_id']);
		}

		if (!empty($update['staff_location_id'])) {
			$this->db->set('staff_location_id', $update['staff_location_id']);
		}

		if ($update['staff_status'] === '1') {
			$this->db->set('staff_status', $update['staff_status']);
		} else {
			$this->db->set('staff_status', '0');
		}

		if (!empty($update['staff_id'])) {
			$this->db->where('staff_id', $update['staff_id']);
			
			if ($query = $this->db->update('staffs')) {
				if (!empty($update['password'])) {
					$this->db->set('salt', $salt = substr(md5(uniqid(rand(), TRUE)), 0, 9));
					$this->db->set('password', sha1($salt . sha1($salt . sha1($update['password']))));
				}

				if (!empty($update['username'])) {
					$this->db->set('username', strtolower($update['username']));
				}
		
				if (!empty($update['staff_id'])) {
					$this->db->where('staff_id', $update['staff_id']);
					$this->db->update('users'); 
				}
			}
		}
			
			
		return $query;
	}	

	public function addStaff($add = array()) {
		$query = FALSE;

		if (!empty($add['staff_name'])) {
			$this->db->set('staff_name', $add['staff_name']);
		}

		if (!empty($add['staff_email'])) {
			$this->db->set('staff_email', strtolower($add['staff_email']));
		}

		if (!empty($add['staff_group_id'])) {
			$this->db->set('staff_group_id', $add['staff_group_id']);
		}

		if (!empty($add['staff_location_id'])) {
			$this->db->set('staff_location_id', $add['staff_location_id']);
		}

		if ($add['staff_status'] === '1') {
			$this->db->set('staff_status', $add['staff_status']);
		} else {
			$this->db->set('staff_status', '0');
		}

		if (!empty($add)) {
			$this->db->set('date_added', mdate('%Y-%m-%d', time()));
			
			if ($this->db->insert('staffs')) {
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
				$query = $staff_id;
			}
		}

		return $query;
	}

	public function deleteStaff($staff_id) {
		if (is_numeric($staff_id)) {
			$this->db->where('staff_id', $staff_id);
			$this->db->delete('staffs');

			$this->db->where('staff_id', $staff_id);
			$this->db->delete('users'); 

			if ($this->db->affected_rows() > 0) {
				return TRUE;
			}
		}
	}
}

/* End of file staffs_model.php */
/* Location: ./application/models/staffs_model.php */