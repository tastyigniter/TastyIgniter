<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\PayOrderRequest;

/**
 * Builder for model PayOrderRequest
 *
 * @see PayOrderRequest
 */
class PayOrderRequestBuilder
{
    /**
     * @var PayOrderRequest
     */
    private $instance;

    private function __construct(PayOrderRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new pay order request Builder object.
     */
    public static function init(string $idempotencyKey): self
    {
        return new self(new PayOrderRequest($idempotencyKey));
    }

    /**
     * Sets order version field.
     */
    public function orderVersion(?int $value): self
    {
        $this->instance->setOrderVersion($value);
        return $this;
    }

    /**
     * Unsets order version field.
     */
    public function unsetOrderVersion(): self
    {
        $this->instance->unsetOrderVersion();
        return $this;
    }

    /**
     * Sets payment ids field.
     */
    public function paymentIds(?array $value): self
    {
        $this->instance->setPaymentIds($value);
        return $this;
    }

    /**
     * Unsets payment ids field.
     */
    public function unsetPaymentIds(): self
    {
        $this->instance->unsetPaymentIds();
        return $this;
    }

    /**
     * Initializes a new pay order request object.
     */
    public function build(): PayOrderRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
