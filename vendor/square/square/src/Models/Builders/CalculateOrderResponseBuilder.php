<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CalculateOrderResponse;
use Square\Models\Order;

/**
 * Builder for model CalculateOrderResponse
 *
 * @see CalculateOrderResponse
 */
class CalculateOrderResponseBuilder
{
    /**
     * @var CalculateOrderResponse
     */
    private $instance;

    private function __construct(CalculateOrderResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new calculate order response Builder object.
     */
    public static function init(): self
    {
        return new self(new CalculateOrderResponse());
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
     * Initializes a new calculate order response object.
     */
    public function build(): CalculateOrderResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
