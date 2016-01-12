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
 * Pages Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Pages_model.php
 * @link           http://docs.tastyigniter.com
 */
class Pages_model extends TI_Model {

	public function getCount($filter = array()) {
		if ( ! empty($filter['filter_search'])) {
			$this->db->like('name', $filter['filter_search']);
		}

		if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
			$this->db->where('status', $filter['filter_status']);
		}

		$this->db->from('pages');

		return $this->db->count_all_results();
	}

	public function getList($filter = array()) {
		if ( ! empty($filter['page']) AND $filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}

		if ($this->db->limit($filter['limit'], $filter['page'])) {
			$this->db->select('*, languages.name AS language_name, pages.name AS name');
			$this->db->from('pages');
			$this->db->join('languages', 'languages.language_id = pages.language_id',
			                'left'); // join categories based on category_id

			if ( ! empty($filter['filter_search'])) {
				$this->db->like('pages.name', $filter['filter_search']);
			}

			if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
				$this->db->where('pages.status', $filter['filter_status']);
			}

			$query = $this->db->get();
			$result = array();

			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}

			return $result;
		}
	}

	public function getPages() {
		$this->db->from('pages');

		$this->db->where('status', '1');

		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				if ( ! empty($row['navigation'])) {
					$row['navigation'] = unserialize($row['navigation']);
				}

				$result[] = $row;
			}
		}

		return $result;
	}

	public function getPage($page_id) {
		$this->db->from('pages');

		$this->db->where('page_id', $page_id);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
	}

	public function savePage($page_id, $save = array()) {
		if (empty($save)) return FALSE;

		if (isset($save['language_id'])) {
			$this->db->set('language_id', $save['language_id']);
		}

		if (isset($save['title'])) {
			$this->db->set('name', $save['title']);
			$this->db->set('title', $save['title']);
		}

		if (isset($save['heading'])) {
			$this->db->set('heading', $save['heading']);
		}

		if (isset($save['content'])) {
			$this->db->set('content', $save['content']);
		}

		if (isset($save['meta_description'])) {
			$this->db->set('meta_description', $save['meta_description']);
		}

		if (isset($save['meta_keywords'])) {
			$this->db->set('meta_keywords', $save['meta_keywords']);
		}

		if (isset($save['layout_id'])) {
			$this->db->set('layout_id', $save['layout_id']);
		} else {
			$this->db->set('layout_id', '0');
		}

		if (isset($save['navigation'])) {
			$this->db->set('navigation', serialize($save['navigation']));
		}

		if (isset($save['date_updated'])) {
			$this->db->set('date_updated', $save['date_updated']);
		}

		if ($save['status'] === '1') {
			$this->db->set('status', '1');
		} else {
			$this->db->set('status', '0');
		}

		if (is_numeric($page_id)) {
			$this->db->set('date_updated', mdate('%Y-%m-%d %H:%i:%s', time()));
			$this->db->where('page_id', $page_id);
			$query = $this->db->update('pages');
		} else {
			$this->db->set('date_added', mdate('%Y-%m-%d %H:%i:%s', time()));
			$this->db->set('date_updated', mdate('%Y-%m-%d %H:%i:%s', time()));
			$query = $this->db->insert('pages');
			$page_id = $this->db->insert_id();
		}

		if ($query === TRUE AND is_numeric($page_id)) {
			if ( ! empty($save['permalink'])) {
				$this->permalink->savePermalink('pages', $save['permalink'], 'page_id=' . $page_id);
			}

			return $page_id;
		}
	}

	public function deletePage($page_id) {
		if (is_numeric($page_id)) $page_id = array($page_id);

		if ( ! empty($page_id) AND ctype_digit(implode('', $page_id))) {
			$this->db->where_in('page_id', $page_id);
			$this->db->delete('pages');

			if (($affected_rows = $this->db->affected_rows()) > 0) {
				foreach ($page_id as $id) {
					$this->permalink->deletePermalink('pages', 'page_id=' . $id);
				}

				return $affected_rows;
			}
		}
	}
}

/* End of file pages_model.php */
/* Location: ./system/tastyigniter/models/pages_model.php */