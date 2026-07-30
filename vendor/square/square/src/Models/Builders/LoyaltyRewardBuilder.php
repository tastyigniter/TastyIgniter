<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\LoyaltyReward;

/**
 * Builder for model LoyaltyReward
 *
 * @see LoyaltyReward
 */
class LoyaltyRewardBuilder
{
    /**
     * @var LoyaltyReward
     */
    private $instance;

    private function __construct(LoyaltyReward $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new loyalty reward Builder object.
     */
    public static function init(string $loyaltyAccountId, string $rewardTierId): self
    {
        return new self(new LoyaltyReward($loyaltyAccountId, $rewardTierId));
    }

    /**
     * Sets id field.
     */
    public function id(?string $value): self
    {
        $this->instance->setId($value);
        return $this;
    }

    /**
     * Sets status field.
     */
    public function status(?string $value): self
    {
        $this->instance->setStatus($value);
        return $this;
    }

    /**
     * Sets points field.
     */
    public function points(?int $value): self
    {
        $this->instance->setPoints($value);
        return $this;
    }

    /**
     * Sets order id field.
     */
    public function orderId(?string $value): self
    {
        $this->instance->setOrderId($value);
        return $this;
    }

    /**
     * Unsets order id field.
     */
    public function unsetOrderId(): self
    {
        $this->instance->unsetOrderId();
        return $this;
    }

    /**
     * Sets created at field.
     */
    public function createdAt(?string $value): self
    {
        $this->instance->setCreatedAt($value);
        return $this;
    }

    /**
     * Sets updated at field.
     */
    public function updatedAt(?string $value): self
    {
        $this->instance->setUpdatedAt($value);
        return $this;
    }

    /**
     * Sets redeemed at field.
     */
    public function redeemedAt(?string $value): self
    {
        $this->instance->setRedeemedAt($value);
        return $this;
    }

    /**
     * Initializes a new loyalty reward object.
     */
    public function build(): LoyaltyReward
    {
        return CoreHelper::clone($this->instance);
    }
}
