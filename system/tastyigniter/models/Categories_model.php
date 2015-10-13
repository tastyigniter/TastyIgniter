<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Categories_model extends TI_Model {

	public function getCount($filter = array()) {
		if ( ! empty($filter['filter_search'])) {
			$this->db->like('name', $filter['filter_search']);
		}

		$this->db->from('categories');

		return $this->db->count_all_results();
	}

	public function getList($filter = array()) {
		if ( ! empty($filter['page']) AND $filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}

		if ($this->db->limit($filter['limit'], $filter['page'])) {
			$this->db->from('categories');

			if ( ! empty($filter['sort_by']) AND ! empty($filter['order_by'])) {
				$this->db->order_by($filter['sort_by'], $filter['order_by']);
			}

			if ( ! empty($filter['filter_search'])) {
				$this->db->like('name', $filter['filter_search']);
			}

			$query = $this->db->get();
			$result = array();

			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}

			return $result;
		}
	}

	public function getCategories($parent = 0) {
		$sql = "SELECT cat1.category_id, cat1.name, cat1.description, cat1.image, ";
		$sql .= "cat1.priority, child.category_id as child_id, sibling.category_id as sibling_id ";
		$sql .= "FROM {$this->db->dbprefix('categories')} AS cat1 ";
		$sql .= "LEFT JOIN {$this->db->dbprefix('categories')} AS child ON child.parent_id = cat1.category_id ";
		$sql .= "LEFT JOIN {$this->db->dbprefix('categories')} AS sibling ON sibling.parent_id = child.category_id ";
		$sql .= ($parent === 0) ? "WHERE cat1.parent_id = 0 " : "WHERE cat1.parent_id = ? ";

		$query = $this->db->query($sql, $parent);

		$result = array();

		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$result[$row['category_id']] = $row;
			}
		}

		return $result;
	}

	public function getCategory($category_id) {
		if (is_numeric($category_id)) {
			$this->db->from('categories');
			$this->db->where('category_id', $category_id);

			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				return $query->row_array();
			}
		}
	}

	public function saveCategory($category_id, $save = array()) {
		if (empty($save)) return FALSE;

		if (isset($save['name'])) {
			$this->db->set('name', $save['name']);
		}

		if (isset($save['description'])) {
			$this->db->set('description', $save['description']);
		}

		if (isset($save['parent_id'])) {
			$this->db->set('parent_id', $save['parent_id']);
		}

		if (isset($save['image'])) {
			$this->db->set('image', $save['image']);
		}

		if (isset($save['priority'])) {
			$this->db->set('priority', $save['priority']);
		}

		if (is_numeric($category_id)) {
			$this->db->where('category_id', $category_id);
			$query = $this->db->update('categories');
		} else {
			$query = $this->db->insert('categories');
			$category_id = $this->db->insert_id();
		}

		if ($query === TRUE AND is_numeric($category_id)) {
			if ( ! empty($save['permalink'])) {
				$this->permalink->savePermalink('menus', $save['permalink'], 'category_id=' . $category_id);
			}

			return $category_id;
		}
	}

	public function deleteCategory($category_id) {
		if (is_numeric($category_id)) $category_id = array($category_id);

		if ( ! empty($category_id) AND ctype_digit(implode('', $category_id))) {
			$this->db->where_in('category_id', $category_id);
			$this->db->delete('categories');

			if (($affected_rows = $this->db->affected_rows()) > 0) {
				foreach ($category_id as $id) {
					$this->permalink->deletePermalink('menus', 'category_id=' . $id);
				}

				return $affected_rows;
			}
		}
	}
}

/* End of file categories_model.php */
/* Location: ./system/tastyigniter/models/categories_model.php */