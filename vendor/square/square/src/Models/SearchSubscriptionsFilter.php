<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents a set of query expressions (filters) to narrow the scope of targeted subscriptions
 * returned by
 * the [SearchSubscriptions]($e/Subscriptions/SearchSubscriptions) endpoint.
 */
class SearchSubscriptionsFilter implements \JsonSerializable
{
    /**
     * @var array
     */
    private $customerIds = [];

    /**
     * @var array
     */
    private $locationIds = [];

    /**
     * @var array
     */
    private $sourceNames = [];

    /**
     * Returns Customer Ids.
     * A filter to select subscriptions based on the subscribing customer IDs.
     *
     * @return string[]|null
     */
    public function getCustomerIds(): ?array
    {
        if (count($this->customerIds) == 0) {
            return null;
        }
        return $this->customerIds['value'];
    }

    /**
     * Sets Customer Ids.
     * A filter to select subscriptions based on the subscribing customer IDs.
     *
     * @maps customer_ids
     *
     * @param string[]|null $customerIds
     */
    public function setCustomerIds(?array $customerIds): void
    {
        $this->customerIds['value'] = $customerIds;
    }

    /**
     * Unsets Customer Ids.
     * A filter to select subscriptions based on the subscribing customer IDs.
     */
    public function unsetCustomerIds(): void
    {
        $this->customerIds = [];
    }

    /**
     * Returns Location Ids.
     * A filter to select subscriptions based on the location.
     *
     * @return string[]|null
     */
    public function getLocationIds(): ?array
    {
        if (count($this->locationIds) == 0) {
            return null;
        }
        return $this->locationIds['value'];
    }

    /**
     * Sets Location Ids.
     * A filter to select subscriptions based on the location.
     *
     * @maps location_ids
     *
     * @param string[]|null $locationIds
     */
    public function setLocationIds(?array $locationIds): void
    {
        $this->locationIds['value'] = $locationIds;
    }

    /**
     * Unsets Location Ids.
     * A filter to select subscriptions based on the location.
     */
    public function unsetLocationIds(): void
    {
        $this->locationIds = [];
    }

    /**
     * Returns Source Names.
     * A filter to select subscriptions based on the source application.
     *
     * @return string[]|null
     */
    public function getSourceNames(): ?array
    {
        if (count($this->sourceNames) == 0) {
            return null;
        }
        return $this->sourceNames['value'];
    }

    /**
     * Sets Source Names.
     * A filter to select subscriptions based on the source application.
     *
     * @maps source_names
     *
     * @param string[]|null $sourceNames
     */
    public function setSourceNames(?array $sourceNames): void
    {
        $this->sourceNames['value'] = $sourceNames;
    }

    /**
     * Unsets Source Names.
     * A filter to select subscriptions based on the source application.
     */
    public function unsetSourceNames(): void
    {
        $this->sourceNames = [];
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
        if (!empty($this->customerIds)) {
            $json['customer_ids'] = $this->customerIds['value'];
        }
        if (!empty($this->locationIds)) {
            $json['location_ids'] = $this->locationIds['value'];
        }
        if (!empty($this->sourceNames)) {
            $json['source_names'] = $this->sourceNames['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
