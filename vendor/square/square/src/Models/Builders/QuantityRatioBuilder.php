<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\QuantityRatio;

/**
 * Builder for model QuantityRatio
 *
 * @see QuantityRatio
 */
class QuantityRatioBuilder
{
    /**
     * @var QuantityRatio
     */
    private $instance;

    private function __construct(QuantityRatio $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new quantity ratio Builder object.
     */
    public static function init(): self
    {
        return new self(new QuantityRatio());
    }

    /**
     * Sets quantity field.
     */
    public function quantity(?int $value): self
    {
        $this->instance->setQuantity($value);
        return $this;
    }

    /**
     * Unsets quantity field.
     */
    public function unsetQuantity(): self
    {
        $this->instance->unsetQuantity();
        return $this;
    }

    /**
     * Sets quantity denominator field.
     */
    public function quantityDenominator(?int $value): self
    {
        $this->instance->setQuantityDenominator($value);
        return $this;
    }

    /**
     * Unsets quantity denominator field.
     */
    public function unsetQuantityDenominator(): self
    {
        $this->instance->unsetQuantityDenominator();
        return $this;
    }

    /**
     * Initializes a new quantity ratio object.
     */
    public function build(): QuantityRatio
    {
        return CoreHelper::clone($this->instance);
    }
}
