<?php

declare(strict_types=1);

namespace Igniter\Flame\Pagic\Source;

use Igniter\Flame\Pagic\Processors\Processor;

abstract class AbstractSource
{
    /** The query post processor implementation. */
    protected Processor $processor;

    /**
     * Get the query post processor used by the connection.
     */
    public function getProcessor(): Processor
    {
        return $this->processor;
    }

    /**
     * Generate a cache key unique to this source.
     */
    public function makeCacheKey(string $name = ''): int
    {
        return crc32($name);
    }
}
