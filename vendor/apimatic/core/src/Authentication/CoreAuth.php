<?php

declare(strict_types=1);

namespace Core\Authentication;

use CoreInterfaces\Core\Authentication\AuthInterface;
use CoreInterfaces\Core\Request\ParamInterface;
use CoreInterfaces\Core\Request\RequestSetterInterface;
use CoreInterfaces\Core\Request\TypeValidatorInterface;
use InvalidArgumentException;

/**
 * Use to apply authentication parameters to the request
 */
class CoreAuth implements AuthInterface
{
    private $parameters;
    private $isValid = false;

    /**
     * @param ParamInterface ...$parameters
     */
    public function __construct(...$parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function validate(TypeValidatorInterface $validator): void
    {
        if ($this->isValid) {
            return;
        }
        array_walk($this->parameters, function ($param) use ($validator): void {
            $param->validate($validator);
        });
        $this->isValid = true;
    }

    public function apply(RequestSetterInterface $request): void
    {
        if (!$this->isValid) {
            return;
        }
        array_walk($this->parameters, function ($param) use ($request): void {
            $param->apply($request);
        });
    }
}
