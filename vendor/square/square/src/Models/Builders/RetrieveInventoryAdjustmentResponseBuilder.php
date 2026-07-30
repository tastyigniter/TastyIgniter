<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\InventoryAdjustment;
use Square\Models\RetrieveInventoryAdjustmentResponse;

/**
 * Builder for model RetrieveInventoryAdjustmentResponse
 *
 * @see RetrieveInventoryAdjustmentResponse
 */
class RetrieveInventoryAdjustmentResponseBuilder
{
    /**
     * @var RetrieveInventoryAdjustmentResponse
     */
    private $instance;

    private function __construct(RetrieveInventoryAdjustmentResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new retrieve inventory adjustment response Builder object.
     */
    public static function init(): self
    {
        return new self(new RetrieveInventoryAdjustmentResponse());
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
     * Sets adjustment field.
     */
    public function adjustment(?InventoryAdjustment $value): self
    {
        $this->instance->setAdjustment($value);
        return $this;
    }

    /**
     * Initializes a new retrieve inventory adjustment response object.
     */
    public function build(): RetrieveInventoryAdjustmentResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
