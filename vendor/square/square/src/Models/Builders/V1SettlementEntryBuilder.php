<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\V1Money;
use Square\Models\V1SettlementEntry;

/**
 * Builder for model V1SettlementEntry
 *
 * @see V1SettlementEntry
 */
class V1SettlementEntryBuilder
{
    /**
     * @var V1SettlementEntry
     */
    private $instance;

    private function __construct(V1SettlementEntry $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new v1 settlement entry Builder object.
     */
    public static function init(): self
    {
        return new self(new V1SettlementEntry());
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
     * Sets type field.
     */
    public function type(?string $value): self
    {
        $this->instance->setType($value);
        return $this;
    }

    /**
     * Sets amount money field.
     */
    public function amountMoney(?V1Money $value): self
    {
        $this->instance->setAmountMoney($value);
        return $this;
    }

    /**
     * Sets fee money field.
     */
    public function feeMoney(?V1Money $value): self
    {
        $this->instance->setFeeMoney($value);
        return $this;
    }

    /**
     * Initializes a new v1 settlement entry object.
     */
    public function build(): V1SettlementEntry
    {
        return CoreHelper::clone($this->instance);
    }
}
