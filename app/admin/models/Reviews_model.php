<?php namespace Admin\Models;

use Igniter\Flame\Auth\Models\User;
use Model;
use System\Models\Settings_model;

/**
 * Reviews Model Class
 *
 * @package Admin
 */
class Reviews_model extends Model
{
    /**
     * @var string The database table name
     */
    protected $table = 'reviews';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'review_id';

    /**
     * @var array The model table column to convert to dates on insert/update
     */
    public $timestamps = TRUE;

    const CREATED_AT = 'date_added';

    public $relation = [
        'belongsTo' => [
            'location' => ['Admin\Models\Locations_model', 'foreignKey' => 'location_id', 'scope' => 'isEnabled'],
            'customer' => 'Admin\Models\Customers_model',
        ],
        'morphTo'   => [
            'review' => [],
        ],
    ];

    public static $allowedSortingColumns = ['date_added asc', 'date_added desc'];

    public static $relatedSaleTypes = [
        'order'       => 'Admin\Models\Orders_model',
        'reservation' => 'Admin\Models\Reservations_model',
    ];

    public static function getSaleTypeOptions()
    {
        return [
            'order'       => 'lang:admin::reviews.text_order',
            'reservation' => 'lang:admin::reviews.text_reservation',
        ];
    }

    public function getRatingOptions()
    {
        $result = Settings_model::where('sort', 'ratings')->first();

        return array_get($result->value, 'ratings', []);
    }

    //
    // Scopes
    //

    public function scopeListFrontEnd($query, $options = [])
    {
        extract(array_merge([
            'page'      => 1,
            'pageLimit' => 20,
            'sort'      => null,
            'location'  => null,
            'customer'  => null,
        ], $options));

        if (is_numeric($location)) {
            $query->where('location_id', $location);
        }

        if ($customer instanceof User) {
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

    public function scopeIsApproved($query)
    {
        return $query->where('review_status', 1);
    }

    public function scopeHasBeenReviewed($query, $sale, $customerId)
    {
        return $query->where('sale_type', get_class($sale))
                     ->where('sale_id', $sale->getKey())
                     ->where('customer_id', $customerId);
    }

    //
    // Accessors & Mutators
    //

    public function getSaleTypeAttribute($value)
    {
        $types = array_flip(self::$relatedSaleTypes);

        return (isset($types[$value]) AND $types[$value] != 'order')
            ? $types[$value] : 'order';
    }

    public function setSaleTypeAttribute($value)
    {
        $this->attributes['sale_type'] = self::$relatedSaleTypes[$value];
    }

    /**
     * Return the dates of all reviews
     *
     * @return array
     */
    public function getReviewDates()
    {
        return $this->pluckDates('date_added');
    }
}