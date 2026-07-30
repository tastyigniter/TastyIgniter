<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CalculateOrderRequest;
use Square\Models\Order;

/**
 * Builder for model CalculateOrderRequest
 *
 * @see CalculateOrderRequest
 */
class CalculateOrderRequestBuilder
{
    /**
     * @var CalculateOrderRequest
     */
    private $instance;

    private function __construct(CalculateOrderRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new calculate order request Builder object.
     */
    public static function init(Order $order): self
    {
        return new self(new CalculateOrderRequest($order));
    }

    /**
     * Sets proposed rewards field.
     */
    public function proposedRewards(?array $value): self
    {
        $this->instance->setProposedRewards($value);
        return $this;
    }

    /**
     * Unsets proposed rewards field.
     */
    public function unsetProposedRewards(): self
    {
        $this->instance->unsetProposedRewards();
        return $this;
    }

    /**
     * Initializes a new calculate order request object.
     */
    public function build(): CalculateOrderRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
