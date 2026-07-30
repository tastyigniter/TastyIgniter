<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\LoyaltyEventTypeFilter;

/**
 * Builder for model LoyaltyEventTypeFilter
 *
 * @see LoyaltyEventTypeFilter
 */
class LoyaltyEventTypeFilterBuilder
{
    /**
     * @var LoyaltyEventTypeFilter
     */
    private $instance;

    private function __construct(LoyaltyEventTypeFilter $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new loyalty event type filter Builder object.
     */
    public static function init(array $types): self
    {
        return new self(new LoyaltyEventTypeFilter($types));
    }

    /**
     * Initializes a new loyalty event type filter object.
     */
    public function build(): LoyaltyEventTypeFilter
    {
        return CoreHelper::clone($this->instance);
    }
}
