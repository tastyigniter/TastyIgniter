<?php namespace Admin\Models;

use Admin\Classes\PaymentGateways;
use DB;
use Igniter\Flame\Database\Traits\Purgeable;
use Igniter\Flame\Database\Traits\HasPermalink;
use Igniter\Libraries\Location\Location;
use Model;

/**
 * Locations Model Class
 *
 * @package Admin
 */
class Locations_model extends Model
{
    use HasPermalink;
    use Purgeable;

    /**
     * @var string The database table name
     */
    protected $table = 'locations';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'location_id';

    public $fillable = ['location_name', 'location_email', 'description', 'location_address_1',
        'location_address_2', 'location_city', 'location_state', 'location_postcode', 'location_country_id',
        'location_telephone', 'location_lat', 'location_lng', 'location_radius', 'offer_delivery', 'offer_collection',
        'delivery_time', 'last_order_time', 'reservation_time_interval', 'reservation_stay_time', 'location_status',
        'collection_time', 'options', 'location_image'];

    public $relation = [
        'hasMany'       => [
            'working_hours'  => ['Admin\Models\Working_hours_model', 'delete' => TRUE],
            'delivery_areas' => ['Admin\Models\Location_areas_model', 'delete' => TRUE],
            'reviews'        => ['Admin\Models\Reviews_model', 'delete' => TRUE],
        ],
        'belongsTo'     => [
            'country' => ['System\Models\Countries_model', 'otherKey' => 'country_id', 'foreignKey' => 'location_country_id'],
        ],
        'belongsToMany' => [
            'tables' => ['Admin\Models\Tables_model', 'table' => 'location_tables'],
        ],
    ];

    public $purgeable = ['tables', 'delivery_areas'];

    public $casts = [
        'options' => 'serialize',
    ];

    protected $appends = ['location_thumb'];

    public $permalinkable = [
        'permalink_slug' => [
            'source'     => 'location_name',
            'controller' => 'local',
        ],
    ];

    protected static $allowedSortingColumns = [
        'distance asc', 'distance desc',
        'reviews_count asc', 'reviews_count desc',
        'location_id asc', 'location_id desc',
        'location_name asc', 'location_name desc',
    ];

    public $locationClass;

    public static function getDropdownOptions()
    {
        return static::isEnabled()->dropdown('location_name');
    }

    public function getWeekDaysOptions()
    {
        return ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
    }

    //
    // Events
    //

    public function afterFetch()
    {
        $this->parseOptionsValue();
    }

    public function beforeSave()
    {
        $this->parseOptionsValue();
    }

    public function afterSave()
    {
        $this->performAfterSave();
    }

    public function beforeDelete()
    {
        Location_tables_model::whereIn('location_id', $this->getKey())->delete();
    }

    //
    // Scopes
    //

    public function scopeJoinCountry($query)
    {
        return $query->join('countries', 'countries.country_id', '=', 'locations.location_country_id', 'left');
    }

    public function scopeSelectDistance($query, $lat = null, $lng = null)
    {
        if (setting('distance_unit') === 'km') {
            $sql = "( 6371 * acos( cos( radians(?) ) * cos( radians( location_lat ) ) *";
        }
        else {
            $sql = "( 3959 * acos( cos( radians(?) ) * cos( radians( location_lat ) ) *";
        }

        $sql .= " cos( radians( location_lng ) - radians(?) ) + sin( radians(?) ) *";
        $sql .= " sin( radians( location_lat ) ) ) ) AS distance";

        return $query->selectRaw(DB::raw($sql), [$lat, $lng, $lat]);
    }

    /**
     * Scope a query to only include enabled location
     *
     * @return $this
     */
    public function scopeIsEnabled($query)
    {
        return $query->where('location_status', 1);
    }

