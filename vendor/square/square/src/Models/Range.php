<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * The range of a number value between the specified lower and upper bounds.
 */
class Range implements \JsonSerializable
{
    /**
     * @var array
     */
    private $min = [];

    /**
     * @var array
     */
    private $max = [];

    /**
     * Returns Min.
     * The lower bound of the number range. At least one of `min` or `max` must be specified.
     * If unspecified, the results will have no minimum value.
     */
    public function getMin(): ?string
    {
        if (count($this->min) == 0) {
            return null;
        }
        return $this->min['value'];
    }

    /**
     * Sets Min.
     * The lower bound of the number range. At least one of `min` or `max` must be specified.
     * If unspecified, the results will have no minimum value.
     *
     * @maps min
     */
    public function setMin(?string $min): void
    {
        $this->min['value'] = $min;
    }

    /**
     * Unsets Min.
     * The lower bound of the number range. At least one of `min` or `max` must be specified.
     * If unspecified, the results will have no minimum value.
     */
    public function unsetMin(): void
    {
        $this->min = [];
    }

    /**
     * Returns Max.
     * The upper bound of the number range. At least one of `min` or `max` must be specified.
     * If unspecified, the results will have no maximum value.
     */
    public function getMax(): ?string
    {
        if (count($this->max) == 0) {
            return null;
        }
        return $this->max['value'];
    }

    /**
     * Sets Max.
     * The upper bound of the number range. At least one of `min` or `max` must be specified.
     * If unspecified, the results will have no maximum value.
     *
     * @maps max
     */
    public function setMax(?string $max): void
    {
        $this->max['value'] = $max;
    }

    /**
     * Unsets Max.
     * The upper bound of the number range. At least one of `min` or `max` must be specified.
     * If unspecified, the results will have no maximum value.
     */
    public function unsetMax(): void
    {
        $this->max = [];
    }

    /**
     * Encode this object to JSON
     *
     * @param bool $asArrayWhenEmpty Whether to serialize this model as an array whenever no fields
     *        are set. (default: false)
     *
     * @return array|stdClass
     */
    #[\ReturnTypeWillChange] // @phan-suppress-current-line PhanUndeclaredClassAttribute for (php < 8.1)
    public function jsonSerialize(bool $asArrayWhenEmpty = false)
    {
        $json = [];
        if (!empty($this->min)) {
            $json['min'] = $this->min['value'];
        }
        if (!empty($this->max)) {
            $json['max'] = $this->max['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
