<?php

namespace Spatie\Fractalistic;

use JsonSerializable;
use League\Fractal\Manager;
use League\Fractal\Pagination\CursorInterface;
use League\Fractal\Pagination\PaginatorInterface;
use League\Fractal\TransformerAbstract;
use Spatie\Fractalistic\Exceptions\InvalidTransformation;
use Spatie\Fractalistic\Exceptions\NoTransformerSpecified;
use Traversable;

class Fractal implements JsonSerializable
{
    /** @var \League\Fractal\Manager */
    protected $manager;

    /** @var int */
    protected $recursionLimit = 10;

    /** @var string|\League\Fractal\Serializer\SerializerAbstract */
    protected $serializer;

    /** @var string|callable|\League\Fractal\TransformerAbstract|null */
    protected $transformer;

    /** @var \League\Fractal\Pagination\PaginatorInterface */
    protected $paginator;

    /** @var \League\Fractal\Pagination\CursorInterface */
    protected $cursor;

    /** @var array */
    protected $includes = [];

    /** @var array */
    protected $excludes = [];

    /** @var array */
    protected $fieldsets = [];

    /** @var string */
    protected $dataType;

    /** @var mixed */
    protected $data;

    /** @var string|null */
    protected $resourceName = null;

    /** @var array */
    protected $meta = [];

    /**
     * @param null|mixed $data
     * @param null|string|callable|\League\Fractal\TransformerAbstract $transformer
     * @param null|string|\League\Fractal\Serializer\SerializerAbstract $serializer
     *
     * @return \Spatie\Fractalistic\Fractal
     */
    public static function create($data = null, $transformer = null, $serializer = null)
    {
        $instance = new static(new Manager());

        $instance->data = $data;
        $instance->dataType = $instance->determineDataType($data);
        $instance->transformer = $transformer ?: null;
        $instance->serializer = $serializer ?: null;

        return $instance;
    }

    /** @param \League\Fractal\Manager $manager */
    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Set the collection data that must be transformed.
     *
     * @param mixed $data
     * @param null|string|callable|\League\Fractal\TransformerAbstract $transformer
     * @param null|string $resourceName
     *
     * @return $this
     */
    public function collection($data, $transformer = null, $resourceName = null)
    {
        if (! is_null($resourceName)) {
            $this->resourceName = $resourceName;
        }

        return $this->data('collection', $data, $transformer);
    }

    /**
     * Set the item data that must be transformed.
     *
     * @param mixed $data
     * @param null|string|callable|\League\Fractal\TransformerAbstract $transformer
     * @param null|string $resourceName
     *
     * @return $this
     */
    public function item($data, $transformer = null, $resourceName = null)
    {
        if (! is_null($resourceName)) {
            $this->resourceName = $resourceName;
        }

        return $this->data('item', $data, $transformer);
    }

    /**
     * Set the primitive data that must be transformed.
     *
     * @param mixed $data
     * @param null|string|callable|\League\Fractal\TransformerAbstract $transformer
     * @param null|string $resourceName
     *
     * @return $this
     */
    public function primitive($data, $transformer = null, $resourceName = null)
    {
        if (! is_null($resourceName)) {
            $this->resourceName = $resourceName;
        }

        return $this->data('primitive', $data, $transformer);
    }

    /**
     * Set the data that must be transformed.
     *
     * @param string $dataType
     * @param mixed $data
     * @param null|string|callable|\League\Fractal\TransformerAbstract $transformer
     *
     * @return $this
     */
    public function data($dataType, $data, $transformer = null)
    {
        $this->dataType = $dataType;

        $this->data = $data;

        if (! is_null($transformer)) {
            $this->transformer = $transformer;
        }

        return $this;
    }

    /**
     * @param mixed $data
     *
     * @return string
     */
    protected function determineDataType($data)
    {
        if (is_null($data)) {
            return 'NullResource';
        }

        if (is_array($data)) {
            return 'collection';
        }

        if ($data instanceof Traversable) {
            return 'collection';
        }

        return 'item';
    }

    /**
     * Set the class or function that will perform the transform.
     *
     * @param string|callable|\League\Fractal\TransformerAbstract|null $transformer
     *
     * @return $this
     */
    public function transformWith($transformer)
    {
        $this->transformer = $transformer;

        return $this;
    }

    /**
     * Set the serializer to be used.
     *
     * @param string|\League\Fractal\Serializer\SerializerAbstract $serializer
     *
     * @return $this
     */
    public function serializeWith($serializer)
    {
        $this->serializer = $serializer;

        return $this;
    }

    /**
     * Set a Fractal paginator for the data.
     *
     * @param \League\Fractal\Pagination\PaginatorInterface $paginator
     *
     * @return $this
     */
    public function paginateWith(PaginatorInterface $paginator)
    {
        $this->paginator = $paginator;

        return $this;
    }

    /**
     * Set a Fractal cursor for the data.
     *
     * @param \League\Fractal\Pagination\CursorInterface $cursor
     *
     * @return $this
     */
    public function withCursor(CursorInterface $cursor)
    {
        $this->cursor = $cursor;

        return $this;
    }

    /**
     * Specify the includes.
     *
     * @param array|string $includes Array or string of resources to include.
     *
     * @return $this
     */
    public function parseIncludes($includes)
    {
        $includes = $this->normalizeIncludesOrExcludes($includes);

        $this->includes = array_merge($this->includes, (array) $includes);

        return $this;
    }

    /**
     * Specify the excludes.
     *
     * @param array|string $excludes Array or string of resources to exclude.
     *
     * @return $this
     */
    public function parseExcludes($excludes)
    {
        $excludes = $this->normalizeIncludesOrExcludes($excludes);

        $this->excludes = array_merge($this->excludes, (array) $excludes);

        return $this;
    }

