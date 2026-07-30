<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * A filter to select resources based on an exact field value. For any given
 * value, the value can only be in one property. Depending on the field, either
 * all properties can be set or only a subset will be available.
 *
 * Refer to the documentation of the field.
 */
class FilterValue implements \JsonSerializable
{
    /**
     * @var array
     */
    private $all = [];

    /**
     * @var array
     */
    private $any = [];

    /**
     * @var array
     */
    private $none = [];

    /**
     * Returns All.
     * A list of terms that must be present on the field of the resource.
     *
     * @return string[]|null
     */
    public function getAll(): ?array
    {
        if (count($this->all) == 0) {
            return null;
        }
        return $this->all['value'];
    }

    /**
     * Sets All.
     * A list of terms that must be present on the field of the resource.
     *
     * @maps all
     *
     * @param string[]|null $all
     */
    public function setAll(?array $all): void
    {
        $this->all['value'] = $all;
    }

    /**
     * Unsets All.
     * A list of terms that must be present on the field of the resource.
     */
    public function unsetAll(): void
    {
        $this->all = [];
    }

    /**
     * Returns Any.
     * A list of terms where at least one of them must be present on the
     * field of the resource.
     *
     * @return string[]|null
     */
    public function getAny(): ?array
    {
        if (count($this->any) == 0) {
            return null;
        }
        return $this->any['value'];
    }

    /**
     * Sets Any.
     * A list of terms where at least one of them must be present on the
     * field of the resource.
     *
     * @maps any
     *
     * @param string[]|null $any
     */
    public function setAny(?array $any): void
    {
        $this->any['value'] = $any;
    }

    /**
     * Unsets Any.
     * A list of terms where at least one of them must be present on the
     * field of the resource.
     */
    public function unsetAny(): void
    {
        $this->any = [];
    }

    /**
     * Returns None.
     * A list of terms that must not be present on the field the resource
     *
     * @return string[]|null
     */
    public function getNone(): ?array
    {
        if (count($this->none) == 0) {
            return null;
        }
        return $this->none['value'];
    }

    /**
     * Sets None.
     * A list of terms that must not be present on the field the resource
     *
     * @maps none
     *
     * @param string[]|null $none
     */
    public function setNone(?array $none): void
    {
        $this->none['value'] = $none;
    }

    /**
     * Unsets None.
     * A list of terms that must not be present on the field the resource
     */
    public function unsetNone(): void
    {
        $this->none = [];
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
        if (!empty($this->all)) {
            $json['all']  = $this->all['value'];
        }
        if (!empty($this->any)) {
            $json['any']  = $this->any['value'];
        }
        if (!empty($this->none)) {
            $json['none'] = $this->none['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
