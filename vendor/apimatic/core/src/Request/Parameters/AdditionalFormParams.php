<?php

declare(strict_types=1);

namespace Core\Request\Parameters;

class AdditionalFormParams extends MultipleParams
{
    /**
     * Initializes an AdditionalFormParams object.
     */
    public static function init(?array $values): self
    {
        return new self($values ?? []);
    }

    private function __construct(array $values)
    {
        parent::__construct('additional form');
        $this->parameters = array_map(function ($key, $val) {
            return FormParam::init($key, $val);
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
}
