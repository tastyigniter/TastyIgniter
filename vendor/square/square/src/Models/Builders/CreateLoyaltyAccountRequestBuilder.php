<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CreateLoyaltyAccountRequest;
use Square\Models\LoyaltyAccount;

/**
 * Builder for model CreateLoyaltyAccountRequest
 *
 * @see CreateLoyaltyAccountRequest
 */
class CreateLoyaltyAccountRequestBuilder
{
    /**
     * @var CreateLoyaltyAccountRequest
     */
    private $instance;

    private function __construct(CreateLoyaltyAccountRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new create loyalty account request Builder object.
     */
    public static function init(LoyaltyAccount $loyaltyAccount, string $idempotencyKey): self
    {
        return new self(new CreateLoyaltyAccountRequest($loyaltyAccount, $idempotencyKey));
    }

    /**
     * Initializes a new create loyalty account request object.
     */
    public function build(): CreateLoyaltyAccountRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
