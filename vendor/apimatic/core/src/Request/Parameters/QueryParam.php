<?php

declare(strict_types=1);

namespace Core\Request\Parameters;

use CoreInterfaces\Core\Request\RequestArraySerialization;
use CoreInterfaces\Core\Request\RequestSetterInterface;

class QueryParam extends EncodedParam
{
    /**
     * Initializes a query parameter with the key and value provided.
     */
    public static function init(string $key, $value): self
    {
        return new self($key, $value);
    }

    private function __construct(string $key, $value)
    {
        parent::__construct($key, $value, 'query');
    }

    /**
     * Sets the parameter format to un-indexed.
     */
    public function unIndexed(): self
    {
        $this->format = RequestArraySerialization::UN_INDEXED;
        return $this;
    }

    /**
     * Sets the parameter format to plain.
     */
    public function plain(): self
    {
        $this->format = RequestArraySerialization::PLAIN;
        return $this;
    }

    /**
     * Sets the parameter format to comma separated.
     */
    public function commaSeparated(): self
    {
        $this->format = RequestArraySerialization::CSV;
        return $this;
    }

    /**
     * Sets the parameter format to tab separated.
     */
    public function tabSeparated(): self
    {
        $this->format = RequestArraySerialization::TSV;
        return $this;
    }

    /**
     * Sets the parameter format to pipe separated.
     */
    public function pipeSeparated(): self
    {
        $this->format = RequestArraySerialization::PSV;
        return $this;
    }

    /**
     * Adds the parameter to the request provided.
     *
     * @param RequestSetterInterface $request The request to add the parameter to.
     */
    public function apply(RequestSetterInterface $request): void
    {
        if (!$this->validated) {
            return;
        }
        $value = $this->prepareValue($this->value);
        $query = $this->httpBuildQuery([$this->key => $value], $this->format);
        if (empty($query)) {
            return;
        }
        $hasParams = (strrpos($request->getQueryUrl(), '?') > 0);
        $separator = (($hasParams) ? '&' : '?');
        $request->appendPath($separator . $query);
    }
}
