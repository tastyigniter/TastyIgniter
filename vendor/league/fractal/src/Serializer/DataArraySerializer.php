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

class DataArraySerializer extends ArraySerializer
{
    /**
     * {@inheritDoc}
     */
    public function collection(?string $resourceKey, array $data): array
    {
        return ['data' => $data];
    }

    /**
     * {@inheritDoc}
     */
    public function item(?string $resourceKey, array $data): array
    {
        return ['data' => $data];
    }

    /**
     * {@inheritDoc}
     */
    public function null(): ?array
    {
        return ['data' => []];
    }
}
