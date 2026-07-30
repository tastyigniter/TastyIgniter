<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents a `RetrieveSnippet` response. The response can include either `snippet` or `errors`.
 */
class RetrieveSnippetResponse implements \JsonSerializable
{
    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * @var Snippet|null
     */
    private $snippet;

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
     * Returns Snippet.
     * Represents the snippet that is added to a Square Online site. The snippet code is injected into the
     * `head` element of all pages on the site, except for checkout pages.
     */
    public function getSnippet(): ?Snippet
    {
        return $this->snippet;
    }

    /**
     * Sets Snippet.
     * Represents the snippet that is added to a Square Online site. The snippet code is injected into the
     * `head` element of all pages on the site, except for checkout pages.
     *
     * @maps snippet
     */
    public function setSnippet(?Snippet $snippet): void
    {
        $this->snippet = $snippet;
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
            $json['errors']  = $this->errors;
        }
        if (isset($this->snippet)) {
            $json['snippet'] = $this->snippet;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
