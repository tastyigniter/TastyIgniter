<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * The creation source filter.
 *
 * If one or more creation sources are set, customer profiles are included in,
 * or excluded from, the result if they match at least one of the filter criteria.
 */
class CustomerCreationSourceFilter implements \JsonSerializable
{
    /**
     * @var array
     */
    private $values = [];

    /**
     * @var string|null
     */
    private $rule;

    /**
     * Returns Values.
     * The list of creation sources used as filtering criteria.
     * See [CustomerCreationSource](#type-customercreationsource) for possible values
     *
     * @return string[]|null
     */
    public function getValues(): ?array
    {
        if (count($this->values) == 0) {
            return null;
        }
        return $this->values['value'];
    }

    /**
     * Sets Values.
     * The list of creation sources used as filtering criteria.
     * See [CustomerCreationSource](#type-customercreationsource) for possible values
     *
     * @maps values
     *
     * @param string[]|null $values
     */
    public function setValues(?array $values): void
    {
        $this->values['value'] = $values;
    }

    /**
     * Unsets Values.
     * The list of creation sources used as filtering criteria.
     * See [CustomerCreationSource](#type-customercreationsource) for possible values
     */
    public function unsetValues(): void
    {
        $this->values = [];
    }

    /**
     * Returns Rule.
     * Indicates whether customers should be included in, or excluded from,
     * the result set when they match the filtering criteria.
     */
    public function getRule(): ?string
    {
        return $this->rule;
    }

    /**
     * Sets Rule.
     * Indicates whether customers should be included in, or excluded from,
     * the result set when they match the filtering criteria.
     *
     * @maps rule
     */
    public function setRule(?string $rule): void
    {
        $this->rule = $rule;
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
        if (!empty($this->values)) {
            $json['values'] = $this->values['value'];
        }
        if (isset($this->rule)) {
            $json['rule']   = $this->rule;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
