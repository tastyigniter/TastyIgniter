<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\LoyaltyPromotionIncentive;
use Square\Models\LoyaltyPromotionIncentivePointsAdditionData;
use Square\Models\LoyaltyPromotionIncentivePointsMultiplierData;

/**
 * Builder for model LoyaltyPromotionIncentive
 *
 * @see LoyaltyPromotionIncentive
 */
class LoyaltyPromotionIncentiveBuilder
{
    /**
     * @var LoyaltyPromotionIncentive
     */
    private $instance;

    private function __construct(LoyaltyPromotionIncentive $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new loyalty promotion incentive Builder object.
     */
    public static function init(string $type): self
    {
        return new self(new LoyaltyPromotionIncentive($type));
    }

    /**
     * Sets points multiplier data field.
     */
    public function pointsMultiplierData(?LoyaltyPromotionIncentivePointsMultiplierData $value): self
    {
        $this->instance->setPointsMultiplierData($value);
        return $this;
    }

    /**
     * Sets points addition data field.
     */
    public function pointsAdditionData(?LoyaltyPromotionIncentivePointsAdditionData $value): self
    {
        $this->instance->setPointsAdditionData($value);
        return $this;
    }

    /**
     * Initializes a new loyalty promotion incentive object.
     */
    public function build(): LoyaltyPromotionIncentive
    {
        return CoreHelper::clone($this->instance);
    }
}
