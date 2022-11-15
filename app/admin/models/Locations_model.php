<?php

namespace Admin\Models;

use Admin\Traits\HasDeliveryAreas;
use Admin\Traits\HasLocationOptions;
use Admin\Traits\HasWorkingHours;
use Igniter\Flame\Database\Attach\HasMedia;
use Igniter\Flame\Database\Traits\HasPermalink;
use Igniter\Flame\Database\Traits\Purgeable;
use Igniter\Flame\Exception\ValidationException;
use Igniter\Flame\Location\Models\AbstractLocation;

/**
 * Locations Model Class
 */
class Locations_model extends AbstractLocation
{
    use HasWorkingHours;
    use HasDeliveryAreas;
    use HasPermalink;
    use HasMedia;
    use HasLocationOptions;
    use Purgeable;

    const LOCATION_CONTEXT_SINGLE = 'single';

    const LOCATION_CONTEXT_MULTIPLE = 'multiple';

    protected $appends = ['location_thumb'];

    protected $casts = [
        'location_country_id' => 'integer',
        'location_lat' => 'double',
        'location_lng' => 'double',
        'location_status' => 'boolean',
    ];

    public $relation = [
        'hasMany' => [
            'all_options' => ['Admin\Models\LocationOption', 'delete' => true],
            'working_hours' => ['Admin\Models\Working_hours_model', 'delete' => true],
            'delivery_areas' => ['Admin\Models\Location_areas_model', 'delete' => true],
        ],
        'belongsTo' => [
            'country' => ['System\Models\Countries_model', 'otherKey' => 'country_id', 'foreignKey' => 'location_country_id'],
        ],
        'morphedByMany' => [
            'staffs' => ['Admin\Models\Staffs_model', 'name' => 'locationable'],
            'tables' => ['Admin\Models\Tables_model', 'name' => 'locationable'],
        ],
    ];

    protected $purgeable = ['options', 'delivery_areas'];

    public $permalinkable = [
        'permalink_slug' => [
            'source' => 'location_name',
            'controller' => 'local',
        ],
    ];

    public $mediable = [
        'thumb',
        'gallery' => ['multiple' => true],
    ];

    protected static $allowedSortingColumns = [
        'distance asc', 'distance desc',
        'location_id asc', 'location_id desc',
        'location_name asc', 'location_name desc',
    ];

    public $url;

    public $timestamps = true;

    protected static $defaultLocation;

    public static function getDropdownOptions()
    {
        return static::isEnabled()->dropdown('location_name');
    }

    public static function onboardingIsComplete()
    {
        if (!$defaultId = params('default_location_id'))
            return false;

        if (!$model = self::isEnabled()->find($defaultId))
            return false;

        return isset($model->getAddress()['location_lat'])
            && isset($model->getAddress()['location_lng'])
            && ($model->hasDelivery() || $model->hasCollection())
            && isset($model->options['hours'])
            && $model->delivery_areas->where('is_default', 1)->count() > 0;
    }

    public static function addSortingColumns($newColumns)
    {
        self::$allowedSortingColumns = array_merge(self::$allowedSortingColumns, $newColumns);
    }

    //
    // Events
    //

    protected function beforeDelete()
    {
    }

    protected function afterSave()
    {
        $this->performAfterSave();
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
        extract($options = array_merge([
            'page' => 1,
            'pageLimit' => 20,
            'sort' => null,
            'search' => null,
            'enabled' => null,
            'latitude' => null,
            'longitude' => null,
            'paginate' => true,
        ], $options));

        if ($latitude && $longitude) {
            $query->selectDistance($latitude, $longitude);
        }

        $searchableFields = [
            'location_name', 'location_address_1',
            'location_address_2', 'location_city',
            'location_state', 'location_postcode',
            'description',
        ];

        if (!is_array($sort)) {
            $sort = [$sort];
        }

        foreach ($sort as $_sort) {
            if (in_array($_sort, self::$allowedSortingColumns)) {
                $parts = explode(' ', $_sort);
                if (count($parts) < 2) {
                    $parts[] = 'desc';
                }
                [$sortField, $sortDirection] = $parts;
                $query->orderBy($sortField, $sortDirection);
            }
        }

        $search = trim($search);
        if (strlen($search)) {
            $query->search($search, $searchableFields);
        }

        if (!is_null($enabled))
            $query->where('location_status', $enabled);

        $this->fireEvent('model.extendListFrontEndQuery', [$query]);

        if (is_null($pageLimit))
            return $query;

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
        return (int)$this->getOption('delivery_time_interval');
    }

    public function getCollectionTimeAttribute($value)
    {
        return (int)$this->getOption('collection_time_interval');
    }

    public function getFutureOrdersAttribute($value)
    {
        return (bool)$value;
    }

    public function getReservationTimeIntervalAttribute($value)
    {
        return (int)$this->getOption('reservation_time_interval');
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

    public function getAddress()
    {
        $country = optional($this->country);

        return array_merge(parent::getAddress(), [
            'country' => $country->country_name,
            'iso_code_2' => $country->iso_code_2,
            'iso_code_3' => $country->iso_code_3,
            'format' => $country->format,
        ]);
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

    public function allowGuestOrder()
    {
        if (($allowGuestOrder = (int)$this->getOption('guest_order', -1)) === -1)
            $allowGuestOrder = (int)setting('guest_order', 1);

        return (bool)$allowGuestOrder;
    }

    public function listAvailablePayments()
    {
        $result = [];

        $payments = array_get($this->options, 'payments', []);
        $paymentGateways = Payments_model::listPayments();

        foreach ($paymentGateways as $payment) {
            if ($payments && !in_array($payment->code, $payments)) continue;

            $result[$payment->code] = $payment;
        }

        return collect($result);
    }

    public function performAfterSave()
    {
        $this->restorePurgedValues();

        if (array_key_exists('delivery_areas', $this->attributes))
            $this->addLocationAreas((array)$this->attributes['delivery_areas']);
    }

    public function makeDefault()
    {
        if (!$this->location_status) {
            throw new ValidationException(['location_status' => sprintf(
                lang('admin::lang.alert_error_set_default'), $this->location_name
            )]);
        }

        params()->set(['default_location_id' => $this->getKey()])->save();
    }

    /**
     * Update the default location
     *
     * @param string $locationId
     *
     * @return bool|null
     */
    public static function updateDefault($locationId)
    {
        if ($model = self::find($locationId)) {
            $model->makeDefault();

            return true;
        }
    }

    public static function getDefault()
    {
        if (self::$defaultLocation !== null) {
            return self::$defaultLocation;
        }

        $defaultLocation = self::isEnabled()->where('location_id', params('default_location_id'))->first();
        if (!$defaultLocation) {
            if ($defaultLocation = self::isEnabled()->first()) {
                $defaultLocation->makeDefault();
            }
        }

        return self::$defaultLocation = $defaultLocation;
    }
}
