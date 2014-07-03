<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Permalinks_model extends CI_Model {

	public function getPermalinks() {
		$this->db->from('permalinks');

		$query = $this->db->get();
		$result = array();
	
		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}
	
		return $result;
	}

	public function getPermalink($query) {
		if (!empty($query)) {
			$this->db->from('permalinks');

			$this->db->where('query', $query);
			$query = $this->db->get();
		
			if ($query->num_rows() > 0) {
				$row = $query->row_array();
				return $row['permalink'];
			}
		}
	}

	public function updatePermalink($update = array()) {
		$query = FALSE;

		if (!empty($update['permalink'])) {
			$this->db->set('permalink', $update['permalink']);
		}
		
		if (!empty($update['query'])) {
			$this->db->where('query', $update['query']);
			$query = $this->db->update('permalinks');			
		}		

		return $query;
	}

	public function addPermalink($add = array()) {
		$query = FALSE;

		if (!empty($add['permalink']) AND !empty($add['query'])) {
			$this->db->where('query', $add['query']);
			$this->db->delete('permalinks');

			$this->db->set('permalink', $add['permalink']);
			$this->db->set('query', $add['query']);

			if ($this->db->insert('permalinks')) {
				$query = $this->db->insert_id();
			}			
		}
		
		return $query;
	}
}

/* End of file permalinks_model.php */
/* Location: ./application/models/permalinks_model.php */