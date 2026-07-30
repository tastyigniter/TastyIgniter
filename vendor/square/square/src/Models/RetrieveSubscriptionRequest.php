<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Defines input parameters in a request to the
 * [RetrieveSubscription]($e/Subscriptions/RetrieveSubscription) endpoint.
 */
class RetrieveSubscriptionRequest implements \JsonSerializable
{
    /**
     * @var array
     */
    private $include = [];

    /**
     * Returns Include.
     * A query parameter to specify related information to be included in the response.
     *
     * The supported query parameter values are:
     *
     * - `actions`: to include scheduled actions on the targeted subscription.
     */
    public function getInclude(): ?string
    {
        if (count($this->include) == 0) {
            return null;
        }
        return $this->include['value'];
    }

    /**
     * Sets Include.
     * A query parameter to specify related information to be included in the response.
     *
     * The supported query parameter values are:
     *
     * - `actions`: to include scheduled actions on the targeted subscription.
     *
     * @maps include
     */
    public function setInclude(?string $include): void
    {
        $this->include['value'] = $include;
    }

    /**
     * Unsets Include.
     * A query parameter to specify related information to be included in the response.
     *
     * The supported query parameter values are:
     *
     * - `actions`: to include scheduled actions on the targeted subscription.
     */
    public function unsetInclude(): void
    {
        $this->include = [];
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
        if (!empty($this->include)) {
            $json['include'] = $this->include['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
