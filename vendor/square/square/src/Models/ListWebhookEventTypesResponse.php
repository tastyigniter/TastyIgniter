<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Defines the fields that are included in the response body of
 * a request to the [ListWebhookEventTypes]($e/WebhookSubscriptions/ListWebhookEventTypes) endpoint.
 *
 * Note: if there are errors processing the request, the event types field will not be
 * present.
 */
class ListWebhookEventTypesResponse implements \JsonSerializable
{
    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * @var string[]|null
     */
    private $eventTypes;

    /**
     * @var EventTypeMetadata[]|null
     */
    private $metadata;

    /**
     * Returns Errors.
     * Information on errors encountered during the request.
     *
     * @return Error[]|null
     */
    public function getErrors(): ?array
    {
        return $this->errors;
    }

    /**
     * Sets Errors.
     * Information on errors encountered during the request.
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
     * Returns Event Types.
     * The list of event types.
     *
     * @return string[]|null
     */
    public function getEventTypes(): ?array
    {
        return $this->eventTypes;
    }

    /**
     * Sets Event Types.
     * The list of event types.
     *
     * @maps event_types
     *
     * @param string[]|null $eventTypes
     */
    public function setEventTypes(?array $eventTypes): void
    {
        $this->eventTypes = $eventTypes;
    }

    /**
     * Returns Metadata.
     * Contains the metadata of a webhook event type. For more information, see [EventTypeMetadata](entity:
     * EventTypeMetadata).
     *
     * @return EventTypeMetadata[]|null
     */
    public function getMetadata(): ?array
    {
        return $this->metadata;
    }

    /**
     * Sets Metadata.
     * Contains the metadata of a webhook event type. For more information, see [EventTypeMetadata](entity:
     * EventTypeMetadata).
     *
     * @maps metadata
     *
     * @param EventTypeMetadata[]|null $metadata
     */
    public function setMetadata(?array $metadata): void
    {
        $this->metadata = $metadata;
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
        if (isset($this->errors)) {
            $json['errors']      = $this->errors;
        }
        if (isset($this->eventTypes)) {
            $json['event_types'] = $this->eventTypes;
        }
        if (isset($this->metadata)) {
            $json['metadata']    = $this->metadata;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
