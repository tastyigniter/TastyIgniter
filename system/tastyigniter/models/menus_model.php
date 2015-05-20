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

	public function saveMenu($update = array()) {
        if (empty($update) AND !is_array($update)) return FALSE;

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

		if (is_numeric($this->input->get('id')) AND $menu_id = $this->input->get('id')) {
            $this->db->where('menu_id', $menu_id);
            $query = $this->db->update('menus');
        } else {
            $query = $this->db->insert('menus');
            $menu_id = $this->db->insert_id();
        }

        if (!empty($menu_id) AND !empty($query)) {
            $this->load->model('Notifications_model');
            $this->Notifications_model->addNotification(array('action' => 'updated', 'object' => 'menu', 'object_id' => $menu_id));

            if (!empty($update['menu_options'])) {
                $this->load->model('Menu_options_model');
                $this->Menu_options_model->addMenuOption($menu_id, $update['menu_options']);
            }

            if (!empty($update['start_date']) AND !empty($update['end_date']) AND !empty($update['special_price'])) {
                $this->db->set('start_date', mdate('%Y-%m-%d', strtotime($update['start_date'])));
                $this->db->set('end_date', mdate('%Y-%m-%d', strtotime($update['end_date'])));
                $this->db->set('special_price', $update['special_price']);

                if ($update['special_status'] === '1') {
                    $this->db->set('special_status', '1');
                } else {
                    $this->db->set('special_status', '0');
                }

                if (!empty($update['special_id'])) {
                    $this->db->where('special_id', $update['special_id']);
                    $this->db->where('menu_id', $menu_id);
                    $this->db->update('menus_specials');
                } else {
                    $this->db->set('menu_id', $menu_id);
                    $this->db->insert('menus_specials');
                }
            }

            return $menu_id;
        }
	}

	public function deleteMenu($menu_id) {
		if (is_numeric($menu_id)) {
			$this->db->where('menu_id', $menu_id);
			$this->db->delete('menus');

            $this->load->model('Menu_options_model');
            $this->Menu_options_model->deleteMenuOption($menu_id);

			$this->db->where('menu_id', $menu_id);
			$this->db->delete('menus_specials');

			if ($this->db->affected_rows() > 0) {
				return TRUE;
			}
		}
	}
}

/* End of file menus_model.php */
/* Location: ./system/tastyigniter/models/menus_model.php */