<?php

/*
 * This file is part of the League\Fractal package.
 *
 * (c) Phil Sturgeon <me@philsturgeon.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace League\Fractal;

use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\NullResource;
use League\Fractal\Resource\Primitive;
use League\Fractal\Resource\ResourceInterface;

/**
 * All Transformer classes should extend this to utilize the convenience methods
 * collection() and item(), and make the self::$availableIncludes property available.
 * Extend it and add a `transform()` method to transform any default or included data
 * into a basic array.
 */
abstract class TransformerAbstract
{
    /**
     * Resources that can be included if requested.
     */
    protected array $availableIncludes = [];

    /**
     * Include resources without needing it to be requested.
     */
    protected array $defaultIncludes = [];

    /**
     * The transformer should know about the current scope, so we can fetch relevant params.
     */
    protected ?Scope $currentScope = null;

    /**
     * Getter for availableIncludes.
     */
    public function getAvailableIncludes(): array
    {
        return $this->availableIncludes;
    }

    /**
     * Getter for defaultIncludes.
     */
    public function getDefaultIncludes(): array
    {
        return $this->defaultIncludes;
    }

    /**
     * Getter for currentScope.
     */
    public function getCurrentScope(): ?Scope
    {
        return $this->currentScope;
    }

    /**
     * Figure out which includes we need.
     */
    private function figureOutWhichIncludes(Scope $scope): array
    {
        $includes = $this->getDefaultIncludes();

        foreach ($this->getAvailableIncludes() as $include) {
            if ($scope->isRequested($include)) {
                $includes[] = $include;
            }
        }

        foreach ($includes as $include) {
            if ($scope->isExcluded($include)) {
                $includes = array_diff($includes, [$include]);
            }
        }

        return $includes;
    }

    /**
     * This method is fired to loop through available includes, see if any of
     * them are requested and permitted for this scope.
     *
     * @internal
     *
     * @param mixed $data
     *
     * @return array|false
     */
    public function processIncludedResources(Scope $scope, $data)
    {
        $includedData = [];

        $includes = $this->figureOutWhichIncludes($scope);

        foreach ($includes as $include) {
            $includedData = $this->includeResourceIfAvailable(
                $scope,
                $data,
                $includedData,
                $include
            );
        }

        return $includedData === [] ? false : $includedData;
    }

    /**
     * Include a resource only if it is available on the method.
     *
     * @param mixed  $data
     */
    private function includeResourceIfAvailable(
        Scope $scope,
        $data,
        array $includedData,
        string $include
    ): array {
        if ($resource = $this->callIncludeMethod($scope, $include, $data)) {
            $childScope = $scope->embedChildScope($include, $resource);

            if ($childScope->getResource() instanceof Primitive) {
                $includedData[$include] = $childScope->transformPrimitiveResource();
            } else {
                $includedData[$include] = $childScope->toArray();
            }
        }

        return $includedData;
    }

    /**
     * Call Include Method.
     *
     * @internal
     *
     * @param mixed  $data
     *
     * @throws \Exception
     *
     * @return \League\Fractal\Resource\ResourceInterface|false
     */
    protected function callIncludeMethod(Scope $scope, string $includeName, $data)
    {
        $scopeIdentifier = $scope->getIdentifier($includeName);

        $params = $scope->getManager()->getIncludeParams($scopeIdentifier);

        // Check if the method name actually exists
        $methodName = 'include'.str_replace(
            ' ',
            '',
            ucwords(str_replace(
                '_',
                ' ',
                str_replace(
                    '-',
                    ' ',
                    $includeName
                )
            ))
        );

        $resource = call_user_func([$this, $methodName], $data, $params);

        if ($resource === null) {
            return false;
        }

        if (! $resource instanceof ResourceInterface) {
            throw new \Exception(sprintf(
                'Invalid return value from %s::%s(). Expected %s, received %s.',
                __CLASS__,
                $methodName,
                'League\Fractal\Resource\ResourceInterface',
                is_object($resource) ? get_class($resource) : gettype($resource)
            ));
        }

        return $resource;
    }

    /**
     * Setter for availableIncludes.
     */
    public function setAvailableIncludes(array $availableIncludes): self
    {
        $this->availableIncludes = $availableIncludes;

        return $this;
    }

    /**
     * Setter for defaultIncludes.
     */
    public function setDefaultIncludes(array $defaultIncludes): self
    {
        $this->defaultIncludes = $defaultIncludes;

        return $this;
    }

    /**
     * Setter for currentScope.
     */
    public function setCurrentScope(Scope $currentScope): self
    {
        $this->currentScope = $currentScope;

        return $this;
    }

    /**
     * Create a new primitive resource object.
     *
     * @param mixed                        $data
     * @param callable|null                $transformer
     */
    protected function primitive($data, ?callable $transformer = null, ?string $resourceKey = null): Primitive
    {
        return new Primitive($data, $transformer, $resourceKey);
    }

    /**
     * Create a new item resource object.
     *
     * @param mixed                        $data
     * @param TransformerAbstract|callable $transformer
     */
    protected function item($data, $transformer, ?string $resourceKey = null): Item
    {
        return new Item($data, $transformer, $resourceKey);
    }

    /**
     * Create a new collection resource object.
     *
     * @param mixed                        $data
     * @param TransformerAbstract|callable $transformer
     */
    protected function collection($data, $transformer, ?string $resourceKey = null): Collection
    {
        return new Collection($data, $transformer, $resourceKey);
    }

    /**
     * Create a new null resource object.
     */
    protected function null(): NullResource
    {
        return new NullResource();
    }
}
