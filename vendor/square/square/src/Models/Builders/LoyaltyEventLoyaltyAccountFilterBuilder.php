<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\LoyaltyEventLoyaltyAccountFilter;

/**
 * Builder for model LoyaltyEventLoyaltyAccountFilter
 *
 * @see LoyaltyEventLoyaltyAccountFilter
 */
class LoyaltyEventLoyaltyAccountFilterBuilder
{
    /**
     * @var LoyaltyEventLoyaltyAccountFilter
     */
    private $instance;

    private function __construct(LoyaltyEventLoyaltyAccountFilter $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new loyalty event loyalty account filter Builder object.
     */
    public static function init(string $loyaltyAccountId): self
    {
        return new self(new LoyaltyEventLoyaltyAccountFilter($loyaltyAccountId));
    }

    /**
     * Initializes a new loyalty event loyalty account filter object.
     */
    public function build(): LoyaltyEventLoyaltyAccountFilter
    {
        return CoreHelper::clone($this->instance);
    }
}
