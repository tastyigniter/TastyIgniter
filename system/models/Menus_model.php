<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package Igniter
 * @author Samuel Adepoyigi
 * @copyright (c) 2013 - 2016. Samuel Adepoyigi
 * @copyright (c) 2016 - 2017. TastyIgniter Dev Team
 * @link https://tastyigniter.com
 * @license http://opensource.org/licenses/MIT The MIT License
 * @since File available since Release 1.0
 */
defined('BASEPATH') or exit('No direct script access allowed');

use Igniter\Database\Model;

/**
 * Menus Model Class
 *
 * @category       Models
 * @package        Igniter\Models\Menus_model.php
 * @link           http://docs.tastyigniter.com
 */
class Menus_model extends Model
{
	/**
	 * @var string The database table name
	 */
	protected $table = 'menus';

	/**
	 * @var string The database table primary key
	 */
	protected $primaryKey = 'menu_id';

	protected $fillable = ['menu_id', 'menu_name', 'menu_description', 'menu_price', 'menu_photo', 'menu_category_id',
		'stock_qty', 'minimum_qty', 'subtract_stock', 'mealtime_id', 'menu_status', 'menu_priority'];

	public $hasOne = [
		'menus_special' => ['Menus_specials_model', 'menu_id'],
	];

	public $belongsTo = [
		'category' => ['Categories_model', 'menu_category_id'],
		'mealtime' => ['Mealtimes_model'],
	];

	protected $casts = [
		'start_time' => 'time',
		'end_time'   => 'time',
		'start_date' => 'date',
		'end_date'   => 'date',
	];

	/**
	 * Filter database records
	 *
	 * @param $query
	 * @param array $filter an associative array of field/value pairs
	 *
	 * @return $this
	 */
	public function scopeFilter($query, $filter = [])
	{
		$current_date = $this->escape(mdate('%Y-%m-%d', time()));
		$current_time = $this->escape(mdate('%H:%i:%s', time()));

		$menusTable = $this->tablePrefix('menus');
		$categoriesTable = $this->tablePrefix('categories');
		$menusSpecialsTable = $this->tablePrefix('menus_specials');
		$mealtimesTable = $this->tablePrefix('mealtimes');
		$locationMenusTable = $this->tablePrefix('location_menus');

		if (APPDIR === ADMINDIR) {
			$queryBuilder = "*, {$menusTable}.menu_id, IF(start_date <= {$current_date}, IF(end_date >= {$current_date}, \"1\", \"0\"), \"0\") AS is_special";
		} else {
			$queryBuilder = "{$menusTable}.menu_id, menu_name, menu_description, menu_photo, menu_price, minimum_qty,
				menu_category_id, menu_priority, {$categoriesTable}.name AS category_name, special_status,
				start_date, end_date, special_price, {$menusTable}.mealtime_id, {$mealtimesTable}.mealtime_name,
				{$mealtimesTable}.start_time, {$mealtimesTable}.end_time, mealtime_status, {$locationMenusTable}.location_id, " .
				"IF({$menusSpecialsTable}.start_date <= {$current_date}, IF({$menusSpecialsTable}.end_date >= {$current_date}, \"1\", \"0\"), \"0\") AS is_special, " .
				"IF({$mealtimesTable}.start_time <= {$current_time}, IF({$mealtimesTable}.end_time >= {$current_time}, \"1\", \"0\"), \"0\") AS is_mealtime";
		}

		$query->selectRaw($queryBuilder);
		$query->leftJoin('categories', 'categories.category_id', '=', 'menus.menu_category_id');
		$query->leftJoin('menus_specials', 'menus_specials.menu_id', '=', 'menus.menu_id');
		$query->leftJoin('mealtimes', 'mealtimes.mealtime_id', '=', 'menus.mealtime_id');
		$query->leftJoin('location_menus', 'location_menus.menu_id', '=', 'menus.menu_id');

		if (APPDIR === ADMINDIR) {
			if (!empty($filter['filter_search'])) {
				$query->search($filter['filter_search'], ['menu_name', 'menu_price', 'stock_qty']);
			}

			if (is_numeric($filter['filter_status'])) {
				$query->where('menu_status', $filter['filter_status']);
			}
		}

		if (!empty($filter['filter_location'])) {
			$query->where('location_id', $filter['filter_location']);
		}

		if (!empty($filter['filter_category'])) {
			$query->where('menu_category_id', $filter['filter_category']);
		}

		$query->groupBy('menus.menu_id');

		return $query;
	}

