<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\InventoryAdjustmentGroup;

/**
 * Builder for model InventoryAdjustmentGroup
 *
 * @see InventoryAdjustmentGroup
 */
class InventoryAdjustmentGroupBuilder
{
    /**
     * @var InventoryAdjustmentGroup
     */
    private $instance;

    private function __construct(InventoryAdjustmentGroup $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new inventory adjustment group Builder object.
     */
    public static function init(): self
    {
        return new self(new InventoryAdjustmentGroup());
    }

    /**
     * Sets id field.
     */
    public function id(?string $value): self
    {
        $this->instance->setId($value);
        return $this;
    }

    /**
     * Sets root adjustment id field.
     */
    public function rootAdjustmentId(?string $value): self
    {
        $this->instance->setRootAdjustmentId($value);
        return $this;
    }

    /**
     * Sets from state field.
     */
    public function fromState(?string $value): self
    {
        $this->instance->setFromState($value);
        return $this;
    }

    /**
     * Sets to state field.
     */
    public function toState(?string $value): self
    {
        $this->instance->setToState($value);
        return $this;
    }

    /**
     * Initializes a new inventory adjustment group object.
     */
    public function build(): InventoryAdjustmentGroup
    {
        return CoreHelper::clone($this->instance);
    }
}
