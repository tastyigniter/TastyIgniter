<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CreateRefundResponse;
use Square\Models\Refund;

/**
 * Builder for model CreateRefundResponse
 *
 * @see CreateRefundResponse
 */
class CreateRefundResponseBuilder
{
    /**
     * @var CreateRefundResponse
     */
    private $instance;

    private function __construct(CreateRefundResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new create refund response Builder object.
     */
    public static function init(): self
    {
        return new self(new CreateRefundResponse());
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
     * Sets refund field.
     */
    public function refund(?Refund $value): self
    {
        $this->instance->setRefund($value);
        return $this;
    }

    /**
     * Initializes a new create refund response object.
     */
    public function build(): CreateRefundResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
