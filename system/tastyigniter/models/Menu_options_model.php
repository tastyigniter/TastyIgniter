<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package       TastyIgniter
 * @author        SamPoyigi
 * @copyright (c) 2013 - 2016. TastyIgniter
 * @link          http://tastyigniter.com
 * @license       http://opensource.org/licenses/GPL-3.0 The GNU GENERAL PUBLIC LICENSE
 * @since         File available since Release 1.0
 */
defined('BASEPATH') or exit('No direct script access allowed');

use TastyIgniter\Database\Model;

/**
 * Menu_options Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Menu_options_model.php
 * @link           http://docs.tastyigniter.com
 */
class Menu_options_model extends Model
{
	/**
	 * @var string The database table name
	 */
	protected $table = 'options';

	/**
	 * @var string The database table primary key
	 */
	protected $primaryKey = 'option_id';

//	protected $fillable = ['menu_option_id', 'option_id', 'menu_id', 'required', 'default_value_id', 'option_values'];
	protected $fillable = ['option_id', 'option_name', 'display_type', 'priority'];

	/**
	 * Filter database records
	 *
	 * @param array $filter an associative array of field/value pairs
	 *
	 * @return $this
	 */
	public function scopeFilter($query, $filter = [])
	{
		if (!empty($filter['filter_search'])) {
			$query->like('option_name', $filter['filter_search']);
		}

		if (!empty($filter['filter_display_type'])) {
			$query->where('display_type', $filter['filter_display_type']);
		}

		return $query;
	}

	/**
	 * Return all option values by option_id
	 *
	 * @param int $option_id
	 *
	 * @return array
	 */
	public function getOptionValues($option_id = null)
	{
		$query = $this->orderBy('priority')->from('option_values');

		if ($option_id !== FALSE) {
			$query->where('option_id', $option_id);
		}

		return $query->getAsArray();
	}

	/**
	 * Find a single option by option_id
	 *
	 * @param $option_id
	 *
	 * @return mixed
	 */
	public function getOption($option_id)
	{
		return $this->findOrNew($option_id)->toArray();
	}

	/**
	 * Return all menu options by menu_id
	 *
	 * @param int $menu_id
	 *
	 * @return array
	 */
	public function getMenuOptions($menu_id = null)
	{
		$results = [];

		$tablePrefixed = $this->tablePrefix('menu_options');

		$query = $this->selectRaw("*, {$tablePrefixed}.menu_id, {$tablePrefixed}.option_id")
					  ->leftJoin('options', 'options.option_id', '=', 'menu_options.option_id');

		if (is_numeric($menu_id)) {
			$query->where('menu_id', $menu_id);
		}

		if ($result = $query->orderBy('options.priority')->from('menu_options')->getAsArray()) {
			foreach ($result as $row) {
				$results[] = array_merge($row, [
					'option_values' => $this->getMenuOptionValues($row['menu_option_id'], $row['option_id']),
				]);
			}
		}

		return $results;
	}

	/**
	 * Return all menu option values by menu_option_id and option_id
	 *
	 * @param int $menu_option_id
	 * @param int $option_id
	 *
	 * @return array
	 */
	public function getMenuOptionValues($menu_option_id = null, $option_id = null)
	{
		$result = [];

		if (is_numeric($menu_option_id) AND is_numeric($option_id)) {
			$valuePrefixed = $this->tablePrefix('menu_option_values');
			$optionPrefixed = $this->tablePrefix('option_values');

			$result = $this->selectRaw("*, {$valuePrefixed}.option_id, {$optionPrefixed}.option_value_id")
						   ->leftJoin('option_values', 'option_values.option_value_id', '=', 'menu_option_values.option_value_id')
						   ->where('menu_option_values.menu_option_id', $menu_option_id)
						   ->where('menu_option_values.option_id', $option_id)
						   ->orderBy('option_values.priority')->from('menu_option_values')->getAsArray();
		}

		return $result;
	}

	/**
	 * List all options matching the filter,
	 * to fill select auto-complete options
	 *
	 * @param array $filter
	 *
	 * @return array
	 */
	public function getAutoComplete($filter = [])
	{
		if (is_array($filter) AND !empty($filter)) {
			$queryBuilder = $this->query();

			if (!empty($filter['option_name'])) {
				$queryBuilder->like('option_name', $filter['option_name']);
			}

			$result = [];
			if ($rows = $queryBuilder->getAsArray()) {
				foreach ($rows as $row) {
					$result[] = array_merge($row, [
						'option_values' => $this->getOptionValues($row['option_id']),
					]);
				}
			}

			return $result;
		}
	}

