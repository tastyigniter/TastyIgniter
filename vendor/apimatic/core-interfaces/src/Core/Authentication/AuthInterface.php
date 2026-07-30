<?php

namespace CoreInterfaces\Core\Authentication;

use CoreInterfaces\Core\Request\RequestSetterInterface;
use CoreInterfaces\Core\Request\TypeValidatorInterface;
use InvalidArgumentException;

interface AuthInterface
{
    /**
     * @throws InvalidArgumentException
     */
    public function validate(TypeValidatorInterface $validator): void;
    public function apply(RequestSetterInterface $request): void;
}
