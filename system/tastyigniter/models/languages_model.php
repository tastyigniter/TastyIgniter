<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Languages_model extends TI_Model {

    public function getCount($filter = array()) {
		if (!empty($filter['filter_search'])) {
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
		if (!empty($filter['page']) AND $filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}

		if ($this->db->limit($filter['limit'], $filter['page'])) {
			$this->db->from('languages');

			if (!empty($filter['sort_by']) AND !empty($filter['order_by'])) {
				$this->db->order_by($filter['sort_by'], $filter['order_by']);
			}

			if (!empty($filter['filter_search'])) {
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

		if (!empty($save['name'])) {
			$this->db->set('name', $save['name']);
		}

		if (!empty($save['code'])) {
			$this->db->set('code', $save['code']);
		}

		if (!empty($save['image'])) {
			$this->db->set('image', $save['image']);
		}

		if (!empty($save['directory'])) {
			$this->db->set('directory', $save['directory']);
		}

		if ($save['status'] === '1') {
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

        if (!empty($language_id) AND ctype_digit(implode('', $language_id))) {
            $this->db->where_in('language_id', $language_id);
            $this->db->delete('languages');

            return $this->db->affected_rows();
        }
	}
}

/* End of file languages_model.php */
/* Location: ./system/tastyigniter/models/languages_model.php */