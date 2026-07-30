<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\V1Money;
use Square\Models\V1PaymentDiscount;

/**
 * Builder for model V1PaymentDiscount
 *
 * @see V1PaymentDiscount
 */
class V1PaymentDiscountBuilder
{
    /**
     * @var V1PaymentDiscount
     */
    private $instance;

    private function __construct(V1PaymentDiscount $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new v1 payment discount Builder object.
     */
    public static function init(): self
    {
        return new self(new V1PaymentDiscount());
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
     * Sets applied money field.
     */
    public function appliedMoney(?V1Money $value): self
    {
        $this->instance->setAppliedMoney($value);
        return $this;
    }

    /**
     * Sets discount id field.
     */
    public function discountId(?string $value): self
    {
        $this->instance->setDiscountId($value);
        return $this;
    }

    /**
     * Unsets discount id field.
     */
    public function unsetDiscountId(): self
    {
        $this->instance->unsetDiscountId();
        return $this;
    }

    /**
     * Initializes a new v1 payment discount object.
     */
    public function build(): V1PaymentDiscount
    {
        return CoreHelper::clone($this->instance);
    }
}
