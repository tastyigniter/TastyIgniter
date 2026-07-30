<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\LoyaltyEventAccumulatePromotionPoints;

/**
 * Builder for model LoyaltyEventAccumulatePromotionPoints
 *
 * @see LoyaltyEventAccumulatePromotionPoints
 */
class LoyaltyEventAccumulatePromotionPointsBuilder
{
    /**
     * @var LoyaltyEventAccumulatePromotionPoints
     */
    private $instance;

    private function __construct(LoyaltyEventAccumulatePromotionPoints $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new loyalty event accumulate promotion points Builder object.
     */
    public static function init(int $points, string $orderId): self
    {
        return new self(new LoyaltyEventAccumulatePromotionPoints($points, $orderId));
    }

    /**
     * Sets loyalty program id field.
     */
    public function loyaltyProgramId(?string $value): self
    {
        $this->instance->setLoyaltyProgramId($value);
        return $this;
    }

    /**
     * Sets loyalty promotion id field.
     */
    public function loyaltyPromotionId(?string $value): self
    {
        $this->instance->setLoyaltyPromotionId($value);
        return $this;
    }

    /**
     * Initializes a new loyalty event accumulate promotion points object.
     */
    public function build(): LoyaltyEventAccumulatePromotionPoints
    {
        return CoreHelper::clone($this->instance);
    }
}
