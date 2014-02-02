<?php

class Menus_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}

    public function menus_record_count() {
        return $this->db->count_all('menus');
    }
    
    public function options_record_count() {
        return $this->db->count_all('menu_options');
    }
    
    public function categories_record_count() {
        return $this->db->count_all('categories');
    }
    
	public function getList($filter = array()) {
		if ($filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}
		
        if ($this->db->limit($filter['limit'], $filter['page'])) {	
			$this->db->join('categories', 'categories.category_id = menus.menu_category_id', 'left');
			$this->db->order_by('menu_id', 'ASC');
		
			if (!empty($filter['category_id'])) {
				$this->db->where('menu_category_id', $filter['category_id']);
			}
			
			$query = $this->db->get('menus');
			return $query->result_array();
		}
	}
	
	public function getAdminMenus() {
		//selecting all records from the menu and categories tables.
		$this->db->from('menus');
		$this->db->join('categories', 'categories.category_id = menus.menu_category_id', 'left');
	
		$query = $this->db->get();
		return $query->result_array();
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
		return $query->result_array();															// return an array of available menus
	}

	public function getAdminMenu($menu_id) {					
		//$this->db->select('menus.menu_id, *');
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
		
			$query = $this->db->get();
			return $query->result_array();
       	}
    }
    
	public function getMenuOptions() {		
		//selecting all records from the menu_options tables.
		$this->db->from('menu_options');
		
		$query = $this->db->get();
		return $query->result_array();
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
	
	public function getCategoriesList($filter = array()) {		
		if ($filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}
		
        if ($this->db->limit($filter['limit'], $filter['page'])) {	
			$this->db->from('categories');
		
			$query = $this->db->get();
			return $query->result_array();
       	}
    }
    
	public function getCategories($category_id = FALSE) {
		if ($category_id === FALSE) {

			$this->db->from('categories');

			$query = $this->db->get();
			return $query->result_array();
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
		if (is_array($filter_data) && !empty($filter_data)) {
			//selecting all records from the menu and categories tables.
			$this->db->from('menus');
	
			$this->db->where('menu_status', '1');
	
			if (!empty($filter_data['menu_name'])) {
				$this->db->like('menu_name', $filter_data['menu_name']);		
			}
	
			$query = $this->db->get();
			return $query->result_array();
		}
	}
	
	public function getOptionsAutoComplete($filter_data = array()) {
		if (is_array($filter_data) && !empty($filter_data)) {
			//selecting all records from the menu and categories tables.
			$this->db->from('menu_options');
	
			if (!empty($filter_data['option_name'])) {
				$this->db->like('option_name', $filter_data['option_name']);		
			}
	
			$query = $this->db->get();
			return $query->result_array();
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
	
		if (!empty($update['menu_category'])) {
			$this->db->set('menu_category_id', $update['menu_category']);
		}
	
		if (!empty($update['menu_photo'])) {
			$this->db->set('menu_photo', $menu_photo);
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
			$this->db->update('menus');
		}
		
		if ($this->db->affected_rows() > 0) {
			$query = TRUE;
		}

		$this->db->where('menu_id', $update['menu_id']);
		$this->db->delete('menus_to_options');

		if (!empty($update['menu_options'])) {
			foreach ($update['menu_options'] as $key => $value) {
				$this->db->set('menu_id', $update['menu_id']);
				$this->db->set('option_id', $value);
				$this->db->insert('menus_to_options');
			}
		}

		if ($this->db->affected_rows() > 0) {
			$query = TRUE;
		}

		$this->db->where('menu_id', $update['menu_id']);
		$this->db->delete('menus_specials');

		if ($update['menu_special'] === '1') {
			if (!empty($update['start_date']) && !empty($update['end_date']) && !empty($update['special_price'])) {
				$this->db->set('menu_id', $update['menu_id']);
				$this->db->set('start_date', $update['start_date']);
				$this->db->set('end_date', $update['end_date']);
				$this->db->set('special_price', $update['special_price']);
				$this->db->insert('menus_specials');
			}
		}
				
		if ($this->db->affected_rows() > 0) {
			$query = TRUE;
		}
		
		return $query;
	}

	public function updateMenuOption($update = array()) {
		if (!empty($update['option_name'])) {
			$this->db->set('option_name', $update['option_name']);
		}

		if (!empty($update['option_price'])) {		
			$this->db->set('option_price', $update['option_price']);
		}

		if (!empty($update['option_id'])) {
			$this->db->where('option_id', $update['option_id']);
			$this->db->update('menu_options'); 
		}
				
		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}
	
	public function updateCategory($category_id, $category_name, $category_description) {
		$this->db->set('category_name', $category_name);
		$this->db->set('category_description', $category_description);
		
		$this->db->where('category_id', $category_id);
		$this->db->update('categories'); 

		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}

	public function addMenu($add = array()) {
		if (!empty($add['menu_name'])) {
			$this->db->set('menu_name', $add['menu_name']);
		}
			
		if (!empty($add['menu_description'])) {
			$this->db->set('menu_description', $add['menu_description']);
		}
	
		if (!empty($add['menu_price'])) {
			$this->db->set('menu_price', $add['menu_price']);
		}
			
		if (!empty($add['menu_category_id'])) {
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
		
		$this->db->insert('menus');
	
		if ($this->db->affected_rows() > 0 && $this->db->insert_id()) {
			$menu_id = $this->db->insert_id();

			$this->db->where('menu_id', $menu_id);
			$this->db->delete('menus_to_options');

			if (!empty($add['menu_options'])) {
				foreach ($add['menu_options'] as $key => $value) {
					$this->db->set('menu_id', $menu_id);
					$this->db->set('option_id', $value);
					$this->db->insert('menus_to_options');
				}
			}

			$this->db->where('menu_id', $menu_id);
			$this->db->delete('menus_specials');

			if (!empty($add['menu_special'])) {
				if (!empty($update['start_date']) && !empty($add['end_date']) && !empty($add['special_price'])) {
					$this->db->set('menu_id', $menu_id);
					$this->db->set('start_date', $add['start_date']);
					$this->db->set('end_date', $add['end_date']);
					$this->db->set('special_price', $add['special_price']);
					$this->db->insert('menus_specials');
				}
			}

			return TRUE;
		}
	}

	public function addMenuOption($add = array()) {
		if (!empty($add['option_name'])) {
			$this->db->set('option_name', $add['option_name']);
		}

		if (!empty($add['option_price'])) {		
			$this->db->set('option_price', $add['option_price']);
		}
		
		$this->db->insert('menu_options');

		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}

	public function addCategory($category_name, $category_description) {
		
		$this->db->set('category_name', $category_name);
		$this->db->set('category_description', $category_description);
		
		$this->db->insert('categories');

		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}

	public function deleteMenu($menu_id) {

		$this->db->where('menu_id', $menu_id);

		$this->db->delete('menus');

		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}

	public function deleteMenuOption($option_id) {

		$this->db->where('option_id', $option_id);

		$this->db->delete('menu_options');

		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}

	public function deleteCategory($category_id) {
		$this->db->where('category_id', $category_id);

		$this->db->delete('categories');

		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}
}