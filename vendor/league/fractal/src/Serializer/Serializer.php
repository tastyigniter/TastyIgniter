<?php
namespace League\Fractal\Serializer;

use League\Fractal\Pagination\CursorInterface;
use League\Fractal\Pagination\PaginatorInterface;
use League\Fractal\Resource\ResourceInterface;

interface Serializer
{
    /**
     * Serialize a collection.
     */
    public function collection(?string $resourceKey, array $data): array;

    /**
     * Serialize an item.
     */
    public function item(?string $resourceKey, array $data): array;

    /**
     * Serialize null resource.
     */
    public function null(): ?array;

    /**
     * Serialize the included data.
     */
    public function includedData(ResourceInterface $resource, array $data): array;

    /**
     * Serialize the meta.
     */
    public function meta(array $meta): array;

    /**
     * Serialize the paginator.
     */
    public function paginator(PaginatorInterface $paginator): array;

    /**
     * Serialize the cursor.
     */
    public function cursor(CursorInterface $cursor): array;

    public function mergeIncludes(array $transformedData, array $includedData): array;

    public function injectAvailableIncludeData(array $data, array $availableIncludes): array;

    /**
     * Indicates if includes should be side-loaded.
     */
    public function sideloadIncludes(): bool;

    /**
     * Hook for the serializer to inject custom data based on the relationships of the resource.
     */
    public function injectData(array $data, array $rawIncludedData): array;

    /**
     * Hook for the serializer to modify the final list of includes.
     */
    public function filterIncludes(array $includedData, array $data): array;

    /**
     * Get the mandatory fields for the serializer
     */
    public function getMandatoryFields(): array;
}
