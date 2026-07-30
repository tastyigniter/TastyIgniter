<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Money;

/**
 * Builder for model Money
 *
 * @see Money
 */
class MoneyBuilder
{
    /**
     * @var Money
     */
    private $instance;

    private function __construct(Money $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new money Builder object.
     */
    public static function init(): self
    {
        return new self(new Money());
    }

    /**
     * Sets amount field.
     */
    public function amount(?int $value): self
    {
        $this->instance->setAmount($value);
        return $this;
    }

    /**
     * Unsets amount field.
     */
    public function unsetAmount(): self
    {
        $this->instance->unsetAmount();
        return $this;
    }

    /**
     * Sets currency field.
     */
    public function currency(?string $value): self
    {
        $this->instance->setCurrency($value);
        return $this;
    }

    /**
     * Initializes a new money object.
     */
    public function build(): Money
    {
        return CoreHelper::clone($this->instance);
    }
}
