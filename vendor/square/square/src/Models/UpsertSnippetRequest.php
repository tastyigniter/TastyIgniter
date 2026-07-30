<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents an `UpsertSnippet` request.
 */
class UpsertSnippetRequest implements \JsonSerializable
{
    /**
     * @var Snippet
     */
    private $snippet;

    /**
     * @param Snippet $snippet
     */
    public function __construct(Snippet $snippet)
    {
        $this->snippet = $snippet;
    }

    /**
     * Returns Snippet.
     * Represents the snippet that is added to a Square Online site. The snippet code is injected into the
     * `head` element of all pages on the site, except for checkout pages.
     */
    public function getSnippet(): Snippet
    {
        return $this->snippet;
    }

    /**
     * Sets Snippet.
     * Represents the snippet that is added to a Square Online site. The snippet code is injected into the
     * `head` element of all pages on the site, except for checkout pages.
     *
     * @required
     * @maps snippet
     */
    public function setSnippet(Snippet $snippet): void
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
        $json['snippet'] = $this->snippet;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
