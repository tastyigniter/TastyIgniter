<?php

class Menus_model extends CI_Model {

    public function menus_record_count($filter = array()) {
		if (!empty($filter['filter_search'])) {
			$this->db->like('menu_name', $filter['filter_search']);
			$this->db->or_like('menu_price', $filter['filter_search']);
			$this->db->or_like('stock_qty', $filter['filter_search']);
		}
        
		if (!empty($filter['filter_category'])) {
			$this->db->where('menu_category_id', $filter['filter_category']);
		}
        
		if (is_numeric($filter['filter_status'])) {
			$this->db->where('menu_status', $filter['filter_status']);
		}
		
		$this->db->from('menus');
		return $this->db->count_all_results();
    }
    
    public function options_record_count($filter = array()) {
		if (!empty($filter['filter_search'])) {
			$this->db->like('option_name', $filter['filter_search']);
			$this->db->or_like('option_price', $filter['filter_search']);
		}

		$this->db->from('menu_options');
		return $this->db->count_all_results();
    }
    
    public function categories_record_count($filter = array()) {
		if (!empty($filter['filter_search'])) {
			$this->db->like('category_name', $filter['filter_search']);
		}

		$this->db->from('categories');
		return $this->db->count_all_results();
    }
    
	public function getList($filter = array()) {
		if ($filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}
		
        if ($this->db->limit($filter['limit'], $filter['page'])) {	
			$this->db->join('categories', 'categories.category_id = menus.menu_category_id', 'left');
			
			if (!empty($filter['sort_by']) AND !empty($filter['order_by'])) {
				$this->db->order_by($filter['sort_by'], $filter['order_by']);
			}
		
			if (!empty($filter['filter_search'])) {
				$this->db->like('menu_name', $filter['filter_search']);
				$this->db->or_like('menu_price', $filter['filter_search']);
				$this->db->or_like('stock_qty', $filter['filter_search']);
			}
		
			if (!empty($filter['filter_category'])) {
				$this->db->where('menu_category_id', $filter['filter_category']);
			}
			
			if (is_numeric($filter['filter_status'])) {
				$this->db->where('menu_status', $filter['filter_status']);
			}
			
			$query = $this->db->get('menus');
			$result = array();
		
			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}
		
			return $result;
		}
	}
	
	public function getAdminMenus() {
		//selecting all records from the menu and categories tables.
		$this->db->from('menus');
		$this->db->join('categories', 'categories.category_id = menus.menu_category_id', 'left');
	
		$query = $this->db->get();
		$result = array();
	
		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}
	
		return $result;
	}
	
	public function getMainMenus($filter = array()) {

		$this->db->select('menus.menu_id, menu_name, menu_description, menu_photo, menu_price, category_name, start_date, end_date, special_price');
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

	public function getAdminMenu($menu_id) {					
		//$this->db->select('menus.menu_id, *');
		$this->db->select('menus.menu_id, menu_name, menu_description, menu_price, menu_photo, menu_category_id, stock_qty, minimum_qty, subtract_stock, menu_status, category_id, category_name, category_description, special_id, start_date, end_date, special_price, special_status');
		$this->db->from('menus');
		$this->db->join('categories', 'categories.category_id = menus.menu_category_id', 'left');
		$this->db->join('menus_specials', 'menus_specials.menu_id = menus.menu_id', 'left');
		$this->db->where('menus.menu_id', $menu_id);

		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
	}

	public function getOptionsList($filter = array()) {		
		if ($filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}
		
        if ($this->db->limit($filter['limit'], $filter['page'])) {	
			$this->db->from('menu_options');
		
			if (!empty($filter['sort_by']) AND !empty($filter['order_by'])) {
				$this->db->order_by($filter['sort_by'], $filter['order_by']);
			}
		
			if (!empty($filter['filter_search'])) {
				$this->db->like('option_name', $filter['filter_search']);
				$this->db->or_like('option_price', $filter['filter_search']);
			}
		
			$query = $this->db->get();
			$result = array();
		
			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}
		
			return $result;
       	}
    }
    
	public function getMenuOptions() {		
		//selecting all records from the menu_options tables.
		$this->db->from('menu_options');
		
		$query = $this->db->get();
		$result = array();
	
		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}
	
		return $result;
	}

	public function getMenuOption($option_id) {		
		$this->db->from('menu_options');
		$this->db->where('option_id', $option_id);

		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
	}
	
	public function hasMenuOptions($menu_id = FALSE) {		
		$this->db->from('menus_to_options');

		$menu_options = array();
		
		if ($menu_id !== FALSE) {
			$this->db->where('menu_id', $menu_id);
			$query = $this->db->get();
		
			if ($query->num_rows() > 0) {
				foreach ($query->result_array() as $row) {
					$menu_options[] = $row['option_id'];
				}
			}
	
		} else {
			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				foreach ($query->result_array() as $row) {
					$menu_options[$row['menu_id']][] = $row['option_id'];
				}
			}
		}
	
		return $menu_options;
	}
	
	public function getIsSpecials() {
		$specials = array();
		
		$this->db->select('menu_id, special_id');
		$this->db->from('menus_specials');
		
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$specials[] = $row['menu_id'];
			}
		}
		return $specials;
	}

	public function getCategoriesList($filter = array()) {		
		if ($filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}
		
        if ($this->db->limit($filter['limit'], $filter['page'])) {	
			$this->db->from('categories');
		
			if (!empty($filter['sort_by']) AND !empty($filter['order_by'])) {
				$this->db->order_by($filter['sort_by'], $filter['order_by']);
			}
		
			if (!empty($filter['filter_search'])) {
				$this->db->like('category_name', $filter['filter_search']);
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
		$this->db->from('categories');
		$this->db->where('category_id', $category_id);
		
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
	}

	public function getAutoComplete($filter_data = array()) {
		if (is_array($filter_data) AND !empty($filter_data)) {
			//selecting all records from the menu and categories tables.
			$this->db->from('menus');
	
			$this->db->where('menu_status', '1');
	
			if (!empty($filter_data['menu_name'])) {
				$this->db->like('menu_name', $filter_data['menu_name']);		
			}
	
			$query = $this->db->get();
			$result = array();
		
			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}
		
			return $result;
		}
	}
	
	public function getOptionsAutoComplete($filter_data = array()) {
		if (is_array($filter_data) AND !empty($filter_data)) {
			//selecting all records from the menu and categories tables.
			$this->db->from('menu_options');
	
			if (!empty($filter_data['option_name'])) {
				$this->db->like('option_name', $filter_data['option_name']);		
			}
	
			$query = $this->db->get();
			$result = array();
		
			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}
		
			return $result;
		}
	}

	public function updateMenu($update = array()) {
		$query = FALSE;
		
		if (!empty($update['menu_name'])) {
			$this->db->set('menu_name', $update['menu_name']);
		}
	
		if (!empty($update['menu_description'])) {
			$this->db->set('menu_description', $update['menu_description']);
		}
	
		if (!empty($update['menu_price'])) {
			$this->db->set('menu_price', $update['menu_price']);
		}
	
		if (!empty($update['menu_category']) AND $update['special_status'] === '1') {
			$this->db->set('menu_category_id', (int)$this->config->item('special_category_id'));
		} else if (!empty($update['menu_category'])) {
			$this->db->set('menu_category_id', $update['menu_category']);
		}
	
		if (!empty($update['menu_photo'])) {
			$this->db->set('menu_photo', $update['menu_photo']);
		}
		
		if ($update['stock_qty'] > 0) {
			$this->db->set('stock_qty', $update['stock_qty']);
		} else {
			$this->db->set('stock_qty', '0');
		}
	
		if ($update['minimum_qty'] > 0) {
			$this->db->set('minimum_qty', $update['minimum_qty']);
		} else {
			$this->db->set('minimum_qty', '1');
		}
	
		if ($update['subtract_stock'] === '1') {
			$this->db->set('subtract_stock', $update['subtract_stock']);
		} else {
			$this->db->set('subtract_stock', '0');
		}
		
		if ($update['menu_status'] === '1') {
			$this->db->set('menu_status', $update['menu_status']);
		} else {
			$this->db->set('menu_status', '0');
		}
		
		if (!empty($update['menu_id'])) {
			$this->db->where('menu_id', $update['menu_id']);

			if ($query = $this->db->update('menus')) {
				$this->db->where('menu_id', $update['menu_id']);
				$this->db->delete('menus_to_options');

				if (!empty($update['menu_options'])) {
					foreach ($update['menu_options'] as $key => $value) {
						$this->db->set('menu_id', $update['menu_id']);
						$this->db->set('option_id', $value);
						$query = $this->db->insert('menus_to_options');
					}
				}

				if (!empty($update['start_date'])) {
					$this->db->set('start_date', mdate('%Y-%m-%d', strtotime($update['start_date'])));
				}

				if (!empty($update['end_date'])) {
					$this->db->set('end_date', mdate('%Y-%m-%d', strtotime($update['end_date'])));
				}

				if (!empty($update['special_price'])) {
					$this->db->set('special_price', $update['special_price']);
				}

				if ($update['special_status'] === '1') {
					$this->db->set('special_status', '1');
				} else {
					$this->db->set('special_status', '0');
				}
			
				if (!empty($update['special_id'])) {
					$this->db->where('special_id', $update['special_id']);
					$this->db->where('menu_id', $update['menu_id']);
					$query = $this->db->update('menus_specials');
				} else {
					$this->db->set('menu_id', $update['menu_id']);
					$query = $this->db->insert('menus_specials');
				}
			}
		}
		
		return $query;
	}

	public function updateCategory($category_id, $category_name, $category_description) {
		$this->db->set('category_name', $category_name);
		$this->db->set('category_description', $category_description);
		
		$this->db->where('category_id', $category_id);
		$query = $this->db->update('categories'); 

		return $query;
	}

	public function updateMenuOption($update = array()) {
		$query = FALSE;

		if (!empty($update['option_name'])) {
			$this->db->set('option_name', $update['option_name']);
		}

		if (!empty($update['option_price'])) {		
			$this->db->set('option_price', $update['option_price']);
		}

		if (!empty($update['option_id'])) {
			$this->db->where('option_id', $update['option_id']);
			$query = $this->db->update('menu_options'); 
		}
				
		return $query;
	}
	
	public function addMenu($add = array()) {
		$query = FALSE;

		if (!empty($add['menu_name'])) {
			$this->db->set('menu_name', $add['menu_name']);
		}
			
		if (!empty($add['menu_description'])) {
			$this->db->set('menu_description', $add['menu_description']);
		}
	
		if (!empty($add['menu_price'])) {
			$this->db->set('menu_price', $add['menu_price']);
		}
			
		if (!empty($add['menu_category']) AND $add['special_status'] === '1') {
			$this->db->set('menu_category_id', (int)$this->config->item('special_category_id'));
		} else if (!empty($add['menu_category'])) {
			$this->db->set('menu_category_id', $add['menu_category']);
		}
			
		if (!empty($add['menu_photo'])) {
			$this->db->set('menu_photo', $add['menu_photo']);
		}
		
		if ($add['stock_qty'] > 0) {
			$this->db->set('stock_qty', $add['stock_qty']);
		} else {
			$this->db->set('stock_qty', '0');
		}
		
		if ($add['minimum_qty'] > 0) {
			$this->db->set('minimum_qty', $add['minimum_qty']);
		} else {
			$this->db->set('minimum_qty', '1');
		}
		
		if ($add['subtract_stock'] === '1') {
			$this->db->set('subtract_stock', $add['subtract_stock']);
		} else {
			$this->db->set('subtract_stock', '0');
		}
		
		if ($add['menu_status'] === '1') {
			$this->db->set('menu_status', $add['menu_status']);
		} else {
			$this->db->set('menu_status', '0');
		}
		
		if (!empty($add)) {
			if ($this->db->insert('menus')) {
				$menu_id = $this->db->insert_id();

				$this->db->where('menu_id', $menu_id);
				$this->db->delete('menus_to_options');

				if (!empty($add['menu_options'])) {
					foreach ($add['menu_options'] as $key => $value) {
						$this->db->set('menu_id', $menu_id);
						$this->db->set('option_id', $value);
						$query = $this->db->insert('menus_to_options');
					}
				}

				$this->db->where('menu_id', $menu_id);
				$this->db->delete('menus_specials');

				if ($add['special_status'] === '1') {
					if (!empty($update['start_date']) AND !empty($add['end_date']) AND !empty($add['special_price'])) {
						$this->db->set('menu_id', $menu_id);
						$this->db->set('start_date', mdate('%Y-%m-%d', strtotime($add['start_date'])));
						$this->db->set('end_date', mdate('%Y-%m-%d', strtotime($add['end_date'])));
						$this->db->set('special_price', $add['special_price']);
						$this->db->set('special_status', $add['special_status']);
						$query = $this->db->insert('menus_specials');
					}
				}
				
				$query = $menu_id;
			}
			
			return $query;
		}
	}

	public function addCategory($category_name, $category_description) {
		if ($category_name OR $category_description) {
			$this->db->set('category_name', $category_name);
			$this->db->set('category_description', $category_description);
		
			if ($this->db->insert('categories')) {
				return $this->db->insert_id();
			}
		}
	}

	public function addMenuOption($add = array()) {
		$query = FALSE;

		if (!empty($add['option_name'])) {
			$this->db->set('option_name', $add['option_name']);
		}

		if (!empty($add['option_price'])) {		
			$this->db->set('option_price', $add['option_price']);
		}
		
		if (!empty($add)) {
			if ($this->db->insert('menu_options')) {
				$query = $this->db->insert_id();
			}
		}

		return $query;
	}

	public function deleteMenu($menu_id) {
		if (is_numeric($menu_id)) {
			$this->db->where('menu_id', $menu_id);
			$this->db->delete('menus');

			$this->db->where('menu_id', $menu_id);
			$this->db->delete('menus_specials');

			$this->db->where('menu_id', $menu_id);
			$this->db->delete('menus_to_options');

			if ($this->db->affected_rows() > 0) {
				return TRUE;
			}
		}
	}

	public function deleteMenuOption($option_id) {
		if (is_numeric($option_id)) {
			$this->db->where('option_id', $option_id);
			$this->db->delete('menu_options');

			if ($this->db->affected_rows() > 0) {
				return TRUE;
			}
		}
	}

	public function deleteCategory($category_id) {
		if (is_numeric($category_id)) {
			$this->db->where('category_id', $category_id);
			$this->db->delete('categories');

			if ($this->db->affected_rows() > 0) {
				return TRUE;
			}
		}
	}
}

/* End of file menus_model.php */
/* Location: ./application/models/menus_model.php */