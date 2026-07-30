<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\V1Money;

/**
 * Builder for model V1Money
 *
 * @see V1Money
 */
class V1MoneyBuilder
{
    /**
     * @var V1Money
     */
    private $instance;

    private function __construct(V1Money $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new v1 money Builder object.
     */
    public static function init(): self
    {
        return new self(new V1Money());
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
     * Sets currency code field.
     */
    public function currencyCode(?string $value): self
    {
        $this->instance->setCurrencyCode($value);
        return $this;
    }

    /**
     * Initializes a new v1 money object.
     */
    public function build(): V1Money
    {
        return CoreHelper::clone($this->instance);
    }
}
