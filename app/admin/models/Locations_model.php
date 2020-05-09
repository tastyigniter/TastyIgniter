<?php namespace Admin\Models;

use Admin\Traits\HasDeliveryAreas;
use Admin\Traits\HasWorkingHours;
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
    use HasWorkingHours;
    use HasDeliveryAreas;
    use HasPermalink;
    use Purgeable;
    use HasMedia;

    const LOCATION_CONTEXT_SINGLE = 'single';

    const LOCATION_CONTEXT_MULTIPLE = 'multiple';

    protected $appends = ['location_thumb'];

    protected $hidden = ['options'];

    public $casts = [
        'location_country_id' => 'integer',
        'location_lat' => 'double',
        'location_lng' => 'double',
        'offer_delivery' => 'boolean',
        'offer_collection' => 'boolean',
        'delivery_time' => 'integer',
        'collection_time' => 'integer',
        'last_order_time' => 'integer',
        'reservation_time_interval' => 'integer',
        'reservation_stay_time' => 'integer',
        'location_status' => 'boolean',
        'options' => 'serialize',
    ];

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

    protected $purgeable = ['tables', 'delivery_areas'];

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

    protected static $defaultLocation;

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
            AND $model->delivery_areas->where('is_default', 1)->count() > 0;
    }

    public function getWeekDaysOptions()
    {
        return ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
    }

    //
    // Events
    //

    protected function afterFetch()
    {
        $this->parseOptionsValue();
    }

    protected function beforeSave()
    {
        $this->parseOptionsValue();
    }

    protected function afterSave()
    {
        $this->performAfterSave();
    }

    protected function beforeDelete()
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

        if ($latitude AND $longitude) {
            $query->select('*');
            $query->selectDistance($latitude, $longitude);
        }

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
                [$sortField, $sortDirection] = $parts;
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
        return $this->hasMedia() ? $this->getThumb() : null;
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

        $this->parseHoursFromOptions($value);

        $this->parseAreasFromOptions($value);

        $this->attributes['options'] = @serialize($value);

        return $value;
    }

    public function listAvailablePayments()
    {
        $result = [];

        $payments = array_get($this->options, 'payments', []);
        $paymentGateways = Payments_model::listPayments();

        foreach ($paymentGateways as $payment) {
            if ($payments AND !in_array($payment->code, $payments)) continue;

            $result[$payment->code] = $payment;
        }

        return collect($result);
    }

    public function performAfterSave()
    {
        $this->restorePurgedValues();

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
            self::unguard();
            $saved = $locationModel->fill($update)->save();
            self::reguard();

            params()->set('default_location_id', $locationModel->getKey());
        }

        return $saved ? $locationModel->getKey() : $saved;
    }

    public static function getDefault()
    {
        if (self::$defaultLocation !== null) {
            return self::$defaultLocation;
        }

        $defaultLocation = self::isEnabled()->where('location_id', params('default_location_id'))->first();
        if (!$defaultLocation) {
            $defaultLocation = self::isEnabled()->first();
            if ($defaultLocation) {
                params('default_location_id', $defaultLocation->getKey());
                params()->save();
            }
        }

        return self::$defaultLocation = $defaultLocation;
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
}