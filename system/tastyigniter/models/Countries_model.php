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
 * Countries Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Countries_model.php
 * @link           http://docs.tastyigniter.com
 */
class Countries_model extends TI_Model
{
	/**
	 * @var string The database table name
	 */
	protected $table_name = 'countries';

	/**
	 * @var string The database table primary key
	 */
	protected $primary_key = 'country_id';

	protected $has_one = array(
		'currency' => 'Currencies_model',
	);

	/**
	 * Count the number of records
	 *
	 * @param array $filter
	 *
	 * @return int
	 */
	public function getCount($filter = array()) {
		return $this->filter($filter)->count();
	}

	/**
	 * List all countries matching the filter
	 *
	 * @param array $filter
	 *
	 * @return array
	 */
	public function getList($filter = array()) {
		return $this->filter($filter)->find_all();
	}

	/**
	 * Filter database records
	 *
	 * @param array $filter an associative array of field/value pairs
	 *
	 * @return $this
	 */
	public function filter($filter = array()) {
		if (!empty($filter['filter_search'])) {
			$this->like('country_name', $filter['filter_search']);
		}

		if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
			$this->where('status', $filter['filter_status']);
		}

		return $this;
	}

	/**
	 * Return all countries from the database
	 *
	 * @return array
	 */
	public function getCountries() {
		return $this->order_by('country_name')->find_all();
	}

	/**
	 * Find a single country by country_id
	 *
	 * @param int $country_id
	 *
	 * @return array
	 */
	public function getCountry($country_id) {
		return $this->find($country_id);
	}

	/**
	 * Create a new or update existing country
	 *
	 * @param int   $country_id
	 * @param array $save
	 *
	 * @return bool|int The $country_id of the affected row, or FALSE on failure
	 */
	public function saveCountry($country_id, $save = array()) {
		if (empty($save)) return FALSE;

		return $this->skip_validation(TRUE)->save($save, $country_id);
	}

	/**
	 * Delete a single or multiple country by country_id
	 *
	 * @param string|array $country_id
	 *
	 * @return int The number of deleted rows
	 */
	public function deleteCountry($country_id) {
		if (is_numeric($country_id)) $country_id = array($country_id);

		if (!empty($country_id) AND ctype_digit(implode('', $country_id))) {
			return $this->delete('country_id', $country_id);
		}
	}
}

/* End of file Countries_model.php */
/* Location: ./system/tastyigniter/models/Countries_model.php */