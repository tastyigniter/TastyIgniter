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
 * Addresses Model Class
 *
 * @category       Models
 * @package        Igniter\Models\Addresses_model.php
 * @link           http://docs.tastyigniter.com
 */
class Addresses_model extends Model
{
	/**
	 * @var string The database table name
	 */
	protected $table = 'addresses';

	/**
	 * @var string The database table primary key
	 */
	protected $primaryKey = 'address_id';

	protected $fillable = ['address_id', 'customer_id', 'address_1', 'address_2', 'city', 'state', 'postcode', 'country_id'];

	public $belongsTo = [
		'country' => 'Countries_model',
	];

	public function scopeJoinCountryTable($query)
	{
		return $query->join('countries', 'countries.country_id', '=', 'addresses.country_id', 'left');
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
		if (isset($filter['customer_id']) AND is_numeric($filter['customer_id'])) {
			$query->where('customer_id', $filter['customer_id']);
		}

		return $query;
	}

	/**
	 * Return all customer addresses by customer_id
	 *
	 * @param int $customer_id
	 *
	 * @return array
	 */
	public function getAddresses($customer_id)
	{
		$result = [];

		if (!empty($customer_id) AND is_numeric($customer_id)) {

			$addresses = self::joinCountryTable()->where('customer_id', $customer_id)->getAsArray();
			foreach ($addresses as $row) {
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
	public function getAddress($customer_id, $address_id)
	{
		if (!empty($address_id) AND is_numeric($address_id)) {
			$query = $this->joinCountryTable();
			if (!empty($customer_id) AND is_numeric($customer_id)) {
				$query->where('customer_id', $customer_id);
			}

			return $query->findOrNew($address_id)->toArray();
		}
	}

	/**
	 * Find a single guest address by address_id
	 *
	 * @param int $address_id
	 *
	 * @return array
	 */
	public function getGuestAddress($address_id)
	{
		$queryBuilder = $this->where('address_id', $address_id);

		return $queryBuilder->joinCountryTable()->findOrNew()->toArray();
	}

	/**
	 * Find a customer default address
	 *
	 * @param int $address_id
	 * @param int $customer_id
	 *
	 * @return array
	 */
	public function getDefault($address_id, $customer_id)
	{
		if ($address_id AND $customer_id) {
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
	public function updateDefault($customer_id = null, $address_id = null)
	{
		$query = FALSE;

		if ($address_id !== null AND $customer_id !== null) {
			$this->load->model('Customers_model');
			$query = $this->Customers_model->findOrNew($customer_id)->update(['address_id' => $address_id]);
		}

		return $query;
	}

	/**
	 * Create a new or update existing customer address
	 *
	 * @param int $customer_id
	 * @param int $address_id
	 * @param array $address an array of key/value pairs
	 *
	 * @return bool|int The $address_id of the affected row, or FALSE on failure
	 */
	public function saveAddress($customer_id = null, $address_id = null, $address = [])
	{
		if (is_array($address_id)) {
			$address = $address_id;
			$address_id = isset($address['address_id']) ? $address['address_id'] : null;
		}

		if (empty($address['address_1'])) return FALSE;

		$addressModel = $this->findOrNew($address_id);

		$saved = $addressModel->fill(array_merge($address, [
			'customer_id' => $customer_id,
			'country_id'  => isset($address['country']) ? $address['country'] : $address['country_id'],
		]))->save();

		return $saved ? $addressModel->getKey() : $saved;
	}

	/**
	 * Delete a single customer address by customer_id and address_id
	 *
	 * @param int $customer_id
	 * @param int $address_id
	 *
	 * @return int The number of deleted rows
	 */
	public function deleteAddress($customer_id, $address_id)
	{
		return $this->where([
			['customer_id', '=', $customer_id],
			['address_id', '=', $address_id],
		])->delete();
	}
}

/* End of file Addresses_model.php */
/* Location: ./system/tastyigniter/models/Addresses_model.php */