<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents an action as a pending change to a subscription.
 */
class SubscriptionAction implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $id;

    /**
     * @var string|null
     */
    private $type;

    /**
     * @var array
     */
    private $effectiveDate = [];

    /**
     * @var array
     */
    private $newPlanId = [];

    /**
     * Returns Id.
     * The ID of an action scoped to a subscription.
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Sets Id.
     * The ID of an action scoped to a subscription.
     *
     * @maps id
     */
    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    /**
     * Returns Type.
     * Supported types of an action as a pending change to a subscription.
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * Sets Type.
     * Supported types of an action as a pending change to a subscription.
     *
     * @maps type
     */
    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    /**
     * Returns Effective Date.
     * The `YYYY-MM-DD`-formatted date when the action occurs on the subscription.
     */
    public function getEffectiveDate(): ?string
    {
        if (count($this->effectiveDate) == 0) {
            return null;
        }
        return $this->effectiveDate['value'];
    }

    /**
     * Sets Effective Date.
     * The `YYYY-MM-DD`-formatted date when the action occurs on the subscription.
     *
     * @maps effective_date
     */
    public function setEffectiveDate(?string $effectiveDate): void
    {
        $this->effectiveDate['value'] = $effectiveDate;
    }

    /**
     * Unsets Effective Date.
     * The `YYYY-MM-DD`-formatted date when the action occurs on the subscription.
     */
    public function unsetEffectiveDate(): void
    {
        $this->effectiveDate = [];
    }

    /**
     * Returns New Plan Id.
     * The target subscription plan a subscription switches to, for a `SWAP_PLAN` action.
     */
    public function getNewPlanId(): ?string
    {
        if (count($this->newPlanId) == 0) {
            return null;
        }
        return $this->newPlanId['value'];
    }

    /**
     * Sets New Plan Id.
     * The target subscription plan a subscription switches to, for a `SWAP_PLAN` action.
     *
     * @maps new_plan_id
     */
    public function setNewPlanId(?string $newPlanId): void
    {
        $this->newPlanId['value'] = $newPlanId;
    }

    /**
     * Unsets New Plan Id.
     * The target subscription plan a subscription switches to, for a `SWAP_PLAN` action.
     */
    public function unsetNewPlanId(): void
    {
        $this->newPlanId = [];
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
        if (isset($this->id)) {
            $json['id']             = $this->id;
        }
        if (isset($this->type)) {
            $json['type']           = $this->type;
        }
        if (!empty($this->effectiveDate)) {
            $json['effective_date'] = $this->effectiveDate['value'];
        }
        if (!empty($this->newPlanId)) {
            $json['new_plan_id']    = $this->newPlanId['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
