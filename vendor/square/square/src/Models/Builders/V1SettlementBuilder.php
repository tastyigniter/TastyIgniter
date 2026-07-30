<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\V1Money;
use Square\Models\V1Settlement;

/**
 * Builder for model V1Settlement
 *
 * @see V1Settlement
 */
class V1SettlementBuilder
{
    /**
     * @var V1Settlement
     */
    private $instance;

    private function __construct(V1Settlement $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new v1 settlement Builder object.
     */
    public static function init(): self
    {
        return new self(new V1Settlement());
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
     * Sets status field.
     */
    public function status(?string $value): self
    {
        $this->instance->setStatus($value);
        return $this;
    }

    /**
     * Sets total money field.
     */
    public function totalMoney(?V1Money $value): self
    {
        $this->instance->setTotalMoney($value);
        return $this;
    }

    /**
     * Sets initiated at field.
     */
    public function initiatedAt(?string $value): self
    {
        $this->instance->setInitiatedAt($value);
        return $this;
    }

    /**
     * Unsets initiated at field.
     */
    public function unsetInitiatedAt(): self
    {
        $this->instance->unsetInitiatedAt();
        return $this;
    }

    /**
     * Sets bank account id field.
     */
    public function bankAccountId(?string $value): self
    {
        $this->instance->setBankAccountId($value);
        return $this;
    }

    /**
     * Unsets bank account id field.
     */
    public function unsetBankAccountId(): self
    {
        $this->instance->unsetBankAccountId();
        return $this;
    }

    /**
     * Sets entries field.
     */
    public function entries(?array $value): self
    {
        $this->instance->setEntries($value);
        return $this;
    }

    /**
     * Unsets entries field.
     */
    public function unsetEntries(): self
    {
        $this->instance->unsetEntries();
        return $this;
    }

    /**
     * Initializes a new v1 settlement object.
     */
    public function build(): V1Settlement
    {
        return CoreHelper::clone($this->instance);
    }
}
