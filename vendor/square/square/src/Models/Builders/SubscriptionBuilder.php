<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Money;
use Square\Models\Subscription;
use Square\Models\SubscriptionSource;

/**
 * Builder for model Subscription
 *
 * @see Subscription
 */
class SubscriptionBuilder
{
    /**
     * @var Subscription
     */
    private $instance;

    private function __construct(Subscription $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new subscription Builder object.
     */
    public static function init(): self
    {
        return new self(new Subscription());
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
     * Sets plan id field.
     */
    public function planId(?string $value): self
    {
        $this->instance->setPlanId($value);
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
     * Sets start date field.
     */
    public function startDate(?string $value): self
    {
        $this->instance->setStartDate($value);
        return $this;
    }

    /**
     * Sets canceled date field.
     */
    public function canceledDate(?string $value): self
    {
        $this->instance->setCanceledDate($value);
        return $this;
    }

    /**
     * Unsets canceled date field.
     */
    public function unsetCanceledDate(): self
    {
        $this->instance->unsetCanceledDate();
        return $this;
    }

    /**
     * Sets charged through date field.
     */
    public function chargedThroughDate(?string $value): self
    {
        $this->instance->setChargedThroughDate($value);
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
     * Sets tax percentage field.
     */
    public function taxPercentage(?string $value): self
    {
        $this->instance->setTaxPercentage($value);
        return $this;
    }

    /**
     * Unsets tax percentage field.
     */
    public function unsetTaxPercentage(): self
    {
        $this->instance->unsetTaxPercentage();
        return $this;
    }

    /**
     * Sets invoice ids field.
     */
    public function invoiceIds(?array $value): self
    {
        $this->instance->setInvoiceIds($value);
        return $this;
    }

    /**
     * Sets price override money field.
     */
    public function priceOverrideMoney(?Money $value): self
    {
        $this->instance->setPriceOverrideMoney($value);
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
     * Sets created at field.
     */
    public function createdAt(?string $value): self
    {
        $this->instance->setCreatedAt($value);
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
     * Sets timezone field.
     */
    public function timezone(?string $value): self
    {
        $this->instance->setTimezone($value);
        return $this;
    }

    /**
     * Sets source field.
     */
    public function source(?SubscriptionSource $value): self
    {
        $this->instance->setSource($value);
        return $this;
    }

    /**
     * Sets actions field.
     */
    public function actions(?array $value): self
    {
        $this->instance->setActions($value);
        return $this;
    }

    /**
     * Unsets actions field.
     */
    public function unsetActions(): self
    {
        $this->instance->unsetActions();
        return $this;
    }

    /**
     * Initializes a new subscription object.
     */
    public function build(): Subscription
    {
        return CoreHelper::clone($this->instance);
    }
}
