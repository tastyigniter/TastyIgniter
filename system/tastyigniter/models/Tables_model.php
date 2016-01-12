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
 * Tables Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Tables_model.php
 * @link           http://docs.tastyigniter.com
 */
class Tables_model extends TI_Model {

	public function getCount($filter) {
		if ( ! empty($filter['filter_search'])) {
			$this->db->like('table_name', $filter['filter_search']);
		}

		if (is_numeric($filter['filter_status'])) {
			$this->db->where('table_status', $filter['filter_status']);
		}

		$this->db->from('tables');

		return $this->db->count_all_results();
	}

	public function getList($filter = array()) {
		if ( ! empty($filter['page']) AND $filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}

		if ($this->db->limit($filter['limit'], $filter['page'])) {
			$this->db->from('tables');

			if ( ! empty($filter['sort_by']) AND ! empty($filter['order_by'])) {
				$this->db->order_by($filter['sort_by'], $filter['order_by']);
			}

			if ( ! empty($filter['filter_search'])) {
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
		if (is_array($filter_data) && ! empty($filter_data)) {

			if ( ! empty($filter_data['table_name'])) {
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

	public function saveTable($table_id, $save = array()) {
		if (empty($save)) return FALSE;

		if (isset($save['table_name'])) {
			$this->db->set('table_name', $save['table_name']);
		}

		if (isset($save['min_capacity'])) {
			$this->db->set('min_capacity', $save['min_capacity']);
		}

		if (isset($save['max_capacity'])) {
			$this->db->set('max_capacity', $save['max_capacity']);
		}

		if (isset($save['table_status']) AND $save['table_status'] === '1') {
			$this->db->set('table_status', $save['table_status']);
		} else {
			$this->db->set('table_status', '0');
		}

		if (is_numeric($table_id)) {
			$this->db->where('table_id', $table_id);
			$query = $this->db->update('tables');
		} else {
			$query = $this->db->insert('tables');
			$table_id = $this->db->insert_id();
		}

		return $table_id;
	}

	public function deleteTable($table_id) {
		if (is_numeric($table_id)) $table_id = array($table_id);

		if ( ! empty($table_id) AND ctype_digit(implode('', $table_id))) {
			$this->db->where_in('table_id', $table_id);
			$this->db->delete('tables');

			return $this->db->affected_rows();
		}
	}
}

/* End of file tables_model.php */
/* Location: ./system/tastyigniter/models/tables_model.php */