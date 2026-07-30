<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\LoyaltyPromotionIncentivePointsAdditionData;

/**
 * Builder for model LoyaltyPromotionIncentivePointsAdditionData
 *
 * @see LoyaltyPromotionIncentivePointsAdditionData
 */
class LoyaltyPromotionIncentivePointsAdditionDataBuilder
{
    /**
     * @var LoyaltyPromotionIncentivePointsAdditionData
     */
    private $instance;

    private function __construct(LoyaltyPromotionIncentivePointsAdditionData $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new loyalty promotion incentive points addition data Builder object.
     */
    public static function init(int $pointsAddition): self
    {
        return new self(new LoyaltyPromotionIncentivePointsAdditionData($pointsAddition));
    }

    /**
     * Initializes a new loyalty promotion incentive points addition data object.
     */
    public function build(): LoyaltyPromotionIncentivePointsAdditionData
    {
        return CoreHelper::clone($this->instance);
    }
}
