<?php

declare(strict_types=1);

namespace Igniter\Api\ApiResources\Repositories;

use Igniter\Api\Classes\AbstractRepository;
use Igniter\Local\Models\Location;
use Illuminate\Database\Eloquent\Builder;

class LocationRepository extends AbstractRepository
{
    protected ?string $modelClass = Location::class;

    protected $hidden = ['location_thumb'];

    protected function extendQuery(Builder $query): void
    {
        $query->select('*');
    }
}