	/**
	 * Find a single menu by menu_id
	 *
	 * @param int $menu_id
	 *
	 * @return mixed
	 */
	public function getMenu($menu_id)
	{
		$menusTable = $this->tablePrefix('menus');
		$categoriesTable = $this->tablePrefix('categories');
		$menusSpecialsTable = $this->tablePrefix('menus_specials');
		$mealtimesTable = $this->tablePrefix('mealtimes');

		$result = $this->selectRaw("*, {$menusTable}.menu_id, menu_name, " .
			"menu_description, menu_price, menu_photo, menu_category_id, stock_qty, minimum_qty, subtract_stock, " .
			"menu_status, menu_priority, category_id, {$categoriesTable}.name, description, special_id, start_date, " .
			"end_date, {$menusSpecialsTable}.special_id, special_price, special_status, {$menusTable}.mealtime_id, {$mealtimesTable}.mealtime_name, " .
			"{$mealtimesTable}.start_time, {$mealtimesTable}.end_time, mealtime_status")
					   ->leftJoin('categories', 'categories.category_id', '=', 'menus.menu_category_id')
					   ->leftJoin('menus_specials', 'menus_specials.menu_id', '=', 'menus.menu_id')
					   ->leftJoin('mealtimes', 'mealtimes.mealtime_id', '=', 'menus.mealtime_id')
					   ->findOrNew($menu_id);

		return $result;
	}

	/**
	 * Return all menus by location
	 *
	 * @param int $location_id
	 *
	 * @return array
	 */
	public function getMenusByLocation($location_id = null)
	{
		$location_menus = [];
		$this->load->model('Location_menus_model');
		$menus = $this->Location_menus_model->where('location_id', $location_id)->getAsArray();
		foreach ($menus as $row) {
			$location_menus[] = $row['menu_id'];
		}

		return $location_menus;
	}

