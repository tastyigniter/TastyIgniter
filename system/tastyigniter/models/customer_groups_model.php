<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Customer_groups_model extends TI_Model {

    public function getCount($filter = array()) {
		$this->db->from('customer_groups');
		return $this->db->count_all_results();
    }

	public function getList($filter = array()) {
		if (!empty($filter['page']) AND $filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}

		if ($this->db->limit($filter['limit'], $filter['page'])) {
			$this->db->from('customer_groups');

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

	public function getCustomerGroups() {
		$this->db->from('customer_groups');

		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function getCustomerGroup($customer_group_id) {
		$this->db->from('customer_groups');

		$this->db->where('customer_group_id', $customer_group_id);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
	}

	public function updateCustomerGroup($update = array()) {
		$query = FALSE;

		if (!empty($update['group_name'])) {
			$this->db->set('group_name', $update['group_name']);
		}

		if (!empty($update['description'])) {
			$this->db->set('description', $update['description']);
		}

		if ($update['approval'] === '1') {
			$this->db->set('approval', $update['approval']);
		} else {
			$this->db->set('approval', '0');
		}

		if (!empty($update['customer_group_id'])) {
			$this->db->where('customer_group_id', $update['customer_group_id']);
			$query = $this->db->update('customer_groups');
		}

		return $query;
	}

	public function addCustomerGroup($add = array()) {
		$query = FALSE;

		if (!empty($add['group_name'])) {
			$this->db->set('group_name', $add['group_name']);
		}

		if (!empty($add['description'])) {
			$this->db->set('description', $add['description']);
		}

		if ($add['approval'] === '1') {
			$this->db->set('approval', $add['approval']);
		} else {
			$this->db->set('approval', '0');
		}

		if (!empty($add)) {
			if ($this->db->insert('customer_groups')) {
				$query = $this->db->insert_id();
			}
		}

		return $query;
	}

	public function deleteCustomerGroup($customer_group_id) {
		if (is_numeric($customer_group_id)) {
			$this->db->where('customer_group_id', $customer_group_id);
			$this->db->delete('customer_groups');

			if ($this->db->affected_rows() > 0) {
				return TRUE;
			}
		}
	}
}

/* End of file customer_groups_model.php */
/* Location: ./system/tastyigniter/models/customer_groups_model.php */