    /**
     * Filter database records
     *
     * @param array $filter an associative array of field/value pairs
     *
     * @return $this
     */
    public function scopeFilter($query, $filter = [])
    {
        if (isset($filter['filter_search']) AND is_string($filter['filter_search'])) {
            $query->search($filter['filter_search'], ['location_name', 'location_city', 'location_state', 'location_postcode']);
        }

        if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
            $query->where('location_status', $filter['filter_status']);
        }

        return $query;
    }

    public function scopeListFrontEnd($query, $options = [])
    {
        extract(array_merge([
            'page'      => 1,
            'pageLimit' => 20,
            'sort'      => null,
            'search'    => null,
            'latitude'  => null,
            'longitude' => null,
        ], $options));

        if ($latitude AND $longitude)
            $query->selectDistance($latitude, $longitude);

        $searchableFields = ['location_name', 'location_address_1', 'location_address_2', 'location_city',
            'location_state', 'location_postcode', 'description'];

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

        $search = trim($search);
        if (strlen($search)) {
            $query->search($search, $searchableFields);
        }

        return $query->forPage($page, $pageLimit);
    }

    //
    // Accessors & Mutators
    //

    public function getLocationThumbAttribute()
    {
        return $this->getThumb();
    }

    public function getDeliveryTimeAttribute($value)
    {
        return (int)$value ?: setting('delivery_time');
    }

    public function getCollectionTimeAttribute($value)
    {
        return (int)$value ?: setting('collection_time');
    }

    public function getFutureOrdersAttribute($value)
    {
        return (bool)$value ?: setting('future_orders');
    }

    public function getReservationTimeIntervalAttribute($value)
    {
        return (int)$value ?: setting('reservation_time_interval');
    }

    //
    // Helpers
    //

    public function getThumb($options = [])
    {
        return Image_tool_model::resize($this->location_image, $options);
    }

    public function parseOptionsValue()
    {
        $value = @unserialize($this->attributes['options']) ?: [];

        // Rename options array index 'opening_hours' to 'hours'
        if (isset($value['opening_hours'])) {
            $hours = $value['opening_hours'];
            foreach (['opening', 'daily', 'delivery', 'collection'] as $type) {
                foreach (['type', 'days', 'hours'] as $suffix) {
                    if (isset($hours["{$type}_{$suffix}"])) {
                        $valueItem = $hours["{$type}_{$suffix}"];
                        if ($suffix == 'type')
                            $valueItem = $valueItem != '24_7' ? '24_7' : $valueItem;

                        $typeIndex = $type == 'daily' ? 'opening' : $type;
                        $value['hours'][$typeIndex][$suffix] = $valueItem;
                    }
                }
            }

            if (isset($hours['flexible_hours']) AND is_array($hours['flexible_hours'])) {
                foreach (['opening', 'delivery', 'collection'] as $type) {
                    $value['hours'][$type]['flexible'] = $hours['flexible_hours'];
                }
            }

            unset($value['opening_hours']);
        }

        // Rename options array index ['delivery_areas']['charge']
        // to ['delivery_areas']['conditions']
        if (isset($value['delivery_areas'])) {
            foreach ($value['delivery_areas'] as &$area) {
                if (!isset($charge['charge'])) continue;
                $area['conditions'] = is_array($area['charge']) ? $area['charge'] : [];
                foreach ($area['conditions'] as $id => &$charge) {
                    if (!isset($charge['condition'])) continue;
                    $charge['type'] = $charge['condition'];
                    unset($charge['condition']);
                }
                unset($area['charge']);
            }
        }

        $this->attributes['options'] = @serialize($value);

        return $value;
    }

    public function listPaymentGateways()
    {
        $result = [];
        $gatewayManager = PaymentGateways::instance();
        $payments = $gatewayManager->listGateways();
        foreach ($payments as $payment) {
            $extension = $gatewayManager->findGateway($payment['code']);
            if (!$extension) continue;

            $payment['edit'] = method_exists($extension, 'registerSettings')
                ? $extension->registerSettings()
                : '';

            $result[$payment['code']] = [$payment['name'], $payment['description']];
        }

        return $result;
    }

    public function offersOrderType($type = 'delivery')
    {
        if (!isset($this->attributes["offer_{$type}"]))
            return FALSE;

        return $this->attributes["offer_{$type}"] == 1;
    }

    public function hasFutureOrder()
    {
        return $this->future_orders ? TRUE : FALSE;
    }

    public function applyLocationClass()
    {
        if ($this->locationClass)
            return $this->class;

        $locationClass = new Location(config('location'));

        $this->locationClass = $locationClass;
        $this->locationClass->useLocation($this)->initialize();

        return $this->locationClass;
    }

    public function performAfterSave()
    {
        $this->restorePurgedValues();

//        if ($this->getKey() == params('default_location_id')) {
//            Settings_model::addSetting('prefs', 'main_address', $this->getAddress($this->getKey()), '1');
//        }

        if (is_single_location()) {
            $this->where('location_id', '!=', $this->getKey())
                 ->update(['location_status' => '0']);
        }

        if (array_key_exists('hours', $this->options)) {
            $this->addOpeningHours($this->options['hours']);
        }

        if (array_key_exists('delivery_areas', $this->attributes)) {
            $this->addLocationAreas($this->attributes['delivery_areas']);
        }

        if (array_key_exists('tables', $this->attributes)) {
            $this->addLocationTables($this->attributes['tables']);
        }
    }

    /**
     * Find a location working hour by day of the week
     *
     * @param int $location_id
     * @param string $day
     *
     * @return array
     */
    public function getOpeningHourByDay($location_id = null, $day = null)
    {
        $weekdays = ['Monday' => 0, 'Tuesday' => 1, 'Wednesday' => 2, 'Thursday' => 3, 'Friday' => 4, 'Saturday' => 5, 'Sunday' => 6];
        $day = (!isset($weekdays[$day])) ? date('l', strtotime($day)) : $day;
        $hour = ['open' => '00:00:00', 'close' => '00:00:00', 'status' => '0'];

        $working_hours = Working_hours_model::where('location_id', $location_id)
                                            ->where('weekday', $weekdays[$day])->first();

        if ($working_hours) {
            $hour['open'] = $row['opening_time'];
            $hour['close'] = $row['closing_time'];
            $hour['status'] = $row['status'];
        }

        return $hour;
    }

    /**
     * Find the nearest location to latitude and longitude
     *
     * @param string $lat
     * @param string $lng
     * @param string $search_query
     *
     * @return array|bool an array of the nearest location, or FALSE on failure
     */
    public function getLocalRestaurant($lat = null, $lng = null, $search_query = null)
    {
        $result = null;
        if (!is_null($lat) && !is_null($lng)) {
            $result = $this->newQuery()
                           ->with('delivery_areas')
                           ->select(['location_id', 'location_radius'])
                           ->selectDistance($lat, $lng)
                           ->isEnabled()
//                           ->having('distance', '>', 100)
                           ->orderBy('distance', 'asc')->first();
        }

//        if ($result) {
//            $searchRadius = ($result->location_radius > 0)
//                ? $result->location_radius : (int)setting('search_radius');
//
//            if ($result->distance > $searchRadius) {
//                dd($result->distance, $result->location_radius, $result->getKey(), $searchRadius);
//
//                return null;
//            }
//        }

        return $result;
    }

    /**
     * Update the default location
     *
     * @param array $address
     *
     * @return bool|int
     */
    public static function updateDefault($update = [])
    {
        $location_id = isset($update['location_id'])
            ? (int)$update['location_id']
            : params('default_location_id');

        $locationModel = self::findOrNew($location_id);

        $saved = null;
        if ($locationModel) {
            $locationModel->location_status = true;
            $saved = $locationModel->fill($update)->save();

            params()->set('default_location_id', $locationModel->getKey());

            if (is_single_location()) {
                self::where('location_id', '!=', $locationModel->getKey())
                    ->update(['location_status' => '0']);
            }
        }

        return $saved ? $locationModel->getKey() : $saved;
    }

    /**
     * Create a new or update existing location working hours
     *
     * @param int $location_id
     * @param array $data
     *
     * @return bool
     */
    public function addOpeningHours($data = [])
    {
        $created = FALSE;

        $this->working_hours()->delete();

        if (is_array($data)) foreach ($data as $type => $hours) {
            $_hours = [];
            switch ($hourType = $hours['type']) {
                case '24_7':
                    $_hours = $this->createWorkingHours($hourType, $hours);
                    break;
                case 'daily':
                    $_hours = $this->createWorkingHours($hourType, $hours);
                    break;
                case 'flexible':
                    $_hours = $this->createWorkingHours($hourType, $hours);
                    break;
            }

            foreach ($_hours as $_hour) {
                $created = $this->working_hours()->create([
                    'location_id'  => $this->getKey(),
                    'weekday'      => $_hour['day'],
                    'type'         => $type,
                    'opening_time' => mdate('%H:%i', strtotime($_hour['open'])),
                    'closing_time' => mdate('%H:%i', strtotime($_hour['close'])),
                    'status'       => $_hour['status'],
                ]);
            }
        }

        return $created;
    }

    /**
     * Create a new or update existing location areas
     *
     * @param array $deliveryAreas
     *
     * @return bool
     */
    public function addLocationAreas($deliveryAreas)
    {
        $created = FALSE;

        $this->delivery_areas()->delete();

        if (is_array($deliveryAreas)) foreach ($deliveryAreas as $deliveryArea) {
            $created = $this->delivery_areas()->create(
                array_except($deliveryArea, 'area_id')
            );
        }

        return $created;
    }

    /**
     * Create a new or update existing location tables
     *
     * @param int $location_id
     * @param array $tables
     *
     * @return bool
     */
    public function addLocationTables($tables = [])
    {
        return $this->tables()->sync($tables);
    }

    /**
     * Build working hours array
     *
     * @param $type
     * @param $data
     *
     * @return array
     */
    public function createWorkingHours($type, $data)
    {
        $hours = ['open' => '00:00', 'close' => '23:59'];
        if ($type != '24_7')
            $hours = ['open' => $data['open'], 'close' => $data['close']];

        $days = isset($data['days']) ? $data['days'] : [];

        $workingHours = [];

        for ($day = 0; $day <= 6; $day++) {
            $_hours = ($type == 'flexible' AND isset($data['flexible'][$day])) ? $data['flexible'][$day] : $hours;
            $workingHours[] = [
                'day'    => $day,
                'type'   => $type,
                'open'   => $_hours['open'],
                'close'  => $_hours['close'],
                'status' => (int)in_array($day, $days),
            ];
        }

        return $workingHours;
    }

    public function processAddress($row = null)
    {
        if (is_null($row)) {
            $row = $this->toArray();
        }

        $address_data = [
            'location_id'   => $row['location_id'],
            'location_name' => $row['location_name'],
            'address_1'     => $row['location_address_1'],
            'address_2'     => $row['location_address_2'],
            'city'          => $row['location_city'],
            'state'         => $row['location_state'],
            'postcode'      => $row['location_postcode'],
            'country_id'    => $row['location_country_id'],
            'location_lat'  => $row['location_lat'],
            'location_lng'  => $row['location_lng'],
            'country'       => isset($row['country_name']) ? $row['country_name'] : null,
            'iso_code_2'    => isset($row['iso_code_2']) ? $row['iso_code_2'] : null,
            'iso_code_3'    => isset($row['iso_code_3']) ? $row['iso_code_3'] : null,
            'format'        => isset($row['format']) ? $row['format'] : null,
        ];

        return $address_data;
    }
}