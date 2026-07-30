<?php

declare(strict_types=1);

namespace Igniter\System\Models\Concerns;

use Illuminate\Contracts\Database\Query\Builder;

trait Switchable
{
    public function switchableGetColumn(): string
    {
        if (defined(static::class.'::SWITCHABLE_COLUMN')) {
            return static::SWITCHABLE_COLUMN;
        }

        return 'status';
    }

    public function isEnabled(): bool
    {
        return (bool)$this->{$this->switchableGetColumn()};
    }

    public function isDisabled(): bool
    {
        return !$this->{$this->switchableGetColumn()};
    }

    public function scopeIsEnabled(Builder $query): Builder
    {
        return $this->scopeWhereIsEnabled($query);
    }

    public function scopeWhereIsEnabled(Builder $query): Builder
    {
        return $query
            ->whereNotNull($this->qualifyColumn($this->switchableGetColumn()))
            ->where($this->qualifyColumn($this->switchableGetColumn()), true);
    }

    public function scopeWhereIsDisabled(Builder $query): Builder
    {
        return $query->where($this->qualifyColumn($this->switchableGetColumn()), '!=', true);
    }

    public function scopeApplySwitchable(Builder $query, bool $switch = true): Builder
    {
        return $query->where($this->qualifyColumn($this->switchableGetColumn()), $switch);
    }
}
