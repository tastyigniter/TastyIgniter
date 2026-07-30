<?php

declare(strict_types=1);

namespace Igniter\System\Models\Concerns;

use Igniter\Flame\Database\Relations\BelongsTo;
use Illuminate\Contracts\Database\Eloquent\Builder;

trait HasCountry
{
    public function scopeWhereCountry(Builder $query, $countryId): Builder
    {
        $qualifiedColumnName = $this->getCountryRelationObject()->getQualifiedForeignKeyName();

        return $query->where($qualifiedColumnName, $countryId);
    }

    protected function getCountryRelationName(): string
    {
        if (defined(static::class.'::COUNTRY_RELATION')) {
            return static::COUNTRY_RELATION;
        }

        return 'country';
    }

    protected function getCountryRelationObject(): BelongsTo
    {
        $relationName = $this->getCountryRelationName();

        return $this->{$relationName}();
    }
}
