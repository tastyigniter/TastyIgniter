<?php namespace Admin\Models;

use Admin\Classes\PaymentGateways;
use DB;
use Igniter\Flame\Database\Traits\Purgeable;
use Igniter\Flame\Permalink\Traits\HasPermalink;
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
     * Return all enabled locations
     *
     * @return array
     */
    public function getLocations()
    {
        return $this->where('location_status', '1')->get();
    }

    /**
     * Find a single location by location_id
     *
     * @param $location_id
     *
     * @return mixed
     */
    public function getLocation($location_id)
    {
        return $this->joinCountry()->find($location_id);
    }

    /**
     * Return all location working hours by location id
     *
     * @param int $location_id
     *
     * @return array
     */
    public function getWorkingHours($location_id = null)
    {
        $workingHoursModel = Working_hours_model::query();

        if (!is_null($location_id)) {
            $workingHoursModel->where('location_id', $location_id);
        }

        return $workingHoursModel->get();
    }

    /**
     * Find a single location address by location id
     *
     * @param int $location_id
     *
     * @return array
     */
    public function getAddress($location_id)
    {
        $address_data = [];

        if ($location_id !== 0) {
            if ($row = $this->joinCountry()->find($location_id)) {
                $address_data = $this->processAddress($row);
            }
        }

        return $address_data;
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
     * Return all locations by table
     *
     * @param int $table_id
     *
     * @return array
     */
    public function getLocationsByTable($table_id = null)
    {
        $table_locations = [];
        $locations = Location_tables_model::where('table_id', $table_id)->get();
        foreach ($locations as $row) {
            $table_locations[] = $row['location_id'];
        }

        return $table_locations;
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
    public static function updateDefault($address = [])
    {
        $query = FALSE;

        if (empty($address) AND !is_array($address)) return $query;

        if (isset($address['address_1'])) {
            $update['location_address_1'] = $address['address_1'];
        }

        if (isset($address['address_2'])) {
            $update['location_address_2'] = $address['address_2'];
        }

        if (isset($address['city'])) {
            $update['location_city'] = $address['city'];
        }

        if (isset($address['state'])) {
            $update['location_state'] = $address['state'];
        }

        if (isset($address['postcode'])) {
            $update['location_postcode'] = $address['postcode'];
        }

        if (isset($address['country_id'])) {
            $update['location_country_id'] = $address['country_id'];
        }

        if (isset($address['location_lat'])) {
            $update['location_lat'] = $address['location_lat'];
        }

        if (isset($address['location_lng'])) {
            $update['location_lng'] = $address['location_lng'];
        }

        $update['location_status'] = '1';

        if (isset($address['location_id'])) {
            $location_id = (int)$address['location_id'];
        }
        else {
            $location_id = params('default_location_id');
        }

        $locationModel = self::findOrNew($location_id);

        $saved = null;
        if ($locationModel) {
            $saved = $locationModel->fill($update)->save();

//            Settings_model::addSetting('prefs', 'main_address', $default_address, '1');
            params()->set('default_location_id', $locationModel->getKey());

            if (is_single_location()) {
                self::where('location_id', '!=', $locationModel->getKey())
                    ->update(['location_status' => '0']);
            }
        }

        return $saved ? $locationModel->getKey() : $saved;
    }

    /**
     * Create a new or update existing location
     *
     * @param int $location_id
     * @param array $save
     *
     * @return bool|int
     */
    public function saveLocation($location_id, $save = [])
    {
        if (empty($save)) return FALSE;

        $save = $this->postData($save);

        $locationModel = $this->findOrNew($location_id);

        $saved = $locationModel->fill($save)->save();

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
     * Delete a single or multiple location by location_id
     *
     * @param string|array $location_id
     *
     * @return int The number of deleted rows
     */
    public function deleteLocation($location_id)
    {
        if (is_numeric($location_id)) $location_id = [$location_id];

        if (!empty($location_id) AND ctype_digit(implode('', $location_id))) {
            return $this->whereIn('location_id', $location_id)->delete();
        }
    }

    /**
     * Validate a single location by language_id
     *
     * @param int $location_id
     *
     * @return bool TRUE on success, FALSE on failure
     */
    public function validateLocation($location_id)
    {
        if (!empty($location_id)) {
            if ($this->find($location_id)) {
                return TRUE;
            }
        }

        return FALSE;
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

    /**
     * Build post data to save in database
     * @deprecated
     *
     * @param array $save
     *
     * @return array
     */
    protected function postData($save = [])
    {
        if (isset($save['address']['address_1'])) {
            $save['location_address_1'] = $save['address']['address_1'];
        }

        if (isset($save['address']['address_2'])) {
            $save['location_address_2'] = $save['address']['address_2'];
        }

        if (isset($save['address']['city'])) {
            $save['location_city'] = $save['address']['city'];
        }

        if (isset($save['address']['state'])) {
            $save['location_state'] = $save['address']['state'];
        }

        if (isset($save['address']['postcode'])) {
            $save['location_postcode'] = $save['address']['postcode'];
        }

        if (isset($save['address']['country'])) {
            $save['location_country_id'] = $save['address']['country'];
        }

        if (isset($save['address']['location_lat'])) {
            $save['location_lat'] = $save['address']['location_lat'];
        }

        if (isset($save['address']['location_lng'])) {
            $save['location_lng'] = $save['address']['location_lng'];
        }

        if (isset($save['email'])) {
            $save['location_email'] = $save['email'];
        }

        if (isset($save['telephone'])) {
            $save['location_telephone'] = $save['telephone'];
        }

        $options = [];
        if (isset($save['auto_lat_lng'])) {
            $options['auto_lat_lng'] = $save['auto_lat_lng'];
        }

        if (isset($save['opening_type'])) {
            $options['opening_hours']['opening_type'] = $save['opening_type'];
        }

        if (isset($save['daily_days'])) {
            $options['opening_hours']['daily_days'] = $save['daily_days'];
        }

        if (isset($save['daily_hours'])) {
            $options['opening_hours']['daily_hours'] = $save['daily_hours'];
        }

        if (isset($save['flexible_hours'])) {
            $options['opening_hours']['flexible_hours'] = $save['flexible_hours'];
        }

        if (isset($save['delivery_type'])) {
            $options['opening_hours']['delivery_type'] = $save['delivery_type'];
        }

        if (isset($save['delivery_days'])) {
            $options['opening_hours']['delivery_days'] = $save['delivery_days'];
        }

        if (isset($save['delivery_hours'])) {
            $options['opening_hours']['delivery_hours'] = $save['delivery_hours'];
        }

        if (isset($save['collection_type'])) {
            $options['opening_hours']['collection_type'] = $save['collection_type'];
        }

        if (isset($save['collection_days'])) {
            $options['opening_hours']['collection_days'] = $save['collection_days'];
        }

        if (isset($save['collection_hours'])) {
            $options['opening_hours']['collection_hours'] = $save['collection_hours'];
        }

        if (isset($save['future_orders'])) {
            $options['future_orders'] = $save['future_orders'];
        }

        if (isset($save['future_order_days'])) {
            $options['future_order_days'] = $save['future_order_days'];
        }

        if (isset($save['payments'])) {
            $options['payments'] = $save['payments'];
        }

        if (isset($save['delivery_areas'])) {
            $options['delivery_areas'] = $save['delivery_areas'];
        }

        if (isset($save['gallery'])) {
            $options['gallery'] = $save['gallery'];
        }

        $save['options'] = $options;

        return $save;
    }
}