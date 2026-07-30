<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Filter events by event type.
 */
class LoyaltyEventTypeFilter implements \JsonSerializable
{
    /**
     * @var string[]
     */
    private $types;

    /**
     * @param string[] $types
     */
    public function __construct(array $types)
    {
        $this->types = $types;
    }

    /**
     * Returns Types.
     * The loyalty event types used to filter the result.
     * If multiple values are specified, the endpoint uses a
     * logical OR to combine them.
     * See [LoyaltyEventType](#type-loyaltyeventtype) for possible values
     *
     * @return string[]
     */
    public function getTypes(): array
    {
        return $this->types;
    }

    /**
     * Sets Types.
     * The loyalty event types used to filter the result.
     * If multiple values are specified, the endpoint uses a
     * logical OR to combine them.
     * See [LoyaltyEventType](#type-loyaltyeventtype) for possible values
     *
     * @required
     * @maps types
     *
     * @param string[] $types
     */
    public function setTypes(array $types): void
    {
        $this->types = $types;
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
        $json['types'] = $this->types;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
