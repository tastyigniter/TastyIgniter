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
 * Tables Model Class
 *
 * @category       Models
 * @package        Igniter\Models\Tables_model.php
 * @link           http://docs.tastyigniter.com
 */
class Tables_model extends Model
{
	/**
	 * @var string The database table name
	 */
	protected $table = 'tables';

	/**
	 * @var string The database table primary key
	 */
	protected $primaryKey = 'table_id';

	public $fillable = ['table_id', 'table_name', 'min_capacity', 'max_capacity', 'max_capacity'];

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
		if (!empty($filter['filter_search'])) {
			$query->search($filter['filter_search'], ['table_name']);
		}

		if (is_numeric($filter['filter_status'])) {
			$query->where('table_status', $filter['filter_status']);
		}

		return $query;
	}

	/**
	 * Return all tables
	 *
	 * @return array
	 */
	public function getTables()
	{
		return $this->getAsArray();
	}

	/**
	 * Find a single table by table_id
	 *
	 * @param int $table_id
	 *
	 * @return array
	 */
	public function getTableById($table_id)
	{
		return $this->findOrNew($table_id)->toArray();
	}

	/**
	 * Return all tables by location
	 *
	 * @param int $location_id
	 *
	 * @return array
	 */
	public function getTablesByLocation($location_id = null)
	{
		$location_tables = [];
		$this->load->model('Location_tables_model');
		$tables = $this->Location_tables_model->where('location_id', $location_id)->getAsArray();
		foreach ($tables as $row) {
			$location_tables[] = $row['table_id'];
		}

		return $location_tables;
	}

	/**
	 * List all tables matching the filter,
	 * to fill select auto-complete options
	 *
	 * @param array $filter
	 *
	 * @return array
	 */
	public function getAutoComplete($filter = [])
	{
		if (is_array($filter) && !empty($filter)) {

			$queryBuilder = $this->where('table_status', '>', '0');

			if (!empty($filter['table_name'])) {
				$queryBuilder->like('table_name', $filter['table_name']);
			}

			return $queryBuilder->getAsArray();
		}
	}

	/**
	 * Create a new or update existing table
	 *
	 * @param int $table_id
	 * @param array $save
	 *
	 * @return bool|int The $table_id of the affected row, or FALSE on failure
	 */
	public function saveTable($table_id, $save = [])
	{
		if (empty($save)) return FALSE;

		$tableModel = $this->findOrNew($table_id);

		if ($saved = $tableModel->fill($save)->save()) {
			$table_id = $tableModel->getKey();
			$this->addTableLocations($table_id, isset($save['locations']) ? $save['locations'] : []);

			return $table_id;
		}
	}

	/**
	 * Create a new or update existing table locations
	 *
	 * @param int $menu_id
	 * @param array $locations
	 *
	 * @return bool
	 */
	public function addTableLocations($table_id, $locations = [])
	{
		if (is_single_location())
			return TRUE;

		$this->load->model('Location_tables_model');
		$affected_rows = $this->Location_tables_model->where('table_id', $table_id)->delete();

		if (is_array($locations) && !empty($locations)) {
			foreach ($locations as $key => $location_id) {
				$this->Location_tables_model->firstOrCreate([
					'table_id'    => $table_id,
					'location_id' => $location_id,
				]);
			}
		}

		if (!empty($locations) AND $affected_rows > 0) {
			return TRUE;
		}
	}

	/**
	 * Delete a single or multiple table by table_id
	 *
	 * @param string|array $table_id
	 *
	 * @return int  The number of deleted rows
	 */
	public function deleteTable($table_id)
	{
		if (is_numeric($table_id)) $table_id = [$table_id];

		if (!empty($table_id) AND ctype_digit(implode('', $table_id))) {
			$affected_rows = $this->whereIn('table_id', $table_id)->delete();

			if ($affected_rows > 0) {
				$this->load->model('Location_tables_model');
				$this->Location_tables_model->whereIn('table_id', $table_id)->delete();
			}
		}
	}
}

/* End of file Tables_model.php */
/* Location: ./system/tastyigniter/models/Tables_model.php */
