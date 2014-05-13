<?php
class Languages_model extends CI_Model {

    public function record_count($filter = array()) {
		if (!empty($filter['filter_search'])) {
			$this->db->like('name', $filter['filter_search']);
			$this->db->or_like('code', $filter['filter_search']);
		}

		if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
			$this->db->where('status', $filter['filter_status']);
		}
	
		$this->db->from('languages');
		return $this->db->count_all_results();
    }
    
	public function getList($filter = array()) {
		if ($filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}
			
		if ($this->db->limit($filter['limit'], $filter['page'])) {
			$this->db->from('languages');
		
			if (!empty($filter['filter_search'])) {
				$this->db->like('name', $filter['filter_search']);
				$this->db->or_like('code', $filter['filter_search']);
			}

			if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
				$this->db->where('status', $filter['filter_status']);
			}
	
			$query = $this->db->get();
		
			$result = array();
	
			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}
	
			return $result;
		}
	}

	public function getLanguages() {
		$this->db->from('languages');
		
		$this->db->where('status', '1');

		$query = $this->db->get();
		
		$result = array();
	
		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}
	
		return $result;
	}

	public function getLanguage($language_id) {
		$this->db->from('languages');

		$this->db->where('language_id', $language_id);

		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
	}

	public function updateLanguage($update = array()) {
		$query = FALSE;

		if (!empty($update['name'])) {
			$this->db->set('name', $update['name']);
		}
		
		if (!empty($update['code'])) {
			$this->db->set('code', $update['code']);
		}
		
		if (!empty($update['image'])) {
			$this->db->set('image', $update['image']);
		}
		
		if (!empty($update['directory'])) {
			$this->db->set('directory', $update['directory']);
		}
		
		if ($update['status'] === '1') {
			$this->db->set('status', '1');
		} else {
			$this->db->set('status', '0');
		}
		
		if (!empty($update['language_id'])) {
			$this->db->where('language_id', $update['language_id']);
			$this->db->update('languages');			
		}		

		if ($this->db->affected_rows() > 0) {
			$query = TRUE;
		}

		return $query;
	}

	public function addLanguage($add = array()) {

		if (!empty($add['name'])) {
			$this->db->set('name', $add['name']);
		}
		
		if (!empty($add['code'])) {
			$this->db->set('code', $add['code']);
		}
		
		if (!empty($add['image'])) {
			$this->db->set('image', $add['image']);
		}
		
		if (!empty($add['directory'])) {
			$this->db->set('directory', $add['directory']);
		}
		
		if ($add['status'] === '1') {
			$this->db->set('status', '1');
		} else {
			$this->db->set('status', '0');
		}
		
		$this->db->insert('languages');			

		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}

	public function deleteLanguage($language_id) {
		$this->db->where('language_id', $language_id);
		$this->db->delete('languages');

		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}
}

/* End of file languages_model.php */
/* Location: ./application/models/languages_model.php */