<?php

/*
 * This file is part of the League\Fractal package.
 *
 * (c) Phil Sturgeon <me@philsturgeon.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace League\Fractal\Serializer;

use InvalidArgumentException;
use League\Fractal\Pagination\PaginatorInterface;
use League\Fractal\Resource\ResourceInterface;

class JsonApiSerializer extends ArraySerializer
{
    protected ?string $baseUrl = null;
    protected array $rootObjects = [];

    public function __construct(?string $baseUrl = null)
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * {@inheritDoc}
     */
    public function collection(?string $resourceKey, array $data): array
    {
        $resources = [];

        foreach ($data as $resource) {
            $resources[] = $this->item($resourceKey, $resource)['data'];
        }

        return ['data' => $resources];
    }

    /**
     * {@inheritDoc}
     */
    public function item(?string $resourceKey, array $data): array
    {
        $id = $this->getIdFromData($data);

        $resource = [
            'data' => [
                'type' => $resourceKey,
                'id' => "$id",
                'attributes' => $data,
            ],
        ];

        unset($resource['data']['attributes']['id']);

        if (isset($resource['data']['attributes']['links'])) {
            $custom_links = $data['links'];
            unset($resource['data']['attributes']['links']);
        }

        if (isset($resource['data']['attributes']['meta'])) {
            $resource['data']['meta'] = $data['meta'];
            unset($resource['data']['attributes']['meta']);
        }

        if (empty($resource['data']['attributes'])) {
            $resource['data']['attributes'] = (object) [];
        }

        if ($this->shouldIncludeLinks()) {
            $resource['data']['links'] = [
                'self' => "{$this->baseUrl}/$resourceKey/$id",
            ];
            if (isset($custom_links)) {
                $resource['data']['links'] = array_merge($resource['data']['links'], $custom_links);
            }
        }

        return $resource;
    }

    /**
     * {@inheritDoc}
     */
    public function paginator(PaginatorInterface $paginator): array
    {
        $currentPage = $paginator->getCurrentPage();
        $lastPage = $paginator->getLastPage();

        $pagination = [
            'total' => $paginator->getTotal(),
            'count' => $paginator->getCount(),
            'per_page' => $paginator->getPerPage(),
            'current_page' => $currentPage,
            'total_pages' => $lastPage,
        ];

        $pagination['links'] = [];

        $pagination['links']['self'] = $paginator->getUrl($currentPage);
        $pagination['links']['first'] = $paginator->getUrl(1);

        if ($currentPage > 1) {
            $pagination['links']['prev'] = $paginator->getUrl($currentPage - 1);
        }

        if ($currentPage < $lastPage) {
            $pagination['links']['next'] = $paginator->getUrl($currentPage + 1);
        }

        $pagination['links']['last'] = $paginator->getUrl($lastPage);

        return ['pagination' => $pagination];
    }

    /**
     * {@inheritDoc}
     */
    public function meta(array $meta): array
    {
        if (empty($meta)) {
            return [];
        }

        $result['meta'] = $meta;

        if (array_key_exists('pagination', $result['meta'])) {
            $result['links'] = $result['meta']['pagination']['links'];
            unset($result['meta']['pagination']['links']);
        }

        return $result;
    }

    /**
     * {@inheritDoc}
     */
    public function null(): ?array
    {
        return [
            'data' => null,
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function includedData(ResourceInterface $resource, array $data): array
    {
        list($serializedData, $linkedIds) = $this->pullOutNestedIncludedData($data);

        foreach ($data as $value) {
            foreach ($value as $includeObject) {
                if ($this->isNull($includeObject) || $this->isEmpty($includeObject)) {
                    continue;
                }

                $includeObjects = $this->createIncludeObjects($includeObject);

                list($serializedData, $linkedIds) = $this->serializeIncludedObjectsWithCacheKey(
                    $includeObjects,
                    $linkedIds,
                    $serializedData
                );
            }
        }

        return empty($serializedData) ? [] : ['included' => $serializedData];
    }

    /**
     * {@inheritDoc}
     */
    public function sideloadIncludes(): bool
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function injectData(array $data, array $rawIncludedData): array
    {
        $relationships = $this->parseRelationships($rawIncludedData);

        if (!empty($relationships)) {
            $data = $this->fillRelationships($data, $relationships);
        }

        return $data;
    }

    /**
     * {@inheritDoc}
     *
     * Hook to manipulate the final sideloaded includes.
     * The JSON API specification does not allow the root object to be included
     * into the sideloaded `included`-array. We have to make sure it is
     * filtered out, in case some object links to the root object in a
     * relationship.
     */
    public function filterIncludes(array $includedData, array $data): array
    {
        if (!isset($includedData['included'])) {
            return $includedData;
        }

        // Create the RootObjects
        $this->createRootObjects($data);

        // Filter out the root objects
        $filteredIncludes = array_filter($includedData['included'], [$this, 'filterRootObject']);

        // Reset array indizes
        $includedData['included'] = array_merge([], $filteredIncludes);

        return $includedData;
    }

    /**
     * {@inheritDoc}
     */
    public function getMandatoryFields(): array
    {
        return ['id'];
    }

    /**
     * Filter function to delete root objects from array.
     */
    protected function filterRootObject(array $object): bool
    {
        return !$this->isRootObject($object);
    }

    /**
     * Set the root objects of the JSON API tree.
     */
    protected function setRootObjects(array $objects = []): void
    {
        $this->rootObjects = array_map(function ($object) {
            return "{$object['type']}:{$object['id']}";
        }, $objects);
    }

    /**
     * Determines whether an object is a root object of the JSON API tree.
     */
    protected function isRootObject(array $object): bool
    {
        $objectKey = "{$object['type']}:{$object['id']}";

        return in_array($objectKey, $this->rootObjects);
    }

    protected function isCollection(array $data): bool
    {
        return array_key_exists('data', $data) &&
            array_key_exists(0, $data['data']);
    }

    protected function isNull(array $data): bool
    {
        return array_key_exists('data', $data) && $data['data'] === null;
    }

    protected function isEmpty(array $data): bool
    {
        return array_key_exists('data', $data) && $data['data'] === [];
    }

    protected function fillRelationships(array $data, array $relationships): array
    {
        if ($this->isCollection($data)) {
            foreach ($relationships as $key => $relationship) {
                $data = $this->fillRelationshipAsCollection($data, $relationship, $key);
            }
        } else { // Single resource
            foreach ($relationships as $key => $relationship) {
                $data = $this->fillRelationshipAsSingleResource($data, $relationship, $key);
            }
        }

        return $data;
    }

    protected function parseRelationships(array $includedData): array
    {
        $relationships = [];

        foreach ($includedData as $key => $inclusion) {
            foreach ($inclusion as $includeKey => $includeObject) {
                $relationships = $this->buildRelationships($includeKey, $relationships, $includeObject, $key);
                if (isset($includedData[0][$includeKey]['meta'])) {
                    $relationships[$includeKey][0]['meta'] = $includedData[0][$includeKey]['meta'];
                }
            }
        }

        return $relationships;
    }

    /**
     * @return mixed
     */
    #[\ReturnTypeWillChange]
    protected function getIdFromData(array $data)
    {
        if (!array_key_exists('id', $data)) {
            throw new InvalidArgumentException(
                'JSON API resource objects MUST have a valid id'
            );
        }

        return $data['id'];
    }

    /**
     * Keep all sideloaded inclusion data on the top level.
     */
    protected function pullOutNestedIncludedData(array $data): array
    {
        $includedData = [];
        $linkedIds = [];

        foreach ($data as $value) {
            foreach ($value as $includeObject) {
                if (isset($includeObject['included'])) {
                    list($includedData, $linkedIds) = $this->serializeIncludedObjectsWithCacheKey(
                        $includeObject['included'],
                        $linkedIds,
                        $includedData
                    );
                }
            }
        }

        return [$includedData, $linkedIds];
    }

    /**
     * Whether or not the serializer should include `links` for resource objects.
     */
    protected function shouldIncludeLinks(): bool
    {
        return $this->baseUrl !== null;
    }

    /**
     * Check if the objects are part of a collection or not
     *
     * @param array|object $includeObject
     */
    private function createIncludeObjects($includeObject): array
    {
        if ($this->isCollection($includeObject)) {
            $includeObjects = $includeObject['data'];

            return $includeObjects;
        } else {
            $includeObjects = [$includeObject['data']];

            return $includeObjects;
        }
    }

    /**
     * Sets the RootObjects, either as collection or not.
     */
    private function createRootObjects(array $data): void
    {
        if ($this->isCollection($data)) {
            $this->setRootObjects($data['data']);
        } else {
            $this->setRootObjects([$data['data']]);
        }
    }


    /**
     * Loops over the relationships of the provided data and formats it
     */
    private function fillRelationshipAsCollection(array $data, array $relationship, string $key): array
    {
        foreach ($relationship as $index => $relationshipData) {
            $data['data'][$index]['relationships'][$key] = $relationshipData;
        }

        return $data;
    }

    private function fillRelationshipAsSingleResource(array $data, array $relationship, string $key): array
    {
        $data['data']['relationships'][$key] = $relationship[0];

        return $data;
    }

    private function buildRelationships(
        string $includeKey,
        array $relationships,
        array $includeObject,
        string $key
    ): array {
        $relationships = $this->addIncludekeyToRelationsIfNotSet($includeKey, $relationships);

        if ($this->isNull($includeObject)) {
            $relationship = $this->null();
        } elseif ($this->isEmpty($includeObject)) {
            $relationship = [
                'data' => [],
            ];
        } elseif ($this->isCollection($includeObject)) {
            $relationship = ['data' => []];

            $relationship = $this->addIncludedDataToRelationship($includeObject, $relationship);
        } else {
            $relationship = [
                'data' => [
                    'type' => $includeObject['data']['type'],
                    'id' => $includeObject['data']['id'],
                ],
            ];
        }

        $relationships[$includeKey][$key] = $relationship;

        return $relationships;
    }

    private function addIncludekeyToRelationsIfNotSet(string $includeKey, array $relationships): array
    {
        if (!array_key_exists($includeKey, $relationships)) {
            $relationships[$includeKey] = [];
            return $relationships;
        }

        return $relationships;
    }

    private function addIncludedDataToRelationship(array $includeObject, array $relationship): array
    {
        foreach ($includeObject['data'] as $object) {
            $relationship['data'][] = [
                'type' => $object['type'],
                'id' => $object['id'],
            ];
        }

        return $relationship;
    }

    /**
     * {@inheritdoc}
     */
    public function injectAvailableIncludeData(array $data, array $availableIncludes): array
    {
        if (!$this->shouldIncludeLinks()) {
            return $data;
        }

        if ($this->isCollection($data)) {
            $data['data'] = array_map(function ($resource) use ($availableIncludes) {
                foreach ($availableIncludes as $relationshipKey) {
                    $resource = $this->addRelationshipLinks($resource, $relationshipKey);
                }
                return $resource;
            }, $data['data']);
        } else {
            foreach ($availableIncludes as $relationshipKey) {
                $data['data'] = $this->addRelationshipLinks($data['data'], $relationshipKey);
            }
        }

        return $data;
    }

    /**
     * Adds links for all available includes to a single resource.
     *
     * @param array $resource         The resource to add relationship links to
     * @param string $relationshipKey The resource key of the relationship
     */
    private function addRelationshipLinks(array $resource, string $relationshipKey): array
    {
        if (!isset($resource['relationships']) || !isset($resource['relationships'][$relationshipKey])) {
            $resource['relationships'][$relationshipKey] = [];
        }

        $resource['relationships'][$relationshipKey] = array_merge(
            [
                'links' => [
                    'self' => "{$this->baseUrl}/{$resource['type']}/{$resource['id']}/relationships/{$relationshipKey}",
                    'related' => "{$this->baseUrl}/{$resource['type']}/{$resource['id']}/{$relationshipKey}",
                ]
            ],
            $resource['relationships'][$relationshipKey]
        );

        return $resource;
    }

    private function serializeIncludedObjectsWithCacheKey(
        array $includeObjects,
        array $linkedIds,
        array $serializedData
    ): array {
        foreach ($includeObjects as $object) {
            $includeType = $object['type'];
            $includeId = $object['id'];
            $cacheKey = "$includeType:$includeId";
            if (!array_key_exists($cacheKey, $linkedIds)) {
                $serializedData[] = $object;
                $linkedIds[$cacheKey] = $object;
            }
        }
        return [$serializedData, $linkedIds];
    }
}
