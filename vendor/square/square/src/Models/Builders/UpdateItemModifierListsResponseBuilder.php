<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\UpdateItemModifierListsResponse;

/**
 * Builder for model UpdateItemModifierListsResponse
 *
 * @see UpdateItemModifierListsResponse
 */
class UpdateItemModifierListsResponseBuilder
{
    /**
     * @var UpdateItemModifierListsResponse
     */
    private $instance;

    private function __construct(UpdateItemModifierListsResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new update item modifier lists response Builder object.
     */
    public static function init(): self
    {
        return new self(new UpdateItemModifierListsResponse());
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
     * Initializes a new update item modifier lists response object.
     */
    public function build(): UpdateItemModifierListsResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
