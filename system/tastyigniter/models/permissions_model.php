<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Permissions_model extends TI_Model {

    public function getCount($filter) {
		if (!empty($filter['filter_search'])) {
			$this->db->like('name', $filter['filter_search']);
		}

		if (is_numeric($filter['filter_status'])) {
			$this->db->where('status', $filter['filter_status']);
		}

		$this->db->from('permissions');
		return $this->db->count_all_results();
    }

	public function getList($filter = array()) {
		if (!empty($filter['page']) AND $filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}

        if ($this->db->limit($filter['limit'], $filter['page'])) {
			$this->db->from('permissions');

			if (!empty($filter['sort_by']) AND !empty($filter['order_by'])) {
				$this->db->order_by($filter['sort_by'], $filter['order_by']);
			}

			if (!empty($filter['filter_search'])) {
				$this->db->like('name', $filter['filter_search']);
			}

			if (is_numeric($filter['filter_status'])) {
				$this->db->where('status', $filter['filter_status']);
			}

			$query = $this->db->get();
			$result = array();

			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}

			return $result;
		}
	}

	public function getPermissions() {
		$this->load->helper('string');

        $this->db->from('permissions');
        $this->db->where('status', '1');

		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $permission = explode('.', $row['name']);
                $domain = isset($permission[0]) ? $permission[0] : 'Admin';
                $controller = isset($permission[1]) ? $permission[1] : '';

                $result[$domain][] = array(
                    'permission_id'     => $row['permission_id'],
                    'name'              => $row['name'],
                    'domain'            => $domain,
                    'controller'        => convert_camelcase_to_underscore($controller, TRUE),
                    'description'       => $row['description'],
                    'action'            => unserialize($row['action']),
                    'status'            => $row['status']
                );
            }
        }

		return $result;
	}

	public function getPermission($permission_id) {
		$this->db->from('permissions');
		$this->db->where('permission_id', $permission_id);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
	}

    public function getPermissionsByIds($permission_id = NULL) {
        $permissions_list = $this->getPermissions();

        foreach ($permissions_list as $domain => $permissions) {
            foreach ($permissions as $permission) {
                if (is_numeric($permission_id) AND $permission_id === $permission['permission_id']) {
                    return $permission;
                }

                $results[$permission['permission_id']] = $permission;
            }
        }

        return $results;
    }

	public function savePermission($permission_id, $save = array()) {
        if (empty($save)) return FALSE;

		if (!empty($save['name'])) {
			$this->db->set('name', $save['name']);
		}

		if (!empty($save['description'])) {
			$this->db->set('description', $save['description']);
		}

		if (!empty($save['action'])) {
			$this->db->set('action', serialize($save['action']));
		}

		if ($save['status'] === '1') {
			$this->db->set('status', $save['status']);
		} else {
			$this->db->set('status', '0');
		}

		if (is_numeric($permission_id)) {
            $notification_action = 'updated';
            $this->db->where('permission_id', $permission_id);
            $query = $this->db->update('permissions');
        } else {
            $notification_action = 'added';
            $query = $this->db->insert('permissions');
            $permission_id = $this->db->insert_id();
        }

        if ($query === TRUE AND is_numeric($permission_id)) {
            $this->load->model('Notifications_model');
            $this->Notifications_model->addNotification(array('action' => $notification_action, 'object' => 'permission', 'object_id' => $permission_id));

            return $permission_id;
        }
	}

	public function deletePermission($permission_id) {
        if (is_numeric($permission_id)) $permission_id = array($permission_id);

        if (!empty($permission_id) AND ctype_digit(implode('', $permission_id))) {
            $this->db->where_in('permission_id', $permission_id);
            $this->db->delete('permissions');

            return $this->db->affected_rows();
        }
	}
}

/* End of file permissions_model.php */
/* Location: ./system/tastyigniter/models/permissions_model.php */