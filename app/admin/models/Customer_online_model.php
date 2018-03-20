<?php namespace Admin\Models;

use Model;

/**
 * Customer_online Model Class
 *
 * @package Admin
 */
class Customer_online_model extends Model
{
    const CREATED_AT = 'date_added';

    /**
     * @var string The database table name
     */
    protected $table = 'customers_online';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'activity_id';

    public $timestamps = TRUE;

    public $relation = [
        'belongsTo' => [
            'customer' => ['Admin\Models\Customers_model', 'foreignKey' => 'customer_id'],
            'country'  => ['System\Models\Countries_model', 'foreignKey' => 'country_code', 'otherKey' => 'iso_code_2'],
        ],
    ];

    //
    // Accessors & Mutators
    //

    public function getAccessTypeAttribute($value)
    {
        return ucwords($value);
    }

    public function getDateAddedAttribute($value)
    {
        return time_elapsed($value);
    }

    //
    // Scopes
    //

    public function scopeIsOnline($query, $value)
    {
        if ($value) {
            $online_time_out = (setting('customer_online_time_out') > 120) ? setting('customer_online_time_out') : 120;
            $query->where('date_added', '>=', mdate('%Y-%m-%d %H:%i:%s', time() - $online_time_out));
        }

        return $query;
    }

    //
    // Helpers
    //

    /**
     * Find when a customer was last online by ip
     *
     * @param string $ip the IP address of the current user
     *
     * @return array
     */
    public function getLastOnline($ip)
    {
//        if ($this->input->valid_ip($ip)) {
        return $this->selectRaw('*, MAX(date_added) as date_added')->where('ip_address', $ip)->first();
//        }
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