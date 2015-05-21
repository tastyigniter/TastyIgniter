<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Categories_model extends TI_Model {

    public function getCount($filter = array()) {
        if (!empty($filter['filter_search'])) {
            $this->db->like('name', $filter['filter_search']);
        }

        $this->db->from('categories');
        return $this->db->count_all_results();
    }

    public function getList($filter = array()) {
        if (!empty($filter['page']) AND $filter['page'] !== 0) {
            $filter['page'] = ($filter['page'] - 1) * $filter['limit'];
        }

        if ($this->db->limit($filter['limit'], $filter['page'])) {
            $this->db->from('categories');

            if (!empty($filter['sort_by']) AND !empty($filter['order_by'])) {
                $this->db->order_by($filter['sort_by'], $filter['order_by']);
            }

            if (!empty($filter['filter_search'])) {
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

    public function getCategories($category_id = FALSE) {
        if ($category_id === FALSE) {

            $this->db->from('categories');

            $query = $this->db->get();
            $result = array();

            if ($query->num_rows() > 0) {
                $result = $query->result_array();
            }

            return $result;
        }
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

        if (!empty($save['name'])) {
            $this->db->set('name', $save['name']);
        }

        if (!empty($save['description'])) {
            $this->db->set('description', $save['description']);
        }

        if (!empty($save['parent_id'])) {
            $this->db->set('parent_id', $save['parent_id']);
        }

        if (!empty($save['image'])) {
            $this->db->set('image', $save['image']);
        }

        if (is_numeric($category_id)) {
            $this->db->where('category_id', $category_id);
            $query = $this->db->update('categories');
        } else {
            $query = $this->db->insert('categories');
            $category_id = $this->db->insert_id();
        }

        if ($query === TRUE AND is_numeric($category_id)) {
            if (!empty($save['permalink'])) {
                $this->permalink->savePermalink('menus', $save['permalink'], 'category_id=' . $category_id);
            }

            return $category_id;
        }
    }

    public function deleteCategory($category_id) {
        if (is_numeric($category_id)) {
            $this->db->where('category_id', $category_id);
            $this->db->delete('categories');

            $this->permalink->deletePermalink('menus', 'category_id=' . $category_id);

            if ($this->db->affected_rows() > 0) {
                return TRUE;
            }
        }
    }
}

/* End of file categories_model.php */
/* Location: ./system/tastyigniter/models/categories_model.php */