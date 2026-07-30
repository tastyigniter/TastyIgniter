<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Provides metadata when the event `type` is `ACCUMULATE_POINTS`.
 */
class LoyaltyEventAccumulatePoints implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $loyaltyProgramId;

    /**
     * @var array
     */
    private $points = [];

    /**
     * @var array
     */
    private $orderId = [];

    /**
     * Returns Loyalty Program Id.
     * The ID of the [loyalty program](entity:LoyaltyProgram).
     */
    public function getLoyaltyProgramId(): ?string
    {
        return $this->loyaltyProgramId;
    }

    /**
     * Sets Loyalty Program Id.
     * The ID of the [loyalty program](entity:LoyaltyProgram).
     *
     * @maps loyalty_program_id
     */
    public function setLoyaltyProgramId(?string $loyaltyProgramId): void
    {
        $this->loyaltyProgramId = $loyaltyProgramId;
    }

    /**
     * Returns Points.
     * The number of points accumulated by the event.
     */
    public function getPoints(): ?int
    {
        if (count($this->points) == 0) {
            return null;
        }
        return $this->points['value'];
    }

    /**
     * Sets Points.
     * The number of points accumulated by the event.
     *
     * @maps points
     */
    public function setPoints(?int $points): void
    {
        $this->points['value'] = $points;
    }

    /**
     * Unsets Points.
     * The number of points accumulated by the event.
     */
    public function unsetPoints(): void
    {
        $this->points = [];
    }

    /**
     * Returns Order Id.
     * The ID of the [order](entity:Order) for which the buyer accumulated the points.
     * This field is returned only if the Orders API is used to process orders.
     */
    public function getOrderId(): ?string
    {
        if (count($this->orderId) == 0) {
            return null;
        }
        return $this->orderId['value'];
    }

    /**
     * Sets Order Id.
     * The ID of the [order](entity:Order) for which the buyer accumulated the points.
     * This field is returned only if the Orders API is used to process orders.
     *
     * @maps order_id
     */
    public function setOrderId(?string $orderId): void
    {
        $this->orderId['value'] = $orderId;
    }

    /**
     * Unsets Order Id.
     * The ID of the [order](entity:Order) for which the buyer accumulated the points.
     * This field is returned only if the Orders API is used to process orders.
     */
    public function unsetOrderId(): void
    {
        $this->orderId = [];
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
        if (isset($this->loyaltyProgramId)) {
            $json['loyalty_program_id'] = $this->loyaltyProgramId;
        }
        if (!empty($this->points)) {
            $json['points']             = $this->points['value'];
        }
        if (!empty($this->orderId)) {
            $json['order_id']           = $this->orderId['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
