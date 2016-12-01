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
 * Tables Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Tables_model.php
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

		$saved = $tableModel->fill($save)->save();

		return $saved ? $tableModel->getKey() : $saved;
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
			return $this->whereIn('table_id', $table_id)->delete();
		}
	}
}

/* End of file Tables_model.php */
/* Location: ./system/tastyigniter/models/Tables_model.php */