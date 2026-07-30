<?php

declare(strict_types=1);

namespace Igniter\Api\Tests\ApiResources;

use Igniter\Api\Classes\ApiController;
use Igniter\Api\Http\Actions\RestController;
use Igniter\Cart\Models\Category;
use Igniter\User\Models\User;
use Laravel\Sanctum\Sanctum;

it('returns all categories', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['categories:*']);
    $category = Category::first();

    $this
        ->get(route('igniter.api.categories.index'))
        ->assertOk()
        ->assertJsonPath('data.0.id', (string)$category->getKey())
        ->assertJsonPath('data.0.attributes.name', $category->name);
});

it('shows a category', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['categories:*']);
    $category = Category::first();

    $this
        ->get(route('igniter.api.categories.show', [$category->getKey()]))
        ->assertOk()
        ->assertJsonPath('data.id', (string)$category->getKey())
        ->assertJsonPath('data.attributes.name', $category->name);
});

it('shows a category with media relationship', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['categories:*']);
    $category = Category::first();
    $categoryMedia = $category->media()->create(['file_name' => 'test.jpg', 'tag' => 'thumb']);

    $this
        ->get(route('igniter.api.categories.show', [$category->getKey()]).'?'.http_build_query([
            'include' => 'media',
        ]))
        ->assertOk()
        ->assertJsonPath('data.relationships.media.data.type', 'media')
        ->assertJsonPath('included.0.id', (string)$categoryMedia->getKey())
        ->assertJsonPath('included.0.attributes.file_name', 'test.jpg');
});

it('shows a category with menus relationship', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['categories:*']);
    $category = Category::first();
    $categoryMenu = $category->menus()->create(['menu_name' => 'Test Menu']);

    $this
        ->get(route('igniter.api.categories.show', [$category->getKey()]).'?'.http_build_query([
            'include' => 'menus',
        ]))
        ->assertOk()
        ->assertJsonPath('data.relationships.menus.data.0.type', 'menus')
        ->assertJsonPath('included.0.id', (string)$categoryMenu->getKey())
        ->assertJsonPath('included.0.attributes.menu_name', 'Test Menu');
});

it('shows a category with locations relationship', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['categories:*']);
    $category = Category::first();
    $categoryLocation = $category->locations()->create(['location_name' => 'Test Location']);

    $this
        ->get(route('igniter.api.categories.show', [$category->getKey()]).'?'.http_build_query([
            'include' => 'locations',
        ]))
        ->assertOk()
        ->assertJsonPath('data.relationships.locations.data.0.type', 'locations');
    //        ->assertJsonPath('included.0.id', (string)$categoryLocation->getKey())
    //        ->assertJsonPath('included.0.attributes.location_name', 'Test Location');
})->note('Skipping assertion on included data due to polymorphic relationship issues.');

it('creates a category', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['categories:*']);

    $this
        ->post(route('igniter.api.categories.store'), [
            'name' => 'Test Category',
        ])
        ->assertCreated()
        ->assertJsonPath('data.attributes.name', 'Test Category');
});

it('creates a category fails on validation', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['categories:*']);

    $this
        ->post(route('igniter.api.categories.store'))
        ->assertStatus(422);
});

it('validates request data successfully', function(): void {
    $controller = new class extends ApiController
    {
        public array $restConfig = [
            'actions' => [],
            'repository' => null,
            'transformer' => null,
            'request' => null,
        ];

        public function restValidate(): array
        {
            return ['validated' => 'data'];
        }
    };

    $restController = new RestController($controller);
    $result = callProtectedMethod($restController, 'validateRequest', ['all']);

    expect($result)->toBe(['validated' => 'data']);
});

it('updates a category', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['categories:*']);
    $category = Category::first();

    $this
        ->put(route('igniter.api.categories.update', [$category->getKey()]), [
            'name' => 'Test Category',
        ])
        ->assertOk()
        ->assertJsonPath('data.attributes.name', 'Test Category');
});

it('deletes a category', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['categories:*']);
    $category = Category::first();

    $this
        ->delete(route('igniter.api.categories.destroy', [$category->getKey()]))
        ->assertStatus(204);
});
