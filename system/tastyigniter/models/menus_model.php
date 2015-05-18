<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Menus_model extends TI_Model {

    public function getCount($filter = array()) {
		if (APPDIR === ADMINDIR) {
            if (!empty($filter['filter_search'])) {
                $this->db->like('menu_name', $filter['filter_search']);
                $this->db->or_like('menu_price', $filter['filter_search']);
                $this->db->or_like('stock_qty', $filter['filter_search']);
            }

            if (is_numeric($filter['filter_status'])) {
                $this->db->where('menu_status', $filter['filter_status']);
            }
        }

        if (!empty($filter['filter_category'])) {
            $this->db->where('menu_category_id', $filter['filter_category']);
        }

        $this->db->from('menus');
		return $this->db->count_all_results();
    }

    public function getOptionsCount($filter = array()) {
		if (!empty($filter['filter_search'])) {
			$this->db->like('option_name', $filter['filter_search']);
			$this->db->or_like('option_price', $filter['filter_search']);
		}

		$this->db->from('options');
		return $this->db->count_all_results();
    }

    public function getCategoriesCount($filter = array()) {
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
            if (APPDIR === ADMINDIR) {
                $this->db->select('*, menus.menu_id');
            } else {
                $this->db->select('menus.menu_id, menu_name, menu_description, menu_photo, menu_price, categories.name, start_date, end_date, special_price');
                $this->db->select('IF(start_date <= CURRENT_DATE(), IF(end_date >= CURRENT_DATE(), "1", "0"), "0") AS is_special', FALSE);
            }

			$this->db->join('categories', 'categories.category_id = menus.menu_category_id', 'left');
			$this->db->join('menus_specials', 'menus_specials.menu_id = menus.menu_id', 'left');

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

	public function getOptionsList($filter = array()) {
		if (!empty($filter['page']) AND $filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}

        if ($this->db->limit($filter['limit'], $filter['page'])) {
			$this->db->from('options');

			if (!empty($filter['sort_by']) AND !empty($filter['order_by'])) {
				$this->db->order_by($filter['sort_by'], $filter['order_by']);
			}

			if (!empty($filter['filter_search'])) {
				$this->db->like('option_name', $filter['filter_search']);
				$this->db->or_like('option_price', $filter['filter_search']);
			}

			if (!empty($filter['filter_display_type'])) {
				$this->db->where('display_type', $filter['filter_display_type']);
			}

			$query = $this->db->get();
			$result = array();

			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}

			return $result;
       	}
    }

	public function getCategoriesList($filter = array()) {
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

	public function getOption($option_id) {
		$this->db->from('options');
		$this->db->where('option_id', $option_id);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
	}

	public function getMenuOptions($menu_id = FALSE) {
		$results = array();

        $this->db->select('*, menu_options.menu_id, menu_options.option_id');
        $this->db->from('menu_options');
        $this->db->join('options', 'options.option_id = menu_options.option_id', 'left');

        if ($menu_id !== FALSE) {
            $this->db->where('menu_options.menu_id', $menu_id);
        }

        $this->db->order_by('options.priority', 'ASC');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $results[] = array(
                    'menu_option_id'	=> $row['menu_option_id'],
                    'menu_id'           => $row['menu_id'],
                    'option_id'			=> $row['option_id'],
                    'option_name'		=> $row['option_name'],
                    'display_type'		=> $row['display_type'],
                    'required'			=> $row['required'],
                    'priority'			=> $row['priority'],
                    'option_values'		=> $this->getMenuOptionValues($row['menu_option_id'], $row['option_id'])
                );
            }
        }

        return $results;
    }

	public function getMenuOptionValues($menu_option_id = FALSE, $option_id = FALSE) {
		$result = array();

		if ($menu_option_id !== FALSE AND $option_id !== FALSE) {
			$this->db->select('*, menu_option_values.option_id, option_values.option_value_id');
			$this->db->from('menu_option_values');
			$this->db->join('option_values', 'option_values.option_value_id = menu_option_values.option_value_id', 'left');

			$this->db->order_by('option_values.priority', 'ASC');
			$this->db->where('menu_option_values.menu_option_id', $menu_option_id);
			$this->db->where('menu_option_values.option_id', $option_id);
			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}
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
			$this->db->from('options');

			if (!empty($filter_data['option_name'])) {
				$this->db->like('option_name', $filter_data['option_name']);
			}

			$query = $this->db->get();
			$result = array();

			if ($query->num_rows() > 0) {
				foreach ($query->result_array() as $row) {
					$result[] = array(
						'option_id'			=> $row['option_id'],
						'option_name'		=> $row['option_name'],
						'display_type'		=> $row['display_type'],
						'priority'			=> $row['priority'],
						'option_values'		=> $this->getOptionValues($row['option_id'])
					);
				}
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
				$this->load->model('Notifications_model');
				$this->Notifications_model->addNotification(array('action' => 'updated', 'object' => 'menu', 'object_id' => $update['menu_id']));

				$this->addMenuOption($update['menu_id'], $update['menu_options']);

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

	public function updateOption($update = array()) {
		$query = FALSE;

		if (!empty($update['option_name'])) {
			$this->db->set('option_name', $update['option_name']);
		}

		if (!empty($update['display_type'])) {
			$this->db->set('display_type', $update['display_type']);
		}

		if (!empty($update['priority'])) {
			$this->db->set('priority', $update['priority']);
		}

		if (!empty($update['option_id'])) {
			$this->db->where('option_id', $update['option_id']);

			if ($query = $this->db->update('options')) {
				$this->db->where('option_id', $update['option_id']);
				$this->db->delete('option_values');

				$this->addOptionValues($update['option_id'], $update['option_values']);
			}
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

				$this->load->model('Notifications_model');
				$this->Notifications_model->addNotification(array('action' => 'added', 'object' => 'menu', 'object_id' => $menu_id));

				$this->db->where('menu_id', $menu_id);
				$this->db->delete('menu_options');

				if (!empty($update['menu_options'])) {
					foreach ($update['menu_options'] as $key => $option) {
						foreach ($option['option_values'] as $value) {
							$this->db->set('menu_id', $update['menu_id']);
							$this->db->set('option_id', $option['option_id']);
							$this->db->set('option_value_id', $value['option_value_id']);
							$this->db->set('price', $value['price']);
							$query = $this->db->insert('menu_options');
						}
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

	public function updateCategory($update = array()) {
		$query = FALSE;

		if (!empty($update['name'])) {
			$this->db->set('name', $update['name']);
		}

		if (!empty($update['description'])) {
			$this->db->set('description', $update['description']);
		}

		if (!empty($update['parent_id'])) {
			$this->db->set('parent_id', $update['parent_id']);
		}

		if (!empty($update['image'])) {
			$this->db->set('image', $update['image']);
		}

		if (!empty($update['category_id'])) {
			$this->db->where('category_id', $update['category_id']);
			$query = $this->db->update('categories');

			if (!empty($update['permalink'])) {
                $this->permalink->updatePermalink('menus', $update['permalink'], 'category_id='.$update['category_id']);
			}
		}

		return $query;
	}

	public function addCategory($add = array()) {
		$query = FALSE;

		if (!empty($add['name'])) {
			$this->db->set('name', $add['name']);
		}

		if (!empty($add['description'])) {
			$this->db->set('description', $add['description']);
		}

		if (!empty($add['parent_id'])) {
			$this->db->set('parent_id', $add['parent_id']);
		}

		if (!empty($add['image'])) {
			$this->db->set('image', $add['image']);
		}

		if (!empty($add)) {
			if ($this->db->insert('categories')) {
				$query = $this->db->insert_id();

				if (!empty($add['permalink'])) {
                    $this->permalink->addPermalink('menus', $add['permalink'], 'category_id='.$query);
				}
			}
		}

		return $query;
	}

	public function addOption($add = array()) {
		$query = FALSE;

		if (!empty($add['option_name'])) {
			$this->db->set('option_name', $add['option_name']);
		}

		if (!empty($add['display_type'])) {
			$this->db->set('display_type', $add['display_type']);
		}

		if (!empty($add['priority'])) {
			$this->db->set('priority', $add['priority']);
		}

		if (!empty($add)) {
			if ($query = $this->db->insert('options')) {
				$option_id = $this->db->insert_id();
				$this->db->where('option_id', $option_id);
				$this->db->delete('option_values');

				$this->addOptionValues($option_id, $add['option_values']);
			}
		}

		return $query;
	}

	public function addOptionValues($option_id = FALSE, $option_values = array()) {
		$query = FALSE;

		if ($option_id !== FALSE AND !empty($option_values) AND is_array($option_values)) {
			$priority = 1;
			foreach ($option_values as $key => $value) {
				if (!empty($value['value'])) {
					$this->db->set('value', $value['value']);
				}

				if (!empty($value['price'])) {
					$this->db->set('price', $value['price']);
				}

				if (!empty($value['option_value_id'])) {
					$this->db->set('option_value_id', $value['option_value_id']);
				}

				$this->db->set('priority', $priority);

				$this->db->set('option_id', $option_id);
				$query = $this->db->insert('option_values');

				$priority++;
			}
		}

		return $query;
	}

	public function addMenuOption($menu_id = FALSE, $menu_options = array()) {
		$query = FALSE;

		if ($menu_id !== FALSE) {
			$this->db->where('menu_id', $menu_id);
			$this->db->delete('menu_options');

			$this->db->where('menu_id', $menu_id);
			$this->db->delete('menu_option_values');

			if (!empty($menu_options)) {
				foreach ($menu_options as $option) {
					$this->db->set('menu_id', $menu_id);
					$this->db->set('option_id', $option['option_id']);
					$this->db->set('required', $option['required']);
					$this->db->set('option_values', serialize($option['option_values']));

					if (!empty($option['menu_option_id'])) {
						$this->db->set('menu_option_id', $option['menu_option_id']);
					}

					if ($query = $this->db->insert('menu_options')) {
						$menu_option_id = $this->db->insert_id();
						$this->addMenuOptionValues($menu_option_id, $menu_id, $option['option_id'], $option['option_values']);
					}
				}
			}
		}

		return $query;
	}

	public function addMenuOptionValues($menu_option_id = FALSE, $menu_id = FALSE, $option_id = FALSE, $option_values = array()) {
		if ($menu_option_id !== FALSE AND $menu_id !== FALSE AND $option_id !== FALSE AND !empty($option_values)) {
			foreach ($option_values as $value) {
				$this->db->set('menu_option_id', $menu_option_id);
				$this->db->set('menu_id', $menu_id);
				$this->db->set('option_id', $option_id);
				$this->db->set('option_value_id', $value['option_value_id']);
				$this->db->set('new_price', $value['price']);

				if (!empty($value['menu_option_value_id'])) {
					$this->db->set('menu_option_value_id', $value['menu_option_value_id']);
				}

				$query = $this->db->insert('menu_option_values');
			}
		}
	}

	public function deleteMenu($menu_id) {
		if (is_numeric($menu_id)) {
			$this->db->where('menu_id', $menu_id);
			$this->db->delete('menus');

			$this->db->where('menu_id', $menu_id);
			$this->db->delete('menu_options');

			$this->db->where('menu_id', $menu_id);
			$this->db->delete('menu_option_values');

			$this->db->where('menu_id', $menu_id);
			$this->db->delete('menus_specials');

			if ($this->db->affected_rows() > 0) {
				return TRUE;
			}
		}
	}

	public function deleteMenuOption($option_id) {
		if (is_numeric($option_id)) {
			$this->db->where('option_id', $option_id);
			$this->db->delete('options');

			$this->db->where('option_id', $option_id);
			$this->db->delete('option_values');

			if ($this->db->affected_rows() > 0) {
				return TRUE;
			}
		}
	}

	public function deleteCategory($category_id) {
		if (is_numeric($category_id)) {
			$this->db->where('category_id', $category_id);
			$this->db->delete('categories');

			$this->db->where('query', 'category_id='.$category_id);
			$this->db->delete('permalinks');

			if ($this->db->affected_rows() > 0) {
				return TRUE;
			}
		}
	}
}

/* End of file menus_model.php */
/* Location: ./system/tastyigniter/models/menus_model.php */