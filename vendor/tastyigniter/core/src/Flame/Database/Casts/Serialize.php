<?php

declare(strict_types=1);

namespace Igniter\Flame\Database\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Override;

class Serialize implements CastsAttributes
{
    #[Override]
    public function get(Model $model, string $key, $value, array $attributes): mixed
    {
        return isset($value) ? @unserialize($value) : null;
    }

    #[Override]
    public function set(Model $model, string $key, $value, array $attributes): mixed
    {
        return isset($value) ? serialize($value) : null;
    }

    /**
     * Get the serialized representation of the value.
     */
    public function serialize(Model $model, string $key, mixed $value, array $attributes): string
    {
        return serialize($value);
    }
}
