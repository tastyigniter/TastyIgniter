<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\LoyaltyEventOrderFilter;

/**
 * Builder for model LoyaltyEventOrderFilter
 *
 * @see LoyaltyEventOrderFilter
 */
class LoyaltyEventOrderFilterBuilder
{
    /**
     * @var LoyaltyEventOrderFilter
     */
    private $instance;

    private function __construct(LoyaltyEventOrderFilter $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new loyalty event order filter Builder object.
     */
    public static function init(string $orderId): self
    {
        return new self(new LoyaltyEventOrderFilter($orderId));
    }

    /**
     * Initializes a new loyalty event order filter object.
     */
    public function build(): LoyaltyEventOrderFilter
    {
        return CoreHelper::clone($this->instance);
    }
}
