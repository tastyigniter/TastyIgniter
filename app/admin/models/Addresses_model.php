<?php namespace Admin\Models;

use Model;

/**
 * Addresses Model Class
 *
 * @package Admin
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

    protected $fillable = ['address_1', 'address_2', 'city', 'state', 'postcode', 'country_id'];

    public $relation = [
        'belongsTo' => [
            'customer' => 'Admin\Models\Customers_model',
            'country'  => 'System\Models\Countries_model',
        ],
    ];

    public static $allowedSortingColumns = [
        'address_id asc', 'address_id desc',
    ];

    public static function createOrUpdateFromPost($address)
    {
        return self::updateOrCreate(
            array_only($address, ['customer_id', 'address_id']),
            $address
        );
    }

    //
    // Scopes
    //

    public function scopeListFrontEnd($query, $options = [])
    {
        extract(array_merge([
            'page'      => 1,
            'pageLimit' => 20,
            'customer'  => null,
            'location'  => null,
            'sort'      => 'address_id desc',
        ], $options));

        if ($customer instanceof Customers_model) {
            $query->where('customer_id', $customer->getKey());
        }
        else if (strlen($customer)) {
            $query->where('customer_id', $customer);
        }

        if (!is_array($sort)) {
            $sort = [$sort];
        }

        foreach ($sort as $_sort) {
            if (in_array($_sort, self::$allowedSortingColumns)) {
                $parts = explode(' ', $_sort);
                if (count($parts) < 2) {
                    array_push($parts, 'desc');
                }
                list($sortField, $sortDirection) = $parts;
                $query->orderBy($sortField, $sortDirection);
            }
        }

        return $query->paginate($pageLimit, $page);
    }

    public function scopeJoinCountry($query)
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
}