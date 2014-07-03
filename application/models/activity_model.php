<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Activity_model extends CI_Model {

    public function getAdminListCount($filter = array()) {
		if (!empty($filter['filter_search'])) {
			$this->db->like('first_name', $filter['filter_search']);
			$this->db->or_like('last_name', $filter['filter_search']);
			$this->db->or_like('browser', $filter['filter_search']);
			$this->db->or_like('customers_activity.ip_address', $filter['filter_search']);
			$this->db->or_like('country_code', $filter['filter_search']);
		}

		if (!empty($filter['filter_access'])) {
			$this->db->where('access_type', $filter['filter_access']);
		}

		if (!empty($filter['filter_type']) AND $filter['filter_type'] === 'online') {
			$this->db->where('customers_activity.date_added >=', $filter['time_out']);
		}

		if (!empty($filter['filter_date'])) {
			$date = explode('-', $filter['filter_date']);
			$this->db->where('YEAR('.$this->db->dbprefix('customers_activity.date_added').')', $date[0]);
			$this->db->where('MONTH('.$this->db->dbprefix('customers_activity.date_added').')', $date[1]);
		}
		
		$this->db->from('customers_activity');
		$this->db->join('customers', 'customers.customer_id = customers_activity.customer_id', 'left');
		return $this->db->count_all_results();
    }

	public function getList($filter = array()) {
		if ($filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}
		
        if ($this->db->limit($filter['limit'], $filter['page'])) {	
			$this->db->select('*, customers_activity.ip_address, customers_activity.date_added, customers.first_name, customers.last_name');
			$this->db->from('customers_activity');
			$this->db->join('customers', 'customers.customer_id = customers_activity.customer_id', 'left');
			$this->db->join('countries', 'countries.iso_code_2 = customers_activity.country_code', 'left');
		
			if (!empty($filter['sort_by']) AND !empty($filter['order_by'])) {
				//$this->db->order_by($filter['sort_by'], $filter['order_by']);
				$this->db->order_by('customers_activity.date_added', $filter['order_by']);
			}
	
			if (!empty($filter['filter_type']) AND $filter['filter_type'] === 'online') {
				$this->db->where('customers_activity.date_added >=', $filter['time_out']);
			}

			if (!empty($filter['filter_search'])) {
				$this->db->or_like('first_name', $filter['filter_search']);
				$this->db->or_like('last_name', $filter['filter_search']);
				$this->db->or_like('browser', $filter['filter_search']);
				$this->db->or_like('customers_activity.ip_address', $filter['filter_search']);
				$this->db->or_like('country_code', $filter['filter_search']);
			}

			if (!empty($filter['filter_date']) AND $filter['filter_type'] !== 'online') {
				$date = explode('-', $filter['filter_date']);
				$this->db->where('YEAR('.$this->db->dbprefix('customers_activity.date_added').')', $date[0]);
				$this->db->where('MONTH('.$this->db->dbprefix('customers_activity.date_added').')', $date[1]);
			}
		
			if (!empty($filter['filter_access'])) {
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
    	
	public function getCustomerActivities($customer_id) {
		$result = array();
		if ($customer_id) {
			$this->db->select('*, customers_activity.ip_address, customers_activity.date_added');
			$this->db->from('customers_activity');
			$this->db->join('customers', 'customers.customer_id = customers_activity.customer_id', 'left');
			$this->db->order_by('customers_activity.date_added', 'DESC');

			$this->db->where('customers_activity.customer_id', $customer_id);
			$query = $this->db->get();
		
			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}
		
		}

		return $result;
	}

	public function getActivityDates($filter = array()) {
		$this->db->select('date_added, MONTH(date_added) as month, YEAR(date_added) as year');
		$this->db->from('customers_activity');
		$this->db->group_by('MONTH(date_added)');
		$this->db->group_by('YEAR(date_added)');
		
		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function deleteActivity($activity_id) {
		if (is_numeric($activity_id)) {
			$this->db->where('activity_id', $activity_id);
			$this->db->delete('customers_activity');
		
			if ($this->db->affected_rows() > 0) {
				return TRUE;
			}
		}
	}
}

/* End of file customers_model.php */
/* Location: ./application/models/customers_model.php */