<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\V1UpdateOrderRequest;

/**
 * Builder for model V1UpdateOrderRequest
 *
 * @see V1UpdateOrderRequest
 */
class V1UpdateOrderRequestBuilder
{
    /**
     * @var V1UpdateOrderRequest
     */
    private $instance;

    private function __construct(V1UpdateOrderRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new v1 update order request Builder object.
     */
    public static function init(string $action): self
    {
        return new self(new V1UpdateOrderRequest($action));
    }

    /**
     * Sets shipped tracking number field.
     */
    public function shippedTrackingNumber(?string $value): self
    {
        $this->instance->setShippedTrackingNumber($value);
        return $this;
    }

    /**
     * Unsets shipped tracking number field.
     */
    public function unsetShippedTrackingNumber(): self
    {
        $this->instance->unsetShippedTrackingNumber();
        return $this;
    }

    /**
     * Sets completed note field.
     */
    public function completedNote(?string $value): self
    {
        $this->instance->setCompletedNote($value);
        return $this;
    }

    /**
     * Unsets completed note field.
     */
    public function unsetCompletedNote(): self
    {
        $this->instance->unsetCompletedNote();
        return $this;
    }

    /**
     * Sets refunded note field.
     */
    public function refundedNote(?string $value): self
    {
        $this->instance->setRefundedNote($value);
        return $this;
    }

    /**
     * Unsets refunded note field.
     */
    public function unsetRefundedNote(): self
    {
        $this->instance->unsetRefundedNote();
        return $this;
    }

    /**
     * Sets canceled note field.
     */
    public function canceledNote(?string $value): self
    {
        $this->instance->setCanceledNote($value);
        return $this;
    }

    /**
     * Unsets canceled note field.
     */
    public function unsetCanceledNote(): self
    {
        $this->instance->unsetCanceledNote();
        return $this;
    }

    /**
     * Initializes a new v1 update order request object.
     */
    public function build(): V1UpdateOrderRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
