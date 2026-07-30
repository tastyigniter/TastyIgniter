<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\LoyaltyEventExpirePoints;

/**
 * Builder for model LoyaltyEventExpirePoints
 *
 * @see LoyaltyEventExpirePoints
 */
class LoyaltyEventExpirePointsBuilder
{
    /**
     * @var LoyaltyEventExpirePoints
     */
    private $instance;

    private function __construct(LoyaltyEventExpirePoints $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new loyalty event expire points Builder object.
     */
    public static function init(string $loyaltyProgramId, int $points): self
    {
        return new self(new LoyaltyEventExpirePoints($loyaltyProgramId, $points));
    }

    /**
     * Initializes a new loyalty event expire points object.
     */
    public function build(): LoyaltyEventExpirePoints
    {
        return CoreHelper::clone($this->instance);
    }
}
