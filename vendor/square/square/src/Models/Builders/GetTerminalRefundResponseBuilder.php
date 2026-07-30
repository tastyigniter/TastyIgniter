<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\GetTerminalRefundResponse;
use Square\Models\TerminalRefund;

/**
 * Builder for model GetTerminalRefundResponse
 *
 * @see GetTerminalRefundResponse
 */
class GetTerminalRefundResponseBuilder
{
    /**
     * @var GetTerminalRefundResponse
     */
    private $instance;

    private function __construct(GetTerminalRefundResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new get terminal refund response Builder object.
     */
    public static function init(): self
    {
        return new self(new GetTerminalRefundResponse());
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
     * Initializes a new get terminal refund response object.
     */
    public function build(): GetTerminalRefundResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
