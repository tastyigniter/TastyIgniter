<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\DestinationDetails;
use Square\Models\Money;
use Square\Models\PaymentRefund;

/**
 * Builder for model PaymentRefund
 *
 * @see PaymentRefund
 */
class PaymentRefundBuilder
{
    /**
     * @var PaymentRefund
     */
    private $instance;

    private function __construct(PaymentRefund $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new payment refund Builder object.
     */
    public static function init(string $id, Money $amountMoney): self
    {
        return new self(new PaymentRefund($id, $amountMoney));
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
     * Unsets status field.
     */
    public function unsetStatus(): self
    {
        $this->instance->unsetStatus();
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
     * Unsets location id field.
     */
    public function unsetLocationId(): self
    {
        $this->instance->unsetLocationId();
        return $this;
    }

    /**
     * Sets unlinked field.
     */
    public function unlinked(?bool $value): self
    {
        $this->instance->setUnlinked($value);
        return $this;
    }

    /**
     * Sets destination type field.
     */
    public function destinationType(?string $value): self
    {
        $this->instance->setDestinationType($value);
        return $this;
    }

    /**
     * Unsets destination type field.
     */
    public function unsetDestinationType(): self
    {
        $this->instance->unsetDestinationType();
        return $this;
    }

    /**
     * Sets destination details field.
     */
    public function destinationDetails(?DestinationDetails $value): self
    {
        $this->instance->setDestinationDetails($value);
        return $this;
    }

    /**
     * Sets app fee money field.
     */
    public function appFeeMoney(?Money $value): self
    {
        $this->instance->setAppFeeMoney($value);
        return $this;
    }

    /**
     * Sets processing fee field.
     */
    public function processingFee(?array $value): self
    {
        $this->instance->setProcessingFee($value);
        return $this;
    }

    /**
     * Unsets processing fee field.
     */
    public function unsetProcessingFee(): self
    {
        $this->instance->unsetProcessingFee();
        return $this;
    }

    /**
     * Sets payment id field.
     */
    public function paymentId(?string $value): self
    {
        $this->instance->setPaymentId($value);
        return $this;
    }

    /**
     * Unsets payment id field.
     */
    public function unsetPaymentId(): self
    {
        $this->instance->unsetPaymentId();
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
     * Unsets order id field.
     */
    public function unsetOrderId(): self
    {
        $this->instance->unsetOrderId();
        return $this;
    }

    /**
     * Sets reason field.
     */
    public function reason(?string $value): self
    {
        $this->instance->setReason($value);
        return $this;
    }

    /**
     * Unsets reason field.
     */
    public function unsetReason(): self
    {
        $this->instance->unsetReason();
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
     * Sets team member id field.
     */
    public function teamMemberId(?string $value): self
    {
        $this->instance->setTeamMemberId($value);
        return $this;
    }

    /**
     * Initializes a new payment refund object.
     */
    public function build(): PaymentRefund
    {
        return CoreHelper::clone($this->instance);
    }
}
