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
}

/* End of file settings_model.php */
/* Location: ./system/tastyigniter/models/settings_model.php */