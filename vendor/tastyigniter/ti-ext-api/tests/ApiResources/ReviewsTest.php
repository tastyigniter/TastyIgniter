<?php

declare(strict_types=1);

namespace Igniter\Api\Tests\ApiResources;

use Igniter\Cart\Models\Order;
use Igniter\Local\Models\Location;
use Igniter\Local\Models\Review;
use Igniter\User\Models\Customer;
use Igniter\User\Models\User;
use Laravel\Sanctum\Sanctum;

it('returns all reviews', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['reviews:*']);
    Review::factory()->count(3)->create();
    $review = Review::first();

    $this
        ->get(route('igniter.api.reviews.index'))
        ->assertOk()
        ->assertJsonPath('data.0.id', (string)$review->getKey())
        ->assertJsonPath('data.0.attributes.author', $review->author);
});

it('shows a review', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['reviews:*']);
    $review = Review::factory()->create();

    $this
        ->get(route('igniter.api.reviews.show', [$review->getKey()]))
        ->assertOk()
        ->assertJsonPath('data.id', (string)$review->getKey())
        ->assertJsonPath('data.attributes.author', $review->author);
});

it('shows a review with location relationship', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['reviews:*']);
    $review = Review::factory()->create();
    $review->location()->associate($reviewLocation = Location::factory()->create())->save();

    $this
        ->get(route('igniter.api.reviews.show', [$review->getKey()]).'?'.
            http_build_query(['include' => 'location']))
        ->assertOk()
        ->assertJsonPath('data.relationships.location.data.type', 'locations')
        ->assertJsonPath('included.0.id', (string)$reviewLocation->getKey())
        ->assertJsonPath('included.0.attributes.location_name', $reviewLocation->location_name);
});

it('shows a review with customer relationship', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['reviews:*']);
    $review = Review::factory()->create();
    $review->customer()->associate($reviewCustomer = Customer::factory()->create())->save();

    $this
        ->get(route('igniter.api.reviews.show', [$review->getKey()]).'?'.
            http_build_query(['include' => 'customer']))
        ->assertOk()
        ->assertJsonPath('data.relationships.customer.data.type', 'customers')
        ->assertJsonPath('included.0.id', (string)$reviewCustomer->getKey())
        ->assertJsonPath('included.0.attributes.first_name', $reviewCustomer->first_name);
});

it('creates a review', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['reviews:*']);

    $order = Order::factory()->create();

    $this
        ->post(route('igniter.api.reviews.store'), [
            'location_id' => 1,
            'customer_id' => 1,
            'reviewable_id' => $order->getKey(),
            'reviewable_type' => $order->getMorphClass(),
            'author' => 'Test User',
            'quality' => 5,
            'delivery' => 5,
            'service' => 5,
            'review_text' => 'This is a test review',
            'review_status' => 1,
        ])
        ->assertCreated()
        ->assertJsonPath('data.attributes.author', 'Test User');
});

it('updates a review', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['reviews:*']);

    $order = Order::factory()->create();
    $review = Review::factory()->create([
        'reviewable_id' => $order->getKey(),
        'reviewable_type' => $order->getMorphClass(),
    ]);

    $this
        ->put(route('igniter.api.reviews.update', [$review->getKey()]), [
            'location_id' => 1,
            'customer_id' => 1,
            'reviewable_id' => $order->getKey(),
            'reviewable_type' => $order->getMorphClass(),
            'quality' => 4,
            'delivery' => 4,
            'service' => 4,
            'review_text' => 'This is an updated test review',
            'review_status' => 0,
        ])
        ->assertOk()
        ->assertJsonPath('data.attributes.quality', 4)
        ->assertJsonPath('data.attributes.review_text', 'This is an updated test review');
});

it('deletes a review', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['reviews:*']);
    $review = Review::factory()->create();

    $this
        ->delete(route('igniter.api.reviews.destroy', [$review->getKey()]))
        ->assertNoContent();

    $this->assertNull(Review::find($review->getKey()));
});
