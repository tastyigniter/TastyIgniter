<?php

namespace Stevebauman\Purify\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Stevebauman\Purify\Facades\Purify;

class PurifyHtmlOnGet extends Caster implements CastsAttributes
{
    /**
     * Purify the given value.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string                              $key
     * @param mixed                               $value
     * @param array                               $attributes
     *
     * @return string|array|null
     */
    public function get($model, $key, $value, $attributes)
    {
        if (is_null($value)) {
            return null;
        }

        return Purify::config($this->config)->clean($value);
    }

    /**
     * Prepare the value for storage.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string                              $key
     * @param mixed                               $value
     * @param array                               $attributes
     *
     * @return array|string|null
     */
    public function set($model, $key, $value, $attributes)
    {
        return $value;
    }
}
