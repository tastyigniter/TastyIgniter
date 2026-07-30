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

use League\Fractal\Pagination\CursorInterface;
use League\Fractal\Pagination\PaginatorInterface;
use League\Fractal\Resource\ResourceInterface;

abstract class SerializerAbstract implements Serializer
{
    /**
     * {@inheritDoc}
     */
    public function mergeIncludes(array $transformedData, array $includedData): array
    {
        // If the serializer does not want the includes to be side-loaded then
        // the included data must be merged with the transformed data.
        if (! $this->sideloadIncludes()) {
            return array_merge($transformedData, $includedData);
        }

        return $transformedData;
    }

    /**
     * {@inheritDoc}
     */
    public function sideloadIncludes(): bool
    {
        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function injectData(array $data, array $rawIncludedData): array
    {
        return $data;
    }

    /**
     * {@inheritDoc}
     */
    public function injectAvailableIncludeData(array $data, array $availableIncludes): array
    {
        return $data;
    }

    /**
     * {@inheritDoc}
     */
    public function filterIncludes(array $includedData, array $data): array
    {
        return $includedData;
    }

    /**
     * {@inheritDoc}
     */
    public function getMandatoryFields(): array
    {
        return [];
    }
}
