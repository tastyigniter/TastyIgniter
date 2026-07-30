<?php

/*
 * This file is part of the League\Fractal package.
 *
 * (c) Phil Sturgeon <me@philsturgeon.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace League\Fractal\Resource;

use League\Fractal\TransformerAbstract;

abstract class ResourceAbstract implements ResourceInterface
{
    /**
     * Any item to process.
     *
     * @var mixed
     */
    protected $data;

    /**
     * Array of meta data.
     */
    protected array $meta = [];

    /**
     * The resource key.
     */
    protected ?string $resourceKey;

    /**
     * A callable to process the data attached to this resource.
     *
     * @var callable|TransformerAbstract|null
     */
    protected $transformer;

    /**
     * @param mixed                             $data
     * @param callable|TransformerAbstract|null $transformer
     */
    public function __construct($data = null, $transformer = null, ?string $resourceKey = null)
    {
        $this->data = $data;
        $this->transformer = $transformer;
        $this->resourceKey = $resourceKey;
    }

    /**
     * Get the data.
     *
     * @return mixed
     */
    #[\ReturnTypeWillChange]
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set the data.
     *
     * @param mixed $data
     */
    public function setData($data): self
    {
         $this->data = $data;

         return $this;
    }

    /**
     * Get the meta data.
     */
    public function getMeta(): array
    {
        return $this->meta;
    }

    /**
     * Get the meta data.
     *
     * @return mixed
     */
    #[\ReturnTypeWillChange]
    public function getMetaValue(string $metaKey)
    {
        return $this->meta[$metaKey];
    }

    public function getResourceKey(): string
    {
        return $this->resourceKey ?? '';
    }

    /**
     * Get the transformer.
     *
     * @return callable|TransformerAbstract|null
     */
    public function getTransformer()
    {
        return $this->transformer;
    }

    /**
     * Set the transformer.
     *
     * @param callable|TransformerAbstract $transformer
     */
    public function setTransformer($transformer): self
    {
        $this->transformer = $transformer;

        return $this;
    }

    /**
     * Set the meta data.
     */
    public function setMeta(array $meta): self
    {
        $this->meta = $meta;

        return $this;
    }

    /**
     * Set one meta data value.
     *
     * @param mixed  $metaValue
     */
    public function setMetaValue(string $metaKey, $metaValue): self
    {
        $this->meta[$metaKey] = $metaValue;

        return $this;
    }

    public function setResourceKey(string $resourceKey): self
    {
        $this->resourceKey = $resourceKey;

        return $this;
    }
}
