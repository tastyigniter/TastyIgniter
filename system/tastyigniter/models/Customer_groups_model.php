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
 * Customer_groups Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Customer_groups_model.php
 * @link           http://docs.tastyigniter.com
 */
class Customer_groups_model extends TI_Model
{
	/**
	 * @var string The database table name
	 */
	protected $table_name = 'customer_groups';

	/**
	 * @var string The database table primary key
	 */
	protected $primary_key = 'customer_group_id';

	/**
	 * Return all customer groups
	 *
	 * @return array
	 */
	public function getCustomerGroups() {
		return $this->find_all();
	}

	/**
	 * Find a single customer group by customer_group_id
	 *
	 * @param int $customer_group_id
	 *
	 * @return array
	 */
	public function getCustomerGroup($customer_group_id) {
		return $this->find($customer_group_id);
	}

	/**
	 * Return total number of customers in group
	 *
	 * @param int $customer_group_id
	 *
	 * @return int
	 */
	public function getCustomersCount($customer_group_id) {
		if ($customer_group_id) {
			$this->load->model('Customers_model');
			$this->Customers_model->where('customer_group_id', $customer_group_id);

			return $this->Customers_model->count();
		}
	}

	/**
	 * Create a new or update existing currency
	 *
	 * @param int   $customer_group_id
	 * @param array $save
	 *
	 * @return bool|int The $customer_group_id of the affected row, or FALSE on failure
	 */
	public function saveCustomerGroup($customer_group_id, $save = array()) {
		if (empty($save)) return FALSE;

		return $this->skip_validation(TRUE)->save($save, $customer_group_id);
	}

	/**
	 * Delete a single or multiple customer group by customer_group_id
	 *
	 * @param string|array $customer_group_id
	 *
	 * @return int  The number of deleted rows
	 */
	public function deleteCustomerGroup($customer_group_id) {
		if (is_numeric($customer_group_id)) $customer_group_id = array($customer_group_id);

		if (!empty($customer_group_id) AND ctype_digit(implode('', $customer_group_id))) {
			return $this->delete('customer_group_id', $customer_group_id);
		}
	}
}

/* End of file Customer_groups_model.php */
/* Location: ./system/tastyigniter/models/Customer_groups_model.php */