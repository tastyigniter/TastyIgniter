<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CancelLoyaltyPromotionResponse;
use Square\Models\LoyaltyPromotion;

/**
 * Builder for model CancelLoyaltyPromotionResponse
 *
 * @see CancelLoyaltyPromotionResponse
 */
class CancelLoyaltyPromotionResponseBuilder
{
    /**
     * @var CancelLoyaltyPromotionResponse
     */
    private $instance;

    private function __construct(CancelLoyaltyPromotionResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new cancel loyalty promotion response Builder object.
     */
    public static function init(): self
    {
        return new self(new CancelLoyaltyPromotionResponse());
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
     * Initializes a new cancel loyalty promotion response object.
     */
    public function build(): CancelLoyaltyPromotionResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
