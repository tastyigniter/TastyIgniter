<?php
class Countries_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}
	
    public function record_count() {
        return $this->db->count_all('countries');
    }
    
	public function getList($filter = array()) {
		if ($filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}
			
		if ($this->db->limit($filter['limit'], $filter['page'])) {
			$this->db->from('countries');
			$this->db->order_by('country_name', 'ASC');
			
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

	public function addCountry($add = array()) {

		if (!empty($add['country_name'])) {
			$this->db->set('country_name', $add['country_name']);
		}
				
		if (!empty($add['iso_code_2'])) {
			$this->db->set('iso_code_2', $add['iso_code_2']);
		}
		
		if (!empty($add['iso_code_3'])) {
			$this->db->set('iso_code_3', $add['iso_code_3']);
		}
		
		if (!empty($add['format'])) {
			$this->db->set('format', $add['format']);
		}
		
		if ($add['status'] === '1') {
			$this->db->set('status', $add['status']);
		} else {
			$this->db->set('status', '0');
		}

		$this->db->insert('countries');
		
		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}

	public function updateCountry($update = array()) {

		if (!empty($update['country_name'])) {
			$this->db->set('country_name', $update['country_name']);
		}
				
		if (!empty($update['iso_code_2'])) {
			$this->db->set('iso_code_2', $update['iso_code_2']);
		}
		
		if (!empty($update['iso_code_3'])) {
			$this->db->set('iso_code_3', $update['iso_code_3']);
		}
		
		if (!empty($update['format'])) {
			$this->db->set('format', $update['format']);
		}
		
		if ($update['status'] === '1') {
			$this->db->set('status', $update['status']);
		} else {
			$this->db->set('status', '0');
		}

		if (!empty($update['country_id'])) {
			$this->db->where('country_id', $update['country_id']);
			$this->db->update('countries'); 
		}
		
		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}

	public function deleteCountry($country_id) {
		$this->db->where('country_id', $country_id);
		
		$this->db->delete('countries');

		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}
}
