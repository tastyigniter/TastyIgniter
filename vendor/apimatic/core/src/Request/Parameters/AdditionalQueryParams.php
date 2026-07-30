<?php

declare(strict_types=1);

namespace Core\Request\Parameters;

class AdditionalQueryParams extends MultipleParams
{
    /**
     * Initializes a new AdditionalQueryParams object.
     */
    public static function init(?array $values): self
    {
        return new self($values ?? []);
    }

    private function __construct(array $values)
    {
        parent::__construct('additional query');
        $this->parameters = array_map(function ($key, $val) {
            return QueryParam::init($key, $val);
        }, array_keys($values), $values);
    }

    /**
     * Turns all parameters of the object to unIndexed.
     */
    public function unIndexed(): self
    {
        $this->parameters = array_map(function ($param) {
            return $param->unIndexed();
        }, $this->parameters);
        return $this;
    }

    /**
     * Turns all parameters of the object to plain.
     */
    public function plain(): self
    {
        $this->parameters = array_map(function ($param) {
            return $param->plain();
        }, $this->parameters);
        return $this;
    }

    /**
     * Turns all parameters of the object to comma separated.
     */
    public function commaSeparated(): self
    {
        $this->parameters = array_map(function ($param) {
            return $param->commaSeparated();
        }, $this->parameters);
        return $this;
    }

    /**
     * Turns all parameters of the object to tab separated.
     */
    public function tabSeparated(): self
    {
        $this->parameters = array_map(function ($param) {
            return $param->tabSeparated();
        }, $this->parameters);
        return $this;
    }

    /**
     * Turns all parameters of the object to pipe separated.
     */
    public function pipeSeparated(): self
    {
        $this->parameters = array_map(function ($param) {
            return $param->pipeSeparated();
        }, $this->parameters);
        return $this;
    }
}
