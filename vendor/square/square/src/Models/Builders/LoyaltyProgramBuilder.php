<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\LoyaltyProgram;
use Square\Models\LoyaltyProgramExpirationPolicy;
use Square\Models\LoyaltyProgramTerminology;

/**
 * Builder for model LoyaltyProgram
 *
 * @see LoyaltyProgram
 */
class LoyaltyProgramBuilder
{
    /**
     * @var LoyaltyProgram
     */
    private $instance;

    private function __construct(LoyaltyProgram $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new loyalty program Builder object.
     */
    public static function init(): self
    {
        return new self(new LoyaltyProgram());
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
     * Sets reward tiers field.
     */
    public function rewardTiers(?array $value): self
    {
        $this->instance->setRewardTiers($value);
        return $this;
    }

    /**
     * Unsets reward tiers field.
     */
    public function unsetRewardTiers(): self
    {
        $this->instance->unsetRewardTiers();
        return $this;
    }

    /**
     * Sets expiration policy field.
     */
    public function expirationPolicy(?LoyaltyProgramExpirationPolicy $value): self
    {
        $this->instance->setExpirationPolicy($value);
        return $this;
    }

    /**
     * Sets terminology field.
     */
    public function terminology(?LoyaltyProgramTerminology $value): self
    {
        $this->instance->setTerminology($value);
        return $this;
    }

    /**
     * Sets location ids field.
     */
    public function locationIds(?array $value): self
    {
        $this->instance->setLocationIds($value);
        return $this;
    }

    /**
     * Unsets location ids field.
     */
    public function unsetLocationIds(): self
    {
        $this->instance->unsetLocationIds();
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
     * Sets accrual rules field.
     */
    public function accrualRules(?array $value): self
    {
        $this->instance->setAccrualRules($value);
        return $this;
    }

    /**
     * Unsets accrual rules field.
     */
    public function unsetAccrualRules(): self
    {
        $this->instance->unsetAccrualRules();
        return $this;
    }

    /**
     * Initializes a new loyalty program object.
     */
    public function build(): LoyaltyProgram
    {
        return CoreHelper::clone($this->instance);
    }
}
