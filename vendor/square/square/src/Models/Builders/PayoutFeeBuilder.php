<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Money;
use Square\Models\PayoutFee;

/**
 * Builder for model PayoutFee
 *
 * @see PayoutFee
 */
class PayoutFeeBuilder
{
    /**
     * @var PayoutFee
     */
    private $instance;

    private function __construct(PayoutFee $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new payout fee Builder object.
     */
    public static function init(): self
    {
        return new self(new PayoutFee());
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
     * Sets effective at field.
     */
    public function effectiveAt(?string $value): self
    {
        $this->instance->setEffectiveAt($value);
        return $this;
    }

    /**
     * Unsets effective at field.
     */
    public function unsetEffectiveAt(): self
    {
        $this->instance->unsetEffectiveAt();
        return $this;
    }

    /**
     * Sets type field.
     */
    public function type(?string $value): self
    {
        $this->instance->setType($value);
        return $this;
    }

    /**
     * Initializes a new payout fee object.
     */
    public function build(): PayoutFee
    {
        return CoreHelper::clone($this->instance);
    }
}
