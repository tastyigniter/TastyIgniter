<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * A filter based on the order `customer_id` and any tender `customer_id`
 * associated with the order. It does not filter based on the
 * [FulfillmentRecipient]($m/FulfillmentRecipient) `customer_id`.
 */
class SearchOrdersCustomerFilter implements \JsonSerializable
{
    /**
     * @var array
     */
    private $customerIds = [];

    /**
     * Returns Customer Ids.
     * A list of customer IDs to filter by.
     *
     * Max: 10 customer IDs.
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
     * A list of customer IDs to filter by.
     *
     * Max: 10 customer IDs.
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
     * A list of customer IDs to filter by.
     *
     * Max: 10 customer IDs.
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
        if (!empty($this->customerIds)) {
            $json['customer_ids'] = $this->customerIds['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
