<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Describes changes to a subscription and the subscription status.
 */
class SubscriptionEvent implements \JsonSerializable
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $subscriptionEventType;

    /**
     * @var string
     */
    private $effectiveDate;

    /**
     * @var string
     */
    private $planId;

    /**
     * @var SubscriptionEventInfo|null
     */
    private $info;

    /**
     * @param string $id
     * @param string $subscriptionEventType
     * @param string $effectiveDate
     * @param string $planId
     */
    public function __construct(string $id, string $subscriptionEventType, string $effectiveDate, string $planId)
    {
        $this->id = $id;
        $this->subscriptionEventType = $subscriptionEventType;
        $this->effectiveDate = $effectiveDate;
        $this->planId = $planId;
    }

    /**
     * Returns Id.
     * The ID of the subscription event.
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Sets Id.
     * The ID of the subscription event.
     *
     * @required
     * @maps id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * Returns Subscription Event Type.
     * Supported types of an event occurred to a subscription.
     */
    public function getSubscriptionEventType(): string
    {
        return $this->subscriptionEventType;
    }

    /**
     * Sets Subscription Event Type.
     * Supported types of an event occurred to a subscription.
     *
     * @required
     * @maps subscription_event_type
     */
    public function setSubscriptionEventType(string $subscriptionEventType): void
    {
        $this->subscriptionEventType = $subscriptionEventType;
    }

    /**
     * Returns Effective Date.
     * The `YYYY-MM-DD`-formatted date (for example, 2013-01-15) when the subscription event occurred.
     */
    public function getEffectiveDate(): string
    {
        return $this->effectiveDate;
    }

    /**
     * Sets Effective Date.
     * The `YYYY-MM-DD`-formatted date (for example, 2013-01-15) when the subscription event occurred.
     *
     * @required
     * @maps effective_date
     */
    public function setEffectiveDate(string $effectiveDate): void
    {
        $this->effectiveDate = $effectiveDate;
    }

    /**
     * Returns Plan Id.
     * The ID of the subscription plan associated with the subscription.
     */
    public function getPlanId(): string
    {
        return $this->planId;
    }

    /**
     * Sets Plan Id.
     * The ID of the subscription plan associated with the subscription.
     *
     * @required
     * @maps plan_id
     */
    public function setPlanId(string $planId): void
    {
        $this->planId = $planId;
    }

    /**
     * Returns Info.
     * Provides information about the subscription event.
     */
    public function getInfo(): ?SubscriptionEventInfo
    {
        return $this->info;
    }

    /**
     * Sets Info.
     * Provides information about the subscription event.
     *
     * @maps info
     */
    public function setInfo(?SubscriptionEventInfo $info): void
    {
        $this->info = $info;
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
        $json['id']                      = $this->id;
        $json['subscription_event_type'] = $this->subscriptionEventType;
        $json['effective_date']          = $this->effectiveDate;
        $json['plan_id']                 = $this->planId;
        if (isset($this->info)) {
            $json['info']                = $this->info;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
