<?php

declare(strict_types=1);

namespace Igniter\Flame\Database\Factories;

trait HasFactory
{
    /**
     * Get a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public static function factory(mixed ...$parameters)
    {
        // @phpstan-ignore-next-line
        $factory = static::newFactory() ?: Factory::factoryForModel(static::class);

        return $factory
            ->count(is_numeric($parameters[0] ?? null) ? $parameters[0] : null)
            ->state(is_array($parameters[0] ?? null) ? $parameters[0] : ($parameters[1] ?? []));
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): null
    {
        return null;
    }
}
