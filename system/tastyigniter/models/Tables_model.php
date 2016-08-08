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
 * Tables Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Tables_model.php
 * @link           http://docs.tastyigniter.com
 */
class Tables_model extends TI_Model
{
	/**
	 * @var string The database table name
	 */
	protected $table_name = 'tables';

	/**
	 * @var string The database table primary key
	 */
	protected $primary_key = 'table_id';

	/**
	 * Filter database records
	 *
	 * @param array $filter an associative array of field/value pairs
	 *
	 * @return $this
	 */
	public function filter($filter = array()) {
		if (!empty($filter['filter_search'])) {
			$this->like('table_name', $filter['filter_search']);
		}

		if (is_numeric($filter['filter_status'])) {
			$this->where('table_status', $filter['filter_status']);
		}

		return $this;
	}

	/**
	 * Return all tables
	 *
	 * @return array
	 */
	public function getTables() {
		return $this->find_all();
	}

	/**
	 * Find a single table by table_id
	 *
	 * @param int $table_id
	 *
	 * @return array
	 */
	public function getTable($table_id) {
		return $this->find($table_id);
	}

	/**
	 * Return all tables by location
	 *
	 * @param int $location_id
	 *
	 * @return array
	 */
	public function getTablesByLocation($location_id = NULL) {
		$location_tables = array();
		$this->load->model('Location_tables_model');
		$this->Location_tables_model->where('location_id', $location_id);
		foreach ($this->Location_tables_model->find_all() as $row) {
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
	public function getAutoComplete($filter = array()) {
		if (is_array($filter) && !empty($filter)) {

			$this->where('table_status >', '0');

			if (!empty($filter['table_name'])) {
				$this->like('table_name', $filter['table_name']);
			}

			return $this->find_all();
		}
	}

	/**
	 * Create a new or update existing table
	 *
	 * @param int   $table_id
	 * @param array $save
	 *
	 * @return bool|int The $table_id of the affected row, or FALSE on failure
	 */
	public function saveTable($table_id, $save = array()) {
		if (empty($save)) return FALSE;

		return $this->skip_validation(TRUE)->save($save, $table_id);
	}

	/**
	 * Delete a single or multiple table by table_id
	 *
	 * @param string|array $table_id
	 *
	 * @return int  The number of deleted rows
	 */
	public function deleteTable($table_id) {
		if (is_numeric($table_id)) $table_id = array($table_id);

		if (!empty($table_id) AND ctype_digit(implode('', $table_id))) {
			return $this->delete('table_id', $table_id);
		}
	}
}

/* End of file Tables_model.php */
/* Location: ./system/tastyigniter/models/Tables_model.php */