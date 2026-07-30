<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\LoyaltyAccountExpiringPointDeadline;

/**
 * Builder for model LoyaltyAccountExpiringPointDeadline
 *
 * @see LoyaltyAccountExpiringPointDeadline
 */
class LoyaltyAccountExpiringPointDeadlineBuilder
{
    /**
     * @var LoyaltyAccountExpiringPointDeadline
     */
    private $instance;

    private function __construct(LoyaltyAccountExpiringPointDeadline $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new loyalty account expiring point deadline Builder object.
     */
    public static function init(int $points, string $expiresAt): self
    {
        return new self(new LoyaltyAccountExpiringPointDeadline($points, $expiresAt));
    }

    /**
     * Initializes a new loyalty account expiring point deadline object.
     */
    public function build(): LoyaltyAccountExpiringPointDeadline
    {
        return CoreHelper::clone($this->instance);
    }
}