    /**
     * Specify the fieldsets to include in the response.
     *
     * @param array $fieldsets array with key = resourceName and value = fields to include
     *                                (array or comma separated string with field names)
     *
     * @return $this
     */
    public function parseFieldsets(array $fieldsets)
    {
        foreach ($fieldsets as $key => $fields) {
            if (is_array($fields)) {
                $fieldsets[$key] = implode(',', $fields);
            }
        }

        $this->fieldsets = array_merge($this->fieldsets, $fieldsets);

        return $this;
    }

    /**
     * Normalize the includes an excludes.
     *
     * @param array|string $includesOrExcludes
     *
     * @return array|string
     */
    protected function normalizeIncludesOrExcludes($includesOrExcludes = '')
    {
        if (! is_string($includesOrExcludes)) {
            return $includesOrExcludes;
        }

        return array_map(function ($value) {
            return trim($value);
        }, explode(',', $includesOrExcludes));
    }

    /**
     * Set the meta data.
     *
     * @param $array,...
     *
     * @return $this
     */
    public function addMeta()
    {
        foreach (func_get_args() as $meta) {
            if (is_array($meta)) {
                $this->meta += $meta;
            }
        }

        return $this;
    }

    /**
     * Set the resource name, to replace 'data' as the root of the collection or item.
     *
     * @param string $resourceName
     *
     * @return $this
     */
    public function withResourceName($resourceName)
    {
        $this->resourceName = $resourceName;

        return $this;
    }

    /**
     * Upper limit to how many levels of included data are allowed.
     *
     * @param int $recursionLimit
     *
     * @return $this
     */
    public function limitRecursion(int $recursionLimit)
    {
        $this->recursionLimit = $recursionLimit;

        return $this;
    }

    /**
     * Perform the transformation to json.
     *
     * @param int $options
     *
     * @return string
     */
    public function toJson($options = 0)
    {
        return $this->createData()->toJson($options);
    }

    /**
     * Perform the transformation to array.
     *
     * @return array|null
     */
    public function toArray()
    {
        return $this->createData()->toArray();
    }

    /**
     * Create fractal data.
     *
     * @return \League\Fractal\Scope
     *
     * @throws \Spatie\Fractalistic\Exceptions\InvalidTransformation
     * @throws \Spatie\Fractalistic\Exceptions\NoTransformerSpecified
     */
    public function createData()
    {
        if (is_null($this->transformer)) {
            throw new NoTransformerSpecified();
        }

        if (is_string($this->serializer)) {
            $this->serializer = new $this->serializer;
        }

        if (! is_null($this->serializer)) {
            $this->manager->setSerializer($this->serializer);
        }

        $this->manager->setRecursionLimit($this->recursionLimit);

        if (! empty($this->includes)) {
            $this->manager->parseIncludes($this->includes);
        }

        if (! empty($this->excludes)) {
            $this->manager->parseExcludes($this->excludes);
        }

        if (! empty($this->fieldsets)) {
            $this->manager->parseFieldsets($this->fieldsets);
        }

        return $this->manager->createData($this->getResource());
    }

    /**
     * Get the resource class.
     *
     * @return string
     *
     * @throws \Spatie\Fractalistic\Exceptions\InvalidTransformation
     */
    public function getResourceClass(): string
    {
        $class = 'League\\Fractal\\Resource\\'.ucfirst($this->dataType);

        if (! class_exists($class)) {
            throw new InvalidTransformation();
        }

        return $class;
    }

    /**
     * Get the resource.
     *
     * @return \League\Fractal\Resource\ResourceInterface
     *
     * @throws \Spatie\Fractalistic\Exceptions\InvalidTransformation
     */
    public function getResource()
    {
        if (is_string($this->transformer)) {
            $this->transformer = new $this->transformer;
        }

        $resourceClass = $this->getResourceClass();
        $resource = new $resourceClass($this->data, $this->transformer, $this->resourceName);

        $resource->setMeta($this->meta);

        if (! is_null($this->paginator)) {
            $resource->setPaginator($this->paginator);
        }

        if (! is_null($this->cursor)) {
            $resource->setCursor($this->cursor);
        }

        return $resource;
    }

    /**
     * Return the name of the resource.
     *
     * @return string|null
     */
    public function getResourceName()
    {
        return $this->resourceName;
    }

    /**
     * Convert the object into something JSON serializable.
     *
     * @return array|null
     */
    #[\ReturnTypeWillChange]
    public function jsonSerialize(): ?array
    {
        return $this->toArray();
    }

    /**
     * Get the transformer.
     *
     * @return string|callable|\League\Fractal\TransformerAbstract|null
     */
    public function getTransformer()
    {
        return $this->transformer;
    }

    /**
     * Support for magic methods to included data.
     *
     * @param string $name
     * @param array $arguments
     *
     * @return $this
     */
    public function __call($name, array $arguments)
    {
        if ($this->startsWith($name, ['include'])) {
            $includeName = lcfirst(substr($name, strlen('include')));

            return $this->parseIncludes($includeName);
        }

        if ($this->startsWith($name, ['exclude'])) {
            $excludeName = lcfirst(substr($name, strlen('exclude')));

            return $this->parseExcludes($excludeName);
        }

        trigger_error('Call to undefined method '.__CLASS__.'::'.$name.'()', E_USER_ERROR);
    }

    /**
     * Determine if a given string starts with a given substring.
     *
     * @param  string $haystack
     * @param  string|array $needles
     *
     * @return bool
     */
    protected function startsWith($haystack, $needles)
    {
        foreach ((array) $needles as $needle) {
            if ($needle != '' && substr($haystack, 0, strlen($needle)) === (string) $needle) {
                return true;
            }
        }

        return false;
    }
}
