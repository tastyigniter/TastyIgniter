<?php
class Settings_model extends CI_Model {

	public function __construct() {
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
	
	public function deleteSettings($sort) {
		$this->db->where('sort', $sort);
			
		return $this->db->delete('settings');
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
