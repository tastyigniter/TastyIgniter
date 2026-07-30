<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Address;
use Square\Models\Transaction;

/**
 * Builder for model Transaction
 *
 * @see Transaction
 */
class TransactionBuilder
{
    /**
     * @var Transaction
     */
    private $instance;

    private function __construct(Transaction $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new transaction Builder object.
     */
    public static function init(): self
    {
        return new self(new Transaction());
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
     * Sets created at field.
     */
    public function createdAt(?string $value): self
    {
        $this->instance->setCreatedAt($value);
        return $this;
    }

    /**
     * Sets tenders field.
     */
    public function tenders(?array $value): self
    {
        $this->instance->setTenders($value);
        return $this;
    }

    /**
     * Unsets tenders field.
     */
    public function unsetTenders(): self
    {
        $this->instance->unsetTenders();
        return $this;
    }

    /**
     * Sets refunds field.
     */
    public function refunds(?array $value): self
    {
        $this->instance->setRefunds($value);
        return $this;
    }

    /**
     * Unsets refunds field.
     */
    public function unsetRefunds(): self
    {
        $this->instance->unsetRefunds();
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
     * Sets product field.
     */
    public function product(?string $value): self
    {
        $this->instance->setProduct($value);
        return $this;
    }

    /**
     * Sets client id field.
     */
    public function clientId(?string $value): self
    {
        $this->instance->setClientId($value);
        return $this;
    }

    /**
     * Unsets client id field.
     */
    public function unsetClientId(): self
    {
        $this->instance->unsetClientId();
        return $this;
    }

    /**
     * Sets shipping address field.
     */
    public function shippingAddress(?Address $value): self
    {
        $this->instance->setShippingAddress($value);
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
     * Initializes a new transaction object.
     */
    public function build(): Transaction
    {
        return CoreHelper::clone($this->instance);
    }
}
