<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Provides metadata when the event `type` is `ACCUMULATE_PROMOTION_POINTS`.
 */
class LoyaltyEventAccumulatePromotionPoints implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $loyaltyProgramId;

    /**
     * @var string|null
     */
    private $loyaltyPromotionId;

    /**
     * @var int
     */
    private $points;

    /**
     * @var string
     */
    private $orderId;

    /**
     * @param int $points
     * @param string $orderId
     */
    public function __construct(int $points, string $orderId)
    {
        $this->points = $points;
        $this->orderId = $orderId;
    }

    /**
     * Returns Loyalty Program Id.
     * The Square-assigned ID of the [loyalty program](entity:LoyaltyProgram).
     */
    public function getLoyaltyProgramId(): ?string
    {
        return $this->loyaltyProgramId;
    }

    /**
     * Sets Loyalty Program Id.
     * The Square-assigned ID of the [loyalty program](entity:LoyaltyProgram).
     *
     * @maps loyalty_program_id
     */
    public function setLoyaltyProgramId(?string $loyaltyProgramId): void
    {
        $this->loyaltyProgramId = $loyaltyProgramId;
    }

    /**
     * Returns Loyalty Promotion Id.
     * The Square-assigned ID of the [loyalty promotion](entity:LoyaltyPromotion).
     */
    public function getLoyaltyPromotionId(): ?string
    {
        return $this->loyaltyPromotionId;
    }

    /**
     * Sets Loyalty Promotion Id.
     * The Square-assigned ID of the [loyalty promotion](entity:LoyaltyPromotion).
     *
     * @maps loyalty_promotion_id
     */
    public function setLoyaltyPromotionId(?string $loyaltyPromotionId): void
    {
        $this->loyaltyPromotionId = $loyaltyPromotionId;
    }

    /**
     * Returns Points.
     * The number of points earned by the event.
     */
    public function getPoints(): int
    {
        return $this->points;
    }

    /**
     * Sets Points.
     * The number of points earned by the event.
     *
     * @required
     * @maps points
     */
    public function setPoints(int $points): void
    {
        $this->points = $points;
    }

    /**
     * Returns Order Id.
     * The ID of the [order](entity:Order) for which the buyer earned the promotion points.
     * Only applications that use the Orders API to process orders can trigger this event.
     */
    public function getOrderId(): string
    {
        return $this->orderId;
    }

    /**
     * Sets Order Id.
     * The ID of the [order](entity:Order) for which the buyer earned the promotion points.
     * Only applications that use the Orders API to process orders can trigger this event.
     *
     * @required
     * @maps order_id
     */
    public function setOrderId(string $orderId): void
    {
        $this->orderId = $orderId;
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
            $json['loyalty_program_id']   = $this->loyaltyProgramId;
        }
        if (isset($this->loyaltyPromotionId)) {
            $json['loyalty_promotion_id'] = $this->loyaltyPromotionId;
        }
        $json['points']                   = $this->points;
        $json['order_id']                 = $this->orderId;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
