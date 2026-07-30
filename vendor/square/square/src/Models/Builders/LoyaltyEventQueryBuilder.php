<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\LoyaltyEventFilter;
use Square\Models\LoyaltyEventQuery;

/**
 * Builder for model LoyaltyEventQuery
 *
 * @see LoyaltyEventQuery
 */
class LoyaltyEventQueryBuilder
{
    /**
     * @var LoyaltyEventQuery
     */
    private $instance;

    private function __construct(LoyaltyEventQuery $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new loyalty event query Builder object.
     */
    public static function init(): self
    {
        return new self(new LoyaltyEventQuery());
    }

    /**
     * Sets filter field.
     */
    public function filter(?LoyaltyEventFilter $value): self
    {
        $this->instance->setFilter($value);
        return $this;
    }

    /**
     * Initializes a new loyalty event query object.
     */
    public function build(): LoyaltyEventQuery
    {
        return CoreHelper::clone($this->instance);
    }
}
