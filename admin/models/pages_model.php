<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Pages_model extends CI_Model {

    public function getCount($filter = array()) {
		if (!empty($filter['filter_search'])) {
			$this->db->like('name', $filter['filter_search']);
		}

		if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
			$this->db->where('status', $filter['filter_status']);
		}

		$this->db->from('pages');
		return $this->db->count_all_results();
    }

	public function getList($filter = array()) {
		if (!empty($filter['page']) AND $filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}

		if ($this->db->limit($filter['limit'], $filter['page'])) {
			$this->db->select('*, languages.name AS language_name, pages.name AS name');
			$this->db->from('pages');
			$this->db->join('languages', 'languages.language_id = pages.language_id', 'left'); // join categories based on category_id

			if (!empty($filter['filter_search'])) {
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
			$result = $query->result_array();
		}

		return $result;
	}

	public function getPage($page_id) {
		$this->db->from('pages');

		$this->db->where('page_id', $page_id);

		$query = $this->db->get();

		if ($this->db->affected_rows() > 0) {
			return $query->row_array();
		}
	}

	public function updatePage($update = array()) {
		$query = FALSE;

		if (!empty($update['language_id'])) {
			$this->db->set('language_id', $update['language_id']);
		}

		if (!empty($update['name'])) {
			$this->db->set('name', $update['name']);
		}

		if (!empty($update['title'])) {
			$this->db->set('title', $update['title']);
		}

		if (!empty($update['heading'])) {
			$this->db->set('heading', $update['heading']);
		}

		if (!empty($update['content'])) {
			$this->db->set('content', $update['content']);
		}

		if (!empty($update['meta_description'])) {
			$this->db->set('meta_description', $update['meta_description']);
		}

		if (!empty($update['meta_keywords'])) {
			$this->db->set('meta_keywords', $update['meta_keywords']);
		}

		if (!empty($update['layout_id'])) {
			$this->db->set('layout_id', $update['layout_id']);
		} else {
			$this->db->set('layout_id', '0');
		}

		if (!empty($update['navigation'])) {
			$this->db->set('navigation', serialize($update['navigation']));
		}

		if (!empty($update['date_updated'])) {
			$this->db->set('date_updated', $update['date_updated']);
		}

		if ($update['status'] === '1') {
			$this->db->set('status', '1');
		} else {
			$this->db->set('status', '0');
		}

		if (!empty($update['page_id'])) {
			$this->db->where('page_id', $update['page_id']);
			$query = $this->db->update('pages');

			if (!empty($update['permalink'])) {
				$this->load->model('Permalinks_model');
				$this->Permalinks_model->updatePermalink(array('controller' => 'pages', 'permalink' => $update['permalink'], 'query' => 'page_id='.$update['page_id']));
			}
		}

		return $query;
	}

	public function addPage($add = array()) {
		$query = FALSE;

		if (!empty($add['language_id'])) {
			$this->db->set('language_id', $add['language_id']);
		}

		if (!empty($add['name'])) {
			$this->db->set('name', $add['name']);
		}

		if (!empty($add['title'])) {
			$this->db->set('title', $add['title']);
		}

		if (!empty($add['heading'])) {
			$this->db->set('heading', $add['heading']);
		}

		if (!empty($add['content'])) {
			$this->db->set('content', $add['content']);
		}

		if (!empty($add['meta_description'])) {
			$this->db->set('meta_description', $add['meta_description']);
		}

		if (!empty($add['meta_keywords'])) {
			$this->db->set('meta_keywords', $add['meta_keywords']);
		}

		if (!empty($add['layout_id'])) {
			$this->db->set('layout_id', $add['layout_id']);
		}

		if (!empty($add['navigation'])) {
			$this->db->set('navigation', serialize($add['navigation']));
		}

		if (!empty($add['date_added'])) {
			$this->db->set('date_added', $add['date_added']);
		}

		if (!empty($add['date_updated'])) {
			$this->db->set('date_updated', $add['date_updated']);
		}

		if ($add['status'] === '1') {
			$this->db->set('status', '1');
		} else {
			$this->db->set('status', '0');
		}

		if (!empty($add)) {
			if ($this->db->insert('pages')) {
				$query = $this->db->insert_id();

				if (!empty($add['permalink'])) {
					$this->load->model('Permalinks_model');
					$this->Permalinks_model->addPermalink(array('controller' => 'pages', 'permalink' => $add['permalink'], 'query' => 'page_id='.$query));
				}
			}
		}

		return $query;
	}

	public function deletePage($page_id) {
		if (is_numeric($page_id)) {
			$this->db->where('page_id', $page_id);
			$this->db->delete('pages');

			if ($this->db->affected_rows() > 0) {
				return TRUE;
			}
		}
	}
}

/* End of file currencies_model.php */
/* Location: ./admin/models/currencies_model.php */