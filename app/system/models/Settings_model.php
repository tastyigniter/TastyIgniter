<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package   TastyIgniter
 * @author    SamPoyigi
 * @copyright TastyIgniter
 * @link      http://tastyigniter.com
 * @license   http://opensource.org/licenses/GPL-3.0 The GNU GENERAL PUBLIC LICENSE
 * @since     File available since Release 1.0
 */
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Settings Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Settings_model.php
 * @link           http://docs.tastyigniter.com
 */
class Settings_model extends TI_Model {

	public function getAll() {
		$this->db->from('settings');

		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function updateSettings($sort, $update = array(), $flush = FALSE) {
		if ( ! empty($update) && ! empty($sort)) {
			if ($flush === TRUE) {
				$this->db->where('sort', $sort);
				$this->db->delete('settings');
			}

			foreach ($update as $item => $value) {
				if ( ! empty($item)) {
					if ($flush === FALSE) {
						$this->db->where('sort', $sort);
						$this->db->where('item', $item);
						$this->db->delete('settings');
					}

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
		if ( ! empty($sort) AND ! empty($item)) {
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