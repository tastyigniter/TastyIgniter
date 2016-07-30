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
 * Addresses Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Addresses_model.php
 * @link           http://docs.tastyigniter.com
 */
class Addresses_model extends TI_Model
{
	/**
	 * @var string The database table name
	 */
	protected $table_name = 'addresses';

	/**
	 * @var string The database table primary key
	 */
	protected $primary_key = 'address_id';

	protected $belongs_to = array(
		'countries' => 'Countries_model',
	);

	/**
	 * Count the number of records
	 *
	 * @param array $filter
	 *
	 * @return int
	 */
	public function getCount($filter = array()) {
		if (!empty($filter['customer_id']) AND is_numeric($filter['customer_id'])) {
			return $this->filter($filter)->with('countries')->count();
		}
	}

	/**
	 * List all addresses matching the filter
	 *
	 * @param array $filter
	 *
	 * @return array
	 */
	public function getList($filter = array()) {
		$result = array();

		if (!empty($filter['customer_id']) AND is_numeric($filter['customer_id'])) {
			foreach ($this->filter($filter)->with('countries')->find_all('customer_id', $filter['customer_id']) as $row) {
				$result[$row['address_id']] = $row;
			}
		}

		return $result;
	}

	/**
	 * Filter database records
	 *
	 * @param array $filter an associative array of field/value pairs
	 *
	 * @return $this
	 */
	public function filter($filter = array()) {
		if (isset($filter['customer_id']) AND is_numeric($filter['customer_id'])) {
			$this->where('customer_id', $filter['customer_id']);
		}

		return $this;
	}

	/**
	 * Return all customer addresses by customer_id
	 *
	 * @param int $customer_id
	 *
	 * @return array
	 */
	public function getAddresses($customer_id) {
		$result = array();

		if (!empty($customer_id) AND is_numeric($customer_id)) {
			foreach ($this->with('countries')->find_all('customer_id', $customer_id) as $row) {
				$result[$row['address_id']] = $row;
			}
		}

		return $result;
	}

	/**
	 * Find a single customer address by customer_id
	 *
	 * @param int $customer_id
	 * @param int $address_id
	 *
	 * @return array
	 */
	public function getAddress($customer_id, $address_id) {
		if (!empty($address_id) AND is_numeric($address_id)) {
			if (!empty($customer_id) AND is_numeric($customer_id)) {
				$this->where('customer_id', $customer_id);
			}

			return $this->with('countries')->find($address_id);
		}
	}

	/**
	 * Find a single guest address by address_id
	 *
	 * @param int $address_id
	 *
	 * @return array
	 */
	public function getGuestAddress($address_id) {
		$this->where('address_id', $address_id);

		return $this->with('countries')->find();
	}

	/**
	 * Find a customer default address
	 *
	 * @param int $address_id
	 * @param int $customer_id
	 *
	 * @return array
	 */
	public function getDefault($address_id, $customer_id) {
		if (($address_id !== '0') AND ($customer_id !== '0')) {
			return $this->getAddress($customer_id, $address_id);
		}
	}

	/**
	 * Update a customer default address
	 *
	 * @param int $customer_id
	 * @param int $address_id
	 *
	 * @return bool
	 */
	public function updateDefault($customer_id = NULL, $address_id = NULL) {
		$query = FALSE;

		if ($address_id !== NULL AND $customer_id !== NULL) {
			$this->load->model('Customers_model');
			$query = $this->Customers_model->update($customer_id, array('address_id' => $address_id));
		}

		return $query;
	}

	/**
	 * Create a new or update existing customer address
	 *
	 * @param int   $customer_id
	 * @param int   $address_id
	 * @param array $address an array of key/value pairs
	 *
	 * @return bool|int The $address_id of the affected row, or FALSE on failure
	 */
	public function saveAddress($customer_id = NULL, $address_id = NULL, $address = array()) {
		if (is_array($address_id)) $address = $address_id;

		if (empty($address['address_1'])) return FALSE;

		return $this->skip_validation(TRUE)->save(array_merge($address, array(
			'customer_id' => $customer_id,
			'country_id'  => isset($address['country']) ? $address['country'] : $address['country_id'],
		)), $address_id);
	}

	/**
	 * Delete a single customer address by customer_id and address_id
	 *
	 * @param int $customer_id
	 * @param int $address_id
	 *
	 * @return int The number of deleted rows
	 */
	public function deleteAddress($customer_id, $address_id) {
		return $this->delete(array('customer_id' => $customer_id, 'address_id' => $address_id));
	}
}

/* End of file Addresses_model.php */
/* Location: ./system/tastyigniter/models/Addresses_model.php */