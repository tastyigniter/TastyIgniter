<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Provides information about a loyalty event.
 * For more information, see [Search for Balance-Changing Loyalty Events](https://developer.squareup.
 * com/docs/loyalty-api/loyalty-events).
 */
class LoyaltyEvent implements \JsonSerializable
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $createdAt;

    /**
     * @var LoyaltyEventAccumulatePoints|null
     */
    private $accumulatePoints;

    /**
     * @var LoyaltyEventCreateReward|null
     */
    private $createReward;

    /**
     * @var LoyaltyEventRedeemReward|null
     */
    private $redeemReward;

    /**
     * @var LoyaltyEventDeleteReward|null
     */
    private $deleteReward;

    /**
     * @var LoyaltyEventAdjustPoints|null
     */
    private $adjustPoints;

    /**
     * @var string
     */
    private $loyaltyAccountId;

    /**
     * @var string|null
     */
    private $locationId;

    /**
     * @var string
     */
    private $source;

    /**
     * @var LoyaltyEventExpirePoints|null
     */
    private $expirePoints;

    /**
     * @var LoyaltyEventOther|null
     */
    private $otherEvent;

    /**
     * @var LoyaltyEventAccumulatePromotionPoints|null
     */
    private $accumulatePromotionPoints;

    /**
     * @param string $id
     * @param string $type
     * @param string $createdAt
     * @param string $loyaltyAccountId
     * @param string $source
     */
    public function __construct(string $id, string $type, string $createdAt, string $loyaltyAccountId, string $source)
    {
        $this->id = $id;
        $this->type = $type;
        $this->createdAt = $createdAt;
        $this->loyaltyAccountId = $loyaltyAccountId;
        $this->source = $source;
    }

    /**
     * Returns Id.
     * The Square-assigned ID of the loyalty event.
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Sets Id.
     * The Square-assigned ID of the loyalty event.
     *
     * @required
     * @maps id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * Returns Type.
     * The type of the loyalty event.
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Sets Type.
     * The type of the loyalty event.
     *
     * @required
     * @maps type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * Returns Created At.
     * The timestamp when the event was created, in RFC 3339 format.
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * Sets Created At.
     * The timestamp when the event was created, in RFC 3339 format.
     *
     * @required
     * @maps created_at
     */
    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Returns Accumulate Points.
     * Provides metadata when the event `type` is `ACCUMULATE_POINTS`.
     */
    public function getAccumulatePoints(): ?LoyaltyEventAccumulatePoints
    {
        return $this->accumulatePoints;
    }

    /**
     * Sets Accumulate Points.
     * Provides metadata when the event `type` is `ACCUMULATE_POINTS`.
     *
     * @maps accumulate_points
     */
    public function setAccumulatePoints(?LoyaltyEventAccumulatePoints $accumulatePoints): void
    {
        $this->accumulatePoints = $accumulatePoints;
    }

    /**
     * Returns Create Reward.
     * Provides metadata when the event `type` is `CREATE_REWARD`.
     */
    public function getCreateReward(): ?LoyaltyEventCreateReward
    {
        return $this->createReward;
    }

    /**
     * Sets Create Reward.
     * Provides metadata when the event `type` is `CREATE_REWARD`.
     *
     * @maps create_reward
     */
    public function setCreateReward(?LoyaltyEventCreateReward $createReward): void
    {
        $this->createReward = $createReward;
    }

    /**
     * Returns Redeem Reward.
     * Provides metadata when the event `type` is `REDEEM_REWARD`.
     */
    public function getRedeemReward(): ?LoyaltyEventRedeemReward
    {
        return $this->redeemReward;
    }

    /**
     * Sets Redeem Reward.
     * Provides metadata when the event `type` is `REDEEM_REWARD`.
     *
     * @maps redeem_reward
     */
    public function setRedeemReward(?LoyaltyEventRedeemReward $redeemReward): void
    {
        $this->redeemReward = $redeemReward;
    }

    /**
     * Returns Delete Reward.
     * Provides metadata when the event `type` is `DELETE_REWARD`.
     */
    public function getDeleteReward(): ?LoyaltyEventDeleteReward
    {
        return $this->deleteReward;
    }

    /**
     * Sets Delete Reward.
     * Provides metadata when the event `type` is `DELETE_REWARD`.
     *
     * @maps delete_reward
     */
    public function setDeleteReward(?LoyaltyEventDeleteReward $deleteReward): void
    {
        $this->deleteReward = $deleteReward;
    }

    /**
     * Returns Adjust Points.
     * Provides metadata when the event `type` is `ADJUST_POINTS`.
     */
    public function getAdjustPoints(): ?LoyaltyEventAdjustPoints
    {
        return $this->adjustPoints;
    }

    /**
     * Sets Adjust Points.
     * Provides metadata when the event `type` is `ADJUST_POINTS`.
     *
     * @maps adjust_points
     */
    public function setAdjustPoints(?LoyaltyEventAdjustPoints $adjustPoints): void
    {
        $this->adjustPoints = $adjustPoints;
    }

    /**
     * Returns Loyalty Account Id.
     * The ID of the [loyalty account](entity:LoyaltyAccount) associated with the event.
     */
    public function getLoyaltyAccountId(): string
    {
        return $this->loyaltyAccountId;
    }

    /**
     * Sets Loyalty Account Id.
     * The ID of the [loyalty account](entity:LoyaltyAccount) associated with the event.
     *
     * @required
     * @maps loyalty_account_id
     */
    public function setLoyaltyAccountId(string $loyaltyAccountId): void
    {
        $this->loyaltyAccountId = $loyaltyAccountId;
    }

    /**
     * Returns Location Id.
     * The ID of the [location](entity:Location) where the event occurred.
     */
    public function getLocationId(): ?string
    {
        return $this->locationId;
    }

    /**
     * Sets Location Id.
     * The ID of the [location](entity:Location) where the event occurred.
     *
     * @maps location_id
     */
    public function setLocationId(?string $locationId): void
    {
        $this->locationId = $locationId;
    }

    /**
     * Returns Source.
     * Defines whether the event was generated by the Square Point of Sale.
     */
    public function getSource(): string
    {
        return $this->source;
    }

    /**
     * Sets Source.
     * Defines whether the event was generated by the Square Point of Sale.
     *
     * @required
     * @maps source
     */
    public function setSource(string $source): void
    {
        $this->source = $source;
    }

    /**
     * Returns Expire Points.
     * Provides metadata when the event `type` is `EXPIRE_POINTS`.
     */
    public function getExpirePoints(): ?LoyaltyEventExpirePoints
    {
        return $this->expirePoints;
    }

    /**
     * Sets Expire Points.
     * Provides metadata when the event `type` is `EXPIRE_POINTS`.
     *
     * @maps expire_points
     */
    public function setExpirePoints(?LoyaltyEventExpirePoints $expirePoints): void
    {
        $this->expirePoints = $expirePoints;
    }

    /**
     * Returns Other Event.
     * Provides metadata when the event `type` is `OTHER`.
     */
    public function getOtherEvent(): ?LoyaltyEventOther
    {
        return $this->otherEvent;
    }

    /**
     * Sets Other Event.
     * Provides metadata when the event `type` is `OTHER`.
     *
     * @maps other_event
     */
    public function setOtherEvent(?LoyaltyEventOther $otherEvent): void
    {
        $this->otherEvent = $otherEvent;
    }

    /**
     * Returns Accumulate Promotion Points.
     * Provides metadata when the event `type` is `ACCUMULATE_PROMOTION_POINTS`.
     */
    public function getAccumulatePromotionPoints(): ?LoyaltyEventAccumulatePromotionPoints
    {
        return $this->accumulatePromotionPoints;
    }

    /**
     * Sets Accumulate Promotion Points.
     * Provides metadata when the event `type` is `ACCUMULATE_PROMOTION_POINTS`.
     *
     * @maps accumulate_promotion_points
     */
    public function setAccumulatePromotionPoints(
        ?LoyaltyEventAccumulatePromotionPoints $accumulatePromotionPoints
    ): void {
        $this->accumulatePromotionPoints = $accumulatePromotionPoints;
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
        $json['id']                              = $this->id;
        $json['type']                            = $this->type;
        $json['created_at']                      = $this->createdAt;
        if (isset($this->accumulatePoints)) {
            $json['accumulate_points']           = $this->accumulatePoints;
        }
        if (isset($this->createReward)) {
            $json['create_reward']               = $this->createReward;
        }
        if (isset($this->redeemReward)) {
            $json['redeem_reward']               = $this->redeemReward;
        }
        if (isset($this->deleteReward)) {
            $json['delete_reward']               = $this->deleteReward;
        }
        if (isset($this->adjustPoints)) {
            $json['adjust_points']               = $this->adjustPoints;
        }
        $json['loyalty_account_id']              = $this->loyaltyAccountId;
        if (isset($this->locationId)) {
            $json['location_id']                 = $this->locationId;
        }
        $json['source']                          = $this->source;
        if (isset($this->expirePoints)) {
            $json['expire_points']               = $this->expirePoints;
        }
        if (isset($this->otherEvent)) {
            $json['other_event']                 = $this->otherEvent;
        }
        if (isset($this->accumulatePromotionPoints)) {
            $json['accumulate_promotion_points'] = $this->accumulatePromotionPoints;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
