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
 * Customer_online Model Class
 *
 * @category       Models
 * @package        Igniter\Models\Customer_online_model.php
 * @link           http://docs.tastyigniter.com
 */
class Customer_online_model extends Model
{
	/**
	 * @var string The database table name
	 */
	protected $table = 'customers_online';

	/**
	 * @var string The database table primary key
	 */
	protected $primaryKey = 'activity_id';

	public $timestamps = TRUE;

	const CREATED_AT = 'date_added';

	public $belongsTo = [
		'customer' => ['Customers_model', 'key' => 'customer_id'],
		'country'  => ['Countries_model', 'key' => 'country_code', 'otherKey' => 'iso_code_2'],
	];

	public function getAccessTypeAttribute($value)
	{
		return ucwords($value);
	}

	public function getDateAddedAttribute($value)
	{
		return time_elapsed($value);
	}

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
		$dateAddedColumn = $this->tablePrefix('customers_online.date_added');
		$query->selectRaw('*, ' . $this->tablePrefix('customers_online.ip_address') . ', ' . $dateAddedColumn);

		$query->leftJoin('customers', 'customers.customer_id', '=', 'customers_online.customer_id');
		$query->leftJoin('countries', 'countries.iso_code_3', '=', 'customers_online.country_code');

		if (!empty($filter['filter_search'])) {
			$query->search($filter['filter_search'], ['first_name', 'last_name', 'browser', 'ip_address', 'country_code']);
		}

		if (!empty($filter['filter_access'])) {
			$query->where('access_type', $filter['filter_access']);
		}

		if (!empty($filter['time_out']) AND !empty($filter['filter_type']) AND $filter['filter_type'] === 'online') {
			$query->whereDate('customers_online.date_added', '>=', $filter['time_out']);
		}

		if (!empty($filter['filter_date'])) {
			$date = explode('-', $filter['filter_date']);
			$query->whereYear('customers_online.date_added', $date[0]);
			$query->whereMonth('customers_online.date_added', $date[1]);
		}

		return $query;
	}

	/**
	 * Return all online customers
	 *
	 * @return array
	 */
	public function getCustomersOnline()
	{
		return $this->getAsArray();
	}

	/**
	 * Find a single online customer by currency_id
	 *
	 * @param int $customer_id
	 *
	 * @return array
	 */
	public function getCustomerOnline($customer_id)
	{
		if ($customer_id) {
			$dateAddedColumn = $this->tablePrefix('customers_online.date_added');

			return $this->selectRaw('*, ' . $this->tablePrefix('customers_online.ip_address') . ', ' . $dateAddedColumn)
						->leftJoin('customers', 'customers.customer_id', '=', 'customers_online.customer_id')
						->orderBy($dateAddedColumn, 'DESC')->where('customer_id', $customer_id)->firstAsArray();
		}
	}

	/**
	 * Find when a customer was last online by ip
	 *
	 * @param string $ip the IP address of the current user
	 *
	 * @return array
	 */
	public function getLastOnline($ip)
	{
		if ($this->input->valid_ip($ip)) {
			return $this->selectRaw('*, MAX(date_added) as date_added')->where('ip_address', $ip)->firstAsArray();
		}
	}

	/**
	 * Return the last online dates of all customers
	 *
	 * @return array
	 */
	public function getOnlineDates()
	{
		return $this->pluckDates('date_added');
	}
}

/* End of file Customer_online_model.php */
/* Location: ./system/tastyigniter/models/Customer_online_model.php */