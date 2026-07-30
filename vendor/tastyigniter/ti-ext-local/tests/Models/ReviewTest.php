<?php

declare(strict_types=1);

namespace Igniter\Local\Tests\Models;

use Igniter\Admin\Models\Status;
use Igniter\Cart\Models\Order;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Local\Models\Concerns\Locationable;
use Igniter\Local\Models\Location;
use Igniter\Local\Models\Review;
use Igniter\Local\Models\ReviewSettings;
use Igniter\Reservation\Models\Reservation;
use Igniter\System\Models\Concerns\Switchable;
use Igniter\User\Models\Customer;
use Illuminate\Database\Eloquent\ModelNotFoundException;

it('creates a review for a completed sale', function(): void {
    ReviewSettings::set('approve_reviews', false);
    $status = Status::factory()->create();
    setting()->set(['completed_order_status' => [$status->getKey()]]);
    $reviewable = Order::factory()->create([
        'processed' => 1,
        'location_id' => 1,
        'customer_id' => 1,
        'first_name' => 'John',
        'last_name' => 'Doe',
    ]);
    $reviewable->updateOrderStatus($status->getKey());

    $data = ['quality' => 5, 'delivery' => 4, 'service' => 3, 'review_text' => 'Great service!'];

    $review = Review::leaveReview($reviewable, $data);

    expect($review)->toBeInstanceOf(Review::class)
        ->and($review->quality)->toBe(5)
        ->and($review->delivery)->toBe(4)
        ->and($review->service)->toBe(3)
        ->and($review->review_status)->toBeNull()
        ->and($review->review_text)->toBe('Great service!');
});

it('creates an approved review for a completed sale', function(): void {
    ReviewSettings::set('approve_reviews', true);
    $status = Status::factory()->create();
    setting()->set(['completed_order_status' => [$status->getKey()]]);
    $reviewable = Order::factory()->create([
        'processed' => 1,
        'location_id' => 1,
        'customer_id' => 1,
        'first_name' => 'John',
        'last_name' => 'Doe',
    ]);
    $reviewable->updateOrderStatus($status->getKey());

    $data = ['quality' => 5, 'delivery' => 4, 'service' => 3, 'review_text' => 'Great service!'];

    $review = Review::leaveReview($reviewable, $data);

    expect($review)->toBeInstanceOf(Review::class)
        ->and($review->quality)->toBe(5)
        ->and($review->delivery)->toBe(4)
        ->and($review->service)->toBe(3)
        ->and($review->review_status)->toBeTrue()
        ->and($review->review_text)->toBe('Great service!');
});

it('throws exception when creating review for incomplete sale', function(): void {
    $reviewable = Order::factory()->create();

    $data = ['quality' => 5, 'delivery' => 4, 'service' => 3, 'review_text' => 'Great service!'];

    expect(fn(): Review => Review::leaveReview($reviewable, $data))->toThrow(ApplicationException::class);
});

it('throws exception when creating duplicate review', function(): void {
    $customer = Customer::factory()->create();
    $status = Status::factory()->create();
    setting()->set(['completed_order_status' => [$status->getKey()]]);
    $reviewable = Order::factory()->create([
        'processed' => 1,
        'location_id' => 1,
        'customer_id' => $customer->getKey(),
        'first_name' => 'John',
        'last_name' => 'Doe',
    ]);
    $reviewable->updateOrderStatus($status->getKey());
    Review::factory()->create([
        'customer_id' => $customer->getKey(),
        'reviewable_id' => $reviewable->getKey(),
        'reviewable_type' => $reviewable->getMorphClass(),
    ]);

    $data = ['quality' => 5, 'delivery' => 4, 'service' => 3, 'review_text' => 'Great service!'];

    expect(fn(): Review => Review::leaveReview($reviewable, $data))->toThrow(ApplicationException::class);
});

it('returns correct reviewable type options', function(): void {
    $result = Review::getReviewableTypeOptions();

    expect($result)->toBeArray()
        ->and($result)->toHaveKey('orders')
        ->and($result)->toHaveKey('reservations');
});

it('finds reviewable by sale type and id', function(): void {
    $order = Order::factory()->create();

    $result = Review::findBy('orders', $order->getKey());

    expect($result)->toBeInstanceOf(Order::class)
        ->and($result->getKey())->toBe($order->getKey());
});

it('throws exception when sale type is not defined', function(): void {
    $order = Order::factory()->create();

    expect(fn() => Review::findBy('invalid-sale-type', $order->getKey()))->toThrow(ModelNotFoundException::class);
});

it('applies approved query scope correctly', function(): void {
    $query = Review::query()->isApproved();

    expect($query->toSql())->toContain('`review_status` = ?');
});

it('applies reviewed query scope correctly', function(): void {
    $order = Order::factory()->create();
    $query = Review::query()->hasBeenReviewed($order, 123);

    expect($query->toSql())->toContain('`customer_id` = ?');
});

it('applies reviewable query scope correctly', function(): void {
    $order = Order::factory()->create();
    $query = Review::query()->whereReviewable($order);

    expect($query->toSql())->toContain('`reviewable_type` = ? and `reviewable_id` = ?');
});

it('returns review dates as an array', function(): void {
    $review = Review::factory()->create(['created_at' => now()]);

    $result = $review->getReviewDates()->all();

    expect($result)->toBeArray()
        ->and($result)->toContain($review->created_at->format('F Y'));
});

it('returns null if location id is not provided for score calculation', function(): void {
    $location = Location::factory()->create();
    $result = Review::getScoreForLocation(null);

    expect(Review::calculateScoreForLocation($location))->toBe(0)
        ->and($result)->toBeNull();
});

it('calculates correct score for location', function(): void {
    $location = Location::factory()->create();
    Review::factory()->create(['location_id' => $location->getKey(), 'quality' => 5, 'delivery' => 4, 'service' => 3]);

    $result = Review::getScoreForLocation($location->getKey());

    expect($result)->toBe(Review::calculateScoreForLocation($location))
        ->and($result)->toBeNumeric()
        ->and($result)->toBeGreaterThan(0);
});

it('configures review model correctly', function(): void {
    $review = new Review;

    expect(class_uses_recursive($review))
        ->toContain(Locationable::class)
        ->toContain(Switchable::class)
        ->and(Review::SWITCHABLE_COLUMN)->toBe('review_status')
        ->and($review->getTable())->toBe('igniter_reviews')
        ->and($review->getKeyName())->toBe('review_id')
        ->and($review->timestamps)->toBeTrue()
        ->and($review->getGuarded())->toBe([])
        ->and($review->getCasts())->toBe([
            'review_id' => 'int',
            'customer_id' => 'integer',
            'reviewable_id' => 'integer',
            'location_id' => 'integer',
            'quality' => 'integer',
            'service' => 'integer',
            'delivery' => 'integer',
            'review_status' => 'boolean',
        ])
        ->and($review->relation)->toBe([
            'belongsTo' => [
                'location' => [Location::class, 'scope' => 'isEnabled'],
                'customer' => Customer::class,
            ],
            'morphTo' => [
                'reviewable' => ['name' => 'sale'],
            ],
        ])
        ->and(Review::$relatedSaleTypes)->toEqual([
            'orders' => Order::class,
            'reservations' => Reservation::class,
        ]);
});
