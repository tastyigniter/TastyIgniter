<?php

namespace Stevebauman\Purify\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Stevebauman\Purify\Facades\Purify;

class PurifyHtmlOnSet extends Caster implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string                              $key
     * @param mixed                               $value
     * @param array                               $attributes
     *
     * @return string|array|null
     */
    public function get($model, string $key, $value, array $attributes)
    {
        return $value;
    }

    /**
     * Purify the value for storage.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string                              $key
     * @param mixed                               $value
     * @param array                               $attributes
     *
     * @return array|string|null
     */
    public function set($model, string $key, $value, array $attributes)
    {
        if (is_null($value)) {
            return null;
        }

        return Purify::config($this->config)->clean($value);
    }
}
