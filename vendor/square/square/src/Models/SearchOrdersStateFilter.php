<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Filter by the current order `state`.
 */
class SearchOrdersStateFilter implements \JsonSerializable
{
    /**
     * @var string[]
     */
    private $states;

    /**
     * @param string[] $states
     */
    public function __construct(array $states)
    {
        $this->states = $states;
    }

    /**
     * Returns States.
     * States to filter for.
     * See [OrderState](#type-orderstate) for possible values
     *
     * @return string[]
     */
    public function getStates(): array
    {
        return $this->states;
    }

    /**
     * Sets States.
     * States to filter for.
     * See [OrderState](#type-orderstate) for possible values
     *
     * @required
     * @maps states
     *
     * @param string[] $states
     */
    public function setStates(array $states): void
    {
        $this->states = $states;
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
        $json['states'] = $this->states;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
