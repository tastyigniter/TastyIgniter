<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Extensions_model extends CI_Model {
	public function getList($type = '') {
		$this->db->from('extensions');
		
		if (!empty($type)) {
			$this->db->where('type', $type);
		}
		
		$query = $this->db->get();
		
		$results = array();
		
		if ($query->num_rows() > 0) {
			$results = $query->result_array();
		}
		
		return $results;
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

	public function getModules() {
		$this->db->from('extensions');
		$this->db->where('type', 'module');
		
		$query = $this->db->get();
	
		$result = array();
	
		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}
	
		return $result;
	}

	public function getExtension($type = '', $name = '') {
		$result = array();

		if (!empty($type) AND !empty($name)) {
			$this->db->from('extensions');
			$this->db->where('type', $type);
			$this->db->where('name', $name);
	
			$query = $this->db->get();
	
			if ($query->num_rows() > 0) {
				$result = $query->row_array();
			}
		}
		
		return $result;
	}

	public function getPayment($name = '') {
		$result = array();

		if (!empty($name)) {
			$this->db->from('extensions');
			$this->db->where('name', $name);
			$this->db->where('type', 'payment');
		
			$query = $this->db->get();
		
			if ($query->num_rows() > 0) {
				$row = $query->row_array();
				
				$result = array(
					'name'		=> $row['name'],
					'data'		=> unserialize($row['data'])
				);
			}
		}
		
		return $result;
	}

	public function updateExtension($update = array(), $serialized = '0') {
		$query = FALSE;
		
		if (!empty($update['type']) AND !empty($update['name']) AND !empty($update['data'])) {
			if (is_array($update['data']) AND $serialized === '1') {
				$data = serialize($update['data']);
			} else {
				$data = $update['data'];
			}
			

			if (!empty($update['extension_id'])) {
				$this->db->set('data', $data);
				$this->db->set('serialized', $serialized);
				$this->db->where('type', $update['type']);
				$this->db->where('name', $update['name']);
				$this->db->where('extension_id', $update['extension_id']);
				$query = $this->db->update('extensions'); 
			} else {
				$this->uninstall($update['type'], $update['name']);
				$this->db->set('data', $data);
				$this->db->set('serialized', $serialized);
				$this->db->set('type', $update['type']);
				$this->db->set('name', $update['name']);
				$query = $this->db->insert('extensions');
			}
		}
		
		return $query;
	}


	public function install($type = '', $name = '') {
		if (!empty($type) AND !empty($name)) {
			$this->db->set('type', $type);
			$this->db->set('name', $name);

			if ($this->db->insert('extensions')) {
				return $this->db->insert_id();
			}
		}
	}

	public function uninstall($type = '', $name = '') {
		if (!empty($type) AND !empty($name)) {
			$this->db->where('type', $type);
			$this->db->where('name', $name);

			return $this->db->delete('extensions');
		}
	}
}

/* End of file extensions_model.php */
/* Location: ./application/models/extensions_model.php */