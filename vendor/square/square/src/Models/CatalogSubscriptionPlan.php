<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Describes a subscription plan. For more information, see
 * [Set Up and Manage a Subscription Plan](https://developer.squareup.com/docs/subscriptions-api/setup-
 * plan).
 */
class CatalogSubscriptionPlan implements \JsonSerializable
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $phases = [];

    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * Returns Name.
     * The name of the plan.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Sets Name.
     * The name of the plan.
     *
     * @required
     * @maps name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Returns Phases.
     * A list of SubscriptionPhase containing the [SubscriptionPhase](entity:SubscriptionPhase) for this
     * plan.
     * This field it required. Not including this field will throw a REQUIRED_FIELD_MISSING error
     *
     * @return SubscriptionPhase[]|null
     */
    public function getPhases(): ?array
    {
        if (count($this->phases) == 0) {
            return null;
        }
        return $this->phases['value'];
    }

    /**
     * Sets Phases.
     * A list of SubscriptionPhase containing the [SubscriptionPhase](entity:SubscriptionPhase) for this
     * plan.
     * This field it required. Not including this field will throw a REQUIRED_FIELD_MISSING error
     *
     * @maps phases
     *
     * @param SubscriptionPhase[]|null $phases
     */
    public function setPhases(?array $phases): void
    {
        $this->phases['value'] = $phases;
    }

    /**
     * Unsets Phases.
     * A list of SubscriptionPhase containing the [SubscriptionPhase](entity:SubscriptionPhase) for this
     * plan.
     * This field it required. Not including this field will throw a REQUIRED_FIELD_MISSING error
     */
    public function unsetPhases(): void
    {
        $this->phases = [];
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
        $json['name']       = $this->name;
        if (!empty($this->phases)) {
            $json['phases'] = $this->phases['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
