<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\RetrieveInventoryChangesResponse;

/**
 * Builder for model RetrieveInventoryChangesResponse
 *
 * @see RetrieveInventoryChangesResponse
 */
class RetrieveInventoryChangesResponseBuilder
{
    /**
     * @var RetrieveInventoryChangesResponse
     */
    private $instance;

    private function __construct(RetrieveInventoryChangesResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new retrieve inventory changes response Builder object.
     */
    public static function init(): self
    {
        return new self(new RetrieveInventoryChangesResponse());
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
     * Sets changes field.
     */
    public function changes(?array $value): self
    {
        $this->instance->setChanges($value);
        return $this;
    }

    /**
     * Sets cursor field.
     */
    public function cursor(?string $value): self
    {
        $this->instance->setCursor($value);
        return $this;
    }

    /**
     * Initializes a new retrieve inventory changes response object.
     */
    public function build(): RetrieveInventoryChangesResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
