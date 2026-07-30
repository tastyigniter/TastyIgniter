<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents a response from a search request containing a filtered list of `TeamMember` objects.
 */
class SearchTeamMembersResponse implements \JsonSerializable
{
    /**
     * @var TeamMember[]|null
     */
    private $teamMembers;

    /**
     * @var string|null
     */
    private $cursor;

    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * Returns Team Members.
     * The filtered list of `TeamMember` objects.
     *
     * @return TeamMember[]|null
     */
    public function getTeamMembers(): ?array
    {
        return $this->teamMembers;
    }

    /**
     * Sets Team Members.
     * The filtered list of `TeamMember` objects.
     *
     * @maps team_members
     *
     * @param TeamMember[]|null $teamMembers
     */
    public function setTeamMembers(?array $teamMembers): void
    {
        $this->teamMembers = $teamMembers;
    }

    /**
     * Returns Cursor.
     * The opaque cursor for fetching the next page. For more information, see
     * [pagination](https://developer.squareup.com/docs/working-with-apis/pagination).
     */
    public function getCursor(): ?string
    {
        return $this->cursor;
    }

    /**
     * Sets Cursor.
     * The opaque cursor for fetching the next page. For more information, see
     * [pagination](https://developer.squareup.com/docs/working-with-apis/pagination).
     *
     * @maps cursor
     */
    public function setCursor(?string $cursor): void
    {
        $this->cursor = $cursor;
    }

    /**
     * Returns Errors.
     * The errors that occurred during the request.
     *
     * @return Error[]|null
     */
    public function getErrors(): ?array
    {
        return $this->errors;
    }

    /**
     * Sets Errors.
     * The errors that occurred during the request.
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
        if (isset($this->teamMembers)) {
            $json['team_members'] = $this->teamMembers;
        }
        if (isset($this->cursor)) {
            $json['cursor']       = $this->cursor;
        }
        if (isset($this->errors)) {
            $json['errors']       = $this->errors;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
