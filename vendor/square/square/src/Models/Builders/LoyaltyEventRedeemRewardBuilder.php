<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\LoyaltyEventRedeemReward;

/**
 * Builder for model LoyaltyEventRedeemReward
 *
 * @see LoyaltyEventRedeemReward
 */
class LoyaltyEventRedeemRewardBuilder
{
    /**
     * @var LoyaltyEventRedeemReward
     */
    private $instance;

    private function __construct(LoyaltyEventRedeemReward $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new loyalty event redeem reward Builder object.
     */
    public static function init(string $loyaltyProgramId): self
    {
        return new self(new LoyaltyEventRedeemReward($loyaltyProgramId));
    }

    /**
     * Sets reward id field.
     */
    public function rewardId(?string $value): self
    {
        $this->instance->setRewardId($value);
        return $this;
    }

    /**
     * Sets order id field.
     */
    public function orderId(?string $value): self
    {
        $this->instance->setOrderId($value);
        return $this;
    }

    /**
     * Initializes a new loyalty event redeem reward object.
     */
    public function build(): LoyaltyEventRedeemReward
    {
        return CoreHelper::clone($this->instance);
    }
}
