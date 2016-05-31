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
 * Languages Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Languages_model.php
 * @link           http://docs.tastyigniter.com
 */
class Languages_model extends TI_Model {

	public function getCount($filter = array()) {
		if ( ! empty($filter['filter_search'])) {
			$this->db->like('name', $filter['filter_search']);
			$this->db->or_like('code', $filter['filter_search']);
		}

		if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
			$this->db->where('status', $filter['filter_status']);
		}

		$this->db->from('languages');

		return $this->db->count_all_results();
	}

	public function getList($filter = array()) {
		if ( ! empty($filter['page']) AND $filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}

		if ($this->db->limit($filter['limit'], $filter['page'])) {
			$this->db->from('languages');

			if ( ! empty($filter['sort_by']) AND ! empty($filter['order_by'])) {
				$this->db->order_by($filter['sort_by'], $filter['order_by']);
			}

			if ( ! empty($filter['filter_search'])) {
				$this->db->like('name', $filter['filter_search']);
				$this->db->or_like('code', $filter['filter_search']);
			}

			if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
				$this->db->where('status', $filter['filter_status']);
			}

			$query = $this->db->get();

			$result = array();

			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}

			return $result;
		}
	}

	public function getLanguages() {
		$this->db->from('languages');

		$this->db->where('status', '1');

		$query = $this->db->get();

		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function getLanguage($language_id) {
		if ($language_id !== '') {
			$this->db->from('languages');

			$this->db->where('language_id', $language_id);

			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				return $query->row_array();
			}
		}
	}

	public function saveLanguage($language_id, $save = array()) {
		if (empty($save)) return FALSE;

		if (isset($save['name'])) {
			$this->db->set('name', $save['name']);
		}

		if (isset($save['code'])) {
			$this->db->set('code', $save['code']);
		}

		if (isset($save['image'])) {
			$this->db->set('image', $save['image']);
		}

		if (isset($save['idiom'])) {
			$this->db->set('idiom', $save['idiom']);
		}

		if (isset($save['can_delete']) AND $save['can_delete'] === '1') {
			$this->db->set('can_delete', '1');
		} else {
			$this->db->set('can_delete', '0');
		}

		if (isset($save['status']) AND $save['status'] === '1') {
			$this->db->set('status', '1');
		} else {
			$this->db->set('status', '0');
		}

		if (is_numeric($language_id)) {
			$this->db->where('language_id', $language_id);
			$query = $this->db->update('languages');
		} else {
			$query = $this->db->insert('languages');
			$language_id = $this->db->insert_id();
		}

		return ($query === TRUE AND is_numeric($language_id)) ? $language_id : FALSE;
	}

	public function deleteLanguage($language_id) {
		if (is_numeric($language_id)) $language_id = array($language_id);

		if ( ! empty($language_id) AND ctype_digit(implode('', $language_id))) {
			$this->db->from('languages');
			$this->db->where('can_delete', '0');
			$this->db->where_in('language_id', $language_id);
			$this->db->where('language_id !=', '11');
			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				foreach ($query->result_array() as $row) {
					delete_language($row['idiom']);
				}
			}

			$this->db->where('can_delete', '0');
			$this->db->where_in('language_id', $language_id);
			$this->db->where('language_id !=', '11');
			$this->db->delete('languages');

			return $this->db->affected_rows();
		}
	}
}

/* End of file languages_model.php */
/* Location: ./system/tastyigniter/models/languages_model.php */