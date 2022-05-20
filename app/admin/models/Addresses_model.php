<?php

namespace Admin\Models;

use Igniter\Flame\Database\Model;

/**
 * Addresses Model Class
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

    protected $fillable = ['customer_id', 'address_1', 'address_2', 'city', 'state', 'postcode', 'country_id'];

    public $relation = [
        'belongsTo' => [
            'customer' => 'Admin\Models\Customers_model',
            'country' => 'System\Models\Countries_model',
        ],
    ];

    protected $casts = [
        'customer_id' => 'integer',
        'country_id' => 'integer',
    ];

    public static $allowedSortingColumns = [
        'address_id asc', 'address_id desc',
    ];

    public static function createOrUpdateFromRequest($address)
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
            'page' => 1,
            'pageLimit' => 20,
            'customer' => null,
            'sort' => 'address_id desc',
        ], $options));

        if ($customer instanceof Customers_model) {
            $query->where('customer_id', $customer->getKey());
        }
        elseif (strlen($customer)) {
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
                [$sortField, $sortDirection] = $parts;
                $query->orderBy($sortField, $sortDirection);
            }
        }

        $this->fireEvent('model.extendListFrontEndQuery', [$query]);

        return $query->paginate($pageLimit, $page);
    }

    //
    // Accessors & Mutators
    //

    public function getFormattedAddressAttribute($value)
    {
        return format_address($this->toArray(), false);
    }
}
