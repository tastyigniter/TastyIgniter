<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Setup_model extends TI_Model {

	public function loadInitialSchema() {
		$query = FALSE;

        $file = IGNITEPATH . '/migrations/initial_schema.sql';
        if (!file_exists($file)) {
            return FALSE;
        }

        $lines = file($file);
        if ($lines) {
            $sql = '';

            foreach ($lines as $line) {
                if ($line && (substr($line, 0, 1) != '#')) {
                    $sql .= $line;

                    if (preg_match('/;\s*$/', $line)) {
                        $sql = str_replace('REPLACE INTO ti_', 'REPLACE INTO ' . $this->db->dbprefix, str_replace('REPLACE INTO `ti_', 'REPLACE INTO `' . $this->db->dbprefix, $sql));
                        $this->db->query($sql);
                        $sql = '';
                    }
                }
            }

            $query = TRUE;
        }

		return $query;
	}

	public function loadDemoSchema($demo_data) {
		$query = TRUE;

		if (isset($demo_data) AND $demo_data === '1' AND $this->db->count_all('coupons') <= 0) {
			$file = IGNITEPATH .'/migrations/demo_schema.sql';
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
							$sql = str_replace('INSERT INTO ti_', 'INSERT INTO ' . $this->db->dbprefix, str_replace('INSERT INTO `ti_', 'INSERT INTO `' . $this->db->dbprefix, $sql));
                            $sql = str_replace('REPLACE INTO ti_', 'REPLACE INTO ' . $this->db->dbprefix, str_replace('REPLACE INTO `ti_', 'REPLACE INTO `' . $this->db->dbprefix, $sql));
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
        if (empty($add['staff_name']) AND empty($add['username']) AND empty($add['password'])) {
            return TRUE;
        }

        $this->db->where('staff_email', strtolower($add['site_email']));
        $this->db->delete('staffs');

        $this->db->set('staff_email', strtolower($add['site_email']));
        $this->db->set('staff_name', $add['staff_name']);
		$this->db->set('staff_group_id', '11');
		$this->db->set('staff_location_id', '0');
		$this->db->set('language_id', '11');
		$this->db->set('timezone', '0');
        $this->db->set('staff_status', '1');

		$this->db->set('date_added', mdate('%Y-%m-%d', time()));

		$query = $this->db->insert('staffs');

		if ($this->db->affected_rows() > 0 AND $query === TRUE) {
            $staff_id = $this->db->insert_id();

            $this->db->where('username', $add['username']);
            $this->db->delete('users');

            $this->db->set('username', $add['username']);
            $this->db->set('staff_id', $staff_id);

            $this->db->set('salt', $salt = substr(md5(uniqid(rand(), TRUE)), 0, 9));
            $this->db->set('password', sha1($salt . sha1($salt . sha1($add['password']))));

			$query = $this->db->insert('users');
		}

		return $query;
	}

	public function updateSettings($setting = array()) {
        if (empty($setting['site_name']) AND empty($setting['site_email'])) {
            return TRUE;
        }

        foreach ($setting as $key => $value) {
            $setting_row = array(
                'sort'   => ($key === 'ti_setup') ? 'prefs' : 'core',
                'item'   => $key,
                'value'  => $value,
                'serialized'   => '0',
            );

            if ($this->db->replace('settings', $setting_row) === FALSE) {
                return FALSE;
            }
        }

        return TRUE;
	}

	public function updateVersion() {
		$this->db->where('sort', 'prefs');
		$this->db->where('item', 'ti_version');
		$this->db->delete('settings');

		$this->db->set('sort', 'prefs');
		$this->db->set('item', 'ti_version');
		$this->db->set('value', TI_VERSION);
		$this->db->set('serialized', '0');
		$this->db->insert('settings');
	}
}

/* End of file setup_model.php */
/* Location: ./setup/models/setup_model.php */