<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ListLoyaltyPromotionsResponse;

/**
 * Builder for model ListLoyaltyPromotionsResponse
 *
 * @see ListLoyaltyPromotionsResponse
 */
class ListLoyaltyPromotionsResponseBuilder
{
    /**
     * @var ListLoyaltyPromotionsResponse
     */
    private $instance;

    private function __construct(ListLoyaltyPromotionsResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new list loyalty promotions response Builder object.
     */
    public static function init(): self
    {
        return new self(new ListLoyaltyPromotionsResponse());
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
     * Sets loyalty promotions field.
     */
    public function loyaltyPromotions(?array $value): self
    {
        $this->instance->setLoyaltyPromotions($value);
        return $this;
    }

    /**
     * Sets cursor field.
     */
    public function cursor(?string $value): self
    {
        $this->instance->setCursor($value);
        return $this;
    }

    /**
     * Initializes a new list loyalty promotions response object.
     */
    public function build(): ListLoyaltyPromotionsResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
