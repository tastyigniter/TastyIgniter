<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Provides metadata when the event `type` is `REDEEM_REWARD`.
 */
class LoyaltyEventRedeemReward implements \JsonSerializable
{
    /**
     * @var string
     */
    private $loyaltyProgramId;

    /**
     * @var string|null
     */
    private $rewardId;

    /**
     * @var string|null
     */
    private $orderId;

    /**
     * @param string $loyaltyProgramId
     */
    public function __construct(string $loyaltyProgramId)
    {
        $this->loyaltyProgramId = $loyaltyProgramId;
    }

    /**
     * Returns Loyalty Program Id.
     * The ID of the [loyalty program](entity:LoyaltyProgram).
     */
    public function getLoyaltyProgramId(): string
    {
        return $this->loyaltyProgramId;
    }

    /**
     * Sets Loyalty Program Id.
     * The ID of the [loyalty program](entity:LoyaltyProgram).
     *
     * @required
     * @maps loyalty_program_id
     */
    public function setLoyaltyProgramId(string $loyaltyProgramId): void
    {
        $this->loyaltyProgramId = $loyaltyProgramId;
    }

    /**
     * Returns Reward Id.
     * The ID of the redeemed [loyalty reward](entity:LoyaltyReward).
     * This field is returned only if the event source is `LOYALTY_API`.
     */
    public function getRewardId(): ?string
    {
        return $this->rewardId;
    }

    /**
     * Sets Reward Id.
     * The ID of the redeemed [loyalty reward](entity:LoyaltyReward).
     * This field is returned only if the event source is `LOYALTY_API`.
     *
     * @maps reward_id
     */
    public function setRewardId(?string $rewardId): void
    {
        $this->rewardId = $rewardId;
    }

    /**
     * Returns Order Id.
     * The ID of the [order](entity:Order) that redeemed the reward.
     * This field is returned only if the Orders API is used to process orders.
     */
    public function getOrderId(): ?string
    {
        return $this->orderId;
    }

    /**
     * Sets Order Id.
     * The ID of the [order](entity:Order) that redeemed the reward.
     * This field is returned only if the Orders API is used to process orders.
     *
     * @maps order_id
     */
    public function setOrderId(?string $orderId): void
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
        $json['loyalty_program_id'] = $this->loyaltyProgramId;
        if (isset($this->rewardId)) {
            $json['reward_id']      = $this->rewardId;
        }
        if (isset($this->orderId)) {
            $json['order_id']       = $this->orderId;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
