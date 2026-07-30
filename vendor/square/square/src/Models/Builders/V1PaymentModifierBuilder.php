<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\V1Money;
use Square\Models\V1PaymentModifier;

/**
 * Builder for model V1PaymentModifier
 *
 * @see V1PaymentModifier
 */
class V1PaymentModifierBuilder
{
    /**
     * @var V1PaymentModifier
     */
    private $instance;

    private function __construct(V1PaymentModifier $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new v1 payment modifier Builder object.
     */
    public static function init(): self
    {
        return new self(new V1PaymentModifier());
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
     * Sets modifier option id field.
     */
    public function modifierOptionId(?string $value): self
    {
        $this->instance->setModifierOptionId($value);
        return $this;
    }

    /**
     * Unsets modifier option id field.
     */
    public function unsetModifierOptionId(): self
    {
        $this->instance->unsetModifierOptionId();
        return $this;
    }

    /**
     * Initializes a new v1 payment modifier object.
     */
    public function build(): V1PaymentModifier
    {
        return CoreHelper::clone($this->instance);
    }
}
