<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\LoyaltyPromotionTriggerLimit;

/**
 * Builder for model LoyaltyPromotionTriggerLimit
 *
 * @see LoyaltyPromotionTriggerLimit
 */
class LoyaltyPromotionTriggerLimitBuilder
{
    /**
     * @var LoyaltyPromotionTriggerLimit
     */
    private $instance;

    private function __construct(LoyaltyPromotionTriggerLimit $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new loyalty promotion trigger limit Builder object.
     */
    public static function init(int $times): self
    {
        return new self(new LoyaltyPromotionTriggerLimit($times));
    }

    /**
     * Sets interval field.
     */
    public function interval(?string $value): self
    {
        $this->instance->setInterval($value);
        return $this;
    }

    /**
     * Initializes a new loyalty promotion trigger limit object.
     */
    public function build(): LoyaltyPromotionTriggerLimit
    {
        return CoreHelper::clone($this->instance);
    }
}
