<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\InventoryPhysicalCount;
use Square\Models\RetrieveInventoryPhysicalCountResponse;

/**
 * Builder for model RetrieveInventoryPhysicalCountResponse
 *
 * @see RetrieveInventoryPhysicalCountResponse
 */
class RetrieveInventoryPhysicalCountResponseBuilder
{
    /**
     * @var RetrieveInventoryPhysicalCountResponse
     */
    private $instance;

    private function __construct(RetrieveInventoryPhysicalCountResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new retrieve inventory physical count response Builder object.
     */
    public static function init(): self
    {
        return new self(new RetrieveInventoryPhysicalCountResponse());
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
     * Sets count field.
     */
    public function count(?InventoryPhysicalCount $value): self
    {
        $this->instance->setCount($value);
        return $this;
    }

    /**
     * Initializes a new retrieve inventory physical count response object.
     */
    public function build(): RetrieveInventoryPhysicalCountResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
