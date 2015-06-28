<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Staff_groups_model extends TI_Model {

    public function getCount($filter = array()) {
        $this->db->from('staff_groups');
        return $this->db->count_all_results();
    }

    public function getList($filter = array()) {
        if (!empty($filter['page']) AND $filter['page'] !== 0) {
            $filter['page'] = ($filter['page'] - 1) * $filter['limit'];
        }

        if ($this->db->limit($filter['limit'], $filter['page'])) {
            $this->db->from('staff_groups');

            if (!empty($filter['sort_by']) AND !empty($filter['order_by'])) {
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

			return array (
				'staff_group_id' 	=> $row['staff_group_id'],
				'staff_group_name' 	=> $row['staff_group_name'],
				'location_access' 	=> $row['location_access'],
				'permissions' 		=> $row['permissions']
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

		if (!empty($save['staff_group_name'])) {
			$this->db->set('staff_group_name', $save['staff_group_name']);
		}

		if ($save['location_access'] === '1') {
			$this->db->set('location_access', $save['location_access']);
		} else {
			$this->db->set('location_access', '0');
		}

		if (!empty($save['permissions'])) {
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

	public function addPermission($staff_group_id, $type, $page) {
		$query = FALSE;

		$department_query = $this->db->get_where('staff_groups', array('staff_group_id' => $staff_group_id));

		if ($department_query->num_rows() > 0) {
			$row = $department_query->row_array();
			$permission = array();
			if (!empty($row['permissions'])) {
				$permission = unserialize($row['permissions']);
			}

			$permission[$type][] = $page;

			$this->db->set('permission', serialize($permission));
			$this->db->where('staff_group_id', $staff_group_id);
			$query = $this->db->update('staff_groups');
		}

		return $query;
	}

	public function deleteStaffGroup($staff_group_id) {
        if (is_numeric($staff_group_id)) $staff_group_id = array($staff_group_id);

        if (!empty($staff_group_id) AND ctype_digit(implode('', $staff_group_id))) {
            $this->db->where_in('staff_group_id', $staff_group_id);
            $this->db->delete('staff_groups');

            return $this->db->affected_rows();
        }
	}
}

/* End of file staff_groups_model.php */
/* Location: ./system/tastyigniter/models/staff_groups_model.php */