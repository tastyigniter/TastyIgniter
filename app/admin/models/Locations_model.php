<?php namespace Admin\Models;

use Igniter\Flame\Database\Attach\HasMedia;
use Igniter\Flame\Database\Traits\HasPermalink;
use Igniter\Flame\Database\Traits\Purgeable;
use Igniter\Flame\Location\Models\AbstractLocation;

/**
 * Locations Model Class
 *
 * @package Admin
 */
class Locations_model extends AbstractLocation
{
    use HasPermalink;
    use Purgeable;
    use HasMedia;

    public $fillable = ['location_name', 'location_email', 'description', 'location_address_1',
        'location_address_2', 'location_city', 'location_state', 'location_postcode', 'location_country_id',
        'location_telephone', 'location_lat', 'location_lng', 'offer_delivery', 'offer_collection',
        'delivery_time', 'last_order_time', 'reservation_time_interval', 'reservation_stay_time', 'location_status',
        'collection_time', 'options', 'location_image'];

    public $relation = [
        'hasMany' => [
            'working_hours' => ['Admin\Models\Working_hours_model', 'delete' => TRUE],
            'delivery_areas' => ['Admin\Models\Location_areas_model', 'delete' => TRUE],
            'reviews' => ['Admin\Models\Reviews_model', 'delete' => TRUE],
        ],
        'belongsTo' => [
            'country' => ['System\Models\Countries_model', 'otherKey' => 'country_id', 'foreignKey' => 'location_country_id'],
        ],
        'belongsToMany' => [
            'tables' => ['Admin\Models\Tables_model', 'table' => 'location_tables'],
        ],
    ];

    public $purgeable = ['tables', 'delivery_areas'];

    protected $appends = ['location_thumb'];

    protected $hidden = ['options'];

    public $permalinkable = [
        'permalink_slug' => [
            'source' => 'location_name',
            'controller' => 'local',
        ],
    ];

    public $mediable = [
        'thumb',
        'gallery' => ['multiple' => TRUE],
    ];

    protected static $allowedSortingColumns = [
        'distance asc', 'distance desc',
        'reviews_count asc', 'reviews_count desc',
        'location_id asc', 'location_id desc',
        'location_name asc', 'location_name desc',
    ];

    public $url;

    public static function getDropdownOptions()
    {
        return static::isEnabled()->dropdown('location_name');
    }

    public static function onboardingIsComplete()
    {
        if (!$defaultId = params('default_location_id'))
            return FALSE;

        if (!$model = self::isEnabled()->find($defaultId))
            return FALSE;

        return isset($model->getAddress()['location_lat'])
            AND isset($model->getAddress()['location_lng'])
            AND ($model->hasDelivery() OR $model->hasCollection())
            AND isset($model->options['hours'])
            AND $model->delivery_areas->count();
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
        Location_tables_model::where('location_id', $this->getKey())->delete();
    }

    //
    // Scopes
    //

    /**
     * Scope a query to only include enabled location
     *
     * @return $this
     */
    public function scopeIsEnabled($query)
    {
        return $query->where('location_status', 1);
    }

