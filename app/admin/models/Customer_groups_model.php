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

    public $casts = [
        'approval' => 'boolean',
    ];

    public $relation = [
        'hasMany' => [
            'customers' => 'Admin\Models\Customers_model',
        ],
    ];

    protected static $defaultGroup;

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

    //
    //
    //

    public function requiresApproval()
    {
        return $this->approval == 1;
    }

    public function makeDefault()
    {
        setting('customer_group_id', $this->getKey());
        setting()->save();
    }

    /**
     * Update the default group
     * @param $groupId
     */
    public static function updateDefault($groupId)
    {
        if ($model = self::find($groupId)) {
            $model->makeDefault();

            return TRUE;
        }
    }

    public static function getDefault()
    {
        if (self::$defaultGroup !== null) {
            return self::$defaultGroup;
        }

        $defaultGroup = self::where('customer_group_id', setting('customer_group_id'))->first();
        if (!$defaultGroup) {
            if ($defaultGroup = self::first()) {
                $defaultGroup->makeDefault();
            }
        }

        return self::$defaultGroup = $defaultGroup;
    }
}