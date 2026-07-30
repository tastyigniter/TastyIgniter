<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\UpdateItemTaxesRequest;

/**
 * Builder for model UpdateItemTaxesRequest
 *
 * @see UpdateItemTaxesRequest
 */
class UpdateItemTaxesRequestBuilder
{
    /**
     * @var UpdateItemTaxesRequest
     */
    private $instance;

    private function __construct(UpdateItemTaxesRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new update item taxes request Builder object.
     */
    public static function init(array $itemIds): self
    {
        return new self(new UpdateItemTaxesRequest($itemIds));
    }

    /**
     * Sets taxes to enable field.
     */
    public function taxesToEnable(?array $value): self
    {
        $this->instance->setTaxesToEnable($value);
        return $this;
    }

    /**
     * Unsets taxes to enable field.
     */
    public function unsetTaxesToEnable(): self
    {
        $this->instance->unsetTaxesToEnable();
        return $this;
    }

    /**
     * Sets taxes to disable field.
     */
    public function taxesToDisable(?array $value): self
    {
        $this->instance->setTaxesToDisable($value);
        return $this;
    }

    /**
     * Unsets taxes to disable field.
     */
    public function unsetTaxesToDisable(): self
    {
        $this->instance->unsetTaxesToDisable();
        return $this;
    }

    /**
     * Initializes a new update item taxes request object.
     */
    public function build(): UpdateItemTaxesRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