    public function scopeListFrontEnd($query, array $options = [])
    {
        extract(array_merge([
            'page' => 1,
            'pageLimit' => 20,
            'sort' => null,
            'search' => null,
            'latitude' => null,
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

        return $query->paginate($pageLimit, $page);
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
        return (int)$value;
    }

    public function getCollectionTimeAttribute($value)
    {
        return (int)$value;
    }

    public function getFutureOrdersAttribute($value)
    {
        return (bool)$value;
    }

    public function getReservationTimeIntervalAttribute($value)
    {
        return (int)$value;
    }

    //
    // Helpers
    //

    public function setUrl($suffix = null)
    {
        if (is_single_location())
            $suffix = '/menus';

        $this->url = site_url($this->permalink_slug.$suffix);
    }

    public function hasGallery()
    {
        return $this->hasMedia('gallery');
    }

    public function getGallery()
    {
        $gallery = array_get($this->options, 'gallery');
        $gallery['images'] = $this->getMedia('gallery');

        return $gallery;
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
                            $valueItem = $valueItem != '24_7' ? $valueItem : '24_7';

                        $typeIndex = $type == 'daily' ? 'opening' : $type;

                        if ($suffix == 'hours') {
                            $value['hours'][$typeIndex]['open'] = $valueItem['open'] ?? '00:00';
                            $value['hours'][$typeIndex]['close'] = $valueItem['close'] ?? '23:59';
                        }
                        else {
                            $value['hours'][$typeIndex][$suffix] = $valueItem;
                        }
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

        // Ensures form checkbox is unchecked when value is empty
        foreach (['opening', 'delivery', 'collection'] as $type) {
            if (!isset($value['hours'][$type]['days']))
                $value['hours'][$type]['days'] = [];
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

    public function listAvailablePayments()
    {
        $paymentGateways = Payments_model::listPayments();
        if (!$payments = array_get($this->options, 'payments', []))
            return $paymentGateways;

        $result = [];
        foreach ($paymentGateways as $payment) {
            if (!in_array($payment->code, $payments)) continue;

            $result[$payment->code] = $payment;
        }

        return collect($result);
    }

    public function performAfterSave()
    {
        $this->restorePurgedValues();

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
     * Update the default location
     *
     * @param array $update
     *
     * @return bool|int
     */
    public static function updateDefault(array $update = [])
    {
        $location_id = isset($update['location_id'])
            ? (int)$update['location_id']
            : params('default_location_id');

        $locationModel = self::findOrNew($location_id);

        $saved = null;
        if ($locationModel) {
            $locationModel->location_status = TRUE;
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
     * @param array $data
     *
     * @return bool
     */
    public function addOpeningHours($data = [])
    {
        $created = FALSE;

        $this->working_hours()->delete();

        if (!$data)
            return FALSE;

        foreach ($data as $type => $hours) {
            $hoursArray = [];

            if (!isset($hours['type'])) continue;

            switch ($hourType = $hours['type']) {
                case '24_7':
                    $hoursArray = $this->createWorkingHoursArray($hourType, $hours);
                    break;
                case 'daily':
                    $hoursArray = $this->createWorkingHoursArray($hourType, $hours);
                    break;
                case 'flexible':
                    $hoursArray = $this->createWorkingHoursArray($hourType, $hours);
                    break;
            }

            foreach ($hoursArray as $hourValue) {
                $created = $this->working_hours()->create([
                    'location_id' => $this->getKey(),
                    'weekday' => $hourValue['day'],
                    'type' => $type,
                    'opening_time' => mdate('%H:%i', strtotime($hourValue['open'])),
                    'closing_time' => mdate('%H:%i', strtotime($hourValue['close'])),
                    'status' => $hourValue['status'],
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
        $locationId = $this->getKey();
        if (!is_numeric($locationId))
            return FALSE;

        if (!is_array($deliveryAreas))
            return FALSE;

        foreach ($deliveryAreas as $area) {
            $locationArea = $this->delivery_areas()->firstOrNew([
                'area_id' => $area['area_id'] ?? null,
            ])->fill(array_except($area, ['area_id']));

            $locationArea->save();
            $idsToKeep[] = $locationArea->getKey();
        }

        $this->delivery_areas()->whereNotIn('area_id', $idsToKeep)->delete();

        return count($idsToKeep);
    }

    /**
     * Create a new or update existing location tables
     *
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
    public function createWorkingHoursArray($type, $data)
    {
        $hours = ['open' => '00:00', 'close' => '23:59', 'status' => 1];
        if ($type != '24_7')
            $hours = ['open' => $data['open'], 'close' => $data['close']];

        $days = isset($data['days']) ? $data['days'] : [];

        $workingHours = [];

        for ($day = 0; $day <= 6; $day++) {
            $_hours = ($type == 'flexible' AND isset($data['flexible'][$day])) ? $data['flexible'][$day] : $hours;
            $workingHours[] = [
                'day' => $day,
                'type' => $type,
                'open' => $_hours['open'],
                'close' => $_hours['close'],
                'status' => isset($_hours['status']) ? $_hours['status'] : (int)in_array($day, $days),
            ];
        }

        return $workingHours;
    }
}