	/**
	 * Subtract or add to menu stock quantity
	 *
	 * @param int $menu_id
	 * @param int $quantity
	 * @param string $action
	 *
	 * @return bool TRUE on success, or FALSE on failure
	 */
	public function updateStock($menu_id, $quantity = 0, $action = 'subtract')
	{
		$update = FALSE;

		if (is_numeric($menu_id)) {
			$menuModel = $this->find($menu_id);
			if ($menuModel AND $row = $menuModel->toArray()) {
				if ($row['subtract_stock'] == '1' AND !empty($quantity)) {
					$stock_qty = $row['stock_qty'] + $quantity;

					if ($action === 'subtract') {
						$stock_qty = $row['stock_qty'] - $quantity;
					}

					$update = $menuModel->update(['stock_qty' => $stock_qty]);
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
	public function getAutoComplete($filter = [])
	{
		if (is_array($filter) AND !empty($filter)) {
			//selecting all records from the menu and categories tables.
			$queryBuilder = $this->where('menu_status', '1');

			if (!empty($filter['menu_name'])) {
				$queryBuilder->like('menu_name', $filter['menu_name']);
			}

			return $queryBuilder->getAsArray();
		}
	}

	/**
	 * Create a new or update existing menu
	 *
	 * @param int $menu_id
	 * @param array $save
	 *
	 * @return bool|int The $menu_id of the affected row, or FALSE on failure
	 */
	public function saveMenu($menu_id, $save = [])
	{
		if (empty($save) AND !is_array($save)) return FALSE;

		if (isset($save['special_status']) AND $save['special_status'] == '1' AND empty($save['menu_category_id'])) {
			$save['menu_category_id'] = (int)$this->config->item('special_category_id');
		}

		$menuModel = $this->findOrNew($menu_id);

		if ($saved = $menuModel->fill($save)->save()) {
			$menu_id = $menuModel->getKey();

			$this->addMenuLocations($menu_id, isset($save['locations']) ? $save['locations'] : []);

			$this->load->model('Menu_options_model');
			$this->Menu_options_model->addMenuOption($menu_id, isset($save['menu_options']) ? $save['menu_options'] : []);

			if (!empty($save['start_date']) AND !empty($save['end_date']) AND isset($save['special_price'])) {
				$save['menu_id'] = $menu_id;
				$this->load->model('Menus_specials_model');
				$this->Menus_specials_model->findOrNew($save['special_id'])->fill($save)->save();
			}

			return $menu_id;
		}
	}

	/**
	 * Create a new or update existing menu locations
	 *
	 * @param int $menu_id
	 * @param array $locations
	 *
	 * @return bool
	 */
	public function addMenuLocations($menu_id, $locations = [])
	{
		if (is_single_location())
			return TRUE;

		$this->load->model('Location_menus_model');
		$affected_rows = $this->Location_menus_model->where('menu_id', $menu_id)->delete();

		if (is_array($locations) AND !empty($locations)) {
			foreach ($locations as $key => $location_id) {
				$this->Location_menus_model->firstOrCreate([
					'menu_id'    => $menu_id,
					'location_id' => $location_id,
				]);
			}
		}

		if (!empty($locations) AND $affected_rows > 0) {
			return TRUE;
		}
	}

	/**
	 * Delete a single or multiple option by menu_id
	 *
	 * @param string|array $menu_id
	 *
	 * @return int The number of deleted rows
	 */
	public function deleteMenu($menu_id)
	{
		if (is_numeric($menu_id)) $menu_id = [$menu_id];

		if (!empty($menu_id) AND ctype_digit(implode('', $menu_id))) {
			$affected_rows = $this->whereIn('menu_id', $menu_id)->delete();

			if ($affected_rows > 0) {
				$this->load->model('Menu_options_model');
				$this->Menu_options_model->deleteMenuOption($menu_id);

				$this->load->model('Menus_specials_model');
				$this->Menus_specials_model->whereIn('menu_id', $menu_id)->delete();

				$this->load->model('Location_menus_model');
				$this->Location_menus_model->whereIn('menu_id', $menu_id)->delete();

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
	public function buildMenuList($rows = [])
	{
		$this->load->model('Image_tool_model');

		$show_menu_images = (is_numeric($this->config->item('show_menu_images'))) ? $this->config->item('show_menu_images') : '';
		$menu_images_h = (is_numeric($this->config->item('menu_images_h'))) ? $this->config->item('menu_images_h') : '50';
		$menu_images_w = (is_numeric($this->config->item('menu_images_w'))) ? $this->config->item('menu_images_w') : '50';

		$result = [];
		foreach ($rows as $row) {                                                            // loop through menus array
			if ($show_menu_images == '1' AND !empty($row['menu_photo'])) {
				$row['menu_photo'] = $this->Image_tool_model->resize($row['menu_photo'], $menu_images_w, $menu_images_h);
			}

			$end_days = $end_date = '';
			if ($row['special_status'] == '1' AND $row['is_special'] == '1') {
				$row['menu_price'] = $row['special_price'];
				$end_date = mdate('%d %M', strtotime($row['end_date']));

				$end_days = sprintf($this->lang->line('text_end_today'));
				if (($daydiff = floor((strtotime($row['end_date']) - time()) / 86400)) > 0) {
					$end_days = sprintf($this->lang->line('text_end_days'), $end_date, $daydiff);
				}
			}

			$result[$row['menu_category_id']][] = array_merge($row, [                                                            // create array of menu data to be sent to view
				'category_id'     => $row['menu_category_id'],
				'minimum_qty'     => !empty($row['minimum_qty']) ? $row['minimum_qty'] : '1',
				'mealtime_status' => (!empty($row['mealtime_id']) AND !empty($row['mealtime_status'])) ? '1' : '0',
				'end_date'        => $end_date,
				'end_days'        => $end_days,
				'menu_price'      => $this->currency->format($row['menu_price']),        //add currency symbol and format price to two decimal places
			]);
		}

		return $result;
	}
}

/* End of file Menus_model.php */
/* Location: ./system/tastyigniter/models/Menus_model.php */
