<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CreateLoyaltyRewardResponse;
use Square\Models\LoyaltyReward;

/**
 * Builder for model CreateLoyaltyRewardResponse
 *
 * @see CreateLoyaltyRewardResponse
 */
class CreateLoyaltyRewardResponseBuilder
{
    /**
     * @var CreateLoyaltyRewardResponse
     */
    private $instance;

    private function __construct(CreateLoyaltyRewardResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new create loyalty reward response Builder object.
     */
    public static function init(): self
    {
        return new self(new CreateLoyaltyRewardResponse());
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
     * Sets reward field.
     */
    public function reward(?LoyaltyReward $value): self
    {
        $this->instance->setReward($value);
        return $this;
    }

    /**
     * Initializes a new create loyalty reward response object.
     */
    public function build(): CreateLoyaltyRewardResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
