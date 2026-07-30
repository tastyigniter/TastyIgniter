<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\LoyaltyEvent;
use Square\Models\RedeemLoyaltyRewardResponse;

/**
 * Builder for model RedeemLoyaltyRewardResponse
 *
 * @see RedeemLoyaltyRewardResponse
 */
class RedeemLoyaltyRewardResponseBuilder
{
    /**
     * @var RedeemLoyaltyRewardResponse
     */
    private $instance;

    private function __construct(RedeemLoyaltyRewardResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new redeem loyalty reward response Builder object.
     */
    public static function init(): self
    {
        return new self(new RedeemLoyaltyRewardResponse());
    }

    /**
     * Sets errors field.
     */
    public function errors(?array $value): self
    {
        $this->instance->setErrors($value);
        return $this;
    }

    /**
     * Sets event field.
     */
    public function event(?LoyaltyEvent $value): self
    {
        $this->instance->setEvent($value);
        return $this;
    }

    /**
     * Initializes a new redeem loyalty reward response object.
     */
    public function build(): RedeemLoyaltyRewardResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
