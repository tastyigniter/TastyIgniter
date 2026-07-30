<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\LoyaltyAccount;
use Square\Models\LoyaltyAccountMapping;

/**
 * Builder for model LoyaltyAccount
 *
 * @see LoyaltyAccount
 */
class LoyaltyAccountBuilder
{
    /**
     * @var LoyaltyAccount
     */
    private $instance;

    private function __construct(LoyaltyAccount $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new loyalty account Builder object.
     */
    public static function init(string $programId): self
    {
        return new self(new LoyaltyAccount($programId));
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
     * Sets balance field.
     */
    public function balance(?int $value): self
    {
        $this->instance->setBalance($value);
        return $this;
    }

    /**
     * Sets lifetime points field.
     */
    public function lifetimePoints(?int $value): self
    {
        $this->instance->setLifetimePoints($value);
        return $this;
    }

    /**
     * Sets customer id field.
     */
    public function customerId(?string $value): self
    {
        $this->instance->setCustomerId($value);
        return $this;
    }

    /**
     * Unsets customer id field.
     */
    public function unsetCustomerId(): self
    {
        $this->instance->unsetCustomerId();
        return $this;
    }

    /**
     * Sets enrolled at field.
     */
    public function enrolledAt(?string $value): self
    {
        $this->instance->setEnrolledAt($value);
        return $this;
    }

    /**
     * Unsets enrolled at field.
     */
    public function unsetEnrolledAt(): self
    {
        $this->instance->unsetEnrolledAt();
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
     * Sets mapping field.
     */
    public function mapping(?LoyaltyAccountMapping $value): self
    {
        $this->instance->setMapping($value);
        return $this;
    }

    /**
     * Sets expiring point deadlines field.
     */
    public function expiringPointDeadlines(?array $value): self
    {
        $this->instance->setExpiringPointDeadlines($value);
        return $this;
    }

    /**
     * Unsets expiring point deadlines field.
     */
    public function unsetExpiringPointDeadlines(): self
    {
        $this->instance->unsetExpiringPointDeadlines();
        return $this;
    }

    /**
     * Initializes a new loyalty account object.
     */
    public function build(): LoyaltyAccount
    {
        return CoreHelper::clone($this->instance);
    }
}
