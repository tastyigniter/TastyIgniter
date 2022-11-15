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

    protected $guarded = [];

    protected $casts = [
        'location_id' => 'integer',
        'value' => 'json',
    ];

    /**
     * @var \Igniter\Flame\Location\Models\AbstractLocation A user who owns the preferences
     */
    public $locationContext;

    protected $itemsToSaveCache = [];

    protected static $cache = [];

    public static function onLocation($location = null)
    {
        $instance = new static;
        $instance->locationContext = $location ?: $instance->resolveLocation();

        return $instance;
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
        return array_get($this->getAll(), $key, $default);
    }

    public function set($key, $value)
    {
        return $this->setAll([$key => $value]);
    }

    public function getAll()
    {
        if (!$location = $this->locationContext)
            return [];

        $cacheKey = $location->location_id;
        if (array_key_exists($cacheKey, static::$cache))
            return static::$cache[$cacheKey];

        $records = static::where('location_id', $location->location_id)
            ->get()->pluck('value', 'item')->toArray();

        return static::$cache[$cacheKey] = $records;
    }

    public function setAll($items)
    {
        if (!$this->locationContext)
            return false;

        if (!is_array($items))
            $items = [];

        $this->itemsToSaveCache = array_merge($this->itemsToSaveCache, $items);

        if ($this->locationContext->exists) {
            $this->updateOptions();
        }
        elseif ($this->itemsToSaveCache) {
            $this->locationContext->bindEventOnce('model.afterSave', function () {
                $this->updateOptions();
            });
        }

        return true;
    }

    public function resetAll()
    {
        if (!$location = $this->locationContext)
            return;

        static::where('location_id', $location->location_id)->delete();
    }

    public function reset($key)
    {
        if (!$location = $this->locationContext)
            return false;

        if (!$record = static::findRecord($key, $location))
            return false;

        $record->delete();

        unset(static::$cache[$location->location_id][$key]);

        return true;
    }

    public function scopeApplyItemAndLocation($query, $key, $location = null)
    {
        $query = $query->where('item', $key);

        if (!is_null($location))
            $query = $query->where('location_id', $location->location_id);

        return $query;
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
        if (starts_with($name, 'options['))
            return $name;

        $parts = name_to_array($name);

        $wrappedName = implode('', array_map(function ($part) {
            return '['.$part.']';
        }, $parts));

        return 'options'.$wrappedName;
    }

    protected function updateOptions()
    {
        if (!$location = $this->locationContext)
            return false;

        self::upsert(collect($this->itemsToSaveCache)
            ->map(function ($value, $key) use ($location) {
                return [
                    'location_id' => $location->location_id,
                    'item' => $key,
                    'value' => json_encode($value),
                ];
            })->values()->all(), ['location_id', 'item'], ['value']);

        unset(static::$cache[$location->location_id]);

        return true;
    }
}
