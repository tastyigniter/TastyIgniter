<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\LoyaltyEventDateTimeFilter;
use Square\Models\TimeRange;

/**
 * Builder for model LoyaltyEventDateTimeFilter
 *
 * @see LoyaltyEventDateTimeFilter
 */
class LoyaltyEventDateTimeFilterBuilder
{
    /**
     * @var LoyaltyEventDateTimeFilter
     */
    private $instance;

    private function __construct(LoyaltyEventDateTimeFilter $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new loyalty event date time filter Builder object.
     */
    public static function init(TimeRange $createdAt): self
    {
        return new self(new LoyaltyEventDateTimeFilter($createdAt));
    }

    /**
     * Initializes a new loyalty event date time filter object.
     */
    public function build(): LoyaltyEventDateTimeFilter
    {
        return CoreHelper::clone($this->instance);
    }
}
