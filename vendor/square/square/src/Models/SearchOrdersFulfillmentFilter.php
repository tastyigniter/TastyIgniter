<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Filter based on [order fulfillment]($m/Fulfillment) information.
 */
class SearchOrdersFulfillmentFilter implements \JsonSerializable
{
    /**
     * @var array
     */
    private $fulfillmentTypes = [];

    /**
     * @var array
     */
    private $fulfillmentStates = [];

    /**
     * Returns Fulfillment Types.
     * A list of [fulfillment types](entity:FulfillmentType) to filter
     * for. The list returns orders if any of its fulfillments match any of the fulfillment types
     * listed in this field.
     * See [FulfillmentType](#type-fulfillmenttype) for possible values
     *
     * @return string[]|null
     */
    public function getFulfillmentTypes(): ?array
    {
        if (count($this->fulfillmentTypes) == 0) {
            return null;
        }
        return $this->fulfillmentTypes['value'];
    }

    /**
     * Sets Fulfillment Types.
     * A list of [fulfillment types](entity:FulfillmentType) to filter
     * for. The list returns orders if any of its fulfillments match any of the fulfillment types
     * listed in this field.
     * See [FulfillmentType](#type-fulfillmenttype) for possible values
     *
     * @maps fulfillment_types
     *
     * @param string[]|null $fulfillmentTypes
     */
    public function setFulfillmentTypes(?array $fulfillmentTypes): void
    {
        $this->fulfillmentTypes['value'] = $fulfillmentTypes;
    }

    /**
     * Unsets Fulfillment Types.
     * A list of [fulfillment types](entity:FulfillmentType) to filter
     * for. The list returns orders if any of its fulfillments match any of the fulfillment types
     * listed in this field.
     * See [FulfillmentType](#type-fulfillmenttype) for possible values
     */
    public function unsetFulfillmentTypes(): void
    {
        $this->fulfillmentTypes = [];
    }

    /**
     * Returns Fulfillment States.
     * A list of [fulfillment states](entity:FulfillmentState) to filter
     * for. The list returns orders if any of its fulfillments match any of the
     * fulfillment states listed in this field.
     * See [FulfillmentState](#type-fulfillmentstate) for possible values
     *
     * @return string[]|null
     */
    public function getFulfillmentStates(): ?array
    {
        if (count($this->fulfillmentStates) == 0) {
            return null;
        }
        return $this->fulfillmentStates['value'];
    }

    /**
     * Sets Fulfillment States.
     * A list of [fulfillment states](entity:FulfillmentState) to filter
     * for. The list returns orders if any of its fulfillments match any of the
     * fulfillment states listed in this field.
     * See [FulfillmentState](#type-fulfillmentstate) for possible values
     *
     * @maps fulfillment_states
     *
     * @param string[]|null $fulfillmentStates
     */
    public function setFulfillmentStates(?array $fulfillmentStates): void
    {
        $this->fulfillmentStates['value'] = $fulfillmentStates;
    }

    /**
     * Unsets Fulfillment States.
     * A list of [fulfillment states](entity:FulfillmentState) to filter
     * for. The list returns orders if any of its fulfillments match any of the
     * fulfillment states listed in this field.
     * See [FulfillmentState](#type-fulfillmentstate) for possible values
     */
    public function unsetFulfillmentStates(): void
    {
        $this->fulfillmentStates = [];
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
        if (!empty($this->fulfillmentTypes)) {
            $json['fulfillment_types']  = $this->fulfillmentTypes['value'];
        }
        if (!empty($this->fulfillmentStates)) {
            $json['fulfillment_states'] = $this->fulfillmentStates['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
