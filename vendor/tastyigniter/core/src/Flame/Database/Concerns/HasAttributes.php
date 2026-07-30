<?php

declare(strict_types=1);

namespace Igniter\Flame\Database\Concerns;

use BadMethodCallException;
use Carbon\Carbon;
use DateTime;
use DateTimeInterface;
use InvalidArgumentException;

trait HasAttributes
{
    /**
     * Add attribute casts for the model.
     *
     * @param array $attributes
     * @return static
     */
    public function addCasts($attributes)
    {
        return $this->mergeCasts($attributes);
    }

    public function getAttribute($key)
    {
        if (array_key_exists($key, $this->attributes) ||
            array_key_exists($key, $this->casts) ||
            $this->hasGetMutator($key) ||
            $this->isClassCastable($key)) {
            return $this->getAttributeValue($key);
        }

        if (method_exists(self::class, $key)) {
            return null;
        }

        if ($this->relationLoaded($key)) {
            return $this->relations[$key];
        }

        if ($this->hasRelation($key) || method_exists($this, $key)) {
            return $this->getRelationshipFromMethod($key);
        }

        return null;
    }

    public function getAttributeValue($key)
    {
        if (($attr = $this->fireEvent('model.beforeGetAttribute', [$key], true)) !== null) {
            return $attr;
        }

        $attr = parent::getAttributeValue($key);

        if ($this->isSerializedCastable($key) && !empty($attr) && is_string($attr)) {
            $attr = $this->fromSerialized($attr);
        }

        if (($_attr = $this->fireEvent('model.getAttribute', [$key, $attr], true)) !== null) {
            return $_attr;
        }

        return $attr;
    }

    public function attributesToArray()
    {
        $attributes = $this->getArrayableAttributes();

        foreach ($attributes as $key => $value) {
            if (($eventValue = $this->fireEvent('model.beforeGetAttribute', [$key], true)) !== null) {
                $attributes[$key] = $eventValue;
            }
        }

        $attributes = $this->addDateAttributesToArray($attributes);

        $attributes = $this->addMutatedAttributesToArray(
            $attributes, $mutatedAttributes = $this->getMutatedAttributes(),
        );

        $attributes = $this->addCastAttributesToArray(
            $attributes, $mutatedAttributes,
        );

        foreach ($attributes as $key => $value) {
            if ($this->isSerializedCastable($key)) {
                $attributes[$key] = $this->fromSerialized($value);
            }
        }

        foreach ($this->getArrayableAppends() as $key) {
            $attributes[$key] = $this->mutateAttributeForArray($key, null);
        }

        foreach ($attributes as $key => $value) {
            if (($eventValue = $this->fireEvent('model.getAttribute', [$key, $value], true)) !== null) {
                $attributes[$key] = $eventValue;
            }
        }

        return $attributes;
    }

