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
 * Customer_groups Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Customer_groups_model.php
 * @link           http://docs.tastyigniter.com
 */

class Customer_groups_model extends TI_Model {

	public function getCount($filter = array()) {
		$this->db->from('customer_groups');

		return $this->db->count_all_results();
	}

	public function getList($filter = array()) {
		if ( ! empty($filter['page']) AND $filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}

		if ($this->db->limit($filter['limit'], $filter['page'])) {
			$this->db->from('customer_groups');

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

	public function saveCustomerGroup($customer_group_id, $save = array()) {
		if (empty($save)) return FALSE;

		if (isset($save['group_name'])) {
			$this->db->set('group_name', $save['group_name']);
		}

		if (isset($save['description'])) {
			$this->db->set('description', $save['description']);
		}

		if (isset($save['approval']) AND $save['approval'] === '1') {
			$this->db->set('approval', $save['approval']);
		} else {
			$this->db->set('approval', '0');
		}

		if (is_numeric($customer_group_id)) {
			$this->db->where('customer_group_id', $customer_group_id);
			$query = $this->db->update('customer_groups');
		} else {
			$query = $this->db->insert('customer_groups');
			$customer_group_id = $this->db->insert_id();
		}

		return ($query === TRUE AND is_numeric($customer_group_id)) ? $customer_group_id : FALSE;
	}

	public function deleteCustomerGroup($customer_group_id) {
		if (is_numeric($customer_group_id)) $customer_group_id = array($customer_group_id);

		if ( ! empty($customer_group_id) AND ctype_digit(implode('', $customer_group_id))) {
			$this->db->where_in('customer_group_id', $customer_group_id);
			$this->db->delete('customer_groups');

			return $this->db->affected_rows();
		}
	}
}

/* End of file customer_groups_model.php */
/* Location: ./system/tastyigniter/models/customer_groups_model.php */