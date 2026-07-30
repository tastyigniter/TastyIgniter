<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\LoyaltyEventDeleteReward;

/**
 * Builder for model LoyaltyEventDeleteReward
 *
 * @see LoyaltyEventDeleteReward
 */
class LoyaltyEventDeleteRewardBuilder
{
    /**
     * @var LoyaltyEventDeleteReward
     */
    private $instance;

    private function __construct(LoyaltyEventDeleteReward $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new loyalty event delete reward Builder object.
     */
    public static function init(string $loyaltyProgramId, int $points): self
    {
        return new self(new LoyaltyEventDeleteReward($loyaltyProgramId, $points));
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
     * Initializes a new loyalty event delete reward object.
     */
    public function build(): LoyaltyEventDeleteReward
    {
        return CoreHelper::clone($this->instance);
    }
}
