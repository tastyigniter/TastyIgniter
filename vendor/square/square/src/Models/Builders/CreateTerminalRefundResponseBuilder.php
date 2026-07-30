<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CreateTerminalRefundResponse;
use Square\Models\TerminalRefund;

/**
 * Builder for model CreateTerminalRefundResponse
 *
 * @see CreateTerminalRefundResponse
 */
class CreateTerminalRefundResponseBuilder
{
    /**
     * @var CreateTerminalRefundResponse
     */
    private $instance;

    private function __construct(CreateTerminalRefundResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new create terminal refund response Builder object.
     */
    public static function init(): self
    {
        return new self(new CreateTerminalRefundResponse());
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
    public function refund(?TerminalRefund $value): self
    {
        $this->instance->setRefund($value);
        return $this;
    }

    /**
     * Initializes a new create terminal refund response object.
     */
    public function build(): CreateTerminalRefundResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
