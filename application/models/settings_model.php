<?php
class Settings_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function getAll() {
		$this->db->from('settings');
		
		$query = $this->db->get();
		$result = array();
	
		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}
	
		return $result;
	}

	public function getdbTables() {
		return $this->db->list_tables();
	}
	
	public function updateSettings($sort, $update = array()) {
 		if (!empty($update) && !empty($sort)) {
			$this->db->where('sort', $sort);
			$this->db->delete('settings');

			foreach ($update as $key => $value) {
				if (is_array($value)) {
					$this->db->set('sort', $sort);
					$this->db->set('key', $key);
					$this->db->set('value', serialize($value));
					$this->db->set('serialized', '1');
					$this->db->insert('settings');
				} else {
					$this->db->set('sort', $sort);
					$this->db->set('key', $key);
					$this->db->set('value', $value);
					$this->db->set('serialized', '0');
					$this->db->insert('settings');
				}
			}
		
			return TRUE;
		}
 	}
	
	public function addSetting($sort, $key, $value, $serialized = '0') {
		$query = FALSE;
		
		if (isset($sort, $key, $value, $serialized)) {
			$this->db->where('sort', $sort);
			$this->db->where('key', $key);
			$this->db->delete('settings');

			$this->db->set('sort', $sort);
			$this->db->set('key', $key);
			
			if (is_array($value)) {
				$this->db->set('value', serialize($value));
			} else {
				$this->db->set('value', $value);
			}
			
			$this->db->set('serialized', $serialized);
			if ($this->db->insert('settings')) {
				$query = $this->db->insert_id();
			}
		}

		return $query;
	}
	
	public function deleteSettings($sort, $key) {
		if (!empty($sort) AND !empty($key)) {
			$this->db->where('sort', $sort);
			$this->db->where('key', $key);
			$this->db->delete('settings');

			if ($this->db->affected_rows() > 0) {
				return TRUE;
			}
		}
	}

	public function backupDatabase($tables = array()) {
		if (!empty($tables)) {
			$this->load->dbutil();
			$this->load->helper('file');

			$prefs = array(
				'tables'      => $tables,  // Array of tables to backup.
				'format'      => 'txt',             // gzip, zip, txt
				'add_drop'    => TRUE,              // Whether to add DROP TABLE statements to backup file
				'add_insert'  => TRUE,              // Whether to add INSERT data to backup file
				'newline'     => "\n"               // Newline character used in backup file
			);

			$backup =& $this->dbutil->backup($prefs);
		
			$this->load->helper('file');
			write_file('./assets/download/tastyigniter.sql', $backup); 
			
			return TRUE;
		}
		
		return FALSE;
	}

	public function restoreDatabase($content) {
		if ($content) {
			foreach(explode(";\n", $content) as $sql) {
				$sql = trim($sql);

				if ($sql) {
					$this->db->query($sql);
				}
			}
			
			$this->db->query("SET CHARACTER SET utf8");
			
			return TRUE;
		}
	}
}

/* End of file settings_model.php */
/* Location: ./application/models/settings_model.php */