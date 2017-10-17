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
 * Customer_online Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Customer_online_model.php
 * @link           http://docs.tastyigniter.com
 */
class Customer_online_model extends TI_Model {

	public function getCount($filter = array()) {
		if ( ! empty($filter['filter_search'])) {
			$this->db->like('first_name', $filter['filter_search']);
			$this->db->or_like('last_name', $filter['filter_search']);
			$this->db->or_like('browser', $filter['filter_search']);
			$this->db->or_like('customers_online.ip_address', $filter['filter_search']);
			$this->db->or_like('country_code', $filter['filter_search']);
		}

		if ( ! empty($filter['filter_access'])) {
			$this->db->where('access_type', $filter['filter_access']);
		}

		if ( ! empty($filter['filter_type']) AND $filter['filter_type'] === 'online') {
			$this->db->where('customers_online.date_added >=', $filter['time_out']);
		}

		if ( ! empty($filter['filter_date'])) {
			$date = explode('-', $filter['filter_date']);
			$this->db->where('YEAR(' . $this->db->dbprefix('customers_online.date_added') . ')', $date[0]);
			$this->db->where('MONTH(' . $this->db->dbprefix('customers_online.date_added') . ')', $date[1]);
		}

		$this->db->from('customers_online');
		$this->db->join('customers', 'customers.customer_id = customers_online.customer_id', 'left');

		return $this->db->count_all_results();
	}

	public function getList($filter = array()) {
		if ( ! empty($filter['page']) AND $filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}

		if ($this->db->limit($filter['limit'], $filter['page'])) {
			$this->db->select('*, customers_online.ip_address, customers_online.date_added, customers.first_name, customers.last_name');
			$this->db->from('customers_online');
			$this->db->join('customers', 'customers.customer_id = customers_online.customer_id', 'left');
			$this->db->join('countries', 'countries.iso_code_2 = customers_online.country_code', 'left');

			if ( ! empty($filter['sort_by']) AND ! empty($filter['order_by'])) {
				//$this->db->order_by($filter['sort_by'], $filter['order_by']);
				$this->db->order_by('customers_online.date_added', $filter['order_by']);
			}

			if ( ! empty($filter['filter_type']) AND $filter['filter_type'] === 'online') {
				$this->db->where('customers_online.date_added >=', $filter['time_out']);
			}

			if ( ! empty($filter['filter_search'])) {
				$this->db->or_like('first_name', $filter['filter_search']);
				$this->db->or_like('last_name', $filter['filter_search']);
				$this->db->or_like('browser', $filter['filter_search']);
				$this->db->or_like('customers_online.ip_address', $filter['filter_search']);
				$this->db->or_like('country_code', $filter['filter_search']);
			}

			if ( ! empty($filter['filter_date']) AND $filter['filter_type'] !== 'online') {
				$date = explode('-', $filter['filter_date']);
				$this->db->where('YEAR(' . $this->db->dbprefix('customers_online.date_added') . ')', $date[0]);
				$this->db->where('MONTH(' . $this->db->dbprefix('customers_online.date_added') . ')', $date[1]);
			}

			if ( ! empty($filter['filter_access'])) {
				$this->db->where('access_type', $filter['filter_access']);
			}

			$query = $this->db->get();
			$result = array();

			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}

			return $result;
		}
	}

	public function getCustomersOnline() {
		$this->db->from('customers_online');

		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function getCustomerOnline($customer_id) {
		$result = array();
		if ($customer_id) {
			$this->db->select('*, customers_online.ip_address, customers_online.date_added');
			$this->db->from('customers_online');
			$this->db->join('customers', 'customers.customer_id = customers_online.customer_id', 'left');
			$this->db->order_by('customers_online.date_added', 'DESC');

			$this->db->where('customers_online.customer_id', $customer_id);
			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}
		}

		return $result;
	}

	public function getLastOnline($ip) {
		if ($this->input->valid_ip($ip)) {
			$this->db->select('*');
			$this->db->select_max('date_added');
			$this->db->from('customers_online');
			$this->db->where('ip_address', $ip);

			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->row_array();
			}
		}
	}

	public function getOnlineDates($filter = array()) {
		$this->db->select('date_added, MONTH(date_added) as month, YEAR(date_added) as year');
		$this->db->from('customers_online');
		$this->db->group_by('MONTH(date_added)');
		$this->db->group_by('YEAR(date_added)');

		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}
}

/* End of file customers_model.php */
/* Location: ./system/tastyigniter/models/customers_model.php */