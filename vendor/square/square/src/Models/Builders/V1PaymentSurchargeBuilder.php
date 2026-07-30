<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\V1Money;
use Square\Models\V1PaymentSurcharge;

/**
 * Builder for model V1PaymentSurcharge
 *
 * @see V1PaymentSurcharge
 */
class V1PaymentSurchargeBuilder
{
    /**
     * @var V1PaymentSurcharge
     */
    private $instance;

    private function __construct(V1PaymentSurcharge $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new v1 payment surcharge Builder object.
     */
    public static function init(): self
    {
        return new self(new V1PaymentSurcharge());
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
     * Sets rate field.
     */
    public function rate(?string $value): self
    {
        $this->instance->setRate($value);
        return $this;
    }

    /**
     * Unsets rate field.
     */
    public function unsetRate(): self
    {
        $this->instance->unsetRate();
        return $this;
    }

    /**
     * Sets amount money field.
     */
    public function amountMoney(?V1Money $value): self
    {
        $this->instance->setAmountMoney($value);
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
     * Sets taxable field.
     */
    public function taxable(?bool $value): self
    {
        $this->instance->setTaxable($value);
        return $this;
    }

    /**
     * Unsets taxable field.
     */
    public function unsetTaxable(): self
    {
        $this->instance->unsetTaxable();
        return $this;
    }

    /**
     * Sets taxes field.
     */
    public function taxes(?array $value): self
    {
        $this->instance->setTaxes($value);
        return $this;
    }

    /**
     * Unsets taxes field.
     */
    public function unsetTaxes(): self
    {
        $this->instance->unsetTaxes();
        return $this;
    }

    /**
     * Sets surcharge id field.
     */
    public function surchargeId(?string $value): self
    {
        $this->instance->setSurchargeId($value);
        return $this;
    }

    /**
     * Unsets surcharge id field.
     */
    public function unsetSurchargeId(): self
    {
        $this->instance->unsetSurchargeId();
        return $this;
    }

    /**
     * Initializes a new v1 payment surcharge object.
     */
    public function build(): V1PaymentSurcharge
    {
        return CoreHelper::clone($this->instance);
    }
}
