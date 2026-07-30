<?php

namespace CoreInterfaces\Core\Request;

use InvalidArgumentException;

interface ParamInterface
{
    /**
     * Pick current parameter's value from a collected parameters array,
     * if key is not found then use the given default value
     */
    public function extract(string $key, $defaultValue = null);
    public function required();
    /**
     * To perform validation and serialization for un unusual types.
     */
    public function serializeBy(callable $serializerMethod);
    /**
     * @param string   $strictType        Strict single type i.e. string, ModelName, etc. or group of types
     *                                    in string format i.e. oneof(...), anyof(...)
     * @param string[] $serializerMethods Methods required for the serialization of specific types in
     *                                    in the provided strict types/type, should be an array in the format:
     *                                    ['path/to/method argumentType', ...]. Default: []
     */
    public function strictType(string $strictType, array $serializerMethods = []);
    /**
     * @throws InvalidArgumentException
     */
    public function validate(TypeValidatorInterface $validator): void;
    public function apply(RequestSetterInterface $request): void;
}
