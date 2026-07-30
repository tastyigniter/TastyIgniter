<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Defines input parameters in a request to the
 * [CreateSubscription]($e/Subscriptions/CreateSubscription) endpoint.
 */
class CreateSubscriptionRequest implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $idempotencyKey;

    /**
     * @var string
     */
    private $locationId;

    /**
     * @var string
     */
    private $planId;

    /**
     * @var string
     */
    private $customerId;

    /**
     * @var string|null
     */
    private $startDate;

    /**
     * @var string|null
     */
    private $canceledDate;

    /**
     * @var string|null
     */
    private $taxPercentage;

    /**
     * @var Money|null
     */
    private $priceOverrideMoney;

    /**
     * @var string|null
     */
    private $cardId;

    /**
     * @var string|null
     */
    private $timezone;

    /**
     * @var SubscriptionSource|null
     */
    private $source;

    /**
     * @param string $locationId
     * @param string $planId
     * @param string $customerId
     */
    public function __construct(string $locationId, string $planId, string $customerId)
    {
        $this->locationId = $locationId;
        $this->planId = $planId;
        $this->customerId = $customerId;
    }

    /**
     * Returns Idempotency Key.
     * A unique string that identifies this `CreateSubscription` request.
     * If you do not provide a unique string (or provide an empty string as the value),
     * the endpoint treats each request as independent.
     *
     * For more information, see [Idempotency keys](https://developer.squareup.com/docs/working-with-
     * apis/idempotency).
     */
    public function getIdempotencyKey(): ?string
    {
        return $this->idempotencyKey;
    }

    /**
     * Sets Idempotency Key.
     * A unique string that identifies this `CreateSubscription` request.
     * If you do not provide a unique string (or provide an empty string as the value),
     * the endpoint treats each request as independent.
     *
     * For more information, see [Idempotency keys](https://developer.squareup.com/docs/working-with-
     * apis/idempotency).
     *
     * @maps idempotency_key
     */
    public function setIdempotencyKey(?string $idempotencyKey): void
    {
        $this->idempotencyKey = $idempotencyKey;
    }

    /**
     * Returns Location Id.
     * The ID of the location the subscription is associated with.
     */
    public function getLocationId(): string
    {
        return $this->locationId;
    }

    /**
     * Sets Location Id.
     * The ID of the location the subscription is associated with.
     *
     * @required
     * @maps location_id
     */
    public function setLocationId(string $locationId): void
    {
        $this->locationId = $locationId;
    }

    /**
     * Returns Plan Id.
     * The ID of the subscription plan created using the Catalog API.
     * For more information, see
     * [Set Up and Manage a Subscription Plan](https://developer.squareup.com/docs/subscriptions-api/setup-
     * plan) and
     * [Subscriptions Walkthrough](https://developer.squareup.com/docs/subscriptions-api/walkthrough).
     */
    public function getPlanId(): string
    {
        return $this->planId;
    }

    /**
     * Sets Plan Id.
     * The ID of the subscription plan created using the Catalog API.
     * For more information, see
     * [Set Up and Manage a Subscription Plan](https://developer.squareup.com/docs/subscriptions-api/setup-
     * plan) and
     * [Subscriptions Walkthrough](https://developer.squareup.com/docs/subscriptions-api/walkthrough).
     *
     * @required
     * @maps plan_id
     */
    public function setPlanId(string $planId): void
    {
        $this->planId = $planId;
    }

    /**
     * Returns Customer Id.
     * The ID of the [customer](entity:Customer) subscribing to the subscription plan.
     */
    public function getCustomerId(): string
    {
        return $this->customerId;
    }

    /**
     * Sets Customer Id.
     * The ID of the [customer](entity:Customer) subscribing to the subscription plan.
     *
     * @required
     * @maps customer_id
     */
    public function setCustomerId(string $customerId): void
    {
        $this->customerId = $customerId;
    }

    /**
     * Returns Start Date.
     * The `YYYY-MM-DD`-formatted date to start the subscription.
     * If it is unspecified, the subscription starts immediately.
     */
    public function getStartDate(): ?string
    {
        return $this->startDate;
    }

    /**
     * Sets Start Date.
     * The `YYYY-MM-DD`-formatted date to start the subscription.
     * If it is unspecified, the subscription starts immediately.
     *
     * @maps start_date
     */
    public function setStartDate(?string $startDate): void
    {
        $this->startDate = $startDate;
    }

    /**
     * Returns Canceled Date.
     * The `YYYY-MM-DD`-formatted date when the newly created subscription is scheduled for cancellation.
     *
     * This date overrides the cancellation date set in the plan configuration.
     * If the cancellation date is earlier than the end date of a subscription cycle, the subscription
     * stops
     * at the canceled date and the subscriber is sent a prorated invoice at the beginning of the canceled
     * cycle.
     *
     * When the subscription plan of the newly created subscription has a fixed number of cycles and the
     * `canceled_date`
     * occurs before the subscription plan expires, the specified `canceled_date` sets the date when the
     * subscription
     * stops through the end of the last cycle.
     */
    public function getCanceledDate(): ?string
    {
        return $this->canceledDate;
    }

    /**
     * Sets Canceled Date.
     * The `YYYY-MM-DD`-formatted date when the newly created subscription is scheduled for cancellation.
     *
     * This date overrides the cancellation date set in the plan configuration.
     * If the cancellation date is earlier than the end date of a subscription cycle, the subscription
     * stops
     * at the canceled date and the subscriber is sent a prorated invoice at the beginning of the canceled
     * cycle.
     *
     * When the subscription plan of the newly created subscription has a fixed number of cycles and the
     * `canceled_date`
     * occurs before the subscription plan expires, the specified `canceled_date` sets the date when the
     * subscription
     * stops through the end of the last cycle.
     *
     * @maps canceled_date
     */
    public function setCanceledDate(?string $canceledDate): void
    {
        $this->canceledDate = $canceledDate;
    }

    /**
     * Returns Tax Percentage.
     * The tax to add when billing the subscription.
     * The percentage is expressed in decimal form, using a `'.'` as the decimal
     * separator and without a `'%'` sign. For example, a value of 7.5
     * corresponds to 7.5%.
     */
    public function getTaxPercentage(): ?string
    {
        return $this->taxPercentage;
    }

    /**
     * Sets Tax Percentage.
     * The tax to add when billing the subscription.
     * The percentage is expressed in decimal form, using a `'.'` as the decimal
     * separator and without a `'%'` sign. For example, a value of 7.5
     * corresponds to 7.5%.
     *
     * @maps tax_percentage
     */
    public function setTaxPercentage(?string $taxPercentage): void
    {
        $this->taxPercentage = $taxPercentage;
    }

    /**
     * Returns Price Override Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     */
    public function getPriceOverrideMoney(): ?Money
    {
        return $this->priceOverrideMoney;
    }

    /**
     * Sets Price Override Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     *
     * @maps price_override_money
     */
    public function setPriceOverrideMoney(?Money $priceOverrideMoney): void
    {
        $this->priceOverrideMoney = $priceOverrideMoney;
    }

    /**
     * Returns Card Id.
     * The ID of the [subscriber's](entity:Customer) [card](entity:Card) to charge.
     * If it is not specified, the subscriber receives an invoice via email. For an example to
     * create a customer profile for a subscriber and add a card on file, see [Subscriptions
     * Walkthrough](https://developer.squareup.com/docs/subscriptions-api/walkthrough).
     */
    public function getCardId(): ?string
    {
        return $this->cardId;
    }

    /**
     * Sets Card Id.
     * The ID of the [subscriber's](entity:Customer) [card](entity:Card) to charge.
     * If it is not specified, the subscriber receives an invoice via email. For an example to
     * create a customer profile for a subscriber and add a card on file, see [Subscriptions
     * Walkthrough](https://developer.squareup.com/docs/subscriptions-api/walkthrough).
     *
     * @maps card_id
     */
    public function setCardId(?string $cardId): void
    {
        $this->cardId = $cardId;
    }

    /**
     * Returns Timezone.
     * The timezone that is used in date calculations for the subscription. If unset, defaults to
     * the location timezone. If a timezone is not configured for the location, defaults to
     * "America/New_York".
     * Format: the IANA Timezone Database identifier for the location timezone. For
     * a list of time zones, see [List of tz database time zones](https://en.wikipedia.
     * org/wiki/List_of_tz_database_time_zones).
     */
    public function getTimezone(): ?string
    {
        return $this->timezone;
    }

    /**
     * Sets Timezone.
     * The timezone that is used in date calculations for the subscription. If unset, defaults to
     * the location timezone. If a timezone is not configured for the location, defaults to
     * "America/New_York".
     * Format: the IANA Timezone Database identifier for the location timezone. For
     * a list of time zones, see [List of tz database time zones](https://en.wikipedia.
     * org/wiki/List_of_tz_database_time_zones).
     *
     * @maps timezone
     */
    public function setTimezone(?string $timezone): void
    {
        $this->timezone = $timezone;
    }

    /**
     * Returns Source.
     * The origination details of the subscription.
     */
    public function getSource(): ?SubscriptionSource
    {
        return $this->source;
    }

    /**
     * Sets Source.
     * The origination details of the subscription.
     *
     * @maps source
     */
    public function setSource(?SubscriptionSource $source): void
    {
        $this->source = $source;
    }

    /**
     * Encode this object to JSON
     *
     * @param bool $asArrayWhenEmpty Whether to serialize this model as an array whenever no fields
     *        are set. (default: false)
     *
     * @return array|stdClass
     */
    #[\ReturnTypeWillChange] // @phan-suppress-current-line PhanUndeclaredClassAttribute for (php < 8.1)
    public function jsonSerialize(bool $asArrayWhenEmpty = false)
    {
        $json = [];
        if (isset($this->idempotencyKey)) {
            $json['idempotency_key']      = $this->idempotencyKey;
        }
        $json['location_id']              = $this->locationId;
        $json['plan_id']                  = $this->planId;
        $json['customer_id']              = $this->customerId;
        if (isset($this->startDate)) {
            $json['start_date']           = $this->startDate;
        }
        if (isset($this->canceledDate)) {
            $json['canceled_date']        = $this->canceledDate;
        }
        if (isset($this->taxPercentage)) {
            $json['tax_percentage']       = $this->taxPercentage;
        }
        if (isset($this->priceOverrideMoney)) {
            $json['price_override_money'] = $this->priceOverrideMoney;
        }
        if (isset($this->cardId)) {
            $json['card_id']              = $this->cardId;
        }
        if (isset($this->timezone)) {
            $json['timezone']             = $this->timezone;
        }
        if (isset($this->source)) {
            $json['source']               = $this->source;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
