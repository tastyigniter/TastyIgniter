<?php

declare(strict_types=1);

namespace Igniter\Api\ApiResources\Transformers;

use Igniter\Api\Traits\MergesIdAttribute;
use Igniter\Flame\Database\Attach\Media;
use Igniter\Local\Models\Location;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

class LocationTransformer extends TransformerAbstract
{
    use MergesIdAttribute;

    protected array $availableIncludes = [
        'media',
        'working_hours',
        'delivery_areas',
        'reviews',
    ];

    public function transform(Location $location): array
    {
        return $this->mergesIdAttribute($location);
    }

    public function includeMedia(Location $location): ?Item
    {
        $thumb = $location->getFirstMedia();

        return ($thumb instanceof Media) ? $this->item($thumb, new MediaTransformer, 'media') : null;
    }

    public function includeWorkingHours(Location $location): ?Collection
    {
        return $this->collection(
            $location->working_hours,
            new WorkingHourTransformer,
            'working_hours',
        );
    }

    public function includeDeliveryAreas(Location $location): ?Collection
    {
        return $this->collection(
            $location->delivery_areas,
            new DeliveryAreaTransformer,
            'delivery_areas',
        );
    }

    public function includeReviews(Location $location): ?Collection
    {
        return $this->collection(
            $location->reviews,
            new ReviewTransformer,
            'reviews',
        );
    }
}
