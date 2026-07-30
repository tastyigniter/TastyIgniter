<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Describes a phase in a subscription plan. For more information, see
 * [Set Up and Manage a Subscription Plan](https://developer.squareup.com/docs/subscriptions-api/setup-
 * plan).
 */
class SubscriptionPhase implements \JsonSerializable
{
    /**
     * @var array
     */
    private $uid = [];

    /**
     * @var string
     */
    private $cadence;

    /**
     * @var array
     */
    private $periods = [];

    /**
     * @var Money|null
     */
    private $recurringPriceMoney;

    /**
     * @var array
     */
    private $ordinal = [];

    /**
     * @param string $cadence
     */
    public function __construct(string $cadence)
    {
        $this->cadence = $cadence;
    }

    /**
     * Returns Uid.
     * The Square-assigned ID of the subscription phase. This field cannot be changed after a
     * `SubscriptionPhase` is created.
     */
    public function getUid(): ?string
    {
        if (count($this->uid) == 0) {
            return null;
        }
        return $this->uid['value'];
    }

    /**
     * Sets Uid.
     * The Square-assigned ID of the subscription phase. This field cannot be changed after a
     * `SubscriptionPhase` is created.
     *
     * @maps uid
     */
    public function setUid(?string $uid): void
    {
        $this->uid['value'] = $uid;
    }

    /**
     * Unsets Uid.
     * The Square-assigned ID of the subscription phase. This field cannot be changed after a
     * `SubscriptionPhase` is created.
     */
    public function unsetUid(): void
    {
        $this->uid = [];
    }

    /**
     * Returns Cadence.
     * Determines the billing cadence of a [Subscription]($m/Subscription)
     */
    public function getCadence(): string
    {
        return $this->cadence;
    }

    /**
     * Sets Cadence.
     * Determines the billing cadence of a [Subscription]($m/Subscription)
     *
     * @required
     * @maps cadence
     */
    public function setCadence(string $cadence): void
    {
        $this->cadence = $cadence;
    }

    /**
     * Returns Periods.
     * The number of `cadence`s the phase lasts. If not set, the phase never ends. Only the last phase can
     * be indefinite. This field cannot be changed after a `SubscriptionPhase` is created.
     */
    public function getPeriods(): ?int
    {
        if (count($this->periods) == 0) {
            return null;
        }
        return $this->periods['value'];
    }

    /**
     * Sets Periods.
     * The number of `cadence`s the phase lasts. If not set, the phase never ends. Only the last phase can
     * be indefinite. This field cannot be changed after a `SubscriptionPhase` is created.
     *
     * @maps periods
     */
    public function setPeriods(?int $periods): void
    {
        $this->periods['value'] = $periods;
    }

    /**
     * Unsets Periods.
     * The number of `cadence`s the phase lasts. If not set, the phase never ends. Only the last phase can
     * be indefinite. This field cannot be changed after a `SubscriptionPhase` is created.
     */
    public function unsetPeriods(): void
    {
        $this->periods = [];
    }

    /**
     * Returns Recurring Price Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     */
    public function getRecurringPriceMoney(): ?Money
    {
        return $this->recurringPriceMoney;
    }

    /**
     * Sets Recurring Price Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     *
     * @maps recurring_price_money
     */
    public function setRecurringPriceMoney(?Money $recurringPriceMoney): void
    {
        $this->recurringPriceMoney = $recurringPriceMoney;
    }

    /**
     * Returns Ordinal.
     * The position this phase appears in the sequence of phases defined for the plan, indexed from 0. This
     * field cannot be changed after a `SubscriptionPhase` is created.
     */
    public function getOrdinal(): ?int
    {
        if (count($this->ordinal) == 0) {
            return null;
        }
        return $this->ordinal['value'];
    }

    /**
     * Sets Ordinal.
     * The position this phase appears in the sequence of phases defined for the plan, indexed from 0. This
     * field cannot be changed after a `SubscriptionPhase` is created.
     *
     * @maps ordinal
     */
    public function setOrdinal(?int $ordinal): void
    {
        $this->ordinal['value'] = $ordinal;
    }

    /**
     * Unsets Ordinal.
     * The position this phase appears in the sequence of phases defined for the plan, indexed from 0. This
     * field cannot be changed after a `SubscriptionPhase` is created.
     */
    public function unsetOrdinal(): void
    {
        $this->ordinal = [];
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
        if (!empty($this->uid)) {
            $json['uid']                   = $this->uid['value'];
        }
        $json['cadence']                   = $this->cadence;
        if (!empty($this->periods)) {
            $json['periods']               = $this->periods['value'];
        }
        if (isset($this->recurringPriceMoney)) {
            $json['recurring_price_money'] = $this->recurringPriceMoney;
        }
        if (!empty($this->ordinal)) {
            $json['ordinal']               = $this->ordinal['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
