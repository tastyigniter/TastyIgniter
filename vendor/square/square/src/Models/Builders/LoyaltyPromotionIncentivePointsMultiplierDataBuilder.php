<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\LoyaltyPromotionIncentivePointsMultiplierData;

/**
 * Builder for model LoyaltyPromotionIncentivePointsMultiplierData
 *
 * @see LoyaltyPromotionIncentivePointsMultiplierData
 */
class LoyaltyPromotionIncentivePointsMultiplierDataBuilder
{
    /**
     * @var LoyaltyPromotionIncentivePointsMultiplierData
     */
    private $instance;

    private function __construct(LoyaltyPromotionIncentivePointsMultiplierData $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new loyalty promotion incentive points multiplier data Builder object.
     */
    public static function init(int $pointsMultiplier): self
    {
        return new self(new LoyaltyPromotionIncentivePointsMultiplierData($pointsMultiplier));
    }

    /**
     * Initializes a new loyalty promotion incentive points multiplier data object.
     */
    public function build(): LoyaltyPromotionIncentivePointsMultiplierData
    {
        return CoreHelper::clone($this->instance);
    }
}
