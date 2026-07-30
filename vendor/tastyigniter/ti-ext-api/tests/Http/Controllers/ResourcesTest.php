<?php

declare(strict_types=1);

namespace Igniter\Api\Tests\Http\Controllers;

use Igniter\Api\Models\Resource;

it('loads resources page', function(): void {
    actingAsSuperUser()
        ->get(route('igniter.api.resources'))
        ->assertOk();
});

it('fails to load create resource page', function(): void {
    actingAsSuperUser()
        ->get(route('igniter.api.resources', ['slug' => 'create']))
        ->assertStatus(500);

    actingAsSuperUser()
        ->post(route('igniter.api.resources', ['slug' => 'create']), [], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onSave',
        ])
        ->assertStatus(500);
});

it('loads edit resource page', function(): void {
    $resource = Resource::factory()->create([
        'endpoint' => 'categories',
    ]);

    actingAsSuperUser()
        ->get(route('igniter.api.resources', ['slug' => 'edit/'.$resource->getKey()]))
        ->assertOk();
});

it('loads resource preview page', function(): void {
    $resource = Resource::factory()->create([
        'endpoint' => 'categories',
    ]);

    actingAsSuperUser()
        ->get(route('igniter.api.resources', ['slug' => 'preview/'.$resource->getKey()]))
        ->assertOk();
});

it('updates resource', function(): void {
    $resource = Resource::factory()->create();

    actingAsSuperUser()
        ->post(route('igniter.api.resources', ['slug' => 'edit/'.$resource->getKey()]), [
            'Resource' => [
                'name' => 'Updated Resource',
                'endpoint' => 'updated-endpoint',
                'description' => 'Updated Resource Description',
            ],
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onSave',
        ]);

    expect(Resource::find($resource->getKey()))->name->toBe('Updated Resource')
        ->endpoint->not->toBe('updated-endpoint')
        ->endpoint->toBe($resource->endpoint);
});

it('deletes resource', function(): void {
    $resource = Resource::factory()->create();

    actingAsSuperUser()
        ->post(route('igniter.api.resources', ['slug' => 'edit/'.$resource->getKey()]), [], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onDelete',
        ]);

    expect(Resource::find($resource->getKey()))->toBeNull();
});
