<?php

namespace Admin\Models;

use Admin\Traits\Locationable;
use Igniter\Flame\Auth\Models\User;
use Igniter\Flame\Database\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Reviews Model Class
 * @deprecated remove before v4. Added for backward compatibility, see Igniter\Local\Models\Reviews_model
 */
class Reviews_model extends Model
{
    use Locationable;

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
    public $timestamps = true;

    protected $guarded = [];

    protected $casts = [
        'customer_id' => 'integer',
        'sale_id' => 'integer',
        'location_id' => 'integer',
        'quality' => 'integer',
        'service' => 'integer',
        'delivery' => 'integer',
        'review_status' => 'boolean',
    ];

    public $relation = [
        'belongsTo' => [
            'location' => ['Admin\Models\Locations_model', 'scope' => 'isEnabled'],
            'customer' => 'Admin\Models\Customers_model',
        ],
        'morphTo' => [
            'reviewable' => ['name' => 'sale'],
        ],
    ];

    public static $allowedSortingColumns = ['created_at asc', 'created_at desc'];

    public static $relatedSaleTypes = [
        'orders' => 'Admin\Models\Orders_model',
        'reservations' => 'Admin\Models\Reservations_model',
    ];

    public static function getSaleTypeOptions()
    {
        return [
            'orders' => 'lang:admin::lang.reviews.text_order',
            'reservations' => 'lang:admin::lang.reviews.text_reservation',
        ];
    }

    public static function findBy($saleType, $saleId)
    {
        $saleTypeModel = (new static)->getSaleTypeModel($saleType);

        return $saleTypeModel->find($saleId);
    }

    public function getRatingOptions()
    {
        return array_get(setting('ratings'), 'ratings', []);
    }

    //
    // Scopes
    //

    public function scopeListFrontEnd($query, $options = [])
    {
        extract(array_merge([
            'page' => 1,
            'pageLimit' => 20,
            'sort' => null,
            'location' => null,
            'customer' => null,
        ], $options));

        if (is_numeric($location)) {
            $query->where('location_id', $location);
        }

        if ($customer instanceof User) {
            $query->where('customer_id', $customer->getKey());
        }
        elseif (strlen($customer)) {
            $query->where('customer_id', $customer);
        }
        else {
            $query->has('customer');
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

    public function scopeIsApproved($query)
    {
        return $query->where('review_status', 1);
    }

    public function scopeHasBeenReviewed($query, $sale, $customerId)
    {
        return $query->where('sale_type', $sale->getMorphClass())
            ->where('sale_id', $sale->getKey())
            ->where('customer_id', $customerId);
    }

    public function scopeWhereReviewable($query, $causer)
    {
        return $query
            ->where('sale_type', $causer->getMorphClass())
            ->where('sale_id', $causer->getKey());
    }

    //
    // Helpers
    //

    public function getSaleTypeModel($saleType)
    {
        $model = self::$relatedSaleTypes[$saleType] ?? null;
        if (!$model || !class_exists($model))
            throw new ModelNotFoundException;

        return new $model();
    }

    /**
     * Return the dates of all reviews
     *
     * @return array
     */
    public function getReviewDates()
    {
        return $this->pluckDates('created_at');
    }

    public static function checkReviewed(Model $object, Model $customer)
    {
        $query = self::whereReviewable($object)
            ->where('customer_id', $customer->getKey());

        return $query->exists();
    }
}
