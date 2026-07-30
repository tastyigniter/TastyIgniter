<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\LoyaltyProgramExpirationPolicy;

/**
 * Builder for model LoyaltyProgramExpirationPolicy
 *
 * @see LoyaltyProgramExpirationPolicy
 */
class LoyaltyProgramExpirationPolicyBuilder
{
    /**
     * @var LoyaltyProgramExpirationPolicy
     */
    private $instance;

    private function __construct(LoyaltyProgramExpirationPolicy $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new loyalty program expiration policy Builder object.
     */
    public static function init(string $expirationDuration): self
    {
        return new self(new LoyaltyProgramExpirationPolicy($expirationDuration));
    }

    /**
     * Initializes a new loyalty program expiration policy object.
     */
    public function build(): LoyaltyProgramExpirationPolicy
    {
        return CoreHelper::clone($this->instance);
    }
}
