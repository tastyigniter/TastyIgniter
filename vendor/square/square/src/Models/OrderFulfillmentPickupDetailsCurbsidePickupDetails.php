<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Specific details for curbside pickup.
 */
class OrderFulfillmentPickupDetailsCurbsidePickupDetails implements \JsonSerializable
{
    /**
     * @var array
     */
    private $curbsideDetails = [];

    /**
     * @var array
     */
    private $buyerArrivedAt = [];

    /**
     * Returns Curbside Details.
     * Specific details for curbside pickup, such as parking number and vehicle model.
     */
    public function getCurbsideDetails(): ?string
    {
        if (count($this->curbsideDetails) == 0) {
            return null;
        }
        return $this->curbsideDetails['value'];
    }

    /**
     * Sets Curbside Details.
     * Specific details for curbside pickup, such as parking number and vehicle model.
     *
     * @maps curbside_details
     */
    public function setCurbsideDetails(?string $curbsideDetails): void
    {
        $this->curbsideDetails['value'] = $curbsideDetails;
    }

    /**
     * Unsets Curbside Details.
     * Specific details for curbside pickup, such as parking number and vehicle model.
     */
    public function unsetCurbsideDetails(): void
    {
        $this->curbsideDetails = [];
    }

    /**
     * Returns Buyer Arrived At.
     * The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)
     * indicating when the buyer arrived and is waiting for pickup. The timestamp must be in RFC 3339
     * format
     * (for example, "2016-09-04T23:59:33.123Z").
     */
    public function getBuyerArrivedAt(): ?string
    {
        if (count($this->buyerArrivedAt) == 0) {
            return null;
        }
        return $this->buyerArrivedAt['value'];
    }

    /**
     * Sets Buyer Arrived At.
     * The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)
     * indicating when the buyer arrived and is waiting for pickup. The timestamp must be in RFC 3339
     * format
     * (for example, "2016-09-04T23:59:33.123Z").
     *
     * @maps buyer_arrived_at
     */
    public function setBuyerArrivedAt(?string $buyerArrivedAt): void
    {
        $this->buyerArrivedAt['value'] = $buyerArrivedAt;
    }

    /**
     * Unsets Buyer Arrived At.
     * The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)
     * indicating when the buyer arrived and is waiting for pickup. The timestamp must be in RFC 3339
     * format
     * (for example, "2016-09-04T23:59:33.123Z").
     */
    public function unsetBuyerArrivedAt(): void
    {
        $this->buyerArrivedAt = [];
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
        if (!empty($this->curbsideDetails)) {
            $json['curbside_details'] = $this->curbsideDetails['value'];
        }
        if (!empty($this->buyerArrivedAt)) {
            $json['buyer_arrived_at'] = $this->buyerArrivedAt['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
