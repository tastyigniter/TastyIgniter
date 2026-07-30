<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CalculateLoyaltyPointsResponse;

/**
 * Builder for model CalculateLoyaltyPointsResponse
 *
 * @see CalculateLoyaltyPointsResponse
 */
class CalculateLoyaltyPointsResponseBuilder
{
    /**
     * @var CalculateLoyaltyPointsResponse
     */
    private $instance;

    private function __construct(CalculateLoyaltyPointsResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new calculate loyalty points response Builder object.
     */
    public static function init(): self
    {
        return new self(new CalculateLoyaltyPointsResponse());
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
     * Sets points field.
     */
    public function points(?int $value): self
    {
        $this->instance->setPoints($value);
        return $this;
    }

    /**
     * Sets promotion points field.
     */
    public function promotionPoints(?int $value): self
    {
        $this->instance->setPromotionPoints($value);
        return $this;
    }

    /**
     * Initializes a new calculate loyalty points response object.
     */
    public function build(): CalculateLoyaltyPointsResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
