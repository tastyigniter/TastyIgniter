<?php

declare(strict_types=1);

namespace Igniter\Flame\Database\Traits;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\Filters\FiltersScope;

trait HasQueryModifier
{
    protected array $queryModifierFilters = [];

    protected array $queryModifierSorts = [];

    protected string $queryModifierSortDirection = 'desc';

    protected array $queryModifierSearchableFields = [];

    public function scopeListFrontEnd(Builder $builder, array $options = []): Builder|LengthAwarePaginator
    {
        $builder = $this->scopeApplyFilters($builder, $options);

        $this->fireEvent('model.extendListFrontEndQuery', [$builder]);

        if (!array_key_exists('pageLimit', $options)) {
            return $builder;
        }

        return $builder->paginate(array_get($options, 'pageLimit'), ['*'], 'page', array_get($options, 'page', 1));
    }

    public function scopeApplyFilters(Builder $builder, array $options = []): Builder
    {
        $search = trim((string)array_get($options, 'search', ''));
        if (strlen($search) && $searchableFields = $this->queryModifierSearchableFields) {
            $builder->search($search, $searchableFields);
        }

        collect($this->queryModifierFilters)
            ->each(function($value, $key) use ($builder, $options) {
                $params = (array)$value;
                if ($filterValue = array_get($options, $key, array_get($params, 'default'))) {
                    (new FiltersScope)($builder, $filterValue, $params[0]);
                }
            });

        return $this->scopeApplySorts($builder, (array)array_get($options, 'sort', []));
    }

    public function scopeApplySorts(Builder $builder, array $sorts = []): Builder
    {
        foreach ($sorts as $sort) {
            if (!str_contains((string)$sort, ' ')) {
                $sort = $sort.' '.$this->queryModifierSortDirection;
            }

            if (in_array($sort, $this->queryModifierSorts)) {
                [$sortField, $sortDirection] = explode(' ', (string)$sort);
                $builder->orderBy($sortField, $sortDirection);
            }
        }

        return $builder;
    }

    public function queryModifierAddSorts(array $sorts): static
    {
        $this->queryModifierSorts = array_unique(array_merge($this->queryModifierSorts, $sorts));

        return $this;
    }

    public function queryModifierGetSorts(): array
    {
        return $this->queryModifierSorts;
    }

    public function queryModifierGetFilters(): array
    {
        return $this->queryModifierFilters;
    }

    public function queryModifierGetSearchableFields(): array
    {
        return $this->queryModifierSearchableFields;
    }

    public function queryModifierAddFilters(array $filters): static
    {
        $this->queryModifierFilters = array_merge($this->queryModifierFilters, $filters);

        return $this;
    }

    public function queryModifierAddSearchableFields(array $searchableFields): static
    {
        $this->queryModifierSearchableFields = array_unique(
            array_merge($this->queryModifierSearchableFields, $searchableFields),
        );

        return $this;
    }
}
