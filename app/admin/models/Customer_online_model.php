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
        $dateAddedColumn = DB::getTablePrefix().'customers_online.date_added';
        $query->selectRaw('*, '.DB::getTablePrefix().'customers_online.ip_address, '.$dateAddedColumn);

        $query->leftJoin('customers', 'customers.customer_id', '=', 'customers_online.customer_id');
        $query->leftJoin('countries', 'countries.iso_code_3', '=', 'customers_online.country_code');

        if (isset($filter['filter_search']) AND is_string($filter['filter_search'])) {
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

    //
    // Helpers
    //

    /**
     * Return all online customers
     *
     * @return array
     */
    public function getCustomersOnline()
    {
        return $this->get();
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
            $dateAddedColumn = DB::getTablePrefix().'customers_online.date_added';

            return $this->selectRaw('*, '.DB::getTablePrefix().'customers_online.ip_address, '.$dateAddedColumn)
                        ->leftJoin('customers', 'customers.customer_id', '=', 'customers_online.customer_id')
                        ->orderBy($dateAddedColumn, 'DESC')->where('customer_id', $customer_id)->first();
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
            return $this->selectRaw('*, MAX(date_added) as date_added')->where('ip_address', $ip)->first();
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