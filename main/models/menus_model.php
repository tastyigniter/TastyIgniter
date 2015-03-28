<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Menus_model extends CI_Model {

    public function getCount($filter = array()) {
		if (!empty($filter['category_id']) AND is_numeric($filter['category_id'])) {
			$this->db->where('menu_category_id', $filter['category_id']);
		}

		$this->db->from('menus');
		return $this->db->count_all_results();
    }

	public function getList($filter = array()) {
		if (!empty($filter['page']) AND $filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}

		if ($this->db->limit($filter['limit'], $filter['page'])) {
			$this->db->select('menus.menu_id, menu_name, menu_description, menu_photo, menu_price, categories.name, start_date, end_date, special_price');
			$this->db->select('IF(start_date <= CURRENT_DATE(), IF(end_date >= CURRENT_DATE(), "1", "0"), "0") AS is_special', FALSE);
			$this->db->from('menus');
			$this->db->join('categories', 'categories.category_id = menus.menu_category_id', 'left'); // join categories based on category_id
			$this->db->join('menus_specials', 'menus_specials.menu_id = menus.menu_id', 'left');	// join menu_specials based on menu_id
			$this->db->order_by('menus.menu_id', 'ASC');

			if (!empty($filter['category_id'])) {
				$this->db->where('menu_category_id', $filter['category_id']);									// select all menus where category_id is available
			}

			$this->db->where('menu_status', '1');

			$query = $this->db->get();
			$result = array();

			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}

			return $result;
		}
	}

	public function getMenu($menu_id) {
		//$this->db->select('menus.menu_id, *');
		$this->db->select('menus.menu_id, menu_name, menu_description, menu_price, menu_photo, menu_category_id, stock_qty, minimum_qty, subtract_stock, menu_status, category_id, categories.name, description, special_id, start_date, end_date, special_price, special_status');
		$this->db->from('menus');
		$this->db->join('categories', 'categories.category_id = menus.menu_category_id', 'left');
		$this->db->join('menus_specials', 'menus_specials.menu_id = menus.menu_id', 'left');
		$this->db->where('menus.menu_id', $menu_id);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
	}

	public function getOptionValues($option_id = FALSE) {
		$result = array();

		$this->db->from('option_values');
		$this->db->order_by('priority', 'ASC');

		if ($option_id !== FALSE) {
			$this->db->where('option_id', $option_id);
		}

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function getMenuOptions() {
		$results = array();

		$this->db->select('*, menu_options.menu_id, menu_options.option_id');
		$this->db->from('menu_options');
		$this->db->join('options', 'options.option_id = menu_options.option_id', 'left');

		$this->db->order_by('options.priority', 'ASC');

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			$menu_option_values = $this->getMenuOptionValues();

			foreach ($query->result_array() as $row) {
				$option_values = array();

				foreach ($menu_option_values as $option_value) {
					if ($row['menu_option_id'] === $option_value['menu_option_id']
						AND $row['option_id'] === $option_value['option_id']) {

						$option_values[] = $option_value;
					}
				}

				$results[] = array(
					'menu_option_id'	=> $row['menu_option_id'],
					'menu_id'			=> $row['menu_id'],
					'option_id'			=> $row['option_id'],
					'option_name'		=> $row['option_name'],
					'display_type'		=> $row['display_type'],
					'priority'			=> $row['priority'],
					'option_values'		=> $option_values
				);
			}
		}

		return $results;
	}

	public function getMenuOptionValues() {
		$result = array();

		$this->db->select('*, menu_option_values.option_id, option_values.option_value_id');
		$this->db->from('menu_option_values');
		$this->db->join('option_values', 'option_values.option_value_id = menu_option_values.option_value_id', 'left');

		$this->db->order_by('option_values.priority', 'ASC');
		//$this->db->where('menu_option_values.menu_option_id', $menu_option_id);
		//$this->db->where('menu_option_values.option_id', $option_id);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->result_array();
		}

		return $result;
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
}

/* End of file menus_model.php */
/* Location: ./main/models/menus_model.php */