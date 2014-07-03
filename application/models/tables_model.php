<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Tables_model extends CI_Model {

    public function getAdminListCount($filter) {
		if (!empty($filter['filter_search'])) {
			$this->db->like('table_name', $filter['filter_search']);
		}

		if (is_numeric($filter['filter_status'])) {
			$this->db->where('table_status', $filter['filter_status']);
		}
	
		$this->db->from('tables');
		return $this->db->count_all_results();
    }
	
	public function getList($filter = array()) {
		if ($filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}
		
        if ($this->db->limit($filter['limit'], $filter['page'])) {	
			$this->db->from('tables');
			
			if (!empty($filter['sort_by']) AND !empty($filter['order_by'])) {
				$this->db->order_by($filter['sort_by'], $filter['order_by']);
			}

			if (!empty($filter['filter_search'])) {
				$this->db->like('table_name', $filter['filter_search']);
			}

			if (is_numeric($filter['filter_status'])) {
				$this->db->where('table_status', $filter['filter_status']);
			}
		
			$query = $this->db->get();
			$result = array();
		
			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}
		
			return $result;
		}
	}
	
	public function getTables() {
		$this->db->from('tables');
		//$this->db->join('locations', 'locations.location_id = tables.location_id', 'left');

		$query = $this->db->get();
		$result = array();
	
		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}
	
		return $result;
	}

	public function getTable($table_id) {		
		$this->db->from('tables');
		$this->db->where('table_id', $table_id);
		
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
	}

	public function getTablesByLocation($location_id = FALSE) {		
		$this->db->from('location_tables');

		$this->db->where('location_id', $location_id);
		
		$query = $this->db->get();
		
		$location_tables = array();
		
		if ($query->num_rows() > 0) {
			
			foreach ($query->result_array() as $row) {
				$location_tables[] = $row['table_id'];
			}
		}
	
		return $location_tables;
	}

	public function getAutoComplete($filter_data = array()) {
		if (is_array($filter_data) && !empty($filter_data)) {

			if (!empty($filter_data['table_name'])) {
				$this->db->from('tables');
				$this->db->where('table_status >', '0');	
				$this->db->like('table_name', $filter_data['table_name']);		
			}
	
			$query = $this->db->get();
			$result = array();
		
			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}
		
			return $result;
		}
	}

	public function updateTable($update = array()) {
		$query = FALSE;

		if (!empty($update['table_name'])) {
			$this->db->set('table_name', $update['table_name']);
		}

		if (!empty($update['min_capacity'])) {
			$this->db->set('min_capacity', $update['min_capacity']);
		}

		if (!empty($update['max_capacity'])) {
			$this->db->set('max_capacity', $update['max_capacity']);
		}

		if ($update['table_status'] === '1') {
			$this->db->set('table_status', $update['table_status']);
		} else {
			$this->db->set('table_status', '0');
		}

		if (!empty($update['table_id'])) {
			$this->db->where('table_id', $update['table_id']);
			$query = $this->db->update('tables'); 
		}
		
		return $query;
	}

	public function addTable($add = array()) {
		$query = FALSE;
		
		if (!empty($add['table_name'])) {
			$this->db->set('table_name', $add['table_name']);
		}

		if (!empty($add['min_capacity'])) {
			$this->db->set('min_capacity', $add['min_capacity']);
		}

		if (!empty($add['max_capacity'])) {
			$this->db->set('max_capacity', $add['max_capacity']);
		}

		if ($add['table_status'] === '1') {
			$this->db->set('table_status', $add['table_status']);
		} else {
			$this->db->set('table_status', '0');
		}

		if (!empty($add)) {
			if ($this->db->insert('tables')) {
				$query = $this->db->insert_id();
			}
		}

		return $query;
	}

	public function deleteTable($table_id) {
		if (is_numeric($table_id)) {
			$this->db->where('table_id', $table_id);
			$this->db->delete('tables');

			if ($this->db->affected_rows() > 0) {
				return TRUE;
			}
		}
	}
}

/* End of file tables_model.php */
/* Location: ./application/models/tables_model.php */