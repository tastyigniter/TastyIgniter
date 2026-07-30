<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\LoyaltyEventCreateReward;

/**
 * Builder for model LoyaltyEventCreateReward
 *
 * @see LoyaltyEventCreateReward
 */
class LoyaltyEventCreateRewardBuilder
{
    /**
     * @var LoyaltyEventCreateReward
     */
    private $instance;

    private function __construct(LoyaltyEventCreateReward $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new loyalty event create reward Builder object.
     */
    public static function init(string $loyaltyProgramId, int $points): self
    {
        return new self(new LoyaltyEventCreateReward($loyaltyProgramId, $points));
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
     * Initializes a new loyalty event create reward object.
     */
    public function build(): LoyaltyEventCreateReward
    {
        return CoreHelper::clone($this->instance);
    }
}
