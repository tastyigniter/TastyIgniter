<?php
class Extensions_model extends CI_Model {

	public function getList($type = '') {
		$this->db->from('extensions');
		$this->db->where('type', $type);
		
		$query = $this->db->get();
		
		$extensions = array();
		
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$extensions[] = $row['code'];
			}
		}
		
		return $extensions;
	}

	public function getExtensions() {
		$this->db->from('extensions');
		
		$query = $this->db->get();
	
		$result = array();
	
		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}
	
		return $result;
	}

	public function getExtension($module, $extension) {
		$this->db->from('extensions');
		$this->db->where('type', $module);
		$this->db->where('code', $extension);
		
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
		
		return FALSE;
	}

	public function install($type, $extension) {
		$this->db->set('type', $type);
		$this->db->set('code', $extension);

		if ($this->db->insert('extensions')) {
			return $this->db->insert_id();
		}
	}

	public function uninstall($type, $extension) {
		$this->db->where('type', $type);
		$this->db->where('code', $extension);

		return $this->db->delete('extensions');
	}
}

/* End of file extensions_model.php */
/* Location: ./application/models/extensions_model.php */