<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\RedeemLoyaltyRewardRequest;

/**
 * Builder for model RedeemLoyaltyRewardRequest
 *
 * @see RedeemLoyaltyRewardRequest
 */
class RedeemLoyaltyRewardRequestBuilder
{
    /**
     * @var RedeemLoyaltyRewardRequest
     */
    private $instance;

    private function __construct(RedeemLoyaltyRewardRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new redeem loyalty reward request Builder object.
     */
    public static function init(string $idempotencyKey, string $locationId): self
    {
        return new self(new RedeemLoyaltyRewardRequest($idempotencyKey, $locationId));
    }

    /**
     * Initializes a new redeem loyalty reward request object.
     */
    public function build(): RedeemLoyaltyRewardRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
