<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\LoyaltyEventLocationFilter;

/**
 * Builder for model LoyaltyEventLocationFilter
 *
 * @see LoyaltyEventLocationFilter
 */
class LoyaltyEventLocationFilterBuilder
{
    /**
     * @var LoyaltyEventLocationFilter
     */
    private $instance;

    private function __construct(LoyaltyEventLocationFilter $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new loyalty event location filter Builder object.
     */
    public static function init(array $locationIds): self
    {
        return new self(new LoyaltyEventLocationFilter($locationIds));
    }

    /**
     * Initializes a new loyalty event location filter object.
     */
    public function build(): LoyaltyEventLocationFilter
    {
        return CoreHelper::clone($this->instance);
    }
}
