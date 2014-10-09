<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Setup_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}

	public function addData($add = array()) {
		$query = FALSE;

		$file = APPPATH .'/extensions/setup/migrations/initial_schema.sql';
		if (!file_exists($file)) { 
			return FALSE; 
		}

		$lines = file($file);
		if ($lines) {
			$sql = '';

			foreach($lines as $line) {
				if ($line && (substr($line, 0, 1) != '#')) {
					$sql .= $line;
  
					if (preg_match('/;\s*$/', $line)) {
						$sql = str_replace('INSERT INTO ti_', 'INSERT INTO '. $this->db->dbprefix, $sql);
						$this->db->query($sql);
						$sql = '';
					}
				}
			}
			
			$query = TRUE;
		}

		if ($this->addUser($add)) {
			$query = TRUE;
		}

		if (isset($add['demo_data']) AND $add['demo_data'] === '1') {
			$file = APPPATH .'/extensions/setup/migrations/demo_schema.sql';
			if (!file_exists($file)) { 
				return FALSE; 
			}

			$lines = file($file);
			if ($lines) {
				$sql = '';

				foreach($lines as $line) {
					if ($line && (substr($line, 0, 1) != '#')) {
						$sql .= $line;
  
						if (preg_match('/;\s*$/', $line)) {
							$sql = str_replace('INSERT INTO ti_', 'INSERT INTO '. $this->db->dbprefix, $sql);
							$this->db->query($sql);
							$sql = '';
						}
					}
				}
			
				$query = TRUE;
			}
		}
		
		return $query;
	}

	public function addUser($add = array()) {
		$query = FALSE;

		if (!empty($add['staff_name'])) {
			$this->db->set('staff_name', $add['staff_name']);
		}

		if (!empty($add['site_email'])) {
			$this->db->set('staff_email', strtolower($add['site_email']));
		}

		$this->db->set('staff_group_id', '11');
		$this->db->set('staff_status', '1');

		$this->db->set('date_added', mdate('%Y-%m-%d', time()));
			
		$query = $this->db->insert('staffs');

		if ($this->db->affected_rows() > 0 && $this->db->insert_id()) {
			$staff_id = $this->db->insert_id();

			if (!empty($add['username'])) {
				$this->db->where('username', $add['username']);
				$this->db->delete('users'); 
				
				$this->db->set('username', $add['username']);
				$this->db->set('staff_id', $staff_id);
			}

			if (!empty($add['password'])) {
				$this->db->set('salt', $salt = substr(md5(uniqid(rand(), TRUE)), 0, 9));
				$this->db->set('password', sha1($salt . sha1($salt . sha1($add['password']))));
			}
		
			$query = $this->db->insert('users'); 

			$this->updateConfig($add['site_name'], $add['site_email']);
		}
		
		return $query;
	}

	public function updateConfig($site_name, $site_email) {
 		if (!empty($site_name)) {
			$this->db->where('sort', 'config');
			$this->db->where('item', 'site_name');
			$this->db->delete('settings');
			
			$this->db->set('sort', 'config');
			$this->db->set('item', 'site_name');
			$this->db->set('value', $site_name);
			$this->db->set('serialized', '0');
			$this->db->insert('settings');
		}

 		if (!empty($site_email)) {
			$this->db->where('sort', 'config');
			$this->db->where('item', 'site_email');
			$this->db->delete('settings');
			
			$this->db->set('sort', 'config');
			$this->db->set('item', 'site_email');
			$this->db->set('value', $site_email);
			$this->db->set('serialized', '0');
			$this->db->insert('settings');
		}
	}
}

/* End of file setup_model.php */
/* Location: ./application/extensions/setup/models/setup_model.php */