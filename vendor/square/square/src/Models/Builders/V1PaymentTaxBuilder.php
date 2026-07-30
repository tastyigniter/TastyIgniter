<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\V1Money;
use Square\Models\V1PaymentTax;

/**
 * Builder for model V1PaymentTax
 *
 * @see V1PaymentTax
 */
class V1PaymentTaxBuilder
{
    /**
     * @var V1PaymentTax
     */
    private $instance;

    private function __construct(V1PaymentTax $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new v1 payment tax Builder object.
     */
    public static function init(): self
    {
        return new self(new V1PaymentTax());
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
     * Unsets errors field.
     */
    public function unsetErrors(): self
    {
        $this->instance->unsetErrors();
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
     * Sets inclusion type field.
     */
    public function inclusionType(?string $value): self
    {
        $this->instance->setInclusionType($value);
        return $this;
    }

    /**
     * Sets fee id field.
     */
    public function feeId(?string $value): self
    {
        $this->instance->setFeeId($value);
        return $this;
    }

    /**
     * Unsets fee id field.
     */
    public function unsetFeeId(): self
    {
        $this->instance->unsetFeeId();
        return $this;
    }

    /**
     * Initializes a new v1 payment tax object.
     */
    public function build(): V1PaymentTax
    {
        return CoreHelper::clone($this->instance);
    }
}
