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
 * Customer_groups Model Class
 *
 * @category       Models
 * @package        Igniter\Models\Customer_groups_model.php
 * @link           http://docs.tastyigniter.com
 */
class Customer_groups_model extends Model
{
	/**
	 * @var string The database table name
	 */
	protected $table = 'customer_groups';

	/**
	 * @var string The database table primary key
	 */
	protected $primaryKey = 'customer_group_id';

	/**
	 * Return all customer groups
	 *
	 * @return array
	 */
	public function getCustomerGroups()
	{
		return $this->getAsArray();
	}

	/**
	 * Find a single customer group by customer_group_id
	 *
	 * @param int $customer_group_id
	 *
	 * @return array
	 */
	public function getCustomerGroup($customer_group_id)
	{
		return $this->findOrNew($customer_group_id)->toArray();
	}

	/**
	 * Return total number of customers in group
	 *
	 * @param int $customer_group_id
	 *
	 * @return int
	 */
	public function getCustomersCount($customer_group_id)
	{
		if ($customer_group_id) {
			$this->load->model('Customers_model');
			$customerModel = $this->Customers_model->where('customer_group_id', $customer_group_id);

			return $customerModel->count();
		}
	}

	/**
	 * Create a new or update existing currency
	 *
	 * @param int $customer_group_id
	 * @param array $save
	 *
	 * @return bool|int The $customer_group_id of the affected row, or FALSE on failure
	 */
	public function saveCustomerGroup($customer_group_id, $save = [])
	{
		if (empty($save)) return FALSE;

		$customerGroupModel = $this->findOrNew($customer_group_id);

		$saved = $customerGroupModel->fill($save)->save();

		return $saved ? $customerGroupModel->getKey() : $saved;
	}

	/**
	 * Delete a single or multiple customer group by customer_group_id
	 *
	 * @param string|array $customer_group_id
	 *
	 * @return int  The number of deleted rows
	 */
	public function deleteCustomerGroup($customer_group_id)
	{
		if (is_numeric($customer_group_id)) $customer_group_id = [$customer_group_id];

		if (!empty($customer_group_id) AND ctype_digit(implode('', $customer_group_id))) {
			return $this->whereIn('customer_group_id', $customer_group_id)->delete();
		}
	}
}

/* End of file Customer_groups_model.php */
/* Location: ./system/tastyigniter/models/Customer_groups_model.php */