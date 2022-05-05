<?php

namespace Admin\Traits;

use Admin\Models\LocationOption;

trait HasLocationOptions
{
    public static function bootHasLocationOptions()
    {
        static::deleted(function (self $model) {
            LocationOption::onLocation($model)->resetAll();
        });
    }

    public function getOptionsAttribute()
    {
        if (!array_key_exists('options', $this->attributes))
            $this->attributes['options'] = LocationOption::onLocation($this)->getAll();

        return $this->attributes['options'];
    }

    public function setOptionsAttribute($value)
    {
        LocationOption::onLocation($this)->setAll($value);
        $this->attributes['options'] = $value;
    }

    public function setOption($key, $value)
    {
        $options = $this->options;
        array_set($options, $key, $value);
        $this->options = $options;
    }

    public function getOption($key = null, $default = null)
    {
        return array_get($this->options, $key, $default);
    }
}
