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
        return $this->customers()->count();
    }

    public function requiresApproval()
    {
        return $this->approval == 1;
    }

    /**
     * Update the default group
     * @param $groupId
     */
    public static function updateDefault($groupId)
    {
        if ($model = self::find($groupId)) {
            setting()->set('customer_group_id', $model->getKey());

            return TRUE;
        }
    }
}