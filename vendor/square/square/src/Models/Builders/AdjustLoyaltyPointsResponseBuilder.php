<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\AdjustLoyaltyPointsResponse;
use Square\Models\LoyaltyEvent;

/**
 * Builder for model AdjustLoyaltyPointsResponse
 *
 * @see AdjustLoyaltyPointsResponse
 */
class AdjustLoyaltyPointsResponseBuilder
{
    /**
     * @var AdjustLoyaltyPointsResponse
     */
    private $instance;

    private function __construct(AdjustLoyaltyPointsResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new adjust loyalty points response Builder object.
     */
    public static function init(): self
    {
        return new self(new AdjustLoyaltyPointsResponse());
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
     * Initializes a new adjust loyalty points response object.
     */
    public function build(): AdjustLoyaltyPointsResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
