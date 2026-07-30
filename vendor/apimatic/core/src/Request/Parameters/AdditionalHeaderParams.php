<?php

declare(strict_types=1);

namespace Core\Request\Parameters;

class AdditionalHeaderParams extends MultipleParams
{
    public static function init(?array $values): self
    {
        return new self($values ?? []);
    }

    private function __construct(array $values)
    {
        parent::__construct('additional header');
        $this->parameters = array_map(function ($key, $val) {
            return HeaderParam::init($key, $val);
        }, array_keys($values), $values);
    }
}
