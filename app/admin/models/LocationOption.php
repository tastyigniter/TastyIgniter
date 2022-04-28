<?php

namespace Admin\Models;

use Admin\Facades\AdminLocation;
use Exception;
use Igniter\Flame\Database\Model;
use Illuminate\Support\Facades\Event;

class LocationOption extends Model
{
    /**
     * @var string The database table used by the model.
     */
    protected $table = 'location_options';

    protected $casts = [
        'location_id' => 'integer',
        'value' => 'json',
    ];

    /**
     * @var \Igniter\Flame\Location\Models\AbstractLocation A user who owns the preferences
     */
    public $locationContext;

    protected static $cache = [];

    public static function onLocation($location = null)
    {
        $self = new static;
        $self->locationContext = $location ?: $self->resolveLocation();

        return $self;
    }

    public static function findRecord($key, $location = null)
    {
        return static::applyItemAndLocation($key, $location)->first();
    }

    public function resolveLocation()
    {
        if (!$location = AdminLocation::current())
            throw new Exception(lang('admin::lang.alert_location_not_selected'));

        return $location;
    }

    public function get($key, $default = null)
    {
        if (!($location = $this->locationContext))
            return $default;

        $cacheKey = $this->getCacheKey($key, $location);

        if (array_key_exists($cacheKey, static::$cache))
            return static::$cache[$cacheKey];

        $record = static::findRecord($key, $location);

        return static::$cache[$cacheKey] = $record ? $record->value : $default;
    }

    public function set($key, $value)
    {
        if (!$location = $this->locationContext)
            return FALSE;

        if (!$record = static::findRecord($key, $location)) {
            $record = new static;
            $record->item = $key;
            $record->location_id = $location->location_id;
        }

        $record->value = $value;
        $record->save();

        $cacheKey = $this->getCacheKey($key, $location);
        static::$cache[$cacheKey] = $value;

        return TRUE;
    }

    public function getAll()
    {
        if (!$location = $this->locationContext)
            return [];

        return static::where('location_id', $location->location_id)->get()->pluck('value', 'item')->toArray();
    }

    public function setAll($items)
    {
        foreach ($items as $item => $value) {
            $this->set($item, $value);
        }
    }

    public function reset($key)
    {
        if (!$location = $this->locationContext)
            return FALSE;

        if (!$record = static::findRecord($key, $location))
            return FALSE;

        $record->delete();

        $cacheKey = $this->getCacheKey($key, $location);
        unset(static::$cache[$cacheKey]);

        return TRUE;
    }

    public function scopeApplyItemAndLocation($query, $key, $location = null)
    {
        $query = $query->where('item', $key);

        if (!is_null($location))
            $query = $query->where('location_id', $location->location_id);

        return $query;
    }

    /**
     * Builds a cache key for the preferences record.
     * @return string
     */
    protected function getCacheKey($key, $location)
    {
        return $location->location_id.'-'.$key;
    }

    public static function getFieldsConfig()
    {
        $instance = new static;

        $result = [];

        $response = Event::fire('admin.locations.defineOptionsFormFields');

        if (is_array($response)) {
            foreach ($response as $fieldsConfig) {
                if (!is_array($fieldsConfig)) continue;

                foreach ($fieldsConfig as $fieldName => $fieldConfig) {
                    $fieldName = $instance->wrapFieldName($fieldName);

                    if ($triggerFieldName = array_get($fieldConfig, 'trigger.field'))
                        $fieldConfig['trigger']['field'] = $instance->wrapFieldName($triggerFieldName);

                    $fieldConfig['tab'] = 'lang:admin::lang.locations.text_tab_options';
                    $result[$fieldName] = $fieldConfig;
                }
            }
        }

        return $result;
    }

    protected function wrapFieldName($name)
    {
        $parts = name_to_array($name);

        return 'options'.implode('', array_map(function ($part) {
                return '['.$part.']';
            }, $parts));
    }
}
