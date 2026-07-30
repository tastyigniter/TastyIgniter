<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents a create request for a `TeamMember` object.
 */
class CreateTeamMemberRequest implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $idempotencyKey;

    /**
     * @var TeamMember|null
     */
    private $teamMember;

    /**
     * Returns Idempotency Key.
     * A unique string that identifies this `CreateTeamMember` request.
     * Keys can be any valid string, but must be unique for every request.
     * For more information, see [Idempotency](https://developer.squareup.
     * com/docs/basics/api101/idempotency).
     *
     * The minimum length is 1 and the maximum length is 45.
     */
    public function getIdempotencyKey(): ?string
    {
        return $this->idempotencyKey;
    }

    /**
     * Sets Idempotency Key.
     * A unique string that identifies this `CreateTeamMember` request.
     * Keys can be any valid string, but must be unique for every request.
     * For more information, see [Idempotency](https://developer.squareup.
     * com/docs/basics/api101/idempotency).
     *
     * The minimum length is 1 and the maximum length is 45.
     *
     * @maps idempotency_key
     */
    public function setIdempotencyKey(?string $idempotencyKey): void
    {
        $this->idempotencyKey = $idempotencyKey;
    }

    /**
     * Returns Team Member.
     * A record representing an individual team member for a business.
     */
    public function getTeamMember(): ?TeamMember
    {
        return $this->teamMember;
    }

    /**
     * Sets Team Member.
     * A record representing an individual team member for a business.
     *
     * @maps team_member
     */
    public function setTeamMember(?TeamMember $teamMember): void
    {
        $this->teamMember = $teamMember;
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
        if (isset($this->idempotencyKey)) {
            $json['idempotency_key'] = $this->idempotencyKey;
        }
        if (isset($this->teamMember)) {
            $json['team_member']     = $this->teamMember;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
