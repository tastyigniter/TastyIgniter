<?php namespace Admin\Models;

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
            $query->whereHas('location', function ($q) use ($location) {
                $q->where('location_id', $location);
            });
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

    public function scopeJoinLocationsTable($query)
    {
        return $query->join('locations', 'locations.location_id', '=', 'reviews.location_id', 'left');
    }

    public function scopeIsApproved($query)
    {
        return $query->where('review_status', 1);
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
        $query->joinLocationsTable();

        if (isset($filter['filter_search']) AND is_string($filter['filter_search'])) {
            $query->search($filter['filter_search'], ['author', 'location_name', 'order_id']);
        }

        if (!empty($filter['filter_location'])) {
            $query->where('reviews.location_id', $filter['filter_location']);
        }

        if (!empty($filter['customer_id'])) {
            $query->where('customer_id', $filter['customer_id']);
        }

        if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
            $query->where('review_status', $filter['filter_status']);
        }

        if (!empty($filter['filter_date'])) {
            $date = explode('-', $filter['filter_date']);
            $query->whereYear('date_added', $date[0]);
            $query->whereMonth('date_added', $date[1]);
        }

        return $query;
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