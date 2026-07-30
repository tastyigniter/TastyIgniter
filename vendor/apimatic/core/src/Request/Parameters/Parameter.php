<?php

declare(strict_types=1);

namespace Core\Request\Parameters;

use Closure;
use CoreInterfaces\Core\Request\ParamInterface;
use CoreInterfaces\Core\Request\TypeValidatorInterface;
use InvalidArgumentException;
use Throwable;

abstract class Parameter implements ParamInterface
{
    protected $key;
    protected $value;
    protected $validated = false;
    private $valueMissing = false;
    private $serializationError;
    /**
     * @var string|null
     */
    private $paramStrictType;
    private $typeGroupSerializers = [];
    private $typeName;

    protected function __construct(string $key, $value, string $typeName)
    {
        $this->key = $key;
        $this->value = $value;
        $this->typeName = $typeName;
    }

    private function getName(): string
    {
        return $this->key == '' ? $this->typeName : $this->key;
    }

    /**
     * Extracting inner value using a `key` only if the current value is a collection i.e. array/object,
     * If key is not found in the value array then defaultValue will be used.
     */
    public function extract(string $key, $defaultValue = null): self
    {
        if (is_array($this->value)) {
            return $this->extractFromArray($key, $defaultValue);
        }
        if (is_object($this->value)) {
            $this->value = (array) $this->value;
            return $this->extractFromArray($key, $defaultValue);
        }
        return $this;
    }

    private function extractFromArray(string $key, $defaultValue): self
    {
        if (isset($this->value[$key])) {
            $this->value = $this->value[$key];
            return $this;
        }
        $this->value = $defaultValue;
        return $this;
    }

    /**
     * Marks the value of the parameter as required and throws an exception on validate if the value is missing.
     */
    public function required(): self
    {
        if (is_null($this->value)) {
            $this->valueMissing = true;
        }
        return $this;
    }

    /**
     * Serializes the parameter using the method provided.
     *
     * @param callable $serializerMethod The method to use for serialization.
     */
    public function serializeBy(callable $serializerMethod): self
    {
        try {
            $this->value = Closure::fromCallable($serializerMethod)($this->value);
        } catch (Throwable $e) {
            $this->serializationError = new InvalidArgumentException("Unable to serialize field: " .
                "{$this->getName()}, Due to:\n{$e->getMessage()}");
        }
        return $this;
    }

    /**
     * @param string   $strictType        Strict single type i.e. string, ModelName, etc. or group of types
     *                                    in string format i.e. oneof(...), anyof(...)
     * @param string[] $serializerMethods Methods required for the serialization of specific types in
     *                                    in the provided strict types/type, should be an array in the format:
     *                                    ['path/to/method argumentType', ...]. Default: []
     */
    public function strictType(string $strictType, array $serializerMethods = []): self
    {
        $this->paramStrictType = $strictType;
        $this->typeGroupSerializers = $serializerMethods;
        return $this;
    }

    /**
     * Validates if the parameter is in a valid state i.e. checks for missing value, serialization errors
     * and strict types.
     *
     * @throws InvalidArgumentException
     */
    public function validate(TypeValidatorInterface $validator): void
    {
        if ($this->validated) {
            return;
        }
        if ($this->valueMissing) {
            throw new InvalidArgumentException("Missing required $this->typeName field: {$this->getName()}");
        }
        if (isset($this->serializationError)) {
            throw $this->serializationError;
        }
        if (isset($this->paramStrictType)) {
            $this->value = $validator->verifyTypes(
                $this->value,
                $this->paramStrictType,
                $this->typeGroupSerializers
            );
        }
        $this->validated = true;
    }
}
