<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Defines input parameters in a call to the
 * [SwapPlan]($e/Subscriptions/SwapPlan) endpoint.
 */
class SwapPlanRequest implements \JsonSerializable
{
    /**
     * @var string
     */
    private $newPlanId;

    /**
     * @param string $newPlanId
     */
    public function __construct(string $newPlanId)
    {
        $this->newPlanId = $newPlanId;
    }

    /**
     * Returns New Plan Id.
     * The ID of the new subscription plan.
     */
    public function getNewPlanId(): string
    {
        return $this->newPlanId;
    }

    /**
     * Sets New Plan Id.
     * The ID of the new subscription plan.
     *
     * @required
     * @maps new_plan_id
     */
    public function setNewPlanId(string $newPlanId): void
    {
        $this->newPlanId = $newPlanId;
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
        $json['new_plan_id'] = $this->newPlanId;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
