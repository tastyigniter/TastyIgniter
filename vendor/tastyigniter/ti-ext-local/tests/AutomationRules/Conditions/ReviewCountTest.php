<?php

declare(strict_types=1);

namespace Igniter\Local\Tests\AutomationRules\Conditions;

use Igniter\Automation\AutomationException;
use Igniter\Automation\Models\RuleCondition;
use Igniter\Cart\Models\Order;
use Igniter\Local\AutomationRules\Conditions\ReviewCount;
use Igniter\Reservation\Models\Reservation;
use stdClass;

it('returns correct condition details', function(): void {
    $condition = new ReviewCount;

    $result = $condition->conditionDetails();

    expect($result)->toMatchArray([
        'name' => 'Review Count',
        'description' => 'Number of reviews for this order or reservation',
    ]);
});

it('defines model attributes correctly', function(): void {
    $reviewCount = new ReviewCount;

    $attributes = $reviewCount->defineModelAttributes();

    expect($attributes)->toHaveKeys([
        'review_count',
    ]);
});

it('counts reviews for order object correctly', function(): void {
    $order = Order::factory()->hasReview(1)->create();

    $reviewCount = new ReviewCount;

    expect($reviewCount->getReviewCountAttribute(null, $order))->toBe(1);
});

it('counts reviews for reservation object correctly', function(): void {
    $reservation = Reservation::factory()->hasReview(1)->create();

    $reviewCount = new ReviewCount;

    expect($reviewCount->getReviewCountAttribute(null, $reservation))->toBe(1);
});

it('returns zero when object is not order or reservation', function(): void {
    $reviewCount = new ReviewCount;

    $result = $reviewCount->getReviewCountAttribute(null, new stdClass);

    expect($result)->toBe(0);
});

it('evaluates isTrue when no reviews correctly', function(): void {
    $order = Order::factory()->create();

    $orderAttribute = new ReviewCount(new RuleCondition([
        'options' => [
            ['attribute' => 'review_count', 'operator' => 'is', 'value' => 1],
        ],
    ]));

    $params = ['order' => $order];
    expect($orderAttribute->isTrue($params))->toBeFalse();
});

it('evaluates isTrue when review count is 1 correctly', function(): void {
    $order = Order::factory()->hasReview(1)->create();

    $orderAttribute = new ReviewCount(new RuleCondition([
        'options' => [
            ['attribute' => 'review_count', 'operator' => 'is', 'value' => 1],
        ],
    ]));

    $params = ['order' => $order];
    expect($orderAttribute->isTrue($params))->toBeTrue();
});

it('evaluates isTrue when review count is more than 1 correctly', function(): void {
    $order = Order::factory()->hasReview(3)->create();

    $orderAttribute = new ReviewCount(new RuleCondition([
        'options' => [
            ['attribute' => 'review_count', 'operator' => 'greater', 'value' => 1],
        ],
    ]));

    $params = ['order' => $order];
    expect($orderAttribute->isTrue($params))->toBeTrue();
});

it('throws exception when neither order nor reservation object is provided in parameters', function(): void {
    $reviewCount = new ReviewCount;
    $params = [];

    expect(fn() => $reviewCount->isTrue($params))->toThrow(AutomationException::class);
});
