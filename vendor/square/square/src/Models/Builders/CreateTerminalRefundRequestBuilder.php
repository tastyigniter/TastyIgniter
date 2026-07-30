<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CreateTerminalRefundRequest;
use Square\Models\TerminalRefund;

/**
 * Builder for model CreateTerminalRefundRequest
 *
 * @see CreateTerminalRefundRequest
 */
class CreateTerminalRefundRequestBuilder
{
    /**
     * @var CreateTerminalRefundRequest
     */
    private $instance;

    private function __construct(CreateTerminalRefundRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new create terminal refund request Builder object.
     */
    public static function init(string $idempotencyKey): self
    {
        return new self(new CreateTerminalRefundRequest($idempotencyKey));
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
     * Initializes a new create terminal refund request object.
     */
    public function build(): CreateTerminalRefundRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
