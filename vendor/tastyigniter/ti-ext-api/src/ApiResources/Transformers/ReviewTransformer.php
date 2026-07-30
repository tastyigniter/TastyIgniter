<?php

declare(strict_types=1);

namespace Igniter\Api\ApiResources\Transformers;

use Igniter\Api\Traits\MergesIdAttribute;
use Igniter\Local\Models\Review;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

class ReviewTransformer extends TransformerAbstract
{
    use MergesIdAttribute;

    protected array $availableIncludes = [
        'location',
        'customer',
    ];

    public function transform(Review $review): array
    {
        return $this->mergesIdAttribute($review);
    }

    public function includeCustomer(Review $review): Item
    {
        return $this->item($review->customer, new CustomerTransformer, 'customers');
    }

    public function includeLocation(Review $review): Item
    {
        return $this->item($review->location, new LocationTransformer, 'locations');
    }
}
