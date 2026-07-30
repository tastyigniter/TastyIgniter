<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CreateLoyaltyRewardRequest;
use Square\Models\LoyaltyReward;

/**
 * Builder for model CreateLoyaltyRewardRequest
 *
 * @see CreateLoyaltyRewardRequest
 */
class CreateLoyaltyRewardRequestBuilder
{
    /**
     * @var CreateLoyaltyRewardRequest
     */
    private $instance;

    private function __construct(CreateLoyaltyRewardRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new create loyalty reward request Builder object.
     */
    public static function init(LoyaltyReward $reward, string $idempotencyKey): self
    {
        return new self(new CreateLoyaltyRewardRequest($reward, $idempotencyKey));
    }

    /**
     * Initializes a new create loyalty reward request object.
     */
    public function build(): CreateLoyaltyRewardRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
