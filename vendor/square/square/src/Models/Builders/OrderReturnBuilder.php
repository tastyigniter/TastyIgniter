<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\OrderMoneyAmounts;
use Square\Models\OrderReturn;
use Square\Models\OrderRoundingAdjustment;

/**
 * Builder for model OrderReturn
 *
 * @see OrderReturn
 */
class OrderReturnBuilder
{
    /**
     * @var OrderReturn
     */
    private $instance;

    private function __construct(OrderReturn $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new order return Builder object.
     */
    public static function init(): self
    {
        return new self(new OrderReturn());
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
     * Sets source order id field.
     */
    public function sourceOrderId(?string $value): self
    {
        $this->instance->setSourceOrderId($value);
        return $this;
    }

    /**
     * Unsets source order id field.
     */
    public function unsetSourceOrderId(): self
    {
        $this->instance->unsetSourceOrderId();
        return $this;
    }

    /**
     * Sets return line items field.
     */
    public function returnLineItems(?array $value): self
    {
        $this->instance->setReturnLineItems($value);
        return $this;
    }

    /**
     * Unsets return line items field.
     */
    public function unsetReturnLineItems(): self
    {
        $this->instance->unsetReturnLineItems();
        return $this;
    }

    /**
     * Sets return service charges field.
     */
    public function returnServiceCharges(?array $value): self
    {
        $this->instance->setReturnServiceCharges($value);
        return $this;
    }

    /**
     * Sets return taxes field.
     */
    public function returnTaxes(?array $value): self
    {
        $this->instance->setReturnTaxes($value);
        return $this;
    }

    /**
     * Unsets return taxes field.
     */
    public function unsetReturnTaxes(): self
    {
        $this->instance->unsetReturnTaxes();
        return $this;
    }

    /**
     * Sets return discounts field.
     */
    public function returnDiscounts(?array $value): self
    {
        $this->instance->setReturnDiscounts($value);
        return $this;
    }

    /**
     * Unsets return discounts field.
     */
    public function unsetReturnDiscounts(): self
    {
        $this->instance->unsetReturnDiscounts();
        return $this;
    }

    /**
     * Sets rounding adjustment field.
     */
    public function roundingAdjustment(?OrderRoundingAdjustment $value): self
    {
        $this->instance->setRoundingAdjustment($value);
        return $this;
    }

    /**
     * Sets return amounts field.
     */
    public function returnAmounts(?OrderMoneyAmounts $value): self
    {
        $this->instance->setReturnAmounts($value);
        return $this;
    }

    /**
     * Initializes a new order return object.
     */
    public function build(): OrderReturn
    {
        return CoreHelper::clone($this->instance);
    }
}
