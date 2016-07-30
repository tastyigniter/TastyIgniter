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
 * Customer_online Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Customer_online_model.php
 * @link           http://docs.tastyigniter.com
 */
class Customer_online_model extends TI_Model
{
	/**
	 * @var string The database table name
	 */
	protected $table_name = 'customers_online';

	/**
	 * @var string The database table primary key
	 */
	protected $primary_key = 'activity_id';

	/**
	 * @var array The model table column to convert to dates on insert/update
	 */
	protected $timestamps = array('created');

	protected $belongs_to = array(
		'customers' => array('Customers_model', 'customer_id'),
		'countries' => array('Countries_model', 'country_code', 'iso_code_2'),
	);

	/**
	 * Count the number of records
	 *
	 * @param array $filter
	 *
	 * @return int
	 */

	public function getCount($filter = array()) {
		return $this->filter($filter)->with('customers', 'countries')->count();
	}

	/**
	 * List all online and recently online customers
	 *
	 * @param array $filter
	 *
	 * @return array
	 */
	public function getList($filter = array()) {
		$this->select('*, customers_online.ip_address, customers_online.date_added, customers.first_name, customers.last_name');

		return $this->filter($filter)->with('customers', 'countries')->find_all();
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
			$this->like('first_name', $filter['filter_search']);
			$this->or_like('last_name', $filter['filter_search']);
			$this->or_like('browser', $filter['filter_search']);
			$this->or_like('customers_online.ip_address', $filter['filter_search']);
			$this->or_like('country_code', $filter['filter_search']);
		}

		if (!empty($filter['filter_access'])) {
			$this->where('access_type', $filter['filter_access']);
		}

		if (!empty($filter['filter_type']) AND $filter['filter_type'] === 'online') {
			$this->where('customers_online.date_added >=', $filter['time_out']);
		}

		if (!empty($filter['filter_date'])) {
			$date = explode('-', $filter['filter_date']);
			$this->where('YEAR(' . $this->table_prefix('customers_online.date_added') . ')', $date[0]);
			$this->where('MONTH(' . $this->table_prefix('customers_online.date_added') . ')', $date[1]);
		}

		return $this;
	}

	/**
	 * Return all online customers
	 *
	 * @return array
	 */
	public function getCustomersOnline() {
		return $this->find_all();
	}

	/**
	 * Find a single online customer by currency_id
	 *
	 * @param int $customer_id
	 *
	 * @return array
	 */
	public function getCustomerOnline($customer_id) {
		$result = array();

		if ($customer_id) {
			$this->select('*, customers_online.ip_address, customers_online.date_added');

			$result = $this->with('customers')->order_by('customers_online.date_added', 'DESC')->find($customer_id);
		}

		return $result;
	}

	/**
	 * Find when a customer was last online by ip
	 *
	 * @param string $ip the IP address of the current user
	 *
	 * @return array
	 */
	public function getLastOnline($ip) {
		if ($this->input->valid_ip($ip)) {
			$this->select('*')->select_max('date_added');

			return $this->find('ip_address', $ip);
		}
	}

	/**
	 * Return the last online dates of all customers
	 *
	 * @return array
	 */
	public function getOnlineDates() {
		$this->select('date_added, MONTH(date_added) as month, YEAR(date_added) as year');
		$this->group_by('MONTH(date_added)');
		$this->group_by('YEAR(date_added)');

		return $this->find_all();
	}
}

/* End of file Customer_online_model.php */
/* Location: ./system/tastyigniter/models/Customer_online_model.php */