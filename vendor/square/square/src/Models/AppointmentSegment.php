<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Defines an appointment segment of a booking.
 */
class AppointmentSegment implements \JsonSerializable
{
    /**
     * @var array
     */
    private $durationMinutes = [];

    /**
     * @var array
     */
    private $serviceVariationId = [];

    /**
     * @var string
     */
    private $teamMemberId;

    /**
     * @var array
     */
    private $serviceVariationVersion = [];

    /**
     * @var int|null
     */
    private $intermissionMinutes;

    /**
     * @var bool|null
     */
    private $anyTeamMember;

    /**
     * @var string[]|null
     */
    private $resourceIds;

    /**
     * @param string $teamMemberId
     */
    public function __construct(string $teamMemberId)
    {
        $this->teamMemberId = $teamMemberId;
    }

    /**
     * Returns Duration Minutes.
     * The time span in minutes of an appointment segment.
     */
    public function getDurationMinutes(): ?int
    {
        if (count($this->durationMinutes) == 0) {
            return null;
        }
        return $this->durationMinutes['value'];
    }

    /**
     * Sets Duration Minutes.
     * The time span in minutes of an appointment segment.
     *
     * @maps duration_minutes
     */
    public function setDurationMinutes(?int $durationMinutes): void
    {
        $this->durationMinutes['value'] = $durationMinutes;
    }

    /**
     * Unsets Duration Minutes.
     * The time span in minutes of an appointment segment.
     */
    public function unsetDurationMinutes(): void
    {
        $this->durationMinutes = [];
    }

    /**
     * Returns Service Variation Id.
     * The ID of the [CatalogItemVariation](entity:CatalogItemVariation) object representing the service
     * booked in this segment.
     */
    public function getServiceVariationId(): ?string
    {
        if (count($this->serviceVariationId) == 0) {
            return null;
        }
        return $this->serviceVariationId['value'];
    }

    /**
     * Sets Service Variation Id.
     * The ID of the [CatalogItemVariation](entity:CatalogItemVariation) object representing the service
     * booked in this segment.
     *
     * @maps service_variation_id
     */
    public function setServiceVariationId(?string $serviceVariationId): void
    {
        $this->serviceVariationId['value'] = $serviceVariationId;
    }

    /**
     * Unsets Service Variation Id.
     * The ID of the [CatalogItemVariation](entity:CatalogItemVariation) object representing the service
     * booked in this segment.
     */
    public function unsetServiceVariationId(): void
    {
        $this->serviceVariationId = [];
    }

    /**
     * Returns Team Member Id.
     * The ID of the [TeamMember](entity:TeamMember) object representing the team member booked in this
     * segment.
     */
    public function getTeamMemberId(): string
    {
        return $this->teamMemberId;
    }

    /**
     * Sets Team Member Id.
     * The ID of the [TeamMember](entity:TeamMember) object representing the team member booked in this
     * segment.
     *
     * @required
     * @maps team_member_id
     */
    public function setTeamMemberId(string $teamMemberId): void
    {
        $this->teamMemberId = $teamMemberId;
    }

    /**
     * Returns Service Variation Version.
     * The current version of the item variation representing the service booked in this segment.
     */
    public function getServiceVariationVersion(): ?int
    {
        if (count($this->serviceVariationVersion) == 0) {
            return null;
        }
        return $this->serviceVariationVersion['value'];
    }

    /**
     * Sets Service Variation Version.
     * The current version of the item variation representing the service booked in this segment.
     *
     * @maps service_variation_version
     */
    public function setServiceVariationVersion(?int $serviceVariationVersion): void
    {
        $this->serviceVariationVersion['value'] = $serviceVariationVersion;
    }

    /**
     * Unsets Service Variation Version.
     * The current version of the item variation representing the service booked in this segment.
     */
    public function unsetServiceVariationVersion(): void
    {
        $this->serviceVariationVersion = [];
    }

    /**
     * Returns Intermission Minutes.
     * Time between the end of this segment and the beginning of the subsequent segment.
     */
    public function getIntermissionMinutes(): ?int
    {
        return $this->intermissionMinutes;
    }

    /**
     * Sets Intermission Minutes.
     * Time between the end of this segment and the beginning of the subsequent segment.
     *
     * @maps intermission_minutes
     */
    public function setIntermissionMinutes(?int $intermissionMinutes): void
    {
        $this->intermissionMinutes = $intermissionMinutes;
    }

    /**
     * Returns Any Team Member.
     * Whether the customer accepts any team member, instead of a specific one, to serve this segment.
     */
    public function getAnyTeamMember(): ?bool
    {
        return $this->anyTeamMember;
    }

    /**
     * Sets Any Team Member.
     * Whether the customer accepts any team member, instead of a specific one, to serve this segment.
     *
     * @maps any_team_member
     */
    public function setAnyTeamMember(?bool $anyTeamMember): void
    {
        $this->anyTeamMember = $anyTeamMember;
    }

    /**
     * Returns Resource Ids.
     * The IDs of the seller-accessible resources used for this appointment segment.
     *
     * @return string[]|null
     */
    public function getResourceIds(): ?array
    {
        return $this->resourceIds;
    }

    /**
     * Sets Resource Ids.
     * The IDs of the seller-accessible resources used for this appointment segment.
     *
     * @maps resource_ids
     *
     * @param string[]|null $resourceIds
     */
    public function setResourceIds(?array $resourceIds): void
    {
        $this->resourceIds = $resourceIds;
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
        if (!empty($this->durationMinutes)) {
            $json['duration_minutes']          = $this->durationMinutes['value'];
        }
        if (!empty($this->serviceVariationId)) {
            $json['service_variation_id']      = $this->serviceVariationId['value'];
        }
        $json['team_member_id']                = $this->teamMemberId;
        if (!empty($this->serviceVariationVersion)) {
            $json['service_variation_version'] = $this->serviceVariationVersion['value'];
        }
        if (isset($this->intermissionMinutes)) {
            $json['intermission_minutes']      = $this->intermissionMinutes;
        }
        if (isset($this->anyTeamMember)) {
            $json['any_team_member']           = $this->anyTeamMember;
        }
        if (isset($this->resourceIds)) {
            $json['resource_ids']              = $this->resourceIds;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
