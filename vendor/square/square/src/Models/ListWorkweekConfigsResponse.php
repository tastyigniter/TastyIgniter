<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * The response to a request for a set of `WorkweekConfig` objects. The response contains
 * the requested `WorkweekConfig` objects and might contain a set of `Error` objects if
 * the request resulted in errors.
 */
class ListWorkweekConfigsResponse implements \JsonSerializable
{
    /**
     * @var WorkweekConfig[]|null
     */
    private $workweekConfigs;

    /**
     * @var string|null
     */
    private $cursor;

    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * Returns Workweek Configs.
     * A page of `WorkweekConfig` results.
     *
     * @return WorkweekConfig[]|null
     */
    public function getWorkweekConfigs(): ?array
    {
        return $this->workweekConfigs;
    }

    /**
     * Sets Workweek Configs.
     * A page of `WorkweekConfig` results.
     *
     * @maps workweek_configs
     *
     * @param WorkweekConfig[]|null $workweekConfigs
     */
    public function setWorkweekConfigs(?array $workweekConfigs): void
    {
        $this->workweekConfigs = $workweekConfigs;
    }

    /**
     * Returns Cursor.
     * The value supplied in the subsequent request to fetch the next page of
     * `WorkweekConfig` results.
     */
    public function getCursor(): ?string
    {
        return $this->cursor;
    }

    /**
     * Sets Cursor.
     * The value supplied in the subsequent request to fetch the next page of
     * `WorkweekConfig` results.
     *
     * @maps cursor
     */
    public function setCursor(?string $cursor): void
    {
        $this->cursor = $cursor;
    }

    /**
     * Returns Errors.
     * Any errors that occurred during the request.
     *
     * @return Error[]|null
     */
    public function getErrors(): ?array
    {
        return $this->errors;
    }

    /**
     * Sets Errors.
     * Any errors that occurred during the request.
     *
     * @maps errors
     *
     * @param Error[]|null $errors
     */
    public function setErrors(?array $errors): void
    {
        $this->errors = $errors;
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
        if (isset($this->workweekConfigs)) {
            $json['workweek_configs'] = $this->workweekConfigs;
        }
        if (isset($this->cursor)) {
            $json['cursor']           = $this->cursor;
        }
        if (isset($this->errors)) {
            $json['errors']           = $this->errors;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
