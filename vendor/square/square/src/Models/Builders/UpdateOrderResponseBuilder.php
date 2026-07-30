<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Order;
use Square\Models\UpdateOrderResponse;

/**
 * Builder for model UpdateOrderResponse
 *
 * @see UpdateOrderResponse
 */
class UpdateOrderResponseBuilder
{
    /**
     * @var UpdateOrderResponse
     */
    private $instance;

    private function __construct(UpdateOrderResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new update order response Builder object.
     */
    public static function init(): self
    {
        return new self(new UpdateOrderResponse());
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
     * Initializes a new update order response object.
     */
    public function build(): UpdateOrderResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
