<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Settings_model extends TI_Model {

    public function getAll() {
        if ($this->db->table_exists($this->db->dbprefix('settings'))) {
            $this->db->from('settings');

            $query = $this->db->get();
            $result = array();

            if ($query->num_rows() > 0) {
                $result = $query->result_array();
            }

            return $result;
        }
	}

	public function getdbTables() {
		$result = array();

        $sql = "SELECT table_name, table_rows FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = ? ";
        $query = $this->db->query($sql, $this->db->database);

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
        }

		return $result;
	}

	public function updateSettings($sort, $update = array()) {
 		if (!empty($update) && !empty($sort)) {
			foreach ($update as $item => $value) {
				if (!empty($item)) {
					$this->db->where('sort', $sort);
					$this->db->where('item', $item);
					$this->db->delete('settings');

					if (isset($value)) {
						$serialized = '0';
						if (is_array($value)) {
							$value = serialize($value);
							$serialized = '1';
						}

						$this->db->set('sort', $sort);
						$this->db->set('item', $item);
						$this->db->set('value', $value);
						$this->db->set('serialized', $serialized);
						$this->db->insert('settings');
					}
				}
			}

			return TRUE;
		}
 	}

	public function addSetting($sort, $item, $value, $serialized = '0') {
		$query = FALSE;

		if (isset($sort, $item, $value, $serialized)) {
			$this->db->where('sort', $sort);
			$this->db->where('item', $item);
			$this->db->delete('settings');

			$this->db->set('sort', $sort);
			$this->db->set('item', $item);

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

	public function deleteSettings($sort, $item) {
		if (!empty($sort) AND !empty($item)) {
			$this->db->where('sort', $sort);
			$this->db->where('item', $item);
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

            $backup = $this->dbutil->backup($prefs);

            $timestamp = mdate('%Y-%m-%d-%H-%i-%s', now());

            if (file_put_contents(ROOTPATH. 'assets/downloads/tastyigniter-'.$timestamp.'.sql', $backup, LOCK_EX)) {
                return TRUE;
            }
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
/* Location: ./system/tastyigniter/models/settings_model.php */