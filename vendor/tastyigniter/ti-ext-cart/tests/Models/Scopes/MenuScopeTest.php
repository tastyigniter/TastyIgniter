<?php

declare(strict_types=1);

namespace Igniter\Cart\Tests\Models\Scopes;

use Igniter\Cart\Models\Scopes\MenuScope;
use Illuminate\Database\Eloquent\Builder;
use Mockery;

beforeEach(function(): void {
    $this->scope = new MenuScope;
    $this->builder = Mockery::mock(Builder::class);
});

it('applies location filter correctly', function(): void {
    $locationId = 1;
    $this->builder->shouldReceive('whereHasOrDoesntHaveLocation')->once()->with($locationId)->andReturnSelf();
    $this->builder->shouldReceive('with')->once()->andReturnUsing(function(array $relations) use ($locationId) {
        $builderMock = Mockery::mock(Builder::class)
            ->shouldReceive('whereHasOrDoesntHaveLocation')
            ->with($locationId)
            ->andReturnSelf()
            ->shouldReceive('isEnabled')
            ->andReturnSelf()
            ->getMock();
        $relations['categories']($builderMock);

        return $this->builder;
    });

    $applyLocation = $this->scope->addApplyLocation();
    $applyLocation($this->builder, $locationId);
});

it('applies category group filter correctly', function(): void {
    $group = 'test-group';
    $this->builder->shouldReceive('whereHas')->with('categories', Mockery::on(function($callback) use ($group): true {
        $query = Mockery::mock(Builder::class);
        $query->shouldReceive('groupBy')->with($group)->once();
        $callback($query);

        return true;
    }))->once()->andReturnSelf();

    $applyCategoryGroup = $this->scope->addApplyCategoryGroup();
    $applyCategoryGroup($this->builder, $group);
});

it('applies order type filter correctly', function(): void {
    $orderType = 'delivery';
    $this->builder->shouldReceive('where')->with(Mockery::on(function($callback) use ($orderType): true {
        $query = Mockery::mock(Builder::class);
        $query->shouldReceive('whereNull')->with('order_restriction')->once()->andReturnSelf();
        $query->shouldReceive('orWhere')->with('order_restriction', 'like', '%"'.$orderType.'"%')->once();
        $callback($query);

        return true;
    }))->once()->andReturnSelf();

    $applyOrderType = $this->scope->addApplyOrderType();
    $applyOrderType($this->builder, $orderType);
});

it('applies allergen filter correctly', function(): void {
    $allergenId = 1;
    $this->builder->shouldReceive('whereHas')->with('allergens', Mockery::on(function($callback) use ($allergenId): true {
        $query = Mockery::mock(Builder::class);
        $query->shouldReceive('where')->with('allergen_id', $allergenId)->once()->andReturnSelf();
        $query->shouldReceive('where')->with('is_allergen', 1)->once();
        $callback($query);

        return true;
    }))->once()->andReturnSelf();

    $applyAllergen = $this->scope->addWhereHasAllergen();
    $applyAllergen($this->builder, $allergenId);
});

it('applies category filter with category id correctly', function(): void {
    $categoryId = 1;
    $this->builder->shouldReceive('whereHas')->with('categories', Mockery::on(function($callback) use ($categoryId): true {
        $query = Mockery::mock(Builder::class);
        $query->shouldReceive('where')->with('categories.category_id', $categoryId)->once();
        $callback($query);

        return true;
    }))->once()->andReturnSelf();

    $applyCategory = $this->scope->addWhereHasCategory();
    $applyCategory($this->builder, $categoryId);
});

it('applies category filter with category slug correctly', function(): void {
    $categorySlug = 'permalink-slug';
    $this->builder->shouldReceive('whereHas')->with('categories', Mockery::on(function($callback) use ($categorySlug): true {
        $query = Mockery::mock(Builder::class);
        $query->shouldReceive('whereSlug')->with($categorySlug)->once();
        $callback($query);

        return true;
    }))->once()->andReturnSelf();

    $applyCategory = $this->scope->addWhereHasCategory();
    $applyCategory($this->builder, $categorySlug);
});

it('applies ingredient filter correctly', function(): void {
    $ingredientId = 1;
    $this->builder->shouldReceive('whereHas')->with('ingredients', Mockery::on(function($callback) use ($ingredientId): true {
        $query = Mockery::mock(Builder::class);
        $query->shouldReceive('where')->with('ingredient_id', $ingredientId)->once();
        $callback($query);

        return true;
    }))->once()->andReturnSelf();

    $applyIngredient = $this->scope->addWhereHasIngredient();
    $applyIngredient($this->builder, $ingredientId);
});

it('applies mealtime filter correctly', function(): void {
    $mealtimeId = 1;
    $this->builder->shouldReceive('whereHas')->with('mealtimes', Mockery::on(function($callback) use ($mealtimeId): true {
        $query = Mockery::mock(Builder::class);
        $query->shouldReceive('where')->with('mealtimes.mealtime_id', $mealtimeId)->once();
        $callback($query);

        return true;
    }))->once()->andReturnSelf();

    $applyMealtime = $this->scope->addWhereHasMealtime();
    $applyMealtime($this->builder, $mealtimeId);
});
