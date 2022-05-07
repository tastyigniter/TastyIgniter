<?php

namespace Admin\Traits;

use Admin\Models\LocationOption;

trait HasLocationOptions
{
    protected $optionsCache;

    public static function bootHasLocationOptions()
    {
        static::deleted(function (self $model) {
            LocationOption::onLocation($model)->resetAll();
        });
    }

    public function getOptionsAttribute()
    {
        if (is_null($this->optionsCache))
            $this->optionsCache = LocationOption::onLocation($this)->getAll();

        return $this->optionsCache;
    }

    public function setOptionsAttribute($value)
    {
        LocationOption::onLocation($this)->setAll($value);
        $this->optionsCache = null;
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