	/**
	 * Create a new or update existing options
	 *
	 * @param int $option_id
	 * @param array $save
	 *
	 * @return bool|int The $option_id of the affected row, or FALSE on failure
	 */
	public function saveOption($option_id, $save = [])
	{
		if (empty($save)) return FALSE;

		$menuOptionModel = $this->findOrNew($option_id);

		if ($saved = $menuOptionModel->fill($save)->save()) {
			$save['option_values'] = isset($save['option_values']) ? $save['option_values'] : [];
			$this->addOptionValues($menuOptionModel->getKey(), $save['option_values']);
		}

		return $saved ? $menuOptionModel->getKey() : $saved;
	}

	/**
	 * Create a new or update existing option values
	 *
	 * @param bool $option_id
	 * @param array $option_values
	 *
	 * @return bool
	 */
	public function addOptionValues($option_id = FALSE, $option_values = [])
	{
		$query = FALSE;

		if ($option_id !== FALSE AND !empty($option_values) AND is_array($option_values)) {
			$queryBuilder = $this->queryBuilder();
			$queryBuilder->table('option_values')->where('option_id', $option_id)->delete();

			$priority = 1;
			foreach ($option_values as $key => $value) {
				$query = $queryBuilder->table('option_values')->insertGetId(array_merge($value, [
					'option_id' => $option_id,
					'priority'  => $priority,
				]));

				$priority++;
			}
		}

		return $query;
	}

	/**
	 * Create a new or update existing menu options
	 *
	 * @param bool $menu_id
	 * @param array $menu_options
	 *
	 * @return bool
	 */
	public function addMenuOption($menu_id = FALSE, $menu_options = [])
	{
		$query = FALSE;

		if ($menu_id !== FALSE) {
			$queryBuilder = $this->queryBuilder();

			$queryBuilder->table('menu_options')->where('menu_id', $menu_id)->delete();
			$queryBuilder->table('menu_option_values')->where('menu_id', $menu_id)->delete();

			if (!empty($menu_options)) {
				foreach ($menu_options as $option) {
					$option_values = $option['option_values'];
					$insert = [
						'menu_option_id'   => $option['menu_option_id'],
						'menu_id'          => $menu_id,
						'option_id'        => $option['option_id'],
						'required'         => $option['required'],
						'default_value_id' => empty($option['default_value_id']) ? '0' : $option['default_value_id'],
						'option_values'    => serialize($option['option_values']),
					];

					if ($menu_option_id = $queryBuilder->table('menu_options')->insertGetId($insert)) {
						$this->addMenuOptionValues($menu_option_id, $menu_id, $option['option_id'], $option_values);
					}
				}
			}
		}

		return $query;
	}

	/**
	 * Create a new or update existing menu option values
	 *
	 * @param int $menu_option_id
	 * @param int $menu_id
	 * @param int $option_id
	 * @param array $option_values
	 */
	public function addMenuOptionValues($menu_option_id = null, $menu_id = null, $option_id = null, $option_values = [])
	{
		if ($menu_option_id !== null AND $menu_id !== null AND $option_id !== null AND !empty($option_values)) {
			foreach ($option_values as $value) {
				$this->queryBuilder()->table('menu_option_values')->insertGetId([
					'menu_option_id'  => $menu_option_id,
					'menu_id'         => $menu_id,
					'option_id'       => $option_id,
					'option_value_id' => $value['option_value_id'],
					'new_price'       => $value['price'],
					'quantity'        => $value['quantity'],
					'subtract_stock'  => $value['subtract_stock'],
				]);
			}
		}
	}

	/**
	 * Delete a single or multiple option by option_id
	 *
	 * @param string|array $option_id
	 *
	 * @return int The number of deleted rows
	 */
	public function deleteOption($option_id)
	{
		if (is_numeric($option_id)) $option_id = [$option_id];

		if (!empty($option_id) AND ctype_digit(implode('', $option_id))) {
			$affected_rows = $this->whereIn('option_id', $option_id)->delete();

			if ($affected_rows > 0) {
				$queryBuilder = $this->queryBuilder();

				$queryBuilder->table('option_values')->whereIn('option_id', $option_id)->delete();

				$queryBuilder->table('menu_options')->whereIn('option_id', $option_id)->delete();

				$queryBuilder->table('menu_option_values')->whereIn('option_id', $option_id)->delete();

				return $affected_rows;
			}
		}
	}

	/**
	 * Delete a single or multiple menu option by menu_id
	 *
	 * @param string|array $menu_id
	 *
	 * @return int The number of deleted rows
	 */
	public function deleteMenuOption($menu_id)
	{
		if (is_numeric($menu_id)) $menu_id = [$menu_id];

		if (!empty($menu_id) AND ctype_digit(implode('', $menu_id))) {
			$queryBuilder = $this->queryBuilder();

			$affected_rows = $queryBuilder->table('menu_options')->whereIn('menu_id', $menu_id)->delete();

			if ($affected_rows > 0) {
				$queryBuilder->table('menu_option_values')->whereIn('menu_id', $menu_id)->delete();

				return $affected_rows;
			}
		}
	}
}

/* End of file Menu_options_model.php */
/* Location: ./system/tastyigniter/models/Menu_options_model.php */