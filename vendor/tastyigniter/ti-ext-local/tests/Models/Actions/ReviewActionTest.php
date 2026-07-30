<?php

declare(strict_types=1);

namespace Igniter\Local\Tests\Models\Actions;

use Igniter\Cart\Models\Order;
use Igniter\Local\Models\Actions\ReviewAction;

it('saves a review successfully', function(): void {
    $model = Order::factory()->create(['processed' => 1]);
    $model->updateOrderStatus(setting('completed_order_status')[0]);

    $reviewAttributes = ['rating' => 5, 'review_text' => 'Great service!'];

    $result = (new ReviewAction($model))->leaveReview($reviewAttributes);

    expect($result->review_text)->toBe($reviewAttributes['review_text']);
});
