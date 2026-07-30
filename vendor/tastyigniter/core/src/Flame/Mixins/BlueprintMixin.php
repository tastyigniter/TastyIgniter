<?php

declare(strict_types=1);

namespace Igniter\Flame\Mixins;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/** @mixin Blueprint */
class BlueprintMixin
{
    public function dropForeignKeyIfExists()
    {
        return function($key) {
            $foreignKeys = array_map(fn($key) => array_get($key, 'name'), Schema::getForeignKeys($this->getTable()));

            if (!ends_with($key, '_foreign')) {
                $key = sprintf('%s_foreign', $key);
            }

            if (!starts_with($key, $this->getTable().'_')) {
                $key = sprintf('%s_%s', $this->getTable(), $key);
            }

            if (!starts_with($key, DB::getTablePrefix())) {
                $key = sprintf('%s%s', DB::getTablePrefix(), $key);
            }

            if (!in_array($key, $foreignKeys)) {
                return;
            }

            return $this->dropForeign($key);
        };
    }

    public function dropIndexIfExists()
    {
        return function($key) {
            $indexes = array_map(fn($key) => array_get($key, 'name'), Schema::getIndexes($this->getTable()));

            if (!ends_with($key, ['_index', '_foreign', '_unique'])) {
                $key = sprintf('%s_index', $key);
            }

            if (!starts_with($key, $this->getTable().'_')) {
                $key = sprintf('%s_%s', $this->getTable(), $key);
            }

            if (!starts_with($key, DB::getTablePrefix())) {
                $key = sprintf('%s%s', DB::getTablePrefix(), $key);
            }

            if (!in_array($key, $indexes)) {
                return;
            }

            return $this->dropIndex($key);
        };
    }
}
