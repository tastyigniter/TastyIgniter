<?php

declare(strict_types=1);

namespace Tests\Models;

use Igniter\Cart\Models\Category;
use Igniter\Cart\Models\Menu;
use Igniter\Cart\Models\MenuCategory;
use Igniter\Cart\Models\Scopes\CategoryScope;
use Igniter\Flame\Database\Attach\HasMedia;
use Igniter\Flame\Database\Traits\HasPermalink;
use Igniter\Flame\Database\Traits\NestedTree;
use Igniter\Flame\Database\Traits\Sortable;
use Igniter\Local\Models\Concerns\Locationable;
use Igniter\Local\Models\Location;
use Igniter\Local\Models\Scopes\LocationableScope;
use Igniter\System\Models\Concerns\Switchable;

it('returns enabled categories dropdown options', function(): void {
    $count = Category::count();

    Category::factory()->count(3)->create(['status' => 0]);

    expect(Category::getDropdownOptions()->all())->toHaveCount($count);
});

it('returns description attribute', function(): void {
    $category = Category::factory()->create(['description' => '<p>Description</p>']);

    expect($category->description)->toBe('Description');
});

it('counts menus', function(): void {
    $category = Category::factory()->create();
    $category->menus()->saveMany(Menu::factory()->count(3)->make());

    expect($category->count_menus)->toBe(3);
});

it('belongs to parent category', function(): void {
    $category = new Category;
    $relation = $category->parent_cat();

    expect($relation->getRelated())->toBeInstanceOf(Category::class)
        ->and($relation->getForeignKeyName())->toBe('parent_id')
        ->and($relation->getOwnerKeyName())->toBe('category_id');
});

it('belongs to many menus', function(): void {
    $category = new Category;
    $relation = $category->menus();

    expect($relation->getRelated())->toBeInstanceOf(Menu::class)
        ->and($relation->getTable())->toBe('menu_categories');
});

it('morphs to many locations', function(): void {
    $category = new Category;
    $relation = $category->locations();

    expect($relation->getMorphType())->toBe('locationable_type')
        ->and($relation->getRelated())->toBeInstanceOf(Location::class);
});

it('generates permalink slug', function(): void {
    $category = Category::factory()->create(['name' => 'Category Name']);

    expect($category->permalink_slug)->toBe('category-name');
});

it('scopes to categories with menus', function(): void {
    $menu = Menu::factory()->create();
    $menu->categories()->saveMany(Category::factory()->count(3)->make(['status' => 1]));

    expect(Category::whereHasMenus()->count())->toBe(3);
});

it('applies filters to query builder', function(): void {
    $query = Category::query()->applyFilters([
        'enabled' => 1,
        'location' => 1,
        'sort' => 'priority desc',
        'search' => 'Location category',
    ]);

    expect($query->toSql())
        ->toContain('`categories`.`status` = ?')
        ->toContain('`locationables`.`location_id` in (?)')
        ->toContain('order by `priority` desc')
        ->toContain('lower(name)', 'lower(description)');
});

it('configures category model correctly', function(): void {
    $category = new Category;

    expect(class_uses_recursive($category))
        ->toContain(HasMedia::class)
        ->toContain(HasPermalink::class)
        ->toContain(Locationable::class)
        ->toContain(NestedTree::class)
        ->toContain(Sortable::class)
        ->toContain(Switchable::class)
        ->and($category->getTable())->toBe('categories')
        ->and($category->getKeyName())->toBe('category_id')
        ->and($category->timestamps)->toBeTrue()
        ->and($category->getGuarded())->toBe([])
        ->and($category->getMorphClass())->toBe('categories')
        ->and($category->relation)->toEqual([
            'belongsTo' => [
                'parent_cat' => [Category::class, 'foreignKey' => 'parent_id', 'otherKey' => 'category_id'],
            ],
            'belongsToMany' => [
                'menus' => [Menu::class, 'table' => 'menu_categories'],
            ],
            'morphToMany' => [
                'locations' => [Location::class, 'name' => 'locationable'],
            ],
        ])
        ->and($category->permalinkable)->toBe([
            'permalink_slug' => [
                'source' => 'name',
            ],
        ])
        ->and($category->mediable())->toHaveKey('thumb')
        ->and($category->getGlobalScopes())->toHaveKeys([
            CategoryScope::class,
            LocationableScope::class,
        ])
        ->and(new MenuCategory)->getMorphClass()->toBe('menu_categories');
});
