<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\DeviceCheckoutOptions;
use Square\Models\Money;
use Square\Models\PaymentOptions;
use Square\Models\TerminalCheckout;

/**
 * Builder for model TerminalCheckout
 *
 * @see TerminalCheckout
 */
class TerminalCheckoutBuilder
{
    /**
     * @var TerminalCheckout
     */
    private $instance;

    private function __construct(TerminalCheckout $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new terminal checkout Builder object.
     */
    public static function init(Money $amountMoney, DeviceCheckoutOptions $deviceOptions): self
    {
        return new self(new TerminalCheckout($amountMoney, $deviceOptions));
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
     * Sets reference id field.
     */
    public function referenceId(?string $value): self
    {
        $this->instance->setReferenceId($value);
        return $this;
    }

    /**
     * Unsets reference id field.
     */
    public function unsetReferenceId(): self
    {
        $this->instance->unsetReferenceId();
        return $this;
    }

    /**
     * Sets note field.
     */
    public function note(?string $value): self
    {
        $this->instance->setNote($value);
        return $this;
    }

    /**
     * Unsets note field.
     */
    public function unsetNote(): self
    {
        $this->instance->unsetNote();
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
     * Sets payment options field.
     */
    public function paymentOptions(?PaymentOptions $value): self
    {
        $this->instance->setPaymentOptions($value);
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
     * Sets payment ids field.
     */
    public function paymentIds(?array $value): self
    {
        $this->instance->setPaymentIds($value);
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
     * Sets payment type field.
     */
    public function paymentType(?string $value): self
    {
        $this->instance->setPaymentType($value);
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
     * Unsets team member id field.
     */
    public function unsetTeamMemberId(): self
    {
        $this->instance->unsetTeamMemberId();
        return $this;
    }

    /**
     * Sets customer id field.
     */
    public function customerId(?string $value): self
    {
        $this->instance->setCustomerId($value);
        return $this;
    }

    /**
     * Unsets customer id field.
     */
    public function unsetCustomerId(): self
    {
        $this->instance->unsetCustomerId();
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
     * Sets statement description identifier field.
     */
    public function statementDescriptionIdentifier(?string $value): self
    {
        $this->instance->setStatementDescriptionIdentifier($value);
        return $this;
    }

    /**
     * Unsets statement description identifier field.
     */
    public function unsetStatementDescriptionIdentifier(): self
    {
        $this->instance->unsetStatementDescriptionIdentifier();
        return $this;
    }

    /**
     * Sets tip money field.
     */
    public function tipMoney(?Money $value): self
    {
        $this->instance->setTipMoney($value);
        return $this;
    }

    /**
     * Initializes a new terminal checkout object.
     */
    public function build(): TerminalCheckout
    {
        return CoreHelper::clone($this->instance);
    }
}
