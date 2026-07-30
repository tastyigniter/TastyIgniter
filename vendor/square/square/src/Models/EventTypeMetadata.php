<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Contains the metadata of a webhook event type.
 */
class EventTypeMetadata implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $eventType;

    /**
     * @var string|null
     */
    private $apiVersionIntroduced;

    /**
     * @var string|null
     */
    private $releaseStatus;

    /**
     * Returns Event Type.
     * The event type.
     */
    public function getEventType(): ?string
    {
        return $this->eventType;
    }

    /**
     * Sets Event Type.
     * The event type.
     *
     * @maps event_type
     */
    public function setEventType(?string $eventType): void
    {
        $this->eventType = $eventType;
    }

    /**
     * Returns Api Version Introduced.
     * The API version at which the event type was introduced.
     */
    public function getApiVersionIntroduced(): ?string
    {
        return $this->apiVersionIntroduced;
    }

    /**
     * Sets Api Version Introduced.
     * The API version at which the event type was introduced.
     *
     * @maps api_version_introduced
     */
    public function setApiVersionIntroduced(?string $apiVersionIntroduced): void
    {
        $this->apiVersionIntroduced = $apiVersionIntroduced;
    }

    /**
     * Returns Release Status.
     * The release status of the event type.
     */
    public function getReleaseStatus(): ?string
    {
        return $this->releaseStatus;
    }

    /**
     * Sets Release Status.
     * The release status of the event type.
     *
     * @maps release_status
     */
    public function setReleaseStatus(?string $releaseStatus): void
    {
        $this->releaseStatus = $releaseStatus;
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
        if (isset($this->eventType)) {
            $json['event_type']             = $this->eventType;
        }
        if (isset($this->apiVersionIntroduced)) {
            $json['api_version_introduced'] = $this->apiVersionIntroduced;
        }
        if (isset($this->releaseStatus)) {
            $json['release_status']         = $this->releaseStatus;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
