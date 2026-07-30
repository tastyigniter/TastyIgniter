<?php

declare(strict_types=1);

namespace Igniter\Flame\Database\Connections;

use Igniter\Flame\Database\MemoryCache;
use Igniter\Flame\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Connection as ConnectionBase;
use Override;

class Connection extends ConnectionBase
{
    /**
     * Get a new query builder instance.
     */
    #[Override]
    public function query(): QueryBuilder
    {
        return new QueryBuilder(
            $this,
            $this->getQueryGrammar(),
            $this->getPostProcessor(),
        );
    }

    /**
     * Flush the memory cache.
     */
    public static function flushDuplicateCache(): void
    {
        resolve(MemoryCache::class)->flush();
    }

    /**
     * Log a query in the connection's query log.
     *
     * @param string $query
     * @param array $bindings
     * @param float|null $time
     */
    #[Override]
    public function logQuery($query, $bindings, $time = null): void
    {
        if (isset($this->events)) {
            $this->events->dispatch('illuminate.query', [$query, $bindings, $time, $this->getName()]);
        }

        parent::logQuery($query, $bindings, $time);
    }

    /**
     * Fire an event for this connection.
     *
     * @param string $event
     * @return array|null
     */
    #[Override]
    protected function fireConnectionEvent($event)
    {
        if (isset($this->events)) {
            $this->events->dispatch('connection.'.$this->getName().'.'.$event, $this);
        }

        return parent::fireConnectionEvent($event);
    }
}
