<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CreateLoyaltyPromotionResponse;
use Square\Models\LoyaltyPromotion;

/**
 * Builder for model CreateLoyaltyPromotionResponse
 *
 * @see CreateLoyaltyPromotionResponse
 */
class CreateLoyaltyPromotionResponseBuilder
{
    /**
     * @var CreateLoyaltyPromotionResponse
     */
    private $instance;

    private function __construct(CreateLoyaltyPromotionResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new create loyalty promotion response Builder object.
     */
    public static function init(): self
    {
        return new self(new CreateLoyaltyPromotionResponse());
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
     * Sets loyalty promotion field.
     */
    public function loyaltyPromotion(?LoyaltyPromotion $value): self
    {
        $this->instance->setLoyaltyPromotion($value);
        return $this;
    }

    /**
     * Initializes a new create loyalty promotion response object.
     */
    public function build(): CreateLoyaltyPromotionResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
