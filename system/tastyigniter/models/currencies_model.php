<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Currencies_model extends TI_Model {

    public function getCount($filter = array()) {
		if (!empty($filter['filter_search'])) {
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
		if (!empty($filter['page']) AND $filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}

        if ($this->db->limit($filter['limit'], $filter['page'])) {
			$this->db->from('currencies');
			$this->db->join('countries', 'countries.country_id = currencies.country_id', 'left');

			if (!empty($filter['sort_by']) AND !empty($filter['order_by'])) {
				$this->db->order_by($filter['sort_by'], $filter['order_by']);
			}

			if (!empty($filter['filter_search'])) {
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

	public function updateCurrency($update = array()) {
		$query = FALSE;

		if (!empty($update['currency_name'])) {
			$this->db->set('currency_name', $update['currency_name']);
		}

		if (!empty($update['currency_code'])) {
			$this->db->set('currency_code', $update['currency_code']);
		}

		if (!empty($update['currency_symbol'])) {
			$this->db->set('currency_symbol', $update['currency_symbol']);
		}

		if (!empty($update['country_id'])) {
			$this->db->set('country_id', $update['country_id']);
		}

		if (!empty($update['iso_alpha2'])) {
			$this->db->set('iso_alpha2', $update['iso_alpha2']);
		}

		if (!empty($update['iso_alpha3'])) {
			$this->db->set('iso_alpha3', $update['iso_alpha3']);
		}

		if (!empty($update['iso_numeric'])) {
			$this->db->set('iso_numeric', $update['iso_numeric']);
		}

		if ($update['currency_status'] === '1') {
			$this->db->set('currency_status', $update['currency_status']);
		} else {
			$this->db->set('currency_status', '0');
		}


		if (!empty($update['currency_id'])) {
			$this->db->where('currency_id', $update['currency_id']);
			$query = $this->db->update('currencies');
		}

		return $query;
	}

	public function addCurrency($add = array()) {
		$query = FALSE;

		if (!empty($add['currency_name'])) {
			$this->db->set('currency_name', $add['currency_name']);
		}

		if (!empty($add['currency_code'])) {
			$this->db->set('currency_code', $add['currency_code']);
		}

		if (!empty($add['currency_symbol'])) {
			$this->db->set('currency_symbol', $add['currency_symbol']);
		}

		if (!empty($add['country_id'])) {
			$this->db->set('country_id', $add['country_id']);
		}

		if (!empty($add['iso_alpha2'])) {
			$this->db->set('iso_alpha2', $add['iso_alpha2']);
		}

		if (!empty($add['iso_alpha3'])) {
			$this->db->set('iso_alpha3', $add['iso_alpha3']);
		}

		if (!empty($add['iso_numeric'])) {
			$this->db->set('iso_numeric', $add['iso_numeric']);
		}

		if ($add['currency_status'] === '1') {
			$this->db->set('currency_status', $add['currency_status']);
		} else {
			$this->db->set('currency_status', '0');
		}

		if (!empty($add)) {
			if ($this->db->insert('currencies')) {
				$query = $this->db->insert_id();
			}
		}

		return $query;
	}

	public function deleteCurrency($currency_id) {
		if (is_numeric($currency_id)) {
			$this->db->where('currency_id', $currency_id);
			$this->db->delete('currencies');

			if ($this->db->affected_rows() > 0) {
				return TRUE;
			}
		}
	}
}

/* End of file currencies_model.php */
/* Location: ./system/tastyigniter/models/currencies_model.php */