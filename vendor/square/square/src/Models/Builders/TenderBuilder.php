<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Money;
use Square\Models\Tender;
use Square\Models\TenderCardDetails;
use Square\Models\TenderCashDetails;

/**
 * Builder for model Tender
 *
 * @see Tender
 */
class TenderBuilder
{
    /**
     * @var Tender
     */
    private $instance;

    private function __construct(Tender $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new tender Builder object.
     */
    public static function init(string $type): self
    {
        return new self(new Tender($type));
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
     * Sets transaction id field.
     */
    public function transactionId(?string $value): self
    {
        $this->instance->setTransactionId($value);
        return $this;
    }

    /**
     * Unsets transaction id field.
     */
    public function unsetTransactionId(): self
    {
        $this->instance->unsetTransactionId();
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
     * Sets amount money field.
     */
    public function amountMoney(?Money $value): self
    {
        $this->instance->setAmountMoney($value);
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
     * Sets processing fee money field.
     */
    public function processingFeeMoney(?Money $value): self
    {
        $this->instance->setProcessingFeeMoney($value);
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
     * Sets card details field.
     */
    public function cardDetails(?TenderCardDetails $value): self
    {
        $this->instance->setCardDetails($value);
        return $this;
    }

    /**
     * Sets cash details field.
     */
    public function cashDetails(?TenderCashDetails $value): self
    {
        $this->instance->setCashDetails($value);
        return $this;
    }

    /**
     * Sets additional recipients field.
     */
    public function additionalRecipients(?array $value): self
    {
        $this->instance->setAdditionalRecipients($value);
        return $this;
    }

    /**
     * Unsets additional recipients field.
     */
    public function unsetAdditionalRecipients(): self
    {
        $this->instance->unsetAdditionalRecipients();
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
     * Initializes a new tender object.
     */
    public function build(): Tender
    {
        return CoreHelper::clone($this->instance);
    }
}
