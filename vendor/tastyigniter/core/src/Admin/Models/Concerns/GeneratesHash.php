<?php

declare(strict_types=1);

namespace Igniter\Admin\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;

trait GeneratesHash
{
    /**
     * Generate a unique hash for this order.
     */
    public function generateHash(string $column = 'hash'): string
    {
        $hash = md5(uniqid(self::class, true));
        while ($this->generatesHashNewQuery()->where($column, $hash)->count() > 0) {
            $hash = md5(uniqid(self::class, true));
        }

        return $hash;
    }

    protected function generatesHashNewQuery(): Builder
    {
        return $this->newQuery();
    }
}
