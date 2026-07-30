<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\LoyaltyPromotion;
use Square\Models\RetrieveLoyaltyPromotionResponse;

/**
 * Builder for model RetrieveLoyaltyPromotionResponse
 *
 * @see RetrieveLoyaltyPromotionResponse
 */
class RetrieveLoyaltyPromotionResponseBuilder
{
    /**
     * @var RetrieveLoyaltyPromotionResponse
     */
    private $instance;

    private function __construct(RetrieveLoyaltyPromotionResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new retrieve loyalty promotion response Builder object.
     */
    public static function init(): self
    {
        return new self(new RetrieveLoyaltyPromotionResponse());
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
     * Initializes a new retrieve loyalty promotion response object.
     */
    public function build(): RetrieveLoyaltyPromotionResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
