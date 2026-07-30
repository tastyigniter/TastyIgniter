<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CreateSubscriptionRequest;
use Square\Models\Money;
use Square\Models\SubscriptionSource;

/**
 * Builder for model CreateSubscriptionRequest
 *
 * @see CreateSubscriptionRequest
 */
class CreateSubscriptionRequestBuilder
{
    /**
     * @var CreateSubscriptionRequest
     */
    private $instance;

    private function __construct(CreateSubscriptionRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new create subscription request Builder object.
     */
    public static function init(string $locationId, string $planId, string $customerId): self
    {
        return new self(new CreateSubscriptionRequest($locationId, $planId, $customerId));
    }

    /**
     * Sets idempotency key field.
     */
    public function idempotencyKey(?string $value): self
    {
        $this->instance->setIdempotencyKey($value);
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
     * Sets tax percentage field.
     */
    public function taxPercentage(?string $value): self
    {
        $this->instance->setTaxPercentage($value);
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
     * Sets card id field.
     */
    public function cardId(?string $value): self
    {
        $this->instance->setCardId($value);
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
     * Initializes a new create subscription request object.
     */
    public function build(): CreateSubscriptionRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
