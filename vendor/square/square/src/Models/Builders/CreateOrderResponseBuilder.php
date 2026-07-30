<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CreateOrderResponse;
use Square\Models\Order;

/**
 * Builder for model CreateOrderResponse
 *
 * @see CreateOrderResponse
 */
class CreateOrderResponseBuilder
{
    /**
     * @var CreateOrderResponse
     */
    private $instance;

    private function __construct(CreateOrderResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new create order response Builder object.
     */
    public static function init(): self
    {
        return new self(new CreateOrderResponse());
    }

    /**
     * Sets order field.
     */
    public function order(?Order $value): self
    {
        $this->instance->setOrder($value);
        return $this;
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
     * Initializes a new create order response object.
     */
    public function build(): CreateOrderResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
