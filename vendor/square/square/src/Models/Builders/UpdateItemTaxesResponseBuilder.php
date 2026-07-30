<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\UpdateItemTaxesResponse;

/**
 * Builder for model UpdateItemTaxesResponse
 *
 * @see UpdateItemTaxesResponse
 */
class UpdateItemTaxesResponseBuilder
{
    /**
     * @var UpdateItemTaxesResponse
     */
    private $instance;

    private function __construct(UpdateItemTaxesResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new update item taxes response Builder object.
     */
    public static function init(): self
    {
        return new self(new UpdateItemTaxesResponse());
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
     * Sets updated at field.
     */
    public function updatedAt(?string $value): self
    {
        $this->instance->setUpdatedAt($value);
        return $this;
    }

    /**
     * Initializes a new update item taxes response object.
     */
    public function build(): UpdateItemTaxesResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
