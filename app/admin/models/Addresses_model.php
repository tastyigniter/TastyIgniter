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

    //
    // Helpers
    //

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

        $addresses = self::joinCountry()->where('customer_id', $customer_id)->get();
        foreach ($addresses as $row) {
            $result[$row['address_id']] = $row;
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
        $query = $this->joinCountry();
        $query->where('customer_id', $customer_id);

        return $query->find($address_id);
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
        $query = $this->joinCountry()->where('address_id', $address_id);

        return $query->first();
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
        return $this->getAddress($customer_id, $address_id);
    }

    /**
     * Update a customer default address
     *
     * @param int $customer_id
     * @param int $address_id
     *
     * @return bool
     */
    public static function updateDefault($customer_id, $address_id = null)
    {
        return self::customer()->find($customer_id)->update(['address_id' => $address_id]);
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

        if (!isset($address['address_1'])) return FALSE;

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
            ['customer_id', $customer_id],
            ['address_id', $address_id],
        ])->delete();
    }
}