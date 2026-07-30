<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Destination;
use Square\Models\Money;
use Square\Models\Payout;

/**
 * Builder for model Payout
 *
 * @see Payout
 */
class PayoutBuilder
{
    /**
     * @var Payout
     */
    private $instance;

    private function __construct(Payout $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new payout Builder object.
     */
    public static function init(string $id, string $locationId): self
    {
        return new self(new Payout($id, $locationId));
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
     * Sets amount money field.
     */
    public function amountMoney(?Money $value): self
    {
        $this->instance->setAmountMoney($value);
        return $this;
    }

    /**
     * Sets destination field.
     */
    public function destination(?Destination $value): self
    {
        $this->instance->setDestination($value);
        return $this;
    }

    /**
     * Sets version field.
     */
    public function version(?int $value): self
    {
        $this->instance->setVersion($value);
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
     * Sets payout fee field.
     */
    public function payoutFee(?array $value): self
    {
        $this->instance->setPayoutFee($value);
        return $this;
    }

    /**
     * Unsets payout fee field.
     */
    public function unsetPayoutFee(): self
    {
        $this->instance->unsetPayoutFee();
        return $this;
    }

    /**
     * Sets arrival date field.
     */
    public function arrivalDate(?string $value): self
    {
        $this->instance->setArrivalDate($value);
        return $this;
    }

    /**
     * Unsets arrival date field.
     */
    public function unsetArrivalDate(): self
    {
        $this->instance->unsetArrivalDate();
        return $this;
    }

    /**
     * Initializes a new payout object.
     */
    public function build(): Payout
    {
        return CoreHelper::clone($this->instance);
    }
}
