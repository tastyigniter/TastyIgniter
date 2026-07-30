<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Money;
use Square\Models\OrderMoneyAmounts;

/**
 * Builder for model OrderMoneyAmounts
 *
 * @see OrderMoneyAmounts
 */
class OrderMoneyAmountsBuilder
{
    /**
     * @var OrderMoneyAmounts
     */
    private $instance;

    private function __construct(OrderMoneyAmounts $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new order money amounts Builder object.
     */
    public static function init(): self
    {
        return new self(new OrderMoneyAmounts());
    }

    /**
     * Sets total money field.
     */
    public function totalMoney(?Money $value): self
    {
        $this->instance->setTotalMoney($value);
        return $this;
    }

    /**
     * Sets tax money field.
     */
    public function taxMoney(?Money $value): self
    {
        $this->instance->setTaxMoney($value);
        return $this;
    }

    /**
     * Sets discount money field.
     */
    public function discountMoney(?Money $value): self
    {
        $this->instance->setDiscountMoney($value);
        return $this;
    }

    /**
     * Sets tip money field.
     */
    public function tipMoney(?Money $value): self
    {
        $this->instance->setTipMoney($value);
        return $this;
    }

    /**
     * Sets service charge money field.
     */
    public function serviceChargeMoney(?Money $value): self
    {
        $this->instance->setServiceChargeMoney($value);
        return $this;
    }

    /**
     * Initializes a new order money amounts object.
     */
    public function build(): OrderMoneyAmounts
    {
        return CoreHelper::clone($this->instance);
    }
}
