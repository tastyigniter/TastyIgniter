<?php

declare(strict_types=1);

namespace Igniter\Api\Tests\ApiResources;

use Igniter\Local\Models\Location;
use Igniter\User\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;

it('returns all locations', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['locations:*']);
    Location::factory()->count(4)->create();

    $this
        ->get(route('igniter.api.locations.index'))
        ->assertOk()
        ->assertJsonPath('data.0.attributes.name', Location::first()->name)
        ->assertJsonCount(5, 'data');
});

it('shows a location', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['locations:*']);
    $location = Location::first();

    $this
        ->get(route('igniter.api.locations.show', [$location->getKey()]))
        ->assertOk()
        ->assertJson(fn(AssertableJson $json): AssertableJson => $json
            ->has('data.attributes', fn(AssertableJson $json): AssertableJson => $json
                ->where('location_name', $location->location_name)
                ->where('location_email', $location->location_email)
                ->where('location_address_1', $location->location_address_1)
                ->etc(),
            ));
});

it('shows a location with media relationship', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['locations:*']);
    $location = Location::first();
    $locationMedia = $location->media()->create(['file_name' => 'test.jpg', 'tag' => 'thumb']);

    $this
        ->get(route('igniter.api.locations.show', [$location->getKey()]).'?'.
            http_build_query(['include' => 'media']))
        ->assertOk()
        ->assertJsonPath('data.relationships.media.data.type', 'media')
        ->assertJsonPath('included.0.id', (string)$locationMedia->getKey())
        ->assertJsonPath('included.0.attributes.file_name', 'test.jpg');
});

it('shows a location with working_hours relationship', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['locations:*']);
    $location = Location::first();
    $location->working_hours()->create(['weekday' => 1, 'opening_time' => '09:00', 'closing_time' => '17:00']);

    $this
        ->get(route('igniter.api.locations.show', [$location->getKey()]).'?'.
            http_build_query(['include' => 'working_hours']))
        ->assertOk()
        ->assertJsonPath('data.relationships.working_hours.data.0.type', 'working_hours')
        ->assertJsonPath('included.0.attributes.weekday', 1)
        ->assertJsonPath('included.0.attributes.opening_time', '09:00:00')
        ->assertJsonPath('included.0.attributes.closing_time', '17:00:00');
});

it('shows a location with delivery_areas relationship', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['locations:*']);
    $location = Location::first();
    $locationDeliveryArea = $location->delivery_areas()->create(['name' => 'Test Area']);

    $this
        ->get(route('igniter.api.locations.show', [$location->getKey()]).'?'.http_build_query(['include' => 'delivery_areas']))
        ->assertOk()
        ->assertJsonPath('data.relationships.delivery_areas.data.0.type', 'delivery_areas')
        ->assertJsonPath('included.0.id', (string)$locationDeliveryArea->getKey())
        ->assertJsonPath('included.0.attributes.name', 'Test Area');
});

it('shows a location with reviews relationship', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['locations:*']);
    $location = Location::first();
    $locationReview = $location->reviews()->create(['review_text' => 'Test Review']);

    $this
        ->get(route('igniter.api.locations.show', [$location->getKey()]).'?'.http_build_query(['include' => 'reviews']))
        ->assertOk()
        ->assertJsonPath('data.relationships.reviews.data.0.type', 'reviews')
        ->assertJsonPath('included.0.id', (string)$locationReview->getKey())
        ->assertJsonPath('included.0.attributes.review_text', 'Test Review');
});

it('creates a location', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['locations:*']);

    $this
        ->post(route('igniter.api.locations.store'), [
            'location_name' => 'Test Location',
            'location_email' => 'test@location.tld',
            'location_address_1' => '123 Test Address',
            'is_auto_lat_lng' => '0',
            'location_lat' => '0',
            'location_lng' => '0',
        ])
        ->assertCreated()
        ->assertJson(fn(AssertableJson $json): AssertableJson => $json
            ->has('data.attributes', fn(AssertableJson $json): AssertableJson => $json
                ->where('location_name', 'Test Location')
                ->where('location_email', 'test@location.tld')
                ->where('location_address_1', '123 Test Address')
                ->etc(),
            ));
});

it('updates a location', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['locations:*']);
    $location = Location::factory()->create();

    $this
        ->put(route('igniter.api.locations.update', [$location->getKey()]), [
            'location_name' => 'Test Location',
            'location_email' => 'test@location.tld',
            'location_address_1' => '123 Test Address',
            'is_auto_lat_lng' => '0',
            'location_lat' => '0',
            'location_lng' => '0',
        ])
        ->assertOk()
        ->assertJson(fn(AssertableJson $json): AssertableJson => $json
            ->has('data.attributes', fn(AssertableJson $json): AssertableJson => $json
                ->where('location_name', 'Test Location')
                ->where('location_email', 'test@location.tld')
                ->where('location_address_1', '123 Test Address')
                ->etc(),
            ));
});

it('deletes a location', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['locations:*']);
    $location = Location::factory()->create();

    $this
        ->delete(route('igniter.api.locations.destroy', [$location->getKey()]))
        ->assertStatus(204);
});
