<?php
class Currencies_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}

	public function getList() {
		$this->db->from('currencies');

		$query = $this->db->get();
		return $query->result_array();
	}

	public function getCurrencies() {
		$this->db->from('currencies');

		$this->db->where('currency_status', '1');

		$query = $this->db->get();
		return $query->result_array();
	}

	public function getCurrency($currency_id) {
		$this->db->from('currencies');

		$this->db->where('currency_id', $currency_id);

		$query = $this->db->get();
		
		return $query->row_array();
	}
	
	public function updateCurrency($update = array()) {
		
		if (!empty($update['currency_title'])) {
			$this->db->set('currency_title', $update['currency_title']);
		}
		
		if (!empty($update['currency_code'])) {
			$this->db->set('currency_code', $update['currency_code']);
		}
		
		if (!empty($update['currency_symbol'])) {
			$this->db->set('currency_symbol', $update['currency_symbol']);
		}
		
		if ($update['currency_status'] === '1') {
			$this->db->set('currency_status', $update['currency_status']);
		} else {
			$this->db->set('currency_status', '0');
		}

		
		if (!empty($update['currency_id'])) {
			$this->db->where('currency_id', $update['currency_id']);
			$this->db->update('currencies');
		}		
		
		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}

	public function addCurrency($add = array()) {
		
		if (!empty($add['currency_title'])) {
			$this->db->set('currency_title', $add['currency_title']);
		}
		
		if (!empty($add['currency_code'])) {
			$this->db->set('currency_code', $add['currency_code']);
		}
		
		if (!empty($add['currency_symbol'])) {
			$this->db->set('currency_symbol', $add['currency_symbol']);
		}
		
		if ($add['currency_status'] === '1') {
			$this->db->set('currency_status', $add['currency_status']);
		} else {
			$this->db->set('currency_status', '0');
		}

		$this->db->insert('currencies');
		
		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}

	public function deleteCurrency($currency_id) {
		$this->db->where('currency_id', $currency_id);

		$this->db->delete('currencies');

		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}
}