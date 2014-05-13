<?php
class Activity_model extends CI_Model {

    public function record_count($filter = array()) {
		if (!empty($filter['filter_search'])) {
			$this->db->like('first_name', $filter['filter_search']);
			$this->db->or_like('last_name', $filter['filter_search']);
			$this->db->or_like('browser', $filter['filter_search']);
		}

		if (!empty($filter['filter_access'])) {
			$this->db->where('access_type', $filter['filter_access']);
		}

		if (!empty($filter['filter_type']) AND $filter['filter_type'] === 'online') {
			$this->db->from('online_activity');
			$this->db->join('customers', 'customers.customer_id = online_activity.customer_id', 'left');
		
			if (!empty($filter['filter_search'])) {
				$this->db->or_like('online_activity.ip_address', $filter['filter_search']);
			}
		} else {
			$this->db->from('customers_activity');
			$this->db->join('customers', 'customers.customer_id = customers_activity.customer_id', 'left');
		
			if (!empty($filter['filter_search'])) {
				$this->db->or_like('customers_activity.ip_address', $filter['filter_search']);
			}

			if (!empty($filter['filter_date'])) {
				$date = explode('-', $filter['filter_date']);
				$this->db->where('YEAR('.$this->db->dbprefix('customers_activity.date_added').')', $date[0]);
				$this->db->where('MONTH('.$this->db->dbprefix('customers_activity.date_added').')', $date[1]);
			}
		}
		
		return $this->db->count_all_results();
    }

	public function getList($filter = array()) {
		if ($filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}
		
        if ($this->db->limit($filter['limit'], $filter['page'])) {	
			if (!empty($filter['filter_type']) AND $filter['filter_type'] === 'online') {
				$this->db->select('*, online_activity.ip_address, online_activity.date_added, customers.first_name, customers.last_name');
				$this->db->from('online_activity');
				$this->db->join('customers', 'customers.customer_id = online_activity.customer_id', 'left');
			
				if (!empty($filter['sort_by']) AND !empty($filter['order_by'])) {
					//$this->db->order_by($filter['sort_by'], $filter['order_by']);
					$this->db->order_by('online_activity.date_added', $filter['order_by']);
				} else {
					$this->db->order_by('online_activity.date_added', 'DESC');
				}
		
				if (!empty($filter['filter_search'])) {
					$this->db->or_like('online_activity.ip_address', $filter['filter_search']);
				}
			} else {
				$this->db->select('*, customers_activity.ip_address, customers_activity.date_added, customers.first_name, customers.last_name');
				$this->db->from('customers_activity');
				$this->db->join('customers', 'customers.customer_id = customers_activity.customer_id', 'left');
			
				if (!empty($filter['sort_by']) AND !empty($filter['order_by'])) {
					$this->db->order_by('customers_activity.date_added', $filter['order_by']);
					//$this->db->order_by($filter['sort_by'], $filter['order_by']);
				} else {
					$this->db->order_by('customers_activity.date_added', 'DESC');
				}
		
				if (!empty($filter['filter_search'])) {
					$this->db->or_like('customers_activity.ip_address', $filter['filter_search']);
				}

				if (!empty($filter['filter_date'])) {
					$date = explode('-', $filter['filter_date']);
					$this->db->where('YEAR('.$this->db->dbprefix('customers_activity.date_added').')', $date[0]);
					$this->db->where('MONTH('.$this->db->dbprefix('customers_activity.date_added').')', $date[1]);
				}
			}
		
			if (!empty($filter['filter_search'])) {
				$this->db->or_like('first_name', $filter['filter_search']);
				$this->db->or_like('last_name', $filter['filter_search']);
				$this->db->or_like('browser', $filter['filter_search']);
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
		$this->db->select('*, customers_activity.ip_address, customers_activity.date_added');
		$this->db->from('customers_activity');
		$this->db->join('customers', 'customers.customer_id = customers_activity.customer_id', 'left');
		$this->db->order_by('customers_activity.date_added', 'DESC');

		$this->db->where('customers_activity.customer_id', $customer_id);
		$query = $this->db->get();
		$result = array();
		
		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}
		
		return $result;
	}

	public function getActivityDates($filter = array()) {
		$this->db->select('date_added, MONTH(date_added) as month, YEAR(date_added) as year');

		if (!empty($filter['filter_type']) AND $filter['filter_type'] === 'online') {
			$this->db->from('online_activity');
		} else {
			$this->db->from('customers_activity');
		}
		
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
/* Location: ./application/models/customers_model.php */