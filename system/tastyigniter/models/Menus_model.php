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
 * Menus Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Menus_model.php
 * @link           http://docs.tastyigniter.com
 */
class Menus_model extends TI_Model {

	public function getCount($filter = array()) {
		if (APPDIR === ADMINDIR) {
			if ( ! empty($filter['filter_search'])) {
				$this->db->like('menu_name', $filter['filter_search']);
				$this->db->or_like('menu_price', $filter['filter_search']);
				$this->db->or_like('stock_qty', $filter['filter_search']);
			}

			if (is_numeric($filter['filter_status'])) {
				$this->db->where('menu_status', $filter['filter_status']);
			}
		}

		if ( ! empty($filter['filter_category'])) {
			$this->db->where('menu_category_id', $filter['filter_category']);
		}

		$this->db->from('menus');

		return $this->db->count_all_results();
	}

	public function getList($filter = array()) {
		if ( ! empty($filter['page']) AND $filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}

		if ($this->db->limit($filter['limit'], $filter['page'])) {
			if (APPDIR === ADMINDIR) {
				$this->db->select('*, menus.menu_id');
				$this->db->select('IF(start_date <= CURRENT_DATE(), IF(end_date >= CURRENT_DATE(), "1", "0"), "0") AS is_special', FALSE);
			} else {
				$this->db->select('menus.menu_id, menu_name, menu_description, menu_photo, menu_price, minimum_qty,
					menu_category_id, menu_priority, categories.name AS category_name, special_status, start_date, end_date, special_price,
					menus.mealtime_id, mealtimes.mealtime_name, mealtimes.start_time, mealtimes.end_time, mealtime_status');
				$this->db->select('IF(start_date <= CURRENT_DATE(), IF(end_date >= CURRENT_DATE(), "1", "0"), "0") AS is_special', FALSE);
				$this->db->select('IF(start_time <= CURRENT_TIME(), IF(end_time >= CURRENT_TIME(), "1", "0"), "0") AS is_mealtime', FALSE);
			}

			$this->db->join('categories', 'categories.category_id = menus.menu_category_id', 'left');
			$this->db->join('menus_specials', 'menus_specials.menu_id = menus.menu_id', 'left');
			$this->db->join('mealtimes', 'mealtimes.mealtime_id = menus.mealtime_id', 'left');

			if ( ! empty($filter['sort_by']) AND ! empty($filter['order_by'])) {
				$this->db->order_by($filter['sort_by'], $filter['order_by']);
			}

			if ( ! empty($filter['filter_search'])) {
				$this->db->like('menu_name', $filter['filter_search']);
				$this->db->or_like('menu_price', $filter['filter_search']);
				$this->db->or_like('stock_qty', $filter['filter_search']);
			}

			if ( ! empty($filter['filter_category'])) {
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

			if (APPDIR === ADMINDIR) {
				return $result;
			}

			$this->load->model('Image_tool_model');

			$results = array();

			$show_menu_images = (is_numeric($this->config->item('show_menu_images'))) ? $this->config->item('show_menu_images') : '';
			$menu_images_h = (is_numeric($this->config->item('menu_images_h'))) ? $this->config->item('menu_images_h') : '50';
			$menu_images_w = (is_numeric($this->config->item('menu_images_w'))) ? $this->config->item('menu_images_w') : '50';

			foreach ($result as $row) {                                                            // loop through menus array
				$menu_photo_src = '';
				if ($show_menu_images === '1') {
					if ( ! empty($row['menu_photo'])) {
						$menu_photo_src = $this->Image_tool_model->resize($row['menu_photo'], $menu_images_w, $menu_images_h);
					}
				}

				$start_date = $end_date = $end_days = '';
				$price = $row['menu_price'];
				if ($row['special_status'] === '1' AND $row['is_special'] === '1') {
					$price = $row['special_price'];
					$daydiff = floor((strtotime($row['end_date']) - time()) / 86400);
					$start_date = $row['start_date'];
					$end_date = mdate('%d %M', strtotime($row['end_date']));

					if (($daydiff < 0)) {
						$end_days = sprintf($this->lang->line('text_end_today'));
					} else {
						$end_days = sprintf($this->lang->line('text_end_days'), $end_date, $daydiff);
					}
				}

				$results[$row['menu_category_id']][] = array(                                                            // create array of menu data to be sent to view
					'menu_id'          => $row['menu_id'],
					'menu_name'        => (strlen($row['menu_name']) > 80) ? strtolower(substr($row['menu_name'], 0, 80)) . '...' : strtolower($row['menu_name']),
					'menu_description' => (strlen($row['menu_description']) > 120) ? substr($row['menu_description'], 0, 120) . '...' : $row['menu_description'],
					'category_name'    => $row['category_name'],
					'category_id'      => $row['menu_category_id'],
					'minimum_qty'      => ! empty($row['minimum_qty']) ? $row['minimum_qty'] : '1',
					'menu_priority'    => $row['menu_priority'],
					'mealtime_name'    => $row['mealtime_name'],
					'start_time'  	   => mdate($this->config->item('time_format'), strtotime($row['start_time'])),
					'end_time'         => mdate($this->config->item('time_format'), strtotime($row['end_time'])),
					'is_mealtime'      => $row['is_mealtime'],
					'mealtime_status'  => (!empty($row['mealtime_id']) AND !empty($row['mealtime_status'])) ? '1' : '0',
					'special_status'   => $row['special_status'],
					'is_special'       => $row['is_special'],
					'start_date'       => $start_date,
					'end_days'         => $end_days,
					'menu_price'       => $this->currency->format($price),        //add currency symbol and format price to two decimal places
					'menu_photo'       => $menu_photo_src,
				);
			}

			return $results;
		}
	}

	public function getMenu($menu_id) {
		//$this->db->select('menus.menu_id, *');
		$this->db->select('menus.menu_id, menu_name, menu_description, menu_price, menu_photo, menu_category_id, stock_qty,
			minimum_qty, subtract_stock, menu_status, menu_priority, category_id, categories.name, description, special_id, start_date,
			end_date, special_price, special_status, menus.mealtime_id, mealtimes.mealtime_name, mealtimes.start_time, mealtimes.end_time, mealtime_status');
		$this->db->from('menus');
		$this->db->join('categories', 'categories.category_id = menus.menu_category_id', 'left');
		$this->db->join('menus_specials', 'menus_specials.menu_id = menus.menu_id', 'left');
		$this->db->join('mealtimes', 'mealtimes.mealtime_id = menus.mealtime_id', 'left');
		$this->db->where('menus.menu_id', $menu_id);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
	}

	public function updateStock($menu_id, $quantity = 0, $action = 'subtract') {
		$update = FALSE;

		if (is_numeric($menu_id)) {
			$this->db->select('menus.menu_id, menu_name, stock_qty, minimum_qty, subtract_stock, menu_status');
			$this->db->from('menus');
			$this->db->where('menus.menu_id', $menu_id);

			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				$row = $query->row_array();

				if ($row['subtract_stock'] === '1' AND ! empty($quantity)) {
					$stock_qty = 'stock_qty + ' . $quantity;

					if ($action === 'subtract') {
						$stock_qty = 'stock_qty - ' . $quantity;
					}

					$this->db->set('stock_qty', $stock_qty, FALSE);
					$this->db->where('menu_id', $menu_id);
					$update = $this->db->update('menus');
				}
			}
		}

		return $update;
	}

	public function getAutoComplete($filter_data = array()) {
		if (is_array($filter_data) AND ! empty($filter_data)) {
			//selecting all records from the menu and categories tables.
			$this->db->from('menus');

			$this->db->where('menu_status', '1');

			if ( ! empty($filter_data['menu_name'])) {
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

	public function saveMenu($menu_id, $save = array()) {
		if (empty($save) AND ! is_array($save)) return FALSE;

		if (isset($save['menu_name'])) {
			$this->db->set('menu_name', $save['menu_name']);
		}

		if (isset($save['menu_description'])) {
			$this->db->set('menu_description', $save['menu_description']);
		}

		if (isset($save['menu_price'])) {
			$this->db->set('menu_price', $save['menu_price']);
		}

		if (isset($save['special_status']) AND $save['special_status'] === '1') {
			$this->db->set('menu_category_id', (int) $this->config->item('special_category_id'));
		} else if (isset($save['menu_category'])) {
			$this->db->set('menu_category_id', $save['menu_category']);
		}

		if (isset($save['menu_photo'])) {
			$this->db->set('menu_photo', $save['menu_photo']);
		}

		if (isset($save['stock_qty']) AND $save['stock_qty'] > 0) {
			$this->db->set('stock_qty', $save['stock_qty']);
		} else {
			$this->db->set('stock_qty', '0');
		}

		if (isset($save['minimum_qty']) AND $save['minimum_qty'] > 0) {
			$this->db->set('minimum_qty', $save['minimum_qty']);
		} else {
			$this->db->set('minimum_qty', '1');
		}

		if (isset($save['subtract_stock']) AND $save['subtract_stock'] === '1') {
			$this->db->set('subtract_stock', $save['subtract_stock']);
		} else {
			$this->db->set('subtract_stock', '0');
		}

		if (isset($save['menu_status']) AND $save['menu_status'] === '1') {
			$this->db->set('menu_status', $save['menu_status']);
		} else {
			$this->db->set('menu_status', '0');
		}

		if (isset($save['mealtime_id'])) {
			$this->db->set('mealtime_id', $save['mealtime_id']);
		} else {
			$this->db->set('mealtime_id', '0');
		}

		if (isset($save['menu_priority'])) {
			$this->db->set('menu_priority', $save['menu_priority']);
		} else {
			$this->db->set('menu_priority', '0');
		}

		if (is_numeric($menu_id)) {
			$this->db->where('menu_id', (int) $menu_id);
			$query = $this->db->update('menus');
		} else {
			$query = $this->db->insert('menus');
			$menu_id = $this->db->insert_id();
		}

		if ($query === TRUE AND is_numeric($menu_id)) {
			if ( ! empty($save['menu_options'])) {
				$this->load->model('Menu_options_model');
				$this->Menu_options_model->addMenuOption($menu_id, $save['menu_options']);
			}

			if ( ! empty($save['start_date']) AND ! empty($save['end_date']) AND isset($save['special_price'])) {
				$this->db->set('start_date', mdate('%Y-%m-%d', strtotime($save['start_date'])));
				$this->db->set('end_date', mdate('%Y-%m-%d', strtotime($save['end_date'])));
				$this->db->set('special_price', $save['special_price']);

				if (isset($save['special_status']) AND $save['special_status'] === '1') {
					$this->db->set('special_status', '1');
				} else {
					$this->db->set('special_status', '0');
				}

				if (isset($save['special_id'])) {
					$this->db->where('special_id', $save['special_id']);
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
		if (is_numeric($menu_id)) $menu_id = array($menu_id);

		if ( ! empty($menu_id) AND ctype_digit(implode('', $menu_id))) {
			$this->db->where_in('menu_id', $menu_id);
			$this->db->delete('menus');

			if (($affected_rows = $this->db->affected_rows()) > 0) {
				$this->load->model('Menu_options_model');
				$this->Menu_options_model->deleteMenuOption($menu_id);

				$this->db->where_in('menu_id', $menu_id);
				$this->db->delete('menus_specials');

				return $affected_rows;
			}
		}
	}
}

/* End of file menus_model.php */
/* Location: ./system/tastyigniter/models/menus_model.php */