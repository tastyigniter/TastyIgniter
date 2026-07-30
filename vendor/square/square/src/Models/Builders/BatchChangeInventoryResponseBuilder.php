<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\BatchChangeInventoryResponse;

/**
 * Builder for model BatchChangeInventoryResponse
 *
 * @see BatchChangeInventoryResponse
 */
class BatchChangeInventoryResponseBuilder
{
    /**
     * @var BatchChangeInventoryResponse
     */
    private $instance;

    private function __construct(BatchChangeInventoryResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new batch change inventory response Builder object.
     */
    public static function init(): self
    {
        return new self(new BatchChangeInventoryResponse());
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
     * Sets counts field.
     */
    public function counts(?array $value): self
    {
        $this->instance->setCounts($value);
        return $this;
    }

    /**
     * Sets changes field.
     */
    public function changes(?array $value): self
    {
        $this->instance->setChanges($value);
        return $this;
    }

    /**
     * Initializes a new batch change inventory response object.
     */
    public function build(): BatchChangeInventoryResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
