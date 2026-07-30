<?php

declare(strict_types=1);

namespace Core\Request\Parameters;

use CoreInterfaces\Core\Request\ParamInterface;
use CoreInterfaces\Core\Request\RequestSetterInterface;
use CoreInterfaces\Core\Request\TypeValidatorInterface;
use InvalidArgumentException;

class MultipleParams extends Parameter
{
    /**
     * @var ParamInterface[]
     */
    protected $parameters;

    public function __construct(string $typeName)
    {
        parent::__construct('', null, $typeName);
    }

    /**
     * @param ParamInterface[] $parameters
     */
    public function parameters(array $parameters): self
    {
        $this->parameters = $parameters;
        return $this;
    }

    /**
     * Validates all parameters of the object.
     *
     * @throws InvalidArgumentException
     */
    public function validate(TypeValidatorInterface $validator): void
    {
        if ($this->validated) {
            return;
        }
        array_walk($this->parameters, function ($param) use ($validator): void {
            $param->validate($validator);
        });
        $this->validated = true;
    }

    /**
     * Applies all parameters to the request provided.
     */
    public function apply(RequestSetterInterface $request): void
    {
        array_walk($this->parameters, function ($param) use ($request): void {
            $param->apply($request);
        });
    }
}
