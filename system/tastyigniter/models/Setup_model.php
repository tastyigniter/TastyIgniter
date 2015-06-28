<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Setup_model extends TI_Model {

	public function loadInitialSchema() {
		$query = FALSE;

        if ($this->db->count_all('countries') <= 0) {
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
                            $sql = str_replace('INSERT INTO ti_', 'INSERT INTO ' . $this->db->dbprefix, $sql);
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

        $this->db->where('sort', 'prefs')
            ->where('item', 'ti_setup')
            ->delete('settings');

        $this->db->set('sort', 'prefs')
            ->set('item', 'ti_setup')
            ->set('value', 'v2.0')
            ->set('serialized', '0')
            ->insert('settings');

        if (!empty($add['site_email'])) {
			$this->db->where('staff_email', strtolower($add['site_email']));
			$this->db->delete('staffs');

			$this->db->set('staff_email', strtolower($add['site_email']));
		}

		if (!empty($add['staff_name'])) {
			$this->db->set('staff_name', $add['staff_name']);
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

			$this->updateSettings($add['site_name'], $add['site_email']);
		}

		return $query;
	}

	public function updateSettings($site_name, $site_email) {
 		if (!empty($site_name)) {
			$this->db->where('sort', 'config')->where('item', 'site_name')->delete('settings');
			$this->db->set('sort', 'config')->set('item', 'site_name')->set('value', $site_name)->set('serialized', '0')->insert('settings');
		}

 		if (!empty($site_email)) {
			$this->db->where('sort', 'config')->where('item', 'site_email')->delete('settings');
			$this->db->set('sort', 'config')->set('item', 'site_email')->set('value', $site_email)->set('serialized', '0')->insert('settings');
		}

		$this->db->where('sort', 'prefs')->where('item', 'ti_version')->delete('settings');
		$this->db->set('sort', 'prefs')->set('item', 'ti_version')->set('value', 'v1.3-beta')->set('serialized', '0')->insert('settings');
	}
}

/* End of file setup_model.php */
/* Location: ./setup/models/setup_model.php */