<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\InvoicePaymentRequest;
use Square\Models\Money;

/**
 * Builder for model InvoicePaymentRequest
 *
 * @see InvoicePaymentRequest
 */
class InvoicePaymentRequestBuilder
{
    /**
     * @var InvoicePaymentRequest
     */
    private $instance;

    private function __construct(InvoicePaymentRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new invoice payment request Builder object.
     */
    public static function init(): self
    {
        return new self(new InvoicePaymentRequest());
    }

    /**
     * Sets uid field.
     */
    public function uid(?string $value): self
    {
        $this->instance->setUid($value);
        return $this;
    }

    /**
     * Unsets uid field.
     */
    public function unsetUid(): self
    {
        $this->instance->unsetUid();
        return $this;
    }

    /**
     * Sets request method field.
     */
    public function requestMethod(?string $value): self
    {
        $this->instance->setRequestMethod($value);
        return $this;
    }

    /**
     * Sets request type field.
     */
    public function requestType(?string $value): self
    {
        $this->instance->setRequestType($value);
        return $this;
    }

    /**
     * Sets due date field.
     */
    public function dueDate(?string $value): self
    {
        $this->instance->setDueDate($value);
        return $this;
    }

    /**
     * Unsets due date field.
     */
    public function unsetDueDate(): self
    {
        $this->instance->unsetDueDate();
        return $this;
    }

    /**
     * Sets fixed amount requested money field.
     */
    public function fixedAmountRequestedMoney(?Money $value): self
    {
        $this->instance->setFixedAmountRequestedMoney($value);
        return $this;
    }

    /**
     * Sets percentage requested field.
     */
    public function percentageRequested(?string $value): self
    {
        $this->instance->setPercentageRequested($value);
        return $this;
    }

    /**
     * Unsets percentage requested field.
     */
    public function unsetPercentageRequested(): self
    {
        $this->instance->unsetPercentageRequested();
        return $this;
    }

    /**
     * Sets tipping enabled field.
     */
    public function tippingEnabled(?bool $value): self
    {
        $this->instance->setTippingEnabled($value);
        return $this;
    }

    /**
     * Unsets tipping enabled field.
     */
    public function unsetTippingEnabled(): self
    {
        $this->instance->unsetTippingEnabled();
        return $this;
    }

    /**
     * Sets automatic payment source field.
     */
    public function automaticPaymentSource(?string $value): self
    {
        $this->instance->setAutomaticPaymentSource($value);
        return $this;
    }

    /**
     * Sets card id field.
     */
    public function cardId(?string $value): self
    {
        $this->instance->setCardId($value);
        return $this;
    }

    /**
     * Unsets card id field.
     */
    public function unsetCardId(): self
    {
        $this->instance->unsetCardId();
        return $this;
    }

    /**
     * Sets reminders field.
     */
    public function reminders(?array $value): self
    {
        $this->instance->setReminders($value);
        return $this;
    }

    /**
     * Unsets reminders field.
     */
    public function unsetReminders(): self
    {
        $this->instance->unsetReminders();
        return $this;
    }

    /**
     * Sets computed amount money field.
     */
    public function computedAmountMoney(?Money $value): self
    {
        $this->instance->setComputedAmountMoney($value);
        return $this;
    }

    /**
     * Sets total completed amount money field.
     */
    public function totalCompletedAmountMoney(?Money $value): self
    {
        $this->instance->setTotalCompletedAmountMoney($value);
        return $this;
    }

    /**
     * Sets rounding adjustment included money field.
     */
    public function roundingAdjustmentIncludedMoney(?Money $value): self
    {
        $this->instance->setRoundingAdjustmentIncludedMoney($value);
        return $this;
    }

    /**
     * Initializes a new invoice payment request object.
     */
    public function build(): InvoicePaymentRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
