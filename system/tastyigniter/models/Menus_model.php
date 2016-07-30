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
class Menus_model extends TI_Model
{
	/**
	 * @var string The database table name
	 */
	protected $table_name = 'menus';

	/**
	 * @var string The database table primary key
	 */
	protected $primary_key = 'menu_id';

	protected $has_one = array(
		'menus_specials' => array('Menus_specials_model', 'menu_id'),
	);

	protected $belongs_to = array(
		'categories' => array('Categories_model', 'menu_category_id'),
		'mealtimes'  => array('Mealtimes_model'),
	);

	protected $casts = array(
		'start_time' => 'time',
		'end_time'   => 'time',
		'start_date' => 'date',
		'end_date'   => 'date',
	);

	/**
	 * Count the number of records
	 *
	 * @param array $filter
	 *
	 * @return int
	 */
	public function getCount($filter = array()) {
		return $this->filter($filter)->with('categories', 'menus_specials', 'mealtimes')->count();
	}

	/**
	 * List all options matching the filter
	 *
	 * @param array $filter
	 *
	 * @return array|mixed
	 */
	public function getList($filter = array()) {
		$result = $this->filter($filter)->with('categories', 'menus_specials', 'mealtimes')->find_all();

		if (APPDIR === ADMINDIR) {
			return $result;
		}

		return $this->buildMenuArray($result);
	}

	/**
	 * Filter database records
	 *
	 * @param array $filter an associative array of field/value pairs
	 *
	 * @return $this
	 */
	public function filter($filter = array()) {
		$current_date = $this->escape(mdate('%Y-%m-%d', time()));
		$current_time = $this->escape(mdate('%H:%i:%s', time()));

		if (APPDIR === ADMINDIR) {
			$this->select('*, menus.menu_id, IF(start_date <= ' . $current_date . ', IF(end_date >= ' . $current_date . ', "1", "0"), "0") AS is_special', FALSE);
		} else {
			$this->select('menus.menu_id, menu_name, menu_description, menu_photo, menu_price, minimum_qty,
				menu_category_id, menu_priority, categories.name AS category_name, special_status, start_date, end_date, special_price,
				menus.mealtime_id, mealtimes.mealtime_name, mealtimes.start_time, mealtimes.end_time, mealtime_status'
			);
			$this->select('IF(start_date <= ' . $current_date . ', IF(end_date >= ' . $current_date . ', "1", "0"), "0") AS is_special', FALSE);
			$this->select('IF(start_time <= ' . $current_time . ', IF(end_time >= ' . $current_time . ', "1", "0"), "0") AS is_mealtime', FALSE);
		}

		if (APPDIR === ADMINDIR) {
			if (!empty($filter['filter_search'])) {
				$this->like('menu_name', $filter['filter_search']);
				$this->or_like('menu_price', $filter['filter_search']);
				$this->or_like('stock_qty', $filter['filter_search']);
			}

			if (is_numeric($filter['filter_status'])) {
				$this->where('menu_status', $filter['filter_status']);
			}
		}

		if (!empty($filter['filter_category'])) {
			$this->where('menu_category_id', $filter['filter_category']);
		}

		return $this;
	}

