<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\InventoryTransfer;
use Square\Models\RetrieveInventoryTransferResponse;

/**
 * Builder for model RetrieveInventoryTransferResponse
 *
 * @see RetrieveInventoryTransferResponse
 */
class RetrieveInventoryTransferResponseBuilder
{
    /**
     * @var RetrieveInventoryTransferResponse
     */
    private $instance;

    private function __construct(RetrieveInventoryTransferResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new retrieve inventory transfer response Builder object.
     */
    public static function init(): self
    {
        return new self(new RetrieveInventoryTransferResponse());
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
     * Sets transfer field.
     */
    public function transfer(?InventoryTransfer $value): self
    {
        $this->instance->setTransfer($value);
        return $this;
    }

    /**
     * Initializes a new retrieve inventory transfer response object.
     */
    public function build(): RetrieveInventoryTransferResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
