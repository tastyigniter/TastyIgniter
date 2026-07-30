<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\LoyaltyReward;
use Square\Models\RetrieveLoyaltyRewardResponse;

/**
 * Builder for model RetrieveLoyaltyRewardResponse
 *
 * @see RetrieveLoyaltyRewardResponse
 */
class RetrieveLoyaltyRewardResponseBuilder
{
    /**
     * @var RetrieveLoyaltyRewardResponse
     */
    private $instance;

    private function __construct(RetrieveLoyaltyRewardResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new retrieve loyalty reward response Builder object.
     */
    public static function init(): self
    {
        return new self(new RetrieveLoyaltyRewardResponse());
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
     * Initializes a new retrieve loyalty reward response object.
     */
    public function build(): RetrieveLoyaltyRewardResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
