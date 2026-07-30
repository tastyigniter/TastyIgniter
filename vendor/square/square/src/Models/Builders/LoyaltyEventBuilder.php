<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\LoyaltyEvent;
use Square\Models\LoyaltyEventAccumulatePoints;
use Square\Models\LoyaltyEventAccumulatePromotionPoints;
use Square\Models\LoyaltyEventAdjustPoints;
use Square\Models\LoyaltyEventCreateReward;
use Square\Models\LoyaltyEventDeleteReward;
use Square\Models\LoyaltyEventExpirePoints;
use Square\Models\LoyaltyEventOther;
use Square\Models\LoyaltyEventRedeemReward;

/**
 * Builder for model LoyaltyEvent
 *
 * @see LoyaltyEvent
 */
class LoyaltyEventBuilder
{
    /**
     * @var LoyaltyEvent
     */
    private $instance;

    private function __construct(LoyaltyEvent $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new loyalty event Builder object.
     */
    public static function init(
        string $id,
        string $type,
        string $createdAt,
        string $loyaltyAccountId,
        string $source
    ): self {
        return new self(new LoyaltyEvent($id, $type, $createdAt, $loyaltyAccountId, $source));
    }

    /**
     * Sets accumulate points field.
     */
    public function accumulatePoints(?LoyaltyEventAccumulatePoints $value): self
    {
        $this->instance->setAccumulatePoints($value);
        return $this;
    }

    /**
     * Sets create reward field.
     */
    public function createReward(?LoyaltyEventCreateReward $value): self
    {
        $this->instance->setCreateReward($value);
        return $this;
    }

    /**
     * Sets redeem reward field.
     */
    public function redeemReward(?LoyaltyEventRedeemReward $value): self
    {
        $this->instance->setRedeemReward($value);
        return $this;
    }

    /**
     * Sets delete reward field.
     */
    public function deleteReward(?LoyaltyEventDeleteReward $value): self
    {
        $this->instance->setDeleteReward($value);
        return $this;
    }

    /**
     * Sets adjust points field.
     */
    public function adjustPoints(?LoyaltyEventAdjustPoints $value): self
    {
        $this->instance->setAdjustPoints($value);
        return $this;
    }

    /**
     * Sets location id field.
     */
    public function locationId(?string $value): self
    {
        $this->instance->setLocationId($value);
        return $this;
    }

    /**
     * Sets expire points field.
     */
    public function expirePoints(?LoyaltyEventExpirePoints $value): self
    {
        $this->instance->setExpirePoints($value);
        return $this;
    }

    /**
     * Sets other event field.
     */
    public function otherEvent(?LoyaltyEventOther $value): self
    {
        $this->instance->setOtherEvent($value);
        return $this;
    }

    /**
     * Sets accumulate promotion points field.
     */
    public function accumulatePromotionPoints(?LoyaltyEventAccumulatePromotionPoints $value): self
    {
        $this->instance->setAccumulatePromotionPoints($value);
        return $this;
    }

    /**
     * Initializes a new loyalty event object.
     */
    public function build(): LoyaltyEvent
    {
        return CoreHelper::clone($this->instance);
    }
}
