<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Defines supported query expressions to search for vendors by.
 */
class SearchVendorsRequestFilter implements \JsonSerializable
{
    /**
     * @var array
     */
    private $name = [];

    /**
     * @var array
     */
    private $status = [];

    /**
     * Returns Name.
     * The names of the [Vendor](entity:Vendor) objects to retrieve.
     *
     * @return string[]|null
     */
    public function getName(): ?array
    {
        if (count($this->name) == 0) {
            return null;
        }
        return $this->name['value'];
    }

    /**
     * Sets Name.
     * The names of the [Vendor](entity:Vendor) objects to retrieve.
     *
     * @maps name
     *
     * @param string[]|null $name
     */
    public function setName(?array $name): void
    {
        $this->name['value'] = $name;
    }

    /**
     * Unsets Name.
     * The names of the [Vendor](entity:Vendor) objects to retrieve.
     */
    public function unsetName(): void
    {
        $this->name = [];
    }

    /**
     * Returns Status.
     * The statuses of the [Vendor](entity:Vendor) objects to retrieve.
     * See [VendorStatus](#type-vendorstatus) for possible values
     *
     * @return string[]|null
     */
    public function getStatus(): ?array
    {
        if (count($this->status) == 0) {
            return null;
        }
        return $this->status['value'];
    }

    /**
     * Sets Status.
     * The statuses of the [Vendor](entity:Vendor) objects to retrieve.
     * See [VendorStatus](#type-vendorstatus) for possible values
     *
     * @maps status
     *
     * @param string[]|null $status
     */
    public function setStatus(?array $status): void
    {
        $this->status['value'] = $status;
    }

    /**
     * Unsets Status.
     * The statuses of the [Vendor](entity:Vendor) objects to retrieve.
     * See [VendorStatus](#type-vendorstatus) for possible values
     */
    public function unsetStatus(): void
    {
        $this->status = [];
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
        if (!empty($this->name)) {
            $json['name']   = $this->name['value'];
        }
        if (!empty($this->status)) {
            $json['status'] = $this->status['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
