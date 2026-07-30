<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\InvoicePaymentReminder;

/**
 * Builder for model InvoicePaymentReminder
 *
 * @see InvoicePaymentReminder
 */
class InvoicePaymentReminderBuilder
{
    /**
     * @var InvoicePaymentReminder
     */
    private $instance;

    private function __construct(InvoicePaymentReminder $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new invoice payment reminder Builder object.
     */
    public static function init(): self
    {
        return new self(new InvoicePaymentReminder());
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
     * Sets relative scheduled days field.
     */
    public function relativeScheduledDays(?int $value): self
    {
        $this->instance->setRelativeScheduledDays($value);
        return $this;
    }

    /**
     * Unsets relative scheduled days field.
     */
    public function unsetRelativeScheduledDays(): self
    {
        $this->instance->unsetRelativeScheduledDays();
        return $this;
    }

    /**
     * Sets message field.
     */
    public function message(?string $value): self
    {
        $this->instance->setMessage($value);
        return $this;
    }

    /**
     * Unsets message field.
     */
    public function unsetMessage(): self
    {
        $this->instance->unsetMessage();
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
     * Sets sent at field.
     */
    public function sentAt(?string $value): self
    {
        $this->instance->setSentAt($value);
        return $this;
    }

    /**
     * Initializes a new invoice payment reminder object.
     */
    public function build(): InvoicePaymentReminder
    {
        return CoreHelper::clone($this->instance);
    }
}
