<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Currencies_model extends TI_Model {

	public function getCount($filter = array()) {
		if ( ! empty($filter['filter_search'])) {
			$this->db->like('currency_name', $filter['filter_search']);
			$this->db->or_like('currency_code', $filter['filter_search']);
			$this->db->or_like('country_name', $filter['filter_search']);
		}

		if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
			$this->db->where('currency_status', $filter['filter_status']);
		}

		$this->db->from('currencies');
		$this->db->join('countries', 'countries.country_id = currencies.country_id', 'left');

		return $this->db->count_all_results();
	}

	public function getList($filter = array()) {
		if ( ! empty($filter['page']) AND $filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}

		if ($this->db->limit($filter['limit'], $filter['page'])) {
			$this->db->from('currencies');
			$this->db->join('countries', 'countries.country_id = currencies.country_id', 'left');

			if ( ! empty($filter['sort_by']) AND ! empty($filter['order_by'])) {
				$this->db->order_by($filter['sort_by'], $filter['order_by']);
			}

			if ( ! empty($filter['filter_search'])) {
				$this->db->like('currency_name', $filter['filter_search']);
				$this->db->or_like('currency_code', $filter['filter_search']);
				$this->db->or_like('country_name', $filter['filter_search']);
			}

			if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
				$this->db->where('currency_status', $filter['filter_status']);
			}

			$query = $this->db->get();
			$result = array();

			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}

			return $result;
		}
	}

	public function getCurrencies() {
		$this->db->from('currencies');

		$this->db->where('currency_status', '1');

		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function getCurrency($currency_id) {
		$this->db->from('currencies');

		$this->db->where('currency_id', $currency_id);

		$query = $this->db->get();

		if ($this->db->affected_rows() > 0) {
			return $query->row_array();
		}
	}

	public function saveCurrency($currency_id, $save = array()) {
		if (empty($save)) return FALSE;

		if (isset($save['currency_name'])) {
			$this->db->set('currency_name', $save['currency_name']);
		}

		if (isset($save['currency_code'])) {
			$this->db->set('currency_code', $save['currency_code']);
		}

		if (isset($save['currency_symbol'])) {
			$this->db->set('currency_symbol', $save['currency_symbol']);
		}

		if (isset($save['country_id'])) {
			$this->db->set('country_id', $save['country_id']);
		}

		if (isset($save['iso_alpha2'])) {
			$this->db->set('iso_alpha2', $save['iso_alpha2']);
		}

		if (isset($save['iso_alpha3'])) {
			$this->db->set('iso_alpha3', $save['iso_alpha3']);
		}

		if (isset($save['iso_numeric'])) {
			$this->db->set('iso_numeric', $save['iso_numeric']);
		}

		if (isset($save['currency_status']) AND $save['currency_status'] === '1') {
			$this->db->set('currency_status', $save['currency_status']);
		} else {
			$this->db->set('currency_status', '0');
		}

		if (is_numeric($currency_id)) {
			$this->db->where('currency_id', $currency_id);
			$query = $this->db->update('currencies');
		} else {
			$query = $this->db->insert('currencies');
			$currency_id = $this->db->insert_id();
		}

		return ($query === TRUE AND is_numeric($currency_id)) ? $currency_id : FALSE;
	}

	public function deleteCurrency($currency_id) {
		if (is_numeric($currency_id)) $currency_id = array($currency_id);

		if ( ! empty($currency_id) AND ctype_digit(implode('', $currency_id))) {
			$this->db->where_in('currency_id', $currency_id);
			$this->db->delete('currencies');

			return $this->db->affected_rows();
		}
	}
}

/* End of file currencies_model.php */
/* Location: ./system/tastyigniter/models/currencies_model.php */