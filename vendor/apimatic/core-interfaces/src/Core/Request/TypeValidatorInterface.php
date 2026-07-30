<?php

namespace CoreInterfaces\Core\Request;

use InvalidArgumentException;

interface TypeValidatorInterface
{
    /**
     * @param mixed  $value                Value to be verified against the types
     * @param string $strictType           Strict single type i.e. string, ModelName, etc. or group of types
     *                                     in string format i.e. oneof(...), anyof(...)
     * @param array  $serializationMethods Methods required for the serialization of specific types in
     *                                     in the provided types/type, should be an array in the format:
     *                                     ['path/to/method argumentType', ...]. Default: []
     * @return mixed Returns validated and serialized $value
     * @throws InvalidArgumentException
     */
    public function verifyTypes($value, string $strictType, array $serializationMethods = []);
}
