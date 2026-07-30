<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\OrderSource;

/**
 * Builder for model OrderSource
 *
 * @see OrderSource
 */
class OrderSourceBuilder
{
    /**
     * @var OrderSource
     */
    private $instance;

    private function __construct(OrderSource $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new order source Builder object.
     */
    public static function init(): self
    {
        return new self(new OrderSource());
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
     * Initializes a new order source object.
     */
    public function build(): OrderSource
    {
        return CoreHelper::clone($this->instance);
    }
}
