<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * An object representing a team member's wage information.
 */
class WageSetting implements \JsonSerializable
{
    /**
     * @var array
     */
    private $teamMemberId = [];

    /**
     * @var array
     */
    private $jobAssignments = [];

    /**
     * @var array
     */
    private $isOvertimeExempt = [];

    /**
     * @var int|null
     */
    private $version;

    /**
     * @var string|null
     */
    private $createdAt;

    /**
     * @var string|null
     */
    private $updatedAt;

    /**
     * Returns Team Member Id.
     * The unique ID of the `TeamMember` whom this wage setting describes.
     */
    public function getTeamMemberId(): ?string
    {
        if (count($this->teamMemberId) == 0) {
            return null;
        }
        return $this->teamMemberId['value'];
    }

    /**
     * Sets Team Member Id.
     * The unique ID of the `TeamMember` whom this wage setting describes.
     *
     * @maps team_member_id
     */
    public function setTeamMemberId(?string $teamMemberId): void
    {
        $this->teamMemberId['value'] = $teamMemberId;
    }

    /**
     * Unsets Team Member Id.
     * The unique ID of the `TeamMember` whom this wage setting describes.
     */
    public function unsetTeamMemberId(): void
    {
        $this->teamMemberId = [];
    }

    /**
     * Returns Job Assignments.
     * Required. The ordered list of jobs that the team member is assigned to.
     * The first job assignment is considered the team member's primary job.
     *
     * The minimum length is 1 and the maximum length is 12.
     *
     * @return JobAssignment[]|null
     */
    public function getJobAssignments(): ?array
    {
        if (count($this->jobAssignments) == 0) {
            return null;
        }
        return $this->jobAssignments['value'];
    }

    /**
     * Sets Job Assignments.
     * Required. The ordered list of jobs that the team member is assigned to.
     * The first job assignment is considered the team member's primary job.
     *
     * The minimum length is 1 and the maximum length is 12.
     *
     * @maps job_assignments
     *
     * @param JobAssignment[]|null $jobAssignments
     */
    public function setJobAssignments(?array $jobAssignments): void
    {
        $this->jobAssignments['value'] = $jobAssignments;
    }

    /**
     * Unsets Job Assignments.
     * Required. The ordered list of jobs that the team member is assigned to.
     * The first job assignment is considered the team member's primary job.
     *
     * The minimum length is 1 and the maximum length is 12.
     */
    public function unsetJobAssignments(): void
    {
        $this->jobAssignments = [];
    }

    /**
     * Returns Is Overtime Exempt.
     * Whether the team member is exempt from the overtime rules of the seller's country.
     */
    public function getIsOvertimeExempt(): ?bool
    {
        if (count($this->isOvertimeExempt) == 0) {
            return null;
        }
        return $this->isOvertimeExempt['value'];
    }

    /**
     * Sets Is Overtime Exempt.
     * Whether the team member is exempt from the overtime rules of the seller's country.
     *
     * @maps is_overtime_exempt
     */
    public function setIsOvertimeExempt(?bool $isOvertimeExempt): void
    {
        $this->isOvertimeExempt['value'] = $isOvertimeExempt;
    }

    /**
     * Unsets Is Overtime Exempt.
     * Whether the team member is exempt from the overtime rules of the seller's country.
     */
    public function unsetIsOvertimeExempt(): void
    {
        $this->isOvertimeExempt = [];
    }

    /**
     * Returns Version.
     * Used for resolving concurrency issues. The request fails if the version
     * provided does not match the server version at the time of the request. If not provided,
     * Square executes a blind write, potentially overwriting data from another write. For more information,
     * see [optimistic concurrency](https://developer.squareup.com/docs/working-with-apis/optimistic-
     * concurrency).
     */
    public function getVersion(): ?int
    {
        return $this->version;
    }

    /**
     * Sets Version.
     * Used for resolving concurrency issues. The request fails if the version
     * provided does not match the server version at the time of the request. If not provided,
     * Square executes a blind write, potentially overwriting data from another write. For more information,
     * see [optimistic concurrency](https://developer.squareup.com/docs/working-with-apis/optimistic-
     * concurrency).
     *
     * @maps version
     */
    public function setVersion(?int $version): void
    {
        $this->version = $version;
    }

    /**
     * Returns Created At.
     * The timestamp, in RFC 3339 format, describing when the wage setting object was created.
     * For example, "2018-10-04T04:00:00-07:00" or "2019-02-05T12:00:00Z".
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * Sets Created At.
     * The timestamp, in RFC 3339 format, describing when the wage setting object was created.
     * For example, "2018-10-04T04:00:00-07:00" or "2019-02-05T12:00:00Z".
     *
     * @maps created_at
     */
    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Returns Updated At.
     * The timestamp, in RFC 3339 format, describing when the wage setting object was last updated.
     * For example, "2018-10-04T04:00:00-07:00" or "2019-02-05T12:00:00Z".
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    /**
     * Sets Updated At.
     * The timestamp, in RFC 3339 format, describing when the wage setting object was last updated.
     * For example, "2018-10-04T04:00:00-07:00" or "2019-02-05T12:00:00Z".
     *
     * @maps updated_at
     */
    public function setUpdatedAt(?string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
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
        if (!empty($this->teamMemberId)) {
            $json['team_member_id']     = $this->teamMemberId['value'];
        }
        if (!empty($this->jobAssignments)) {
            $json['job_assignments']    = $this->jobAssignments['value'];
        }
        if (!empty($this->isOvertimeExempt)) {
            $json['is_overtime_exempt'] = $this->isOvertimeExempt['value'];
        }
        if (isset($this->version)) {
            $json['version']            = $this->version;
        }
        if (isset($this->createdAt)) {
            $json['created_at']         = $this->createdAt;
        }
        if (isset($this->updatedAt)) {
            $json['updated_at']         = $this->updatedAt;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
