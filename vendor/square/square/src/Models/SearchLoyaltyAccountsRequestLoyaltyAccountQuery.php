<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * The search criteria for the loyalty accounts.
 */
class SearchLoyaltyAccountsRequestLoyaltyAccountQuery implements \JsonSerializable
{
    /**
     * @var array
     */
    private $mappings = [];

    /**
     * @var array
     */
    private $customerIds = [];

    /**
     * Returns Mappings.
     * The set of mappings to use in the loyalty account search.
     *
     * This cannot be combined with `customer_ids`.
     *
     * Max: 30 mappings
     *
     * @return LoyaltyAccountMapping[]|null
     */
    public function getMappings(): ?array
    {
        if (count($this->mappings) == 0) {
            return null;
        }
        return $this->mappings['value'];
    }

    /**
     * Sets Mappings.
     * The set of mappings to use in the loyalty account search.
     *
     * This cannot be combined with `customer_ids`.
     *
     * Max: 30 mappings
     *
     * @maps mappings
     *
     * @param LoyaltyAccountMapping[]|null $mappings
     */
    public function setMappings(?array $mappings): void
    {
        $this->mappings['value'] = $mappings;
    }

    /**
     * Unsets Mappings.
     * The set of mappings to use in the loyalty account search.
     *
     * This cannot be combined with `customer_ids`.
     *
     * Max: 30 mappings
     */
    public function unsetMappings(): void
    {
        $this->mappings = [];
    }

    /**
     * Returns Customer Ids.
     * The set of customer IDs to use in the loyalty account search.
     *
     * This cannot be combined with `mappings`.
     *
     * Max: 30 customer IDs
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
     * The set of customer IDs to use in the loyalty account search.
     *
     * This cannot be combined with `mappings`.
     *
     * Max: 30 customer IDs
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
     * The set of customer IDs to use in the loyalty account search.
     *
     * This cannot be combined with `mappings`.
     *
     * Max: 30 customer IDs
     */
    public function unsetCustomerIds(): void
    {
        $this->customerIds = [];
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
        if (!empty($this->mappings)) {
            $json['mappings']     = $this->mappings['value'];
        }
        if (!empty($this->customerIds)) {
            $json['customer_ids'] = $this->customerIds['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
