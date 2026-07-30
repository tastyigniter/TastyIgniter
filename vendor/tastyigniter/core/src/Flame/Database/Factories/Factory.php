<?php

declare(strict_types=1);

namespace Igniter\Flame\Database\Factories;

use Override;

abstract class Factory extends \Illuminate\Database\Eloquent\Factories\Factory
{
    /**
     * Get the factory name for the given model name.
     *
     * @return string
     */
    #[Override]
    public static function resolveFactoryName(string $modelName)
    {
        $resolver = static::$factoryNameResolver ?: function(string $modelName) {
            $modelName = str_replace('\\Models\\', '\\Database\\Factories\\', $modelName);

            return $modelName.'Factory';
        };

        return $resolver($modelName);
    }
}
