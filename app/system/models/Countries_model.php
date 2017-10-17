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
 * Countries Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Countries_model.php
 * @link           http://docs.tastyigniter.com
 */
class Countries_model extends TI_Model {

	public function getCount($filter = array()) {
		if (isset($filter['filter_search'])) {
			$this->db->like('country_name', $filter['filter_search']);
		}

		if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
			$this->db->where('status', $filter['filter_status']);
		}

		$this->db->from('countries');

		return $this->db->count_all_results();
	}

	public function getList($filter = array()) {
		if ( ! empty($filter['page']) AND $filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}

		if ($this->db->limit($filter['limit'], $filter['page'])) {
			$this->db->from('countries');

			if ( ! empty($filter['filter_search'])) {
				$this->db->like('country_name', $filter['filter_search']);
			}

			if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
				$this->db->where('status', $filter['filter_status']);
			}

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

	public function getCountries() {
		$this->db->from('countries');
		$this->db->order_by('country_name', 'ASC');

		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function getCountry($country_id) {
		$this->db->from('countries');
		$this->db->where('country_id', $country_id);

		$query = $this->db->get();

		if ($this->db->affected_rows() > 0) {
			return $query->row_array();
		}
	}

	public function saveCountry($country_id, $save = array()) {
		if (empty($save)) return FALSE;

		if (isset($save['country_name'])) {
			$this->db->set('country_name', $save['country_name']);
		}

		if (isset($save['iso_code_2'])) {
			$this->db->set('iso_code_2', $save['iso_code_2']);
		}

		if (isset($save['iso_code_3'])) {
			$this->db->set('iso_code_3', $save['iso_code_3']);
		}

		if (isset($save['flag'])) {
			$this->db->set('flag', $save['flag']);
		}

		if (isset($save['format'])) {
			$this->db->set('format', $save['format']);
		}

		if (isset($save['status']) AND $save['status'] === '1') {
			$this->db->set('status', $save['status']);
		} else {
			$this->db->set('status', '0');
		}

		if (is_numeric($country_id)) {
			$this->db->where('country_id', $country_id);
			$query = $this->db->update('countries');
		} else {
			$query = $this->db->insert('countries');
			$country_id = $this->db->insert_id();
		}

		return ($query === TRUE AND is_numeric($country_id)) ? $country_id : FALSE;
	}

	public function deleteCountry($country_id) {
		if (is_numeric($country_id)) $country_id = array($country_id);

		if ( ! empty($country_id) AND ctype_digit(implode('', $country_id))) {
			$this->db->where_in('country_id', $country_id);
			$this->db->delete('countries');

			return $this->db->affected_rows();
		}
	}
}

/* End of file countries_model.php */
/* Location: ./system/tastyigniter/models/countries_model.php */