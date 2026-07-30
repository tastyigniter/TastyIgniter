<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Order;
use Square\Models\PayOrderResponse;

/**
 * Builder for model PayOrderResponse
 *
 * @see PayOrderResponse
 */
class PayOrderResponseBuilder
{
    /**
     * @var PayOrderResponse
     */
    private $instance;

    private function __construct(PayOrderResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new pay order response Builder object.
     */
    public static function init(): self
    {
        return new self(new PayOrderResponse());
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
     * Sets order field.
     */
    public function order(?Order $value): self
    {
        $this->instance->setOrder($value);
        return $this;
    }

    /**
     * Initializes a new pay order response object.
     */
    public function build(): PayOrderResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