    /**
     * Set a given attribute on the model.
     *
     * @param string $key
     *
     * @return self
     */
    public function setAttribute($key, mixed $value)
    {
        if (empty($key)) {
            throw new BadMethodCallException('Cannot access empty model attribute.');
        }

        if ($this->hasSetMutator($key)) {
            return $this->setMutatedAttributeValue($key, $value);
        }

        if ($this->hasAttributeSetMutator($key)) {
            return $this->setAttributeMarkedMutatedAttributeValue($key, $value);
        }

        // If an attribute is listed as a "date", we'll convert it from a DateTime
        // instance into a form proper for storage on the database tables using
        // the connection grammar's date format. We will auto set the values.
        if ($value && $this->isDateAttribute($key)) {
            $value = $this->fromDateTime($value);
        }

        if ($this->hasRelation($key) && !$this->isRelationPurgeable($key)) {
            return $this->setRelationValue($key, $value);
        }

        if (($_value = $this->fireEvent('model.beforeSetAttribute', [$key, $value], true)) !== null) {
            $value = $_value;
        }

        if ($this->isEnumCastable($key)) {
            $this->setEnumCastableAttribute($key, $value);

            return $this;
        }

        if (!is_null($value) && $this->isSerializedCastable($key)) {
            $value = $this->asSerialized($value);
        }

        if ($this->isClassCastable($key)) {
            $this->setClassCastableAttribute($key, $value);

            return $this;
        }

        if (!is_null($value) && $this->isJsonCastable($key)) {
            $value = $this->castAttributeAsJson($key, $value);
        }

        // If this attribute contains a JSON ->, we'll set the proper value in the
        // attribute's underlying array. This takes care of properly nesting an
        // attribute in the array's value in the case of deeply nested items.
        if (str_contains($key, '->')) {
            return $this->fillJsonAttribute($key, $value);
        }

        if (!is_null($value) && $this->isEncryptedCastable($key)) {
            $value = $this->castAttributeAsEncryptedString($key, $value);
        }

        if (!is_null($value) && $this->hasCast($key, 'hashed')) {
            $value = $this->castAttributeAsHashedString($key, $value);
        }

        $this->attributes[$key] = $value;

        $this->fireEvent('model.setAttribute', [$key, $value]);

        return $this;
    }

    protected function asSerialized($value): ?string
    {
        return isset($value) ? serialize($value) : null;
    }

    public function fromSerialized($value)
    {
        return isset($value) ? @unserialize($value) : null;
    }

    protected function isSerializedCastable($key)
    {
        return $this->hasCast($key, ['serialize']);
    }

    protected function asDateTime($value)
    {
        try {
            $value = parent::asDateTime($value);
        } catch (InvalidArgumentException) {
            $value = \Illuminate\Support\Carbon::parse($value);
        }

        return $value;
    }

    protected function asTime($value): ?Carbon
    {
        // If this value is already a Carbon instance, we shall just return it as is.
        // This prevents us having to re-instantiate a Carbon instance when we know
        // it already is one, which wouldn't be fulfilled by the DateTime check.
        if ($value instanceof Carbon) {
            return $value;
        }

        // If the value is already a DateTime instance, we will just skip the rest of
        // these checks since they will be a waste of time, and hinder performance
        // when checking the field. We will just return the DateTime right away.
        if ($value instanceof DateTimeInterface) {
            return new Carbon(
                $value->format('H:i:s.u'), $value->getTimezone(),
            );
        }

        // If this value is an integer, we will assume it is a UNIX timestamp's value
        // and format a Carbon object from this timestamp. This allows flexibility
        // when defining your time fields as they might be UNIX timestamps here.
        if (is_numeric($value)) {
            return Carbon::createFromTimestamp($value);
        }

        // If the value is in simply hour, minute, second format, we will instantiate the
        // Carbon instances from that format. Again, this provides for simple time
        // fields on the database, while still supporting Carbonized conversion.
        if (preg_match('/^(\d{1,2}):(\d{2}):(\d{2})$/', (string)$value)) {
            return Carbon::createFromFormat('H:i:s', $value);
        }

        // Finally, we will just assume this date is in the format used by default on
        // the database connection and use that format to create the Carbon object
        // that is returned back out to the developers after we convert it here.
        return Carbon::createFromFormat($this->getTimeFormat(), $value);
    }

    /**
     * Convert a Carbon Time to a storable string.
     *
     * @param DateTime|Carbon|int $value
     *
     * @return string
     */
    public function fromTime($value)
    {
        $format = $this->getTimeFormat();

        return $this->asTime($value)->format($format);
    }

    /**
     * Get the format for database stored times.
     * @return string
     */
    public function getTimeFormat()
    {
        return $this->timeFormat ?: 'H:i:s';
    }

    /**
     * Set the time format used by the model.
     *
     * @param string $format
     *
     * @return self
     */
    public function setTimeFormat($format)
    {
        $this->timeFormat = $format;

        return $this;
    }
}
