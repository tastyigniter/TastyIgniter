<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Order;
use Square\Models\UpdateOrderRequest;

/**
 * Builder for model UpdateOrderRequest
 *
 * @see UpdateOrderRequest
 */
class UpdateOrderRequestBuilder
{
    /**
     * @var UpdateOrderRequest
     */
    private $instance;

    private function __construct(UpdateOrderRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new update order request Builder object.
     */
    public static function init(): self
    {
        return new self(new UpdateOrderRequest());
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
     * Sets fields to clear field.
     */
    public function fieldsToClear(?array $value): self
    {
        $this->instance->setFieldsToClear($value);
        return $this;
    }

    /**
     * Unsets fields to clear field.
     */
    public function unsetFieldsToClear(): self
    {
        $this->instance->unsetFieldsToClear();
        return $this;
    }

    /**
     * Sets idempotency key field.
     */
    public function idempotencyKey(?string $value): self
    {
        $this->instance->setIdempotencyKey($value);
        return $this;
    }

    /**
     * Unsets idempotency key field.
     */
    public function unsetIdempotencyKey(): self
    {
        $this->instance->unsetIdempotencyKey();
        return $this;
    }

    /**
     * Initializes a new update order request object.
     */
    public function build(): UpdateOrderRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
