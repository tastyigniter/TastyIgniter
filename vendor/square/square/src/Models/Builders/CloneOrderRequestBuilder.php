<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CloneOrderRequest;

/**
 * Builder for model CloneOrderRequest
 *
 * @see CloneOrderRequest
 */
class CloneOrderRequestBuilder
{
    /**
     * @var CloneOrderRequest
     */
    private $instance;

    private function __construct(CloneOrderRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new clone order request Builder object.
     */
    public static function init(string $orderId): self
    {
        return new self(new CloneOrderRequest($orderId));
    }

    /**
     * Sets version field.
     */
    public function version(?int $value): self
    {
        $this->instance->setVersion($value);
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
     * Initializes a new clone order request object.
     */
    public function build(): CloneOrderRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
