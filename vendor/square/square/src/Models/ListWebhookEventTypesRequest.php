<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Lists all webhook event types that can be subscribed to.
 */
class ListWebhookEventTypesRequest implements \JsonSerializable
{
    /**
     * @var array
     */
    private $apiVersion = [];

    /**
     * Returns Api Version.
     * The API version for which to list event types. Setting this field overrides the default version used
     * by the application.
     */
    public function getApiVersion(): ?string
    {
        if (count($this->apiVersion) == 0) {
            return null;
        }
        return $this->apiVersion['value'];
    }

    /**
     * Sets Api Version.
     * The API version for which to list event types. Setting this field overrides the default version used
     * by the application.
     *
     * @maps api_version
     */
    public function setApiVersion(?string $apiVersion): void
    {
        $this->apiVersion['value'] = $apiVersion;
    }

    /**
     * Unsets Api Version.
     * The API version for which to list event types. Setting this field overrides the default version used
     * by the application.
     */
    public function unsetApiVersion(): void
    {
        $this->apiVersion = [];
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
        if (!empty($this->apiVersion)) {
            $json['api_version'] = $this->apiVersion['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