	/**
	 * Find a single menu by menu_id
	 *
	 * @param int $menu_id
	 *
	 * @return mixed
	 */
	public function getMenu($menu_id) {
		$this->select('menus.menu_id, menu_name, menu_description, menu_price, menu_photo, menu_category_id, stock_qty,
			minimum_qty, subtract_stock, menu_status, menu_priority, category_id, categories.name, description, special_id, start_date,
			end_date, special_price, special_status, menus.mealtime_id, mealtimes.mealtime_name, mealtimes.start_time, mealtimes.end_time, mealtime_status');
		$this->where('menus.menu_id', $menu_id);

		return $this->with('categories', 'menus_specials', 'mealtimes')->find();
	}

	/**
	 * Subtract or add to menu stock quantity
	 *
	 * @param int    $menu_id
	 * @param int    $quantity
	 * @param string $action
	 *
	 * @return bool TRUE on success, or FALSE on failure
	 */
	public function updateStock($menu_id, $quantity = 0, $action = 'subtract') {
		$update = FALSE;

		if (is_numeric($menu_id)) {
			$this->select('menus.menu_id, menu_name, stock_qty, minimum_qty, subtract_stock, menu_status');
			if ($row = $this->find('menus.menu_id', $menu_id)) {
				if ($row['subtract_stock'] === '1' AND !empty($quantity)) {
					$stock_qty = $row['stock_qty'] + $quantity;

					if ($action === 'subtract') {
						$stock_qty = $row['stock_qty'] - $quantity;
					}

					$update = $this->update(array('menu_id' => $menu_id), array('stock_qty' => $stock_qty));
				}
			}
		}

		return $update;
	}

	/**
	 * List all menus matching the filter,
	 * to fill select auto-complete options
	 *
	 * @param array $filter
	 *
	 * @return array
	 */
	public function getAutoComplete($filter = array()) {
		if (is_array($filter) AND !empty($filter)) {
			//selecting all records from the menu and categories tables.
			$this->where('menu_status', '1');

			if (!empty($filter['menu_name'])) {
				$this->like('menu_name', $filter['menu_name']);
			}

			return $this->find_all();
		}
	}

	/**
	 * Create a new or update existing menu
	 *
	 * @param int   $menu_id
	 * @param array $save
	 *
	 * @return bool|int The $menu_id of the affected row, or FALSE on failure
	 */
	public function saveMenu($menu_id, $save = array()) {
		if (empty($save) AND !is_array($save)) return FALSE;

		if (isset($save['special_status']) AND $save['special_status'] === '1') {
			$save['menu_category_id'] = (int)$this->config->item('special_category_id');
		}

		if ($menu_id = $this->skip_validation(TRUE)->save($save, $menu_id)) {
			$this->load->model('Menu_options_model');
			$save['menu_options'] = isset($save['menu_options']) ? $save['menu_options'] : array();
			$this->Menu_options_model->addMenuOption($menu_id, $save['menu_options']);

			if (!empty($save['start_date']) AND !empty($save['end_date']) AND isset($save['special_price'])) {
				$save['menu_id'] = $menu_id;
				$this->load->model('Menus_specials_model');
				$this->Menus_specials_model->save($save, $save['special_id']);
			}

			return $menu_id;
		}
	}

	/**
	 * Delete a single or multiple option by menu_id
	 *
	 * @param string|array $menu_id
	 *
	 * @return int The number of deleted rows
	 */
	public function deleteMenu($menu_id) {
		if (is_numeric($menu_id)) $menu_id = array($menu_id);

		if (!empty($menu_id) AND ctype_digit(implode('', $menu_id))) {
			$affected_rows = $this->delete('menu_id', $menu_id);

			if ($affected_rows > 0) {
				$this->load->model('Menu_options_model');
				$this->Menu_options_model->delete('menu_id', $menu_id);

				$this->load->model('Menus_specials_model');
				$this->Menus_specials_model->delete('menu_id', $menu_id);

				return $affected_rows;
			}
		}
	}

	/**
	 * Build menu data array
	 *
	 * @param array $rows
	 *
	 * @return array
	 */
	protected function buildMenuArray($rows = array()) {
		$this->load->model('Image_tool_model');

		$show_menu_images = (is_numeric($this->config->item('show_menu_images'))) ? $this->config->item('show_menu_images') : '';
		$menu_images_h = (is_numeric($this->config->item('menu_images_h'))) ? $this->config->item('menu_images_h') : '50';
		$menu_images_w = (is_numeric($this->config->item('menu_images_w'))) ? $this->config->item('menu_images_w') : '50';

		$result = array();
		foreach ($rows as $row) {                                                            // loop through menus array
			if ($show_menu_images === '1' AND !empty($row['menu_photo'])) {
				$row['menu_photo'] = $this->Image_tool_model->resize($row['menu_photo'], $menu_images_w, $menu_images_h);
			}

			$end_days = $end_date = '';
			if ($row['special_status'] === '1' AND $row['is_special'] === '1') {
				$row['menu_price'] = $row['special_price'];
				$end_date = mdate('%d %M', strtotime($row['end_date']));

				$end_days = sprintf($this->lang->line('text_end_today'));
				if (($daydiff = floor((strtotime($row['end_date']) - time()) / 86400)) > 0) {
					$end_days = sprintf($this->lang->line('text_end_days'), $end_date, $daydiff);
				}
			}

			$result[$row['menu_category_id']][] = array_merge($row, array(                                                            // create array of menu data to be sent to view
//				'menu_name'        => (strlen($row['menu_name']) > 80) ? strtolower(substr($row['menu_name'], 0, 80)) . '...' : strtolower($row['menu_name']),
//				'menu_description' => (strlen($row['menu_description']) > 120) ? substr($row['menu_description'], 0, 120) . '...' : $row['menu_description'],
//				'category_id'      => $row['menu_category_id'],
				'minimum_qty'     => !empty($row['minimum_qty']) ? $row['minimum_qty'] : '1',
				'mealtime_status' => (!empty($row['mealtime_id']) AND !empty($row['mealtime_status'])) ? '1' : '0',
				'end_date'        => $end_date,
				'end_days'        => $end_days,
				'menu_price'      => $this->currency->format($row['menu_price']),        //add currency symbol and format price to two decimal places
			));
		}

		return $result;
	}
}

/* End of file Menus_model.php */
/* Location: ./system/tastyigniter/models/Menus_model.php */