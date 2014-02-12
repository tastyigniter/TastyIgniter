<?php
class Extensions_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}

	public function getList() {
		$this->db->from('extensions');
		
		$query = $this->db->get();
		
		$extensions = array();
		
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$extensions[$row['code']] = $row['name'];
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

	public function install($module, $extension) {
		$this->db->set('type', $module);
		$this->db->set('code', $extension);
		$this->db->set('name', ucwords($extension));

		$this->db->insert('extensions');

		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}

	public function uninstall($module, $extension) {
		$this->db->where('type', $module);
		$this->db->where('code', $extension);

		$this->db->delete('extensions');
	}
}