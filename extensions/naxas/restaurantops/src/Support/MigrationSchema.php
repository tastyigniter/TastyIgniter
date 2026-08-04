<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Support;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use RuntimeException;

final class MigrationSchema
{
    public const IDENTIFIER_LIMIT = 64;

    public const INTERNAL_LIMIT = 55;

    public static function migrationPath(): string
    {
        return dirname(__DIR__, 2).'/database/migrations';
    }

    /** @return list<string> */
    public static function files(): array
    {
        $files = glob(self::migrationPath().'/*.php') ?: [];
        sort($files);

        return $files;
    }

    /** @return array<string, list<string>> */
    public static function tablesAndColumns(): array
    {
        $tables = [];
        foreach (self::files() as $file) {
            $source = (string) file_get_contents($file);
            preg_match_all("/Schema::create\\('([^']+)'\\s*,.*?\{(.*?)\n\s*\}\);/s", $source, $blocks, PREG_SET_ORDER);
            foreach ($blocks as $block) {
                preg_match_all('/\\$table->(?:bigIncrements|[A-Za-z]+)\\(\'([^\']+)\'/', $block[2], $columns);
                $tables[$block[1]] = array_values(array_unique($columns[1]));
            }
        }

        return $tables;
    }

    /** @return array{identifiers: list<array{file:string,name:string,type:string,length:int}>, errors:list<string>} */
    public static function identifierAudit(?string $prefix = null): array
    {
        $prefix ??= (string) config('database.connections.'.config('database.default').'.prefix', '');
        $identifiers = [];
        $errors = [];
        $seen = [];

        foreach (self::files() as $file) {
            $source = (string) file_get_contents($file);
            preg_match_all('/->(index|unique|foreign|primary|fullText|spatialIndex)\\s*\\((.*?)\\)/s', $source, $calls, PREG_SET_ORDER);
            foreach ($calls as $call) {
                $arguments = $call[2];
                if (! preg_match("/,\\s*'([^']+)'\\s*$/s", $arguments, $name)
                    && ! preg_match("/^\\s*'(rops_[^']+)'\\s*$/s", $arguments, $name)) {
                    $errors[] = basename($file).': implicit '.$call[1].' name';

                    continue;
                }

                // Explicit Laravel names are emitted verbatim; the table prefix is not prepended.
                $identifier = $name[1];
                $length = strlen($identifier);
                if (($seen[$identifier] ?? null) === basename($file)) {
                    // The narrowly scoped partial-DDL recovery and clean-create
                    // branches intentionally declare the same physical key.
                    continue;
                }
                $identifiers[] = ['file' => basename($file), 'name' => $identifier, 'type' => $call[1], 'length' => $length];
                if ($length > self::IDENTIFIER_LIMIT) {
                    $errors[] = $identifier.' exceeds '.self::IDENTIFIER_LIMIT.' characters';
                } elseif ($length > self::INTERNAL_LIMIT) {
                    $errors[] = $identifier.' exceeds the RestaurantOps '.self::INTERNAL_LIMIT.'-character safety limit';
                }
                if (isset($seen[$identifier])) {
                    $errors[] = $identifier.' is duplicated';
                }
                $seen[$identifier] = basename($file);
            }

            preg_match_all("/->drop(?:Index|Unique|Foreign)\\s*\\(\\s*'([^']+)'/", $source, $drops);
            foreach ($drops[1] as $drop) {
                if (! isset($seen[$drop])) {
                    $errors[] = basename($file).': down() drops unknown identifier '.$drop;
                }
            }
        }

        return compact('identifiers', 'errors');
    }

    /** @return list<string> */
    public static function databaseAudit(bool $complete = false): array
    {
        $errors = [];
        $driver = DB::connection()->getDriverName();
        if ($driver !== 'mysql') {
            return ['MySQL is required; active driver is '.$driver];
        }

        $version = (string) DB::selectOne('select version() as version')->version;
        if ($version === '') {
            $errors[] = 'Unable to determine MySQL server version.';
        }

        $migrationTable = (string) config('database.migrations', 'migrations');
        $ran = Schema::hasTable($migrationTable)
            ? DB::table($migrationTable)->where('migration', 'like', 'Naxas.RestaurantOps::%')->pluck('migration')->all()
            : [];

        foreach (self::tablesAndColumns() as $table => $columns) {
            $exists = Schema::hasTable($table);
            if ($exists && $ran === []) {
                $errors[] = 'Partial/drift state: '.$table.' exists without RestaurantOps migration history.';
            }
            if (! $complete) {
                continue;
            }
            if (! $exists) {
                $errors[] = 'Missing table '.$table;

                continue;
            }
            foreach ($columns as $column) {
                if (! Schema::hasColumn($table, $column)) {
                    $errors[] = 'Missing column '.$table.'.'.$column;
                }
            }
        }

        if ($complete) {
            $prefix = DB::connection()->getTablePrefix();
            $like = str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $prefix.'naxas_restaurant_ops_').'%';
            $long = DB::select('SELECT TABLE_NAME, INDEX_NAME FROM information_schema.STATISTICS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME LIKE ? AND CHAR_LENGTH(INDEX_NAME) > 64', [$like]);
            $constraints = DB::select('SELECT TABLE_NAME, CONSTRAINT_NAME FROM information_schema.TABLE_CONSTRAINTS WHERE CONSTRAINT_SCHEMA = DATABASE() AND TABLE_NAME LIKE ? AND CHAR_LENGTH(CONSTRAINT_NAME) > 64', [$like]);
            foreach ([...$long, ...$constraints] as $item) {
                $errors[] = 'Overlength database identifier on '.$item->TABLE_NAME;
            }
            foreach (['naxas.restaurantops.overview', 'naxas.restaurantops.menu-operations.index', 'naxas.restaurantops.shifts.index', 'naxas.restaurantops.pos'] as $route) {
                if (! Route::has($route)) {
                    $errors[] = 'Missing route '.$route;
                }
            }
            if (PermissionDefinitions::all() === []) {
                $errors[] = 'No RestaurantOps permissions are registered.';
            }
            if (RoleProfiles::all() === []) {
                $errors[] = 'No stable RestaurantOps roles are defined.';
            }
        }

        return $errors;
    }

    public static function assertPreflight(): void
    {
        $errors = [...self::identifierAudit()['errors'], ...self::databaseAudit()];
        if ($errors !== []) {
            throw new RuntimeException(implode(PHP_EOL, $errors));
        }
    }
}
