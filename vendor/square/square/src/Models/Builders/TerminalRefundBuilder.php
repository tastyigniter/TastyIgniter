<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Money;
use Square\Models\TerminalRefund;

/**
 * Builder for model TerminalRefund
 *
 * @see TerminalRefund
 */
class TerminalRefundBuilder
{
    /**
     * @var TerminalRefund
     */
    private $instance;

    private function __construct(TerminalRefund $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new terminal refund Builder object.
     */
    public static function init(string $paymentId, Money $amountMoney, string $reason, string $deviceId): self
    {
        return new self(new TerminalRefund($paymentId, $amountMoney, $reason, $deviceId));
    }

    /**
     * Sets id field.
     */
    public function id(?string $value): self
    {
        $this->instance->setId($value);
        return $this;
    }

    /**
     * Sets refund id field.
     */
    public function refundId(?string $value): self
    {
        $this->instance->setRefundId($value);
        return $this;
    }

    /**
     * Sets order id field.
     */
    public function orderId(?string $value): self
    {
        $this->instance->setOrderId($value);
        return $this;
    }

    /**
     * Sets deadline duration field.
     */
    public function deadlineDuration(?string $value): self
    {
        $this->instance->setDeadlineDuration($value);
        return $this;
    }

    /**
     * Unsets deadline duration field.
     */
    public function unsetDeadlineDuration(): self
    {
        $this->instance->unsetDeadlineDuration();
        return $this;
    }

    /**
     * Sets status field.
     */
    public function status(?string $value): self
    {
        $this->instance->setStatus($value);
        return $this;
    }

    /**
     * Sets cancel reason field.
     */
    public function cancelReason(?string $value): self
    {
        $this->instance->setCancelReason($value);
        return $this;
    }

    /**
     * Sets created at field.
     */
    public function createdAt(?string $value): self
    {
        $this->instance->setCreatedAt($value);
        return $this;
    }

    /**
     * Sets updated at field.
     */
    public function updatedAt(?string $value): self
    {
        $this->instance->setUpdatedAt($value);
        return $this;
    }

    /**
     * Sets app id field.
     */
    public function appId(?string $value): self
    {
        $this->instance->setAppId($value);
        return $this;
    }

    /**
     * Sets location id field.
     */
    public function locationId(?string $value): self
    {
        $this->instance->setLocationId($value);
        return $this;
    }

    /**
     * Initializes a new terminal refund object.
     */
    public function build(): TerminalRefund
    {
        return CoreHelper::clone($this->instance);
    }
}
