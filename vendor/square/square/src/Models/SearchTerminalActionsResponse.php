<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class SearchTerminalActionsResponse implements \JsonSerializable
{
    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * @var TerminalAction[]|null
     */
    private $action;

    /**
     * @var string|null
     */
    private $cursor;

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
     * Returns Action.
     * The requested search result of `TerminalAction`s.
     *
     * @return TerminalAction[]|null
     */
    public function getAction(): ?array
    {
        return $this->action;
    }

    /**
     * Sets Action.
     * The requested search result of `TerminalAction`s.
     *
     * @maps action
     *
     * @param TerminalAction[]|null $action
     */
    public function setAction(?array $action): void
    {
        $this->action = $action;
    }

    /**
     * Returns Cursor.
     * The pagination cursor to be used in a subsequent request. If empty,
     * this is the final response.
     *
     * See [Pagination](https://developer.squareup.com/docs/build-basics/common-api-patterns/pagination)
     * for more
     * information.
     */
    public function getCursor(): ?string
    {
        return $this->cursor;
    }

    /**
     * Sets Cursor.
     * The pagination cursor to be used in a subsequent request. If empty,
     * this is the final response.
     *
     * See [Pagination](https://developer.squareup.com/docs/build-basics/common-api-patterns/pagination)
     * for more
     * information.
     *
     * @maps cursor
     */
    public function setCursor(?string $cursor): void
    {
        $this->cursor = $cursor;
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
            $json['errors'] = $this->errors;
        }
        if (isset($this->action)) {
            $json['action'] = $this->action;
        }
        if (isset($this->cursor)) {
            $json['cursor'] = $this->cursor;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
