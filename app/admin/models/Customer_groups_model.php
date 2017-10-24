<?php namespace Admin\Models;

use Model;

/**
 * CustomerGroups Model Class
 *
 * @package Admin
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

	protected $fillable = ['group_name', 'approval'];

    public $relation = [
        'hasMany' => [
            'customers' => 'Admin\Models\Customers_model',
        ],
    ];

    public static function getDropdownOptions()
    {
        return static::dropdown('group_name');
	}

    //
    // Accessors & Mutators
    //

    public function getCustomerCountAttribute($value)
    {
        return $this->getCustomersCount($this->customer_group_id);
    }

    //
    // Helpers
    //

    /**
	 * Return all customer groups
	 *
	 * @return array
	 */
	public function getCustomerGroups()
	{
		return $this->get();
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
		return $this->find($customer_group_id);
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
			return $this->customers()->count();
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