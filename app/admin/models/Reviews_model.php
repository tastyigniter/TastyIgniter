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

    //
    // Helpers
    //

    /**
     * Return all reviews by customer_id
     *
     * @param int $customer_id
     *
     * @return array
     */
    public function getReviews($customer_id = null)
    {
        if ($customer_id !== null) {
            return $this->joinLocationsTable()->where('review_status', '1')
                        ->where('customer_id', $customer_id)->get();
        }
    }

    /**
     * Return all reviews grouped by location_id
     *
     * @param int $location_id
     *
     * @return array
     */
    public function getTotalsbyId($location_id = null)
    {
        $query = $this->selectRaw('location_id, COUNT(location_id) as review_total')
                      ->groupBy('location_id')->orderBy('review_total')->where('review_status', '1');

        if ($location_id !== null) {
            $query->where('location_id', $location_id);
        }

        $result = [];
        if ($rows = $query->get()) {
            foreach ($rows as $row) {
                $result[$row['location_id']] = $row['review_total'];
            }
        }

        return $result;
    }

    /**
     * Find a single review by review_id
     *
     * @param int $review_id
     * @param int $customer_id
     * @param string $sale_type
     *
     * @return array
     */
    public function getReview($review_id, $customer_id = null, $sale_type = '')
    {
        if (!empty($review_id)) {
            $query = $this->query();

            if (!empty($customer_id)) {
                $query->where('customer_id', $customer_id);
            }

            if (!empty($sale_type)) {
                $query->where('sale_type', $sale_type);
            }

            return $query->where('review_id', $review_id)->first();
        }
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

    /**
     * Return the total number of reviews by location_id
     *
     * @param int $location_id
     *
     * @return int
     */
    public function getTotalLocationReviews($location_id)
    {
        return $this->where('location_id', $location_id)->where('review_status', '1')->count();
    }

    /**
     * Check if review already exist for an order or reservation
     *
     * @param string $sale_type
     * @param string $sale_id
     * @param string $customer_id
     *
     * @return bool TRUE if already exist, or FALSE if not
     */
    public function checkReviewed($sale_type = 'order', $sale_id = '', $customer_id = '')
    {
        if ($sale_type === 'reservation') {
            $this->load->model('Reservations_model');
            $check_query = $this->Reservations_model->where([
                ['reservation_id', '=', $sale_id],
                ['customer_id', '=', $customer_id],
            ])->first();
        }
        else {
            $this->load->model('Orders_model');
            $check_query = $this->Orders_model->where([
                ['order_id', '=', $sale_id],
                ['customer_id', '=', $customer_id],
            ])->first();
        }

        if (empty($check_query)) {
            return TRUE;
        }

        $query = $this->where('customer_id', $customer_id)
                      ->where('sale_type', $sale_type)->where('sale_id', $sale_id);

        if ($query->first()) {
            return TRUE;
        }

        return FALSE;
    }

    /**
     * Create a new or update existing review
     *
     * @param int $review_id
     * @param array $save
     *
     * @return bool|int The $review_id of the affected row, or FALSE on failure
     */
    public function saveReview($review_id, $save = [])
    {
        if (empty($save)) return FALSE;

        if (isset($save['rating'])) {
            if (isset($save['rating']['quality'])) {
                $save['quality'] = $save['rating']['quality'];
            }

            if (isset($save['rating']['delivery'])) {
                $save['delivery'] = $save['rating']['delivery'];
            }

            if (isset($save['rating']['service'])) {
                $save['service'] = $save['rating']['service'];
            }
        }

        if (is_single_location()) {
            $save['location_id'] = $this->config->item('default_location_id');
        }

        if (APPDIR === ADMINDIR AND isset($save['review_status']) AND $save['review_status'] == '1') {
            $save['review_status'] = '1';
        }
        else if ($this->config->item('approve_reviews') != '1') {
            $save['review_status'] = '1';
        }
        else {
            $save['review_status'] = '0';
        }

        $reviewModel = $this->findOrNew($review_id);

        $saved = $reviewModel->fill($save)->save();

        return $saved ? $reviewModel->getKey() : $saved;
    }

    /**
     * Delete a single or multiple review by review_id
     *
     * @param string|array $review_id
     *
     * @return int  The number of deleted rows
     */
    public function deleteReview($review_id)
    {
        if (is_numeric($review_id)) $review_id = [$review_id];

        if (!empty($review_id) AND ctype_digit(implode('', $review_id))) {
            return $this->whereIn('review_id', $review_id)->delete();
        }
    }
}