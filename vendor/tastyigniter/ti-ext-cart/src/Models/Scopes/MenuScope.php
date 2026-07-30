<?php

declare(strict_types=1);

namespace Igniter\Cart\Models\Scopes;

use Igniter\Flame\Database\Scope;
use Illuminate\Database\Eloquent\Builder;

class MenuScope extends Scope
{
    public function addApplyLocation()
    {
        return fn(Builder $builder, $locationId) => $builder
            ->whereHasOrDoesntHaveLocation($locationId)
            ->with(['categories' => function($q) use ($locationId): void {
                $q->whereHasOrDoesntHaveLocation($locationId);
                $q->isEnabled();
            }]);
    }

    public function addApplyCategoryGroup()
    {
        return fn(Builder $builder, $group) => $builder->whereHas('categories', function(Builder $q) use ($group): void {
            $q->groupBy($group);
        });
    }

    public function addApplyOrderType()
    {
        return fn(Builder $builder, $orderType) => $builder->where(function(Builder $query) use ($orderType): void {
            $query->whereNull('order_restriction')
                ->orWhere('order_restriction', 'like', '%"'.$orderType.'"%');
        });
    }

    public function addWhereHasAllergen()
    {
        return fn(Builder $builder, $allergenId) => $builder->whereHas('allergens', function(Builder $q) use ($allergenId): void {
            $q->where('allergen_id', $allergenId);
            $q->where('is_allergen', 1);
        });
    }

    public function addWhereHasCategory()
    {
        return fn(Builder $builder, $categoryId) => $builder->whereHas('categories', function(Builder $q) use ($categoryId): void {
            if (is_numeric($categoryId)) {
                $q->where('categories.category_id', $categoryId);
            } else {
                $q->whereSlug($categoryId);
            }
        });
    }

    public function addWhereHasIngredient()
    {
        return fn(Builder $builder, $ingredientId) => $builder->whereHas('ingredients', function(Builder $q) use ($ingredientId): void {
            $q->where('ingredient_id', $ingredientId);
        });
    }

    public function addWhereHasMealtime()
    {
        return fn(Builder $builder, $mealtimeId) => $builder->whereHas('mealtimes', function(Builder $q) use ($mealtimeId): void {
            $q->where('mealtimes.mealtime_id', $mealtimeId);
        });
    }
}
