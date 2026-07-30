<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Money;
use Square\Models\OrderRoundingAdjustment;

/**
 * Builder for model OrderRoundingAdjustment
 *
 * @see OrderRoundingAdjustment
 */
class OrderRoundingAdjustmentBuilder
{
    /**
     * @var OrderRoundingAdjustment
     */
    private $instance;

    private function __construct(OrderRoundingAdjustment $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new order rounding adjustment Builder object.
     */
    public static function init(): self
    {
        return new self(new OrderRoundingAdjustment());
    }

    /**
     * Sets uid field.
     */
    public function uid(?string $value): self
    {
        $this->instance->setUid($value);
        return $this;
    }

    /**
     * Unsets uid field.
     */
    public function unsetUid(): self
    {
        $this->instance->unsetUid();
        return $this;
    }

    /**
     * Sets name field.
     */
    public function name(?string $value): self
    {
        $this->instance->setName($value);
        return $this;
    }

    /**
     * Unsets name field.
     */
    public function unsetName(): self
    {
        $this->instance->unsetName();
        return $this;
    }

    /**
     * Sets amount money field.
     */
    public function amountMoney(?Money $value): self
    {
        $this->instance->setAmountMoney($value);
        return $this;
    }

    /**
     * Initializes a new order rounding adjustment object.
     */
    public function build(): OrderRoundingAdjustment
    {
        return CoreHelper::clone($this->instance);
    }
